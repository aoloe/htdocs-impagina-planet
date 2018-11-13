<?php
/**
 * parse the scirbus mailman listing for the latest two month and provide an rss feed with the titles and the first 500 chars of the message
 */

error_reporting(0);
ini_set('display_errors', '0');
// error_reporting(E_ALL);
// ini_set('display_errors', '1');


/*
// i've tried to parse the tar.gz archive but it
// does not work... it's hard to find the email boundaries
$archive = file_get_contents('http://lists.scribus.net/pipermail/scribus/2018-November.txt.gz');
$archive = gzdecode($archive);

$separator = "\r\n";
$line = strtok($archive, $separator);

while ($line !== false) {
    echo("<p>".$line."</p>");
    $line = strtok( $separator );
}
*/
function debug($label, $value = null) {
    echo("<pre>");
    if (isset($value)) echo($label.":\n");
    else $value = $label;
    if (is_null($value)) echo('&lt;null&gt;');
    elseif ($value === true) echo('&lt;true&gt;');
    elseif ($value === false) echo('&lt;false&gt;');
    else echo(htmlspecialchars(print_r($value, 1)));
    echo("</pre>\n");
}

$feed_base_url = 'http://impagina.org/planet/tools/scribus-ml-to-rss.php?feed=';

$feeds = [
    'scribus' => [
        'id' => 'scribus',
        'tag' => '[scribus] ',
        'title' => 'Scribus List',
        'subtitle' => 'Scribus Mailing List',
        'url' => 'http://lists.scribus.net/pipermail/scribus',
        'author' => 'Scribus Mailing List',
        'language' => 'en-us',
        'feed' => $feed_base_url.'scribus',
    ],
    'scribus-dev' => [
        'id' => 'scribus-dev',
        'tag' => '[scribus-dev]',
        'title' => 'Scribus Dev List',
        'subtitle' => 'Scribus Development Mailing List',
        'url' => 'http://lists.scribus.net/pipermail/scribus-dev',
        'author' => 'Scribus Mailing List',
        'language' => 'en-us',
        'feed' => $feed_base_url.'scribus-dev',
    ],
    'scribus-commit' => [
        'id' => 'scribus-commit',
        'tag' => '',
        'title' => 'Scribus Commits',
        'subtitle' => 'Scribus Commits Mailing list',
        'url' => 'http://lists.scribus.net/pipermail/scribus-commit',
        'author' => 'Scribus Mailing List',
        'language' => 'en-us',
        'feed' => $feed_base_url.'scribus-commit',
    ],
];

if (array_key_exists('feed', $_GET) && array_key_exists($_GET['feed'], $feeds)) {
    $feed = $feeds[$_GET['feed']];
} else {
    die('no such feed');
}


$last_month = date_create('first day of last month');

$months = [
    [date('Y'), date('F')],
    [$last_month->format('Y'), $last_month->format('F')]
];

$archive = [];

foreach ($months as $month) {
    $archive_month = [];
    $cache_file_name = strtolower('cache/'.$feed['id'].'-'.$month[0].'-'.$month[1].'.json');
    $cache = [];
    if (file_exists($cache_file_name)) {
        $cache = file_get_contents($cache_file_name);
        $cache = json_decode($cache, true);
    }
    $url_base = $feed['url'].'/'.$month[0].'-'.$month[1];
    $url = $url_base.'/date.html';
    $month_archive = file_get_contents($url);

    // get the second <ul> in the document
    $dom = new DOMDocument();
    $dom->loadHTML($month_archive);
    $ul = $dom->getElementsByTagName('ul');
    $ul = $ul[1];

    // get the text and href of each item
    // and fetch its content
    $li = $ul->getElementsByTagName('li');
    if ($li->length == count($cache)) {
        $archive += $cache;
        continue;
    }
    for ($i = 0; $i < $li->length; $i++) {
        if ($i < count($cache) - 1) {
            $archive_month[] = $cache[$i];
            continue;
        }
        $li_item = $li->item($i);
        $a = $li_item->getElementsByTagName('a');
        $message_title = $a[0]->nodeValue;
        $href = $a[0]->getAttribute('href');

        $url_message = $url_base.'/'.$href;
        $message_content = file_get_contents($url_message);
        $dom_message = new DOMDocument();
        $dom_message->loadHTML($message_content);
        $message_date = date_create($dom_message->getElementsByTagName('i')[0]->nodeValue)->format(DATE_ATOM);
        $message_body = $dom_message->getElementsByTagName('pre')[0];
        $message_body = htmlspecialchars(substr($message_body->textContent, 0, 500));

        $archive_month[] = [
            'title' => htmlspecialchars(trim(substr($message_title, strlen($feed['tag'])))), // remove [scribus]
            'url' => $url_message,
            'content' => $message_body,
            'updated' => $message_date
        ];
        // break;
    }
    // break;
    $cache = json_encode($archive_month, true);
    file_put_contents($cache_file_name, $cache);
    $archive += $archive_month;
}

$feed_template = <<<EOT
<?xml version='1.0' encoding='UTF-8'?>
<feed xmlns="http://www.w3.org/2005/Atom" xml:lang="{{language}}">
    <title>{{title}}</title>
    <subtitle>{{subtitle}}</subtitle>
    <link rel="self" type="application/atom+xml" href="{{feed}}" />
    <link href="{{url}}" />
    <author><name>{{author}}</name></author>
    <id>{{feed}}</id>
    <updated>{{updated}}</updated>
    
    {{foreach::items::::endforeach}}
</feed>
EOT;

$feed_template_item = <<<EOT
<entry>
<title>{{title}}</title>
<id>{{url}}</id>
<link href="{{url}}"/>
<updated>{{updated}}</updated>
<content type="html"><![CDATA[{{content}}]]></content>
</entry>
EOT;

// debug($archive);

$items = [];
foreach ($archive as $item) {
    $items[] = template($feed_template_item, $item);
}

$feed_output = template($feed_template, $feed + ['items' => $items, 'updated' => date(DATE_ATOM)]);
// debug($feed_output);

header("Content-type: text/xml");
echo($feed_output);

// a very simple template engine, with if and foreach
// the original function is in the impagina's planet index
function template($template, $parameter = null) {
    $result = '';
    $pattern = '/\{{(foreach|if)::(.*?)::(.*?)::(endforeach|endif)}}/s';
    // debug('parameter', $parameter);
    $result = preg_replace_callback(
        $pattern,
        function ($match)  use ($parameter) {
            $result = '';
            if ($match[1] == 'foreach') {
                if ($match[3] == '') {
                    $result .= implode("\n", $parameter[$match[2]]);
                } else {
                    foreach ($parameter[$match[2]] as $item) {
                        foreach ($item as $key => $value) {
                            unset($item[$key]);
                            $item['{{'.$key.'}}'] = $value;
                        }
                        $result .= strtr($match[3], $item);
                    }
                    // $result .= preg_replace('/{{*.?}}/', array_keys($value[$match[2]]), array_values($value[$match[2]]));
                }
            } elseif ($match[1] == 'if') {
                // allowed operators: = ! < > none
                // debug('match', $match);
                preg_match("/(.+?)([=!<>])(.*)/", $match[2], $match_if);
                // debug('match_if', $match_if);
                $ok_if = false;
                switch ($match_if[2]) {
                    case "=":
                        $ok_if = ($parameter[$match_if[1]] == $match_if[3]);
                    break;
                    case "!":
                        $ok_if = ($parameter[$match_if[1]] != $match_if[3]);
                    break;
                    case "<":
                        $ok_if = ($parameter[$match_if[1]] < $match_if[3]);
                    break;
                    case ">":
                        $ok_if = ($parameter[$match_if[1]] > $match_if[3]);
                    break;
                }
                // debug('ok_if', $ok_if);
                if ($ok_if) {
                    $result = $match[3];
                }
                // debug('result', $result);
                
            }
            return $result;
        },
        $template
    );
    foreach ($parameter as $key => $value) {
        if (is_array($value)) {
            unset($parameter[$key]);
        } else {
            unset($parameter[$key]);
            $parameter['{{'.$key.'}}'] = $value;
        } 
    }
    $result = strtr($result, $parameter);
    // $result = preg_replace('/{{*.?}}/', );
    return $result;
} // template

?>
