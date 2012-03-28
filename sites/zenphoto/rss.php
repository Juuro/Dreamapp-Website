<?php
if (!defined('ZENFOLDER')) { define('ZENFOLDER', 'zp-core'); }
define('OFFSET_PATH', 0);
header('Content-Type: application/xml');
require_once(ZENFOLDER . "/template-functions.php");
require_once(ZENFOLDER . "/plugins/image_album_statistics.php");

if(isset($_GET['albumname'])) {
	$albumfolder = sanitize_path($_GET['albumname']);
	$collection = FALSE;
} else if(isset($_GET['folder'])) {
	$albumfolder = sanitize_path($_GET['folder']);
	$collection = TRUE;
} else {
	$albumfolder = NULL;
	$collection = FALSE;
}

if(isset($_GET['lang'])) {
	$locale = sanitize($_GET['lang']);
} else {
	$locale = getOption('locale');
}

$validlocale = strtr($locale,"_","-"); // for the <language> tag of the rss
$host = htmlentities($_SERVER["HTTP_HOST"], ENT_QUOTES, 'UTF-8');

if(isset($_GET['albumtitle'])) { 
	$albumname = " (".sanitize(urldecode($_GET['albumtitle'])).")";
} else {
	$albumname = "";
}

if(getOption('mod_rewrite')) {
	$albumpath = "/"; $imagepath = "/"; 
	$modrewritesuffix = getOption('mod_rewrite_image_suffix');
} else  {
	$albumpath = "/index.php?album="; 
	$imagepath = "&amp;image="; 
	$modrewritesuffix = ""; }

if(isset($_GET['size'])) {
	$size = sanitize_numeric($_GET['size']);
} else {
	$size = NULL;
}
if(is_numeric($size) && !is_null($size) && $size < getOption('feed_imagesize')) {
	$size = $size;
} else {
	$size = getOption('feed_imagesize'); // uncropped image size
}
$items = getOption('feed_items'); // # of Items displayed on the feed

?>
<rss version="2.0" xmlns:atom="http://www.w3.org/2005/Atom">
<channel>
<title><?php echo strip_tags(get_language_string(getOption('gallery_title'), $locale)).strip_tags($albumname); ?></title>
<link><?php echo "http://".$host.WEBPATH; ?></link>
<atom:link href="http://<?php echo $host.WEBPATH; ?>/rss.php" rel="self" type="application/rss+xml" />
<description><?php echo strip_tags(get_language_string(getOption('gallery_title'), $locale)); ?></description>
<language><?php echo $validlocale; ?></language>
<pubDate><?php echo date("r", time()); ?></pubDate>
<lastBuildDate><?php echo date("r", time()); ?></lastBuildDate>
<docs>http://blogs.law.harvard.edu/tech/rss</docs>
<generator>ZenPhoto RSS Generator</generator>
<?php
	$admins = getAdministrators();
	$admin = array_shift($admins);
	$adminname = $admin['user'];
	$adminemail = $admin['email'];
?>
<managingEditor><?php echo "$adminemail ($adminname)"; ?></managingEditor>
<webMaster><?php echo "$adminemail ($adminname)"; ?></webMaster>
<?php
$result = getImageStatistic($items,getOption("feed_sortorder"),$albumfolder,$collection);

foreach ($result as $image) {
	$ext = strtolower(strrchr($image->filename, "."));
	$albumobj = $image->getAlbum();
	$imagelink = $host.WEBPATH.$albumpath.$albumobj->name.$imagepath.$image->filename.$modrewritesuffix;
	$fullimagelink = $host.WEBPATH."/albums/".$albumobj->name."/".$image->filename;
	$thumburl = '<img border="0" src="'.$image->getCustomImage($size, NULL, NULL, NULL, NULL, NULL, NULL, TRUE).'" alt="'. $image->getTitle() .'" />';
	$imagecontent = '<![CDATA[<a title="'.$image->getTitle().' in '.$albumobj->getTitle().'" href="http://'.$imagelink.'">'.$thumburl.'</a><p>' . $image->getDesc() . '</p>]]>';
	$videocontent = '<![CDATA[<a title="'.$image->getTitle().' in '.$albumobj->getTitle().'" href="http://'.$imagelink.'">'. $image->filename.'</a><p>' . $image->getDesc() . '</p>]]>';
	$datecontent = '<![CDATA[Date: '.zpFormattedDate(getOption('date_format'),$image->get('mtime')).']]>';
	switch($ext) {
		case  ".flv":
			$mimetype = "video/x-flv";
			break;
		case ".mp3":
			$mimetype = "audio/mpeg";
			break;
		case ".mp4":
			$mimetype = "video/mpeg";
			break;
		case ".3gp":
			$mimetype = "video/3gpp";
			break;
		case ".mov":
			$mimetype = "video/quicktime";
			break;
		case ".jpg":
		case ".jpeg":
			$mimetype = "image/jpeg";
			break;
		case ".gif":
			$mimetype = "image/gif";
			break;
		case ".png":
			$mimetype = "image/png";
			break;
		default:
			$mimetype = "image/jpeg";
			break;
	}
?>
<item>
	<title><?php echo $image->getTitle()." (".$albumobj->getTitle().")"; ?></title>
	<link><?php echo '<![CDATA[http://'.$imagelink. ']]>';?></link>
	<description>
<?php
if (($ext == ".flv") || ($ext == ".mp3") || ($ext == ".mp4") ||  ($ext == ".3gp") ||  ($ext == ".mov")) {
	echo $videocontent;
} else {
	echo $imagecontent; } ?>
	<?php  echo $datecontent; ?>
</description>
<?php 
if(getOption("feed_enclosure")) { // enables download of embeded content like images or movies in some rss clients. just for testing, shall become a real option
?>
<enclosure url="<?php echo $fullimagelink; ?>" type="<?php echo $mimetype; ?>" />
<?php  } ?>
<category><?php echo $albumobj->getTitle(); ?></category>
	<guid><?php echo '<![CDATA[http://'.$imagelink.']]>';?></guid>
	<pubDate><?php echo date("r",strtotime($image->get('date'))); ?></pubDate>
	<?php if(getOption("feed_mediarss")) { ?>
	<media:content url="http://<?php echo $fullimagelink; ?>" 
			type="image/jpeg">
			<media:thumbnail url="<![CDATA[<?php echo $image->getCustomImage($size, NULL, NULL, NULL, NULL, NULL, NULL, TRUE); ?>]]>" width="<?php echo $size; ?>" height="<?php echo $size; ?>"/>
			<media:title type="plain"><?php echo strip_tags($image->getTitle()); ?></media:title>
			<media:description type="plain"><?php echo strip_tags($image->getDesc()); ?></media:description>
			<media:credit role="illustrator"><?php echo $adminname; ?></media:credit>
	</media:content>
	<?php } ?>
</item>
<?php } ?>
</channel>
</rss>