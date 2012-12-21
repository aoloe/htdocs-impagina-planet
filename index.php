<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');

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

$feed_source = array (
    'https://plus.google.com/109612024486187515483/posts' => array (
        'feed' => 'http://gplus-to-rss.appspot.com/rss/109612024486187515483',
        'label' => 'g+',
        'author' => 'Scribus',
        'css' => 'google-plus',
        'url' => 'https://plus.google.com/b/109612024486187515483/109612024486187515483/posts'
    ),
    'http://twitter.com/scribus' => array (
        'feed' => 'http://api.twitter.com/1/statuses/user_timeline.rss?screen_name=scribus',
        'label' => 'twitter',
        'author' => 'Scribus',
        'css' => 'twitter',
        'url' => 'http://twitter.com/scribus',
    ),
    'https://www.facebook.com/groups/114175708594284' => array (
        'feed' => 'http://www.wallflux.com/info/114175708594284',
        'label' => 'facebook',
        'author' => 'Scribus',
        'css' => 'facebook',
        'url' => 'http://www.facebook.com/groups/114175708594284/',
    ),
    'http://rants.scribus.net/' => array (
        'feed' => 'http://rants.scribus.net/feed/',
        'label' => 'Scribus developer blog',
        'author' => 'Scribus',
        'css' => 'blog',
        'url' => 'http://rants.scribus.net',
    ),
    'http://graphicslab.org/blog' => array (
        'feed' => 'http://graphicslab.org/blog/?rss',
        'label' => 'a.l.e\'s graphicslab',
        'author' => 'a.l.e',
        'css' => 'blog',
        'url' => 'http://graphicslab.org/blog',
        'tag' => 'scribus',
    ),
    'http://seenthis.net/people/chelen' => array (
        'feed' => 'http://seenthis.net/people/chelen/feed',
        'label' => 'Chelen\'s GSoC 2012 (Undo / UI)',
        'author' => 'Chelen',
        'css' => 'blog',
        'url' => 'http://seenthis.net/people/chelen',
        'language' => 'fr',
        'format' => 'markdown',
    ),
    'http://googlesummerofscribus.blogspot.com/' => array (
        'feed' => 'http://googlesummerofscribus.blogspot.com/feeds/posts/default?alt=rss',
        'label' => 'Rajat\'s GSoC 2012 (Project manager)',
        'author' => 'Rajat',
        'css' => 'blog',
        'url' => 'http://googlesummerofscribus.blogspot.in/',
    ),
    'http://summerofscribus.blogspot.com/' => array (
        'feed' => 'http://summerofscribus.blogspot.com/feeds/posts/default?alt=rss',
        'label' => 'Parthasarathy \'s GSoC 2012 (New file format)',
        'author' => 'Parthasarathy',
        'css' => 'blog',
        'url' => 'http://summerofscribus.blogspot.in/',
    ),
    'http://blog.gmane.org/gmane.comp.graphics.scribus' => array (
        'feed' => 'http://rss.gmane.org/topics/excerpts/gmane.comp.graphics.scribus',
        'label' => 'Threads from the Scribus mailing list',
        'author' => 'Scribus',
        'css' => 'mailinglist',
        'format' => 'text',
        'url' => 'http://lists.scribus.net/pipermail/scribus',
    ),
    'http://blog.gmane.org/gmane.comp.graphics.scribus.scm' => array (
        'feed' => 'http://rss.gmane.org/topics/excerpts/gmane.comp.graphics.scribus.scm',
        'label' => 'Commits to the Scribus main source code',
        'author' => 'Scribus',
        'css' => 'source-code',
        'format' => 'text',
        'url' => 'http://lists.scribus.net/pipermail/scribus-commit',
    ),
    'http://www.linuxgraphic.org/forums/index.php' => array (
        'feed' => 'http://www.linuxgraphic.org/forums/feed.php?f=20',
        'label' => 'Forum de Linuxgraphics sur Scribus',
        'author' => 'Linuxgraphics',
        'css' => 'forum',
        'url' => 'http://www.linuxgraphic.org/forums/viewforum.php?f=20',
        'language' => 'fr',
        'format' => 'markdown',
    ),
    'http://scribus-forum.de/node/3/feed' => array (
        'feed' => 'http://scribus-forum.de/node/3/feed',
        'label' => 'Scribus Forum: Die deutschsprachige Scribus Community',
        'author' => 'ScribusForum-de',
        'css' => 'forum',
        'url' => 'http://scribus-forum.de/group/scribus-rund-um-das-dtp-programm',
        'language' => 'de',
        'format' => 'markdown',
    ),
);

$template_head = <<<EOT
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>Scribus Planet</title>
  <meta name="description" content="Aggregated news and feeds about the Scribus desktop publishing software">
  <meta name="viewport" content="width=device-width">
  <link href='//fonts.googleapis.com/css?family=Quattrocento+Sans:400,700' rel='stylesheet' type='text/css'>
  <link rel="stylesheet" href="css/style.css"> 
  <link rel="stylesheet" href="css/color-blue.css">  
  
  <!--[if lt IE 9]>
  <script src="//html5shim.googlecode.com/svn/trunk/html5.js"></script>
  <![endif]-->
</head>
EOT;
$template_body_start = <<<EOT
<body>
  <div class="container">
EOT;
$template_body_header = <<<EOT
  <header>
    <div class="header">
      <div class="wrapper">
        
        <!-- logo/sitename -->
        <a href="http://impagina.org/" id="logo" ><img src="http://impagina.org/theme/Innovation/assets/images/impagina_logo.png" /></a>
        
        <!-- main navigation -->
        <nav id="main-nav">

          <ul>
            <li><a href="http://impagina.org/" title="Resources for the Scribus contributors">Home</a></li>
<li class="current planet"><a href="http://impagina.org/planet/" title="Planet">Planet</a></li>
<li class="usability"><a href="http://impagina.org/usability/" title="Scribus UX / UI Design">Usability</a></li>
<li class="projects"><a href="http://impagina.org/projects/" title="Projects">Projects</a></li>
<li class="about"><a href="http://impagina.org/about/" title="About">About</a></li>
<li class="contact"><a href="http://impagina.org/contact/" title="Contact">Contact</a></li>
          </ul>

        </nav>
      </div>
    </div>
    
  </header>
EOT;
$template_body_intro = <<<EOT
		<div class="intro">
			<div class="inside">
			  <h1 class="h1 intro-title"><a href="{{href}}" class="black">Scribus Planet</a></h1>
			  <p>This is the Scribus Planet and it collects posts from:</p>
			  <ul class="feed-list">
              {{foreach::list::<li class="li"><a href="{{url}}">{{label}}</a></li>::endforeach}}
			  </ul>
              <p>Please <a href="http://impagina.org/contact/">let us know</a> if there are other feeds that should be included.</p>
               <p>CSS &amp; Design by <a href="http://greyscalepress.com/">Manuel Schmalsteig</a>; PHP glue code by <a href="http://ideale.ch">Ale Rimoldi</a></p>
			</div>
		</div>
EOT;
$template_body_feed_start = <<<EOT
		<section class="planet-container">
			<div id="freetile">
				<div class="freetile-container">
EOT;
$template_body_feed_end = <<<EOT
  			</div>
      </div>
    </section>
EOT;
$template_body_end = <<<EOT
	</div>
	
	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
	<script>window.jQuery || document.write('<script src="js/libs/jquery-1.8.2.min.js"><\/script>')</script>
	<script src="js/jquery.freetile.min.js"></script>
	<script src="js/scripts.js"></script>
</body>
</html>
EOT;
$template_body_feed_item = <<<EOT
			    <article id="planet-item-{{id}}" class="item {{css_article_class}}">
				    <div class="inside item-inside">
				      <h2 class="h2 item-title"><a href="{{href}}">{{title}}</a></h2>
				      {{if::translate!::<p>[ <a href="http://www.google.com/translate?u={{href}}&hl=en&ie=UTF8&langpair={{translate}}|en">Translate</a> ]</p>::endif}}
				
				      <div class="post-content">{{content}}
				      
                      {{if::content_long=1::
				        <div class="bottom-gradient"></div>
                      ::endif}}
				       </div>
				       <div class="open-close open-button hidden"><a href="#" class="closed black">read more</a></div>
				       <div class="open-close close-button hidden"><a href="#" class="closed black close-button">close</a></div>
				       <div class="post-meta">
                       <p><small class="post-author secondary">Posted by {{author}}</small></p>
	              	<p><small class="post-date secondary">on {{date}}</small></p>
				       </div>
				    </div>
			    </article>
EOT;

require_once('simplepie/autoloader.php');
 
// We'll process this feed with all of the default options.
$feed = new SimplePie();

 
// Set which feed to process.
$list = array();
$template_feeld_list_values = array();
foreach ($feed_source as $key => $value) {
    $list[] = $value['feed'];

    $template_feeld_list_values[] = array (
        'url' => $value['url'],
        'label' => $value['label'],
    );
}
$feed->set_feed_url($list);
unset($list);
 
// Run SimplePie.
$feed->init();
 
// This makes sure that the content is sent to the browser as text/html and the UTF-8 character set (since we didn't change it).
$feed->handle_content_type();

if ($feed->error())
{
    // debug('error', $feed->error());
}

$template_body_intro_values = array (
    'href' => $feed->get_permalink(),
    'list' => $template_feeld_list_values,
);
$template_body_feed_item_values = array();
$id = 0;
foreach ($feed->get_items() as $item) {
    // debug('item', $item);
    // debug('item permalink', $item->get_permalink());
    // debug('feed permalink', $item->get_feed()->get_permalink());
    if (stripos($item->get_title(), 'Wallflux') !== false) { continue; }

    $template_item = array(
        'id' => '',
        'content' => '',
        'content_long' => false,
        'author' => '',
        'translate' => '',
        'date' => '',
        'css_article_class' => '',
    );

    $feed_link = $item->get_feed()->get_permalink(); // the permalink of the item's feed is the only way to find out to what source belongs the specific item and, then, access the settings defined above

    if (!array_key_exists($feed_link, $feed_source)) {
        debug('feed not correctly registered: fix the key', $feed_link);
        continue;
    }

    if ($feed_source[$feed_link]['label'] == 'Forum de Linuxgraphics sur Scribus') {
        // debug('item permalink', $item->get_title());
        if (substr(strtr($item->get_title(), '• ', ''), 0, 18) == "Scribus &bull; Re:")
        {
            continue;
        }
    }


    $template_item['href'] = $item->get_permalink();
    $template_item['title'] = $item->get_title();

    $template_item['content'] = $item->get_description();

    if ($feed_link == 'http://blog.gmane.org/gmane.comp.graphics.scribus.scm') {
        $content = explode("\n", substr($template_item['content'], 5));
        $template_item['content'] = '';
        // debug('content', $content);
        $n = count($content);
        $i = 0;
        $step = 0;
        while ($i < $n) {
            // debug($content[$i]);
            $line = $content[$i];
            switch ($step) {
                case 0 :
                    if (substr($line, 0, 7) == 'Author:') {
                        $template_item['author'] = substr($line, 8);
                        $template_item['content'] .= $template_item['author'].":\n";
                        $step++;
                    }
                case 1 :
                    if (substr($line, 0, 4) == 'URL:') {
                        // $template_item['href'] = substr($line, 5);
                        $step++;
                    }
                break;
                case 2 :
                    if (substr($line, 0, 4) == 'Log:') {
                        $step++;
                    }
                break;
                case 3 :
                    if ($line != '') {
                        $template_item['content'] .= $line;
                    } else {
                        $step++;
                    }
                break;
                case 4 :
                    if (substr($line, 0, 9) == 'Modified:') {
                        $template_item['content'] .= "\nModified\n";
                        $step++;
                    }
                break;
                case 5 :
                    if ($line != '') {
                        $template_item['content'] .= $line;
                    } else {
                        $step++;
                    }
                break;
            }
            $i++;
        }
    } elseif ($feed_link =='http://scribus-forum.de/node/3/feed') {
        // debug('content', $template_item['content']);
        $template_item['content'] = str_replace("<div><ul><li><a href=\"http://scribus-forum.de/group/scribus-rund-um-das-dtp-programm\">Scribus - rund um das DTP-Programm</a></li>\n</ul></div>", "", $template_item['content']);
        $template_item['content'] = str_replace("</p></p>", "<p>", $template_item['content']);
        $template_item['content'] = str_replace("</p>", "</p>", $template_item['content']);
    }

    if (in_array($feed_source[$feed_link]['css'], array('mailinglist', 'source-code'))) {
        if (false !== (substr($template_item['content'], 0, 5) == '<pre>')) {
            $template_item['content'] = substr($template_item['content'], 5);
        }
        if (false !== ($pos = stripos($template_item['content'], '-------------- next part --------------'))) {
            $template_item['content'] = substr($template_item['content'], 0, $pos);
        }
        if (false !== ($pos = stripos($template_item['content'], '___'))) {
            $template_item['content'] = substr($template_item['content'], 0, $pos);
        }
    }
    if (array_key_exists('format', $feed_source[$feed_link])) {
        switch ($feed_source[$feed_link]['format']) {
            case 'markdown' :
                include_once('markdown.php');
                $template_item['content'] = Markdown($template_item['content']);
            break;
            case 'text' :
                $template_item['content'] = "<p>".preg_replace("/(<br \/>){2,}/", "</p>\n<p>", strtr($template_item['content'], array("\n" => "<br />")))."</p>";
            break;
        }
    }

    if (strlen($template_item['content']) > 450) {
        $template_item['css_article_class'] .= ' long-post';
        $template_item['content_long'] = true;
    }
    if (array_key_exists($item->get_feed()->get_link(), $feed_source)) {
        $template_item['css_article_class'] .= ' '.$feed_source[$item->get_feed()->get_link()]['css'];
    }

    if ($template_item['author'] == '') {
        if (array_key_exists('child', $item->data) && array_key_exists('', $item->data['child'])) {
            if (array_key_exists('author', $item->data['child'][''])) {
                $template_item['author'] = $item->data['child']['']['author'][0]['data'];
            } elseif (array_key_exists('title', $item->data['child']['']) && (substr($item->data['child']['']['title'][0]['data'], 0, 18) == 'Group wall post by')) {
                $template_item['author'] = substr($item->data['child']['']['title'][0]['data'], 19);
            } elseif (array_key_exists('description', $item->data['child'][''])) {
                preg_match("/^(\w+) (\w+) (\w+)/", $item->data['child']['']['description'][0]['data'], $matches);
                if (count($matches) > 2) {
                    if ($matches[3] == 'to' || $matches[3] == 'posted') {
                        $template_item['author'] = $matches[1].' '.$matches[2];
                    }
                }
            }
        }
    }
    if ($template_item['author'] == '') {
        $template_item['author'] = $feed_source[$item->get_feed()->get_link()]['author'];
        $author = $feed_source[$item->get_feed()->get_link()]['author'];
    }

    $template_item['date'] = $item->get_date('j F Y | g:i a');

    $template_item['translate'] = ''; // 'fr'
    if (array_key_exists('language', $feed_source[$item->get_feed()->get_link()])) {
        $template_item['translate'] = $feed_source[$item->get_feed()->get_link()]['language'];
    }

    $template_item['id'] = ++$id;

    $template_body_feed_item_values[] = $template_item;
} // foreach $feeld->get_items()

echo($template_head);
echo($template_body_start);
echo($template_body_header);
echo(template($template_body_intro, $template_body_intro_values));
// TODO: use a while to output each item after it has been read...
foreach ($template_body_feed_item_values as $value) {
    echo(template($template_body_feed_item, $value));
}
echo($template_body_end);

// a very simple template engine, with if and foreach
function template($template, $parameter = null) {
    $result = '';
    $pattern = '/\{{(foreach|if)::(.*?)::(.*?)::(endforeach|endif)}}/s';
    // debug('parameter', $parameter);
    $result = preg_replace_callback(
        $pattern,
        function ($match)  use ($parameter) {
            $result = '';
            if ($match[1] == 'foreach') {
                foreach ($parameter[$match[2]] as $item) {
                    foreach ($item as $key => $value) {
                        unset($item[$key]);
                        $item['{{'.$key.'}}'] = $value;
                    }
                    $result .= strtr($match[3], $item);
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
