<?php

/**
 * TODO:
 * - add tags conditions for some blogs (like graphicslab): only read the posts tagged with scribus!
 */

$feed_list = array (
    'http://gplus-to-rss.appspot.com/rss/109612024486187515483' => array (
        'label' => 'g+',
        'css' => 'google-plus',
        'url' => 'https://plus.google.com/b/109612024486187515483/109612024486187515483/posts'
    ),
    'http://api.twitter.com/1/statuses/user_timeline.rss?screen_name=scribus' => array (
        'label' => 'twitter',
        'css' => 'twitter',
        'url' => 'http://twitter.com/scribus',
    ),
    'http://www.wallflux.com/info/114175708594284' => array (
        'label' => 'facebook',
        'css' => 'facebook',
        'url' => 'http://www.facebook.com/groups/114175708594284/',
    ),
    
    'http://rants.scribus.net/feed/' => array (
        'label' => 'Scribus developer blog',
        'css' => 'scribus-dev-blog blog',
        'url' => 'http://rants.scribus.net',
    ),
    'http://graphicslab.org/blog/?rss' => array (
        'label' => 'a.l.e\'s graphicslab',
        'css' => 'graphicslab blog',
        'url' => 'http://graphicslab.org/blog',
        'tag' => 'scribus',
    ),
    'http://seenthis.net/people/chelen/feed' => array (
        'label' => 'Chelen\'s GSoC 2012 (Undo / UI)',
        'css' => 'gsoc blog',
        'url' => 'http://seenthis.net/people/chelen',
        'language' => 'fr',
        'format' => 'markdown',
    ),
    'http://googlesummerofscribus.blogspot.com/feeds/posts/default?alt=rss' => array (
        'label' => 'Rajat\'s GSoC 2012 (Project manager)',
        'css' => 'gsoc blog',
        'url' => 'http://googlesummerofscribus.blogspot.in/',
    ),
    'http://summerofscribus.blogspot.com/feeds/posts/default?alt=rss' => array (
        'label' => 'Parthasarathy \'s GSoC 2012 (New file format)',
        'css' => 'gsoc blog',
        'url' => 'http://summerofscribus.blogspot.in/',
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
$feed->set_feed_url(array_keys($feed_list));
 
// Run SimplePie.
$feed->init();
 
// This makes sure that the content is sent to the browser as text/html and the UTF-8 character set (since we didn't change it).
$feed->handle_content_type();
 
// Let's begin our HTML webpage code.  The DOCTYPE is supposed to be the very first thing, so we'll keep it on the same line as the closing-PHP tag.
?><!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>Scribus Planet</title>
  <meta name="description" content="Aggregated news and feeds about the Scribus desktop publishing software">
  <meta name="viewport" content="width=device-width">
  <link href='//fonts.googleapis.com/css?family=Quattrocento+Sans:400,700' rel='stylesheet' type='text/css'>
  <link rel="stylesheet" href="css/style.css">
</head>
<body>
  <div class="container">
		<header class="header">
			<div class="inside">
			  <h1 class="h1 header-title"><a href="<?php echo $feed->get_permalink(); ?>">Scribus Planet</a></h1>
			  <p>This is the Scribus Planet and it collects posts from:</p>
			  <ul class="feed-list">
			  <?php foreach ($feed_list as $key => $value) : ?>
			      <li class="li"><a href="<?php echo($value['url']); ?>"><?php echo($value['label']); ?></a></li>
			  <?php endforeach; ?>
			  </ul>
			</div>
		</header>
 
  <?php
  /*
  Here, we'll loop through all of the items in the feed, and $item represents the current item in the loop.
  */
  foreach ($feed->get_items() as $item):
    if ($item->get_title() == 'Wallflux demonstration - live') { continue; }
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
  ?>
 
    <article class="item <?php echo($value['css']); ?>">
	    <div class="inside">
	      <h2 class="h2 item-title"><a href="<?php echo $item->get_permalink(); ?>"><?php echo $item->get_title(); ?></a></h2>
	      <?php if (array_key_exists($feed_link, $translate)) : // TODO: add support for lang in item ?>
	      <p>[ <a href="http://www.google.com/translate?u=<?php echo($item->get_permalink()); ?> &hl=en&ie=UTF8&langpair=<?php echo($translate[$feed_link]); ?>|en">Translate</a> ]</p>
	      <?php endif; ?>
	
	      <p><?php echo $content; ?></p>
	      <p><small>Posted on <?php echo $item->get_date('j F Y | g:i a'); ?></small></p>
	    </div>
    </article>
 
  <?php endforeach; ?>
	</div>
</body>
</html>
