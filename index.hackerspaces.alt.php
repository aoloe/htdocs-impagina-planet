<?php

/**
 * TODO:
 * - add tags conditions for some blogs (like graphicslab): only read the posts tagged with scribus!
 */

$feed_list = array (
     'http://www.posttenebraslab.ch' => array (
        'feed' => 'http://www.posttenebraslab.ch/wiki/feed.php',
        'label' => 'Post Tenebras Lab (Geneva)',
        'css' => 'blog',
        'url' => 'http://www.posttenebraslab.ch/',
    ),
    'http://www.i3detroit.com/' => array (
        'feed' => 'http://www.i3detroit.com/feed',
        'label' => 'i3 Detroit',
        'css' => 'blog',
        'url' => 'http://www.i3detroit.com/',
    ),
    'http://earth.hackerspaces.org/' => array (
        'feed' => 'http://earth.hackerspaces.org/atom.xml',
        'label' => 'NYC Resistor',
        'css' => 'blog',
        'url' => 'http://earth.hackerspaces.org/',
    ),
);

$format = array();
$translate = array();
foreach ($feed_list as $key => $value) {
    if (array_key_exists('format', $value)) {
        $format[$value['url']] = $value['format'];
    }
    if (array_key_exists('language', $value)) {
        $translate[$value['url']] = $value['language'];
    }
}

require_once('simplepie/autoloader.php');
 
// We'll process this feed with all of the default options.
$feed = new SimplePie();

 
// Set which feed to process.
$list = array();
foreach ($feed_list as $key => $value) {
    $list[] = $value['feed'];
}
$feed->set_feed_url($list);
unset($list);
 
// Run SimplePie.
$feed->init();
 
// This makes sure that the content is sent to the browser as text/html and the UTF-8 character set (since we didn't change it).
$feed->handle_content_type();
 
// Let's begin our HTML webpage code.  The DOCTYPE is supposed to be the very first thing, so we'll keep it on the same line as the closing-PHP tag.
?><!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>HackerSpaces Planet</title>
  <meta name="description" content="Aggregated news and feeds about HackerSpaces">
  <meta name="viewport" content="width=device-width">
  <link href='//fonts.googleapis.com/css?family=Quattrocento+Sans:400,700' rel='stylesheet' type='text/css'>
  <link rel="stylesheet" href="css/style.css">
  <link rel="stylesheet" href="css/color-blue.css">  
  
  <!--[if lt IE 9]>
  <script src="//html5shim.googlecode.com/svn/trunk/html5.js"></script>
  <![endif]-->
</head>
<body>
  <div class="container">
		<header class="header">
			<div class="inside">
			  <h1 class="h1 header-title"><a href="<?php echo $feed->get_permalink(); ?>" class="black">HackerSpaces Planet</a></h1>
			  <p>This is the HackerSpaces Planet and it collects posts from:</p>
			  <ul class="feed-list">
			  <?php foreach ($feed_list as $key => $value) : ?>
			      <li class="li"><a href="<?php echo($value['url']); ?>"><?php echo($value['label']); ?></a></li>
			  <?php endforeach; ?>
			  </ul>
			</div>
		</header>
		<section class="planet-container">
			<div id="freetile">
				<div class="freetile-container">
  <?php
  /*
  Here, we'll loop through all of the items in the feed, and $item represents the current item in the loop.
  */
  foreach ($feed->get_items() as $item):
    if (substr($item->get_title(), 0, 8) == 'Wallflux') { continue; }
    $feed_link = $item->get_feed()->get_permalink();
    $content = $item->get_description();
    if (array_key_exists($feed_link, $format)) {
        switch ($format[$feed_link]) {
            case 'markdown' :
                include_once('markdown.php');
                $content = Markdown($content);
            break;
        }
    }
    $author = '';
    if (array_key_exists('child', $item->data) && array_key_exists('', $item->data['child'])) {
        if (array_key_exists('author', $item->data['child'][''])) {
            $author = $item->data['child']['']['author'][0]['data'];
        } elseif (array_key_exists('title', $item->data['child']['']) && (substr($item->data['child']['']['title'][0]['data'], 0, 18) == 'Group wall post by')) {
            $author = substr($item->data['child']['']['title'][0]['data'], 19);
        } elseif (array_key_exists('description', $item->data['child'][''])) {
            preg_match("/^(\w+) (\w+) (\w+)/", $item->data['child']['']['description'][0]['data'], $matches);
            if (count($matches) > 2) {
                if ($matches[3] == 'to' || $matches[3] == 'posted') {
                    $author = $matches[1].' '.$matches[2];
                }
            }
        }
    }
  ?>
			    <article class="item <?= strlen($content)>450 ? " long-post" : "" ?><?= array_key_exists($item->get_feed()->get_link(), $feed_list) ? ' '.$feed_list[$item->get_feed()->get_link()]['css'] : '' ?>">
				    <div class="inside item-inside">
              <?= array_key_exists($item->get_feed()->get_link(), $feed_list) ? '' : $item->get_feed()->get_link() ?>
				      <h2 class="h2 item-title"><a href="<?php echo $item->get_permalink(); ?>"><?php echo $item->get_title(); ?></a></h2>
				      <?php if (array_key_exists($feed_link, $translate)) : // TODO: add support for lang in item ?>
				      <p>[ <a href="http://www.google.com/translate?u=<?php echo($item->get_permalink()); ?> &hl=en&ie=UTF8&langpair=<?php echo($translate[$feed_link]); ?>|en">Translate</a> ]</p>
				      <?php endif; ?>
				
				      <div class="post-content"><?php echo $content;
				      
				      // add expansion for long content
				      if (strlen($content)>450) {
				        ?><div class="bottom-gradient"></div>
				        </div>
				        
				        <div class="open-close open-button hidden"><a href="#" class="closed black">read more</a></div>
				        
				        <div class="open-close close-button hidden"><a href="#" class="closed black close-button">close</a>
				        <?php
				      }
				      
				       ?></div>
				       <div class="post-meta">
                      <?php if ($author != '') : ?>
				      		<p><small class="post-author secondary">Posted by <?= $author; ?></small></p>
                      <?php endif; ?>
	              	<p><small class="post-date secondary"><?= $author == '' ? 'Posted ' : '' ?>on <?= $item->get_date('j F Y | g:i a'); ?></small></p>
				       </div>
				    </div>
			    </article>

  <?php endforeach; ?>
  			</div>
      </div>
    </section>
	</div>
	
	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
	<script>window.jQuery || document.write('<script src="js/libs/jquery-1.8.2.min.js"><\/script>')</script>
	<script src="js/jquery.freetile.min.js"></script>
	<script src="js/scripts.js"></script>
</body>
</html>
