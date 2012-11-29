<?php

$feed_list = array (
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
    'http://googlesummerofscribus.blogspot.in/' => array (
        'feed' => 'http://googlesummerofscribus.blogspot.com/feeds/posts/default?alt=rss',
        'label' => 'Rajat\'s GSoC 2012 (Project manager)',
        'author' => 'Rajat',
        'css' => 'blog',
        'url' => 'http://googlesummerofscribus.blogspot.in/',
    ),
    'http://summerofscribus.blogspot.in/' => array (
        'feed' => 'http://summerofscribus.blogspot.com/feeds/posts/default?alt=rss',
        'label' => 'Parthasarathy \'s GSoC 2012 (New file format)',
        'author' => 'Parthasarathy',
        'css' => 'blog',
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
<body>
  <div class="container">
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

		<div class="intro">
			<div class="inside">
			  <h1 class="h1 intro-title"><a href="<?php echo $feed->get_permalink(); ?>" class="black">Scribus Planet</a></h1>
			  <p>This is the Scribus Planet and it collects posts from:</p>
			  <ul class="feed-list">
			  <?php foreach ($feed_list as $key => $value) : ?>
			      <li class="li"><a href="<?php echo($value['url']); ?>"><?php echo($value['label']); ?></a></li>
			  <?php endforeach; ?>
			  </ul>
              <p>Please <a href="http://impagina.org/contact/">let us know</a> if there are other feeds that should be included.</p>
			</div>
		</div>
		<section class="planet-container">
			<div id="freetile">
				<div class="freetile-container">
  <?php
  /*
  Here, we'll loop through all of the items in the feed, and $item represents the current item in the loop.
  */
  foreach ($feed->get_items() as $item):
    // echo("<pre>".print_r($item, 1)."</pre>");
    // if (substr($item->get_title(), 0, 8) == 'Wallflux') { continue; }
    if (stristr($item->get_title(), 'Wallflux')) { continue; }
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
    if ($author == '') {
        $author = $feed_list[$item->get_feed()->get_link()]['author'];
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
