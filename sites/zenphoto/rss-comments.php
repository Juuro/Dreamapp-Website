<?php
if (!defined('ZENFOLDER')) { define('ZENFOLDER', 'zp-core'); }
define('OFFSET_PATH', 0);
header('Content-Type: application/xml');
require_once(ZENFOLDER . "/template-functions.php");

$host = htmlentities($_SERVER["HTTP_HOST"], ENT_QUOTES, 'UTF-8');

if(isset($_GET['id'])) {
	$id = sanitize_numeric($_GET['id']);
} else {
	$id = "";
}
if(isset($_GET['title'])) {
	$title = " - ".sanitize($_GET['title']);
} else {
	$title = NULL;
}
if(isset($_GET['type'])) {
	$type = sanitize($_GET['type']);
} else {
	$type = "all";
}

if(isset($_GET['lang'])) {
	$locale = sanitize($_GET['lang']);
} else {
	$locale = getOption('locale');
}
$validlocale = strtr($locale,"_","-"); // for the <language> tag of the rss

if(getOption('mod_rewrite')) {
	$albumpath = "/"; $imagepath = "/"; $modrewritesuffix = getOption('mod_rewrite_image_suffix');
} else {
	$albumpath = "/index.php?album="; $imagepath = "&amp;image="; $modrewritesuffix = "";
}
$items = getOption('feed_items'); // # of Items displayed on the feed
?>

<rss version="2.0" xmlns:atom="http://www.w3.org/2005/Atom">
<channel>
<title><?php echo strip_tags(get_language_string(getOption('gallery_title'), $locale))." - ".gettext("latest comments").$title; ?></title>
<link><?php echo "http://".$host.WEBPATH; ?></link>
<atom:link href="http://<?php echo $host.WEBPATH; ?>/rss-comments.php" rel="self" type="application/rss+xml" />
<description><?php echo get_language_string(getOption('gallery_title'), $locale); ?></description>
<language><?php echo $validlocale; ?></language>
<pubDate><?php echo date("r", time()); ?></pubDate>
<lastBuildDate><?php echo date("r", time()); ?></lastBuildDate>
<docs>http://blogs.law.harvard.edu/tech/rss</docs>
<generator>ZenPhoto Comment RSS Generator</generator>
<?php
	$admin = getAdministrators();
	$admin = array_shift($admin);
	$adminname = $admin['user'];
	$adminemail = $admin['email'];
?>
<managingEditor><?php echo "$adminemail ($adminname)"; ?></managingEditor>
<webMaster><?php echo "$adminemail ($adminname)"; ?></webMaster>

<?php
$comments = getLatestComments($items);
foreach ($comments as $comment) {
	if($comment['anon'] === "0") {
		$author = " ".gettext("by")." ".$comment['name'];
	} else {
		$author = "";
	}
	$album = $comment['folder'];
	if($comment['type'] != "albums" AND $comment['type'] != "news" AND $comment['type'] != "pages") { // check if not comments on albums or Zenpage items
		$imagetag = $imagepath.$comment['filename'].$modrewritesuffix;
	} else {
		$imagetag = "";
	}
	$date = $comment['date'];
	$albumtitle = $comment['albumtitle'];
	if ($comment['title'] == "") $title = $image; else $title = get_language_string($comment['title']);
	$website = $comment['website'];
	if(!empty($title)) {
		$title = ": ".$title;
	}
?>
<item>
<title><?php echo strip_tags($albumtitle.$title.$author); ?></title>
<link><?php echo '<![CDATA[http://'.$host.WEBPATH.$albumpath.$album.$imagetag.']]>';?></link>
<description><?php echo $comment['comment']; ?></description>
<category><?php echo strip_tags($albumtitle); ?></category>
<guid><?php echo '<![CDATA[http://'.$host.WEBPATH.$albumpath.$album.$imagetag.']]>';?></guid>
<pubDate><?php echo date("r",strtotime($date)); ?></pubDate>
</item>
<?php } ?>
</channel>
</rss>

