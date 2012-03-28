<?php
/**
 * provides the Comments tab of admin
 * @package admin
 */

// force UTF-8 Ø

define('OFFSET_PATH', 1);
require_once(dirname(__FILE__).'/admin-functions.php');

if (!($_zp_loggedin & (ADMIN_RIGHTS | COMMENT_RIGHTS))) { // prevent nefarious access to this page.
	header('Location: ' . FULLWEBPATH . '/' . ZENFOLDER . '/admin.php?from=' . currentRelativeURL() );
	exit();
}

if (getOption('zenphoto_release') != ZENPHOTO_RELEASE) {
	header("Location: " . FULLWEBPATH . "/" . ZENFOLDER . "/setup.php");
	exit();
}


$gallery = new Gallery();
if (isset($_GET['page'])) {
	$page = $_GET['page'];
} else {
	$page = '';
}
if (isset($_GET['fulltext']) && $_GET['fulltext']) $fulltext = true; else $fulltext = false;
if (isset($_GET['viewall'])) $viewall = true; else $viewall = false;

/* handle posts */
if (isset($_GET['action'])) {
	switch ($_GET['action']) {
	
	case "unapprove":
		$sql = 'UPDATE ' . prefix('comments') . ' SET `inmoderation`=1 WHERE `id`=' . $_GET['id'] . ';';
		query($sql);
		header('Location: ' . FULLWEBPATH . '/' . ZENFOLDER . '/admin-comments.php');
		exit();

	case "moderation":
		$sql = 'UPDATE ' . prefix('comments') . ' SET `inmoderation`=0 WHERE `id`=' . $_GET['id'] . ';';
		query($sql);
		header('Location: ' . FULLWEBPATH . '/' . ZENFOLDER . '/admin-comments.php');
		exit();
	
	case 'deletecomments':
		if (isset($_POST['ids']) || isset($_GET['id'])) {
			if (isset($_GET['id'])) {
				$ids = array($_GET['id']);
			} else {
				$ids = $_POST['ids'];
			}
			$total = count($ids);
			if ($total > 0) {
				$n = 0;
				$sql = "DELETE FROM ".prefix('comments')." WHERE ";
				foreach ($ids as $id) {
					$n++;
					$sql .= "id='$id' ";
					if ($n < $total) $sql .= "OR ";
				}
				query($sql);
			}
			header("Location: " . FULLWEBPATH . "/" . ZENFOLDER . "/admin-comments.php?ndeleted=$n");
			exit();
		} else {
			header("Location: " . FULLWEBPATH . "/" . ZENFOLDER . "/admin-comments.php?ndeleted=0");
			exit();
		}

	case 'savecomment':
		if (!isset($_POST['id'])) {
			header("Location: " . FULLWEBPATH . "/" . ZENFOLDER . "/admin-comments.php");
			exit();
		}
		$id = $_POST['id'];
		$name = mysql_real_escape_string(sanitize($_POST['name'], 3));
		$email = mysql_real_escape_string(sanitize($_POST['email'], 3));
		$website = mysql_real_escape_string(sanitize($_POST['website'], 3));
		$date = mysql_real_escape_string(sanitize($_POST['date'], 3));
		$comment = mysql_real_escape_string(sanitize($_POST['comment'], 1));

		$sql = "UPDATE ".prefix('comments')." SET `name` = '$name', `email` = '$email', `website` = '$website', `comment` = '$comment' WHERE id = $id";
		query($sql);

		header("Location: " . FULLWEBPATH . "/" . ZENFOLDER . "/admin-comments.php?sedit");
		exit();

	}
}


printAdminHeader();
echo "\n</head>";
echo "\n<body>";
printLogoAndLinks();
echo "\n" . '<div id="main">';
printTabs('comments');
echo "\n" . '<div id="content">';

if ($page == "editcomment" && isset($_GET['id']) ) { ?>
<h1><?php echo gettext("edit comment"); ?></h1>
<?php
	$id = $_GET['id'];
	
	$commentarr = query_single_row("SELECT * FROM ".prefix('comments')." WHERE id = $id LIMIT 1");
	extract($commentarr);
	?>

<form action="?action=savecomment" method="post"><input
	type="hidden" name="id" value="<?php echo $id; ?>" />
<table style="float:left;margin-right:2em;">

	<tr>
		<td width="100"><?php echo gettext("Author:"); ?></td>
		<td><input type="text" size="40" name="name"
			value="<?php echo $name; ?>" /></td>
	</tr>
	<tr>
		<td><?php echo gettext("Web Site:"); ?></td>
		<td><input type="text" size="40" name="website"
			value="<?php echo $website; ?>" /></td>
	</tr>
	<tr>
		<td><?php echo gettext("E-Mail:"); ?></td>
		<td><input type="text" size="40" name="email"
			value="<?php echo $email; ?>" /></td>
	</tr>
	<tr>
		<td><?php echo gettext("Date/Time:"); ?></td>
		<td><input type="text" size="18" name="date"
			value="<?php echo $date; ?>" /></td>
	</tr>
	<tr>
		<td><?php echo gettext("IP:"); ?></td>
		<td><input type="text" disabled="disabled" size="18" name="date"
			value="<?php echo $IP; ?>" /></td>
	</tr>
	<tr>
		<td valign="top"><?php echo gettext("Comment:"); ?></td>
		<td><textarea rows="8" cols="60" name="comment" /><?php echo $comment; ?></textarea></td>
	</tr>
	<tr>
		<td></td>
		<td>
		<input type="submit" value="<?php echo gettext('save'); ?>" /> 
		<input type="button" value="<?php echo gettext('cancel'); ?>" onClick="window.location = '#';" />
		</td>

</table>
<div>
<h2><?php echo gettext('Comment management:'); ?></h2>
<?php
	if ($inmoderation) {
		$status_moderation = gettext('Comment is unapproved');
		$link_moderation = gettext('Approve');
		$title_moderation = gettext('Approve this comment');
		$url_moderation = '?action=moderation&id='.$id;
	} else {
		$status_moderation = gettext('Comment is approved');
		$link_moderation = gettext('Unapprove');
		$title_moderation = gettext('Unapprove this comment');
		$url_moderation = '?action=unapprove&id='.$id;
	}
	
	if ($private) {
		$status_private = gettext('Comment is private');
	} else {
		$status_private = gettext('Comment is public');
	}

	if ($anon) {
		$status_anon = gettext('Comment is anonymous');
	} else {
		$status_anon = gettext('Comment is not anonymous');
	}


?>
<ul>
<li><?php echo $status_moderation; ?>. <a href="<?php echo $url_moderation; ?>" title="<?php echo $title_moderation; ?>" ><?php echo $link_moderation; ?></a></li>
<li><?php echo $status_private; ?></li>
<li><?php echo $status_anon; ?></li>
<li><a href="javascript: if(confirm('<?php echo gettext('Are you sure you want to delete this comment?'); ?>')) { window.location='?action=deletecomments&id=<?php echo $id; ?>'; }"
		title="<?php echo gettext('Delete this comment.'); ?>" >
		<?php echo gettext('Delete this comment'); ?></a></li>
</ul>
</div>
</form>

<?php
// end of $page == "editcomment"
} else {
	// Set up some view option variables.

	if (isset($_GET['fulltext']) && $_GET['fulltext']) {
		define('COMMENTS_PER_PAGE',10);
		$fulltext = true;
		$fulltexturl = '?fulltext=1';
	} else {
		define('COMMENTS_PER_PAGE',20);
		$fulltext = false;
		$fulltexturl = '';
	}
	$allcomments = fetchComments(NULL);

	if (isset($_GET['subpage'])) {
		$pagenum = max(intval($_GET['subpage']),1);
	} else {
		$pagenum = 1;
	}

	$comments = array_slice($allcomments, ($pagenum-1)*COMMENTS_PER_PAGE, COMMENTS_PER_PAGE);
	$allcommentscount = count($allcomments);
	$totalpages = ceil(($allcommentscount / COMMENTS_PER_PAGE));
	?>
<h1><?php echo gettext("Comments"); ?></h1>

<?php /* Display a message if needed. Fade out and hide after 2 seconds. */
	if ((isset($_GET['ndeleted']) && $_GET['ndeleted'] > 0) || isset($_GET['sedit'])) { ?>
<div class="messagebox" id="fade-message"><?php if (isset($_GET['ndeleted'])) { ?>
<h2><?php echo $_GET['ndeleted']; ?> <?php echo gettext("Comments deleted successfully."); ?></h2>
<?php } ?> <?php if (isset($_GET['sedit'])) { ?>
<h2><?php echo gettext("Comment saved successfully."); ?></h2>
<?php } ?></div>
<?php } ?>

<p><?php echo gettext("You can edit or delete comments on your photos."); ?></p>

<?php if ($totalpages > 1) {?>
	<div align="center">
	<?php adminPageNav($pagenum,$totalpages,'admin-comments.php',$fulltexturl); ?>
	</div>
	<?php } ?>

<form name="comments" action="?action=deletecomments"
	method="post"	onSubmit="return confirm('<?php echo gettext("Are you sure you want to delete these comments?"); ?>');">
<input type="hidden" name="subpage" value="<?php echo $pagenum ?>">
<table class="bordered">
	<tr>
		<th>&nbsp;</th>
		<th><?php echo gettext("Album/Image"); ?></th>
		<th><?php echo gettext("Author/Link"); ?></th>
		<th><?php echo gettext("Date/Time"); ?></th>
		<th><?php echo gettext("Comment"); ?>
		<?php if(!$fulltext) { ?>(
			<a href="?fulltext=1<?php echo $viewall ? "&viewall":""; ?>"><?php echo gettext("View full text"); ?></a> ) <?php
		} else {
			?>( <a	href="admin-comments.php?fulltext=0"<?php echo $viewall ? "?viewall":""; ?>"><?php echo gettext("View truncated"); ?></a> )<?php
		} ?>
		</th>
		<th><?php echo gettext("E&#8209;Mail"); ?></th>
		<th><?php echo gettext("IP address"); ?></th>
		<th><?php echo gettext("Private"); ?></th>
		<th><?php echo gettext("Pending<br />approval"); ?></th>
		<th><?php echo gettext("Edit"); ?></th>
		<th><?php echo gettext("Delete"); ?>

	<?php
	foreach ($comments as $comment) {
		$id = $comment['id'];
		$author = $comment['name'];
		$email = $comment['email'];
		$link = gettext('<strong>database error</strong> '); // in case of such
		$image = '';
		$albumtitle = '';
		
		if(getOption("zp_plugin_zenpage")) {
			require_once(dirname(__FILE__).'/plugins/zenpage/zenpage-class-news.php');
			require_once(dirname(__FILE__).'/plugins/zenpage/zenpage-class-page.php');
		}
		// ZENPAGE: switch added for zenpage comment support
		switch ($comment['type']) {
			case "albums":
				$image = '';
				$title = '';
				$albmdata = query_full_array("SELECT `title`, `folder` FROM ". prefix('albums') .
 										" WHERE `id`=" . $comment['ownerid']);
				if ($albmdata) {
					$albumdata = $albmdata[0];
					$album = $albumdata['folder'];
					$albumtitle = get_language_string($albumdata['title']);
					$link = "<a href=\"".rewrite_path("/$album","/index.php?album=".urlencode($album))."\">".$albumtitle.$title."</a>";
					if (empty($albumtitle)) $albumtitle = $album;
				}
				break;
			case "news": // ZENPAGE: if plugin is installed
				if(getOption("zp_plugin_zenpage")) {
					$titlelink = '';
					$title = '';
					$newsdata = query_full_array("SELECT `title`, `titlelink` FROM ". prefix('zenpage_news') .
 										" WHERE `id`=" . $comment['ownerid']);
					if ($newsdata) {
						$newsdata = $newsdata[0];
						$titlelink = $newsdata['titlelink'];
						$title = get_language_string($newsdata['title']);
				  	$link = "<a href=\"".rewrite_path("/".ZENPAGE_NEWS."/".$titlelink,"/index.php?p=".ZENPAGE_NEWS."&amp;title=".urlencode($titlelink))."\">".$title."</a><br /> ".gettext("[news]");
					}
				}
				break;
			case "pages": // ZENPAGE: if plugin is installed
				if(getOption("zp_plugin_zenpage")) {
					$image = '';
					$title = '';
					$pagesdata = query_full_array("SELECT `title`, `titlelink` FROM ". prefix('zenpage_pages') .
 										" WHERE `id`=" . $comment['ownerid']);
					if ($pagesdata) {
						$pagesdata = $pagesdata[0];
						$titlelink = $pagesdata['titlelink'];
						$title = get_language_string($pagesdata['title']);
						$link = "<a href=\"".rewrite_path("/".ZENPAGE_PAGES."/".$titlelink,"/index.php?p=".ZENPAGE_PAGES."&amp;title=".urlencode($titlelink))."\">".$title."</a><br /> ".gettext("[page]");
					}
				}
				break;
			default: // all the image types
				$imagedata = query_full_array("SELECT `title`, `filename`, `albumid` FROM ". prefix('images') .
 										" WHERE `id`=" . $comment['ownerid']);
				if ($imagedata) {
					$imgdata = $imagedata[0];
					$image = $imgdata['filename'];
					if ($imgdata['title'] == "") $title = $image; else $title = get_language_string($imgdata['title']);
					$title = '/ ' . $title;
					$albmdata = query_full_array("SELECT `folder`, `title` FROM ". prefix('albums') .
 											" WHERE `id`=" . $imgdata['albumid']);
					if ($albmdata) {
						$albumdata = $albmdata[0];
						$album = $albumdata['folder'];
						$albumtitle = get_language_string($albumdata['title']);
						$link = "<a href=\"".rewrite_path("/$album/$image","/index.php?album=".urlencode($album).	"&amp;image=".urlencode($image))."\">".$albumtitle.$title."</a>";
						if (empty($albumtitle)) $albumtitle = $album;
					}
				}
				break;
		}
		$date  = myts_date('%m/%d/%Y %I:%M %p', $comment['date']);
		$website = $comment['website'];
		$shortcomment = truncate_string($comment['comment'], 123);
		$fullcomment = $comment['comment'];
		$inmoderation = $comment['inmoderation'];
		$private = $comment['private'];
		$anon = $comment['anon'];
		?>

	<tr>
		<td><input type="checkbox" name="ids[]" value="<?php echo $id; ?>"
			onClick="triggerAllBox(this.form, 'ids[]', this.form.allbox);" /></td>
		<td><?php echo $link; ?></td>
		<td>
		<?php
		echo $website ? "<a href=\"$website\">$author</a>" : $author;
		if ($anon) {
			echo ' <a title="'.gettext('Anonymous posting').'"><img src="images/action.png" style="border: 0px;" alt="'. gettext("Anonymous posting").'" /></a>';
		}
		?>
		</td>
		<td><?php echo $date; ?></td>
		<td><?php echo ($fulltext) ? $fullcomment : $shortcomment; ?></td>
		<td align="center"><a
			href="mailto:<?php echo $email; ?>?body=<?php echo commentReply($fullcomment, $author, $image, $albumtitle); ?>" title="<?php echo gettext('Reply'); ?>">
		<img src="images/envelope.png" style="border: 0px;" alt="<?php echo gettext('Reply'); ?>" /></a></td>
		<td><?php echo $comment['ip']; ?></td>
		<td align="center">
			<?php
			if($private) {
				echo '<a title="'.gettext("Private message").'"><img src="images/reset.png" style="border: 0px;" alt="'. gettext("Private message").'" /></a>';
			}
			?>
		</td>
		<td align="center"><?php
		if ($inmoderation) {
			echo "<a href=\"?action=moderation&id=" . $id . "\" title=\"".gettext('Approve this message')."\">";
			echo '<img src="images/warn.png" style="border: 0px;" alt="'. gettext("Approve this message").'" /></a>';
		}
		?></td>
		<td align="center"><a href="?page=editcomment&id=<?php echo $id; ?>" title="<?php echo gettext('Edit this comment.'); ?>"> 
			<img src="images/pencil.png" style="border: 0px;" alt="<?php echo gettext('Edit'); ?>" /></a></td>
		<td align="center">
			<a href="javascript: if(confirm('<?php echo gettext('Are you sure you want to delete this comment?'); ?>')) { window.location='?action=deletecomments&id=<?php echo $id; ?>'; }"
			title="<?php echo gettext('Delete this comment.'); ?>" > <img
			src="images/fail.png" style="border: 0px;" alt="<?php echo gettext('Delete'); ?>" /></a></td>
	</tr>
	<?php } ?>
	<tr>
		<td colspan="11" class="subhead"><label><input type="checkbox"
			name="allbox" onClick="checkAll(this.form, 'ids[]', this.checked);" />
		<?php echo gettext("Check All"); ?></label></td>
	</tr>


</table>

<input type="submit" value="<?php echo gettext('Delete Selected Comments'); ?>" class="button" />


</form>

<?php
}

echo "\n" . '</div>';  //content
echo "\n" . '</div>';  //main

printAdminFooter();

echo "\n</body>";
echo "\n</html>";
?>



