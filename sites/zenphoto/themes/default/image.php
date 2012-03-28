<?php if (!defined('WEBPATH')) die(); $themeResult = getTheme($zenCSS, $themeColor, 'light'); $firstPageImages = normalizeColumns('2', '6');?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<?php zenJavascript(); ?>
	<title><?php echo getBareGalleryTitle(); ?> | <?php echo getBareAlbumTitle();?> | <?php echo getBareImageTitle();?></title>
	<link rel="stylesheet" href="<?php echo $zenCSS ?>" type="text/css" />
	<link rel="stylesheet" href="<?php echo FULLWEBPATH . "/" . ZENFOLDER ?>/js/thickbox.css" type="text/css" />
	<script src="<?php echo FULLWEBPATH . "/" . ZENFOLDER ?>/js/thickbox.js" type="text/javascript"></script>
	<script type="text/javascript">
		function toggleComments() {
			var commentDiv = document.getElementById("comments");
			if (commentDiv.style.display == "block") {
				commentDiv.style.display = "none";
			} else {
				commentDiv.style.display = "block";
			}
		}
	</script>
		<?php printRSSHeaderLink('Gallery',gettext('Gallery RSS')); ?>

</head>

<body>

<div id="main">

	<div id="gallerytitle">
		<div class="imgnav">
			<?php if (hasPrevImage()) { ?>
			<div class="imgprevious"><a href="<?php echo htmlspecialchars(getPrevImageURL());?>" title="<?php echo gettext("Previous Image"); ?>">&laquo; <?php echo gettext("prev"); ?></a></div>
			<?php } if (hasNextImage()) { ?>
			<div class="imgnext"><a href="<?php echo htmlspecialchars(getNextImageURL());?>" title="<?php echo gettext("Next Image"); ?>"><?php echo gettext("next"); ?> &raquo;</a></div>
			<?php } ?>
		</div>
		<h2><span><?php printHomeLink('', ' | '); ?><a href="<?php echo htmlspecialchars(getGalleryIndexURL());?>" title="<?php gettext('Albums Index'); ?>"><?php echo getGalleryTitle();?>
			</a> | <?php printParentBreadcrumb("", " | ", " | "); printAlbumBreadcrumb("", " | "); ?>
			</span> <?php printImageTitle(true); ?>
		</h2>

	</div>

	<!-- The Image -->
	<?php if (!checkForPassword()) { ?>
	<div id="image">
		<a href="<?php echo htmlspecialchars(getFullImageURL());?>" title="<?php echo getBareImageTitle();?>">
		<strong>
		<?php
		if (function_exists('printUserSizeImage')) {
			printUserSizeImage(getImageTitle());
		} else {
			printDefaultSizedImage(getImageTitle());
		}
		?>
		</strong>
		</a>
		<?php if (function_exists('printUserSizeImage')) printUserSizeSelectior(); ?>
	</div>

	<div id="narrow">
		<?php printImageDesc(true); ?>
		<?php if (function_exists('printSlideShowLink')) printSlideShowLink(gettext('View Slideshow')); ?>
		<hr /><br />
		<?php
			if (getImageEXIFData()) {echo "<div id=\"exif_link\"><a href=\"#TB_inline?height=345&amp;width=300&amp;inlineId=imagemetadata\" title=\"".gettext("Image Info")."\" class=\"thickbox\">".gettext("Image Info")."</a></div>";
				printImageMetadata('', false);
			}
		?>
		<?php printTags('links', gettext('<strong>Tags:</strong>').' ', 'taglist', ''); ?>
		<br clear=all />

		<?php if (function_exists('printImageMap')) printImageMap(); ?>

    <?php if (function_exists('printImageRating')) { printImageRating(); }?>

		<?php if (function_exists('printShutterfly')) printShutterfly(); ?>

		<?php if (getOption('Allow_comments')) { ?>
				<div id="comments">
		<?php $num = getCommentCount(); echo ($num == 0) ? "" : ("<h3>".sprintf(gettext('Comments (%u)'), $num)."</h3><hr />"); ?>
			<?php while (next_comment()){  ?>
			<div class="comment">
				<div class="commentmeta">
					<span class="commentauthor"><?php printCommentAuthorLink(); ?></span>
				</div>
				<div class="commentbody">
					<?php echo getCommentBody();?>
				</div>
				<div class="commentdate">
					<?php echo getCommentDateTime();?>
					<?php printEditCommentLink(gettext('Edit'), ' | ', ''); ?>
				</div>
			</div>
			<?php }; ?>

			<?php if (OpenedForComments()) { ?>
			<div class="imgcommentform">
							<!-- If comments are on for this image AND album... -->
				<h3><?php echo gettext("Add a comment:"); ?></h3>
				<form id="commentform" action="#" method="post">
				<div><input type="hidden" name="comment" value="1" />
							<input type="hidden" name="remember" value="1" />
								<?php
								printCommentErrors();
								$stored = getCommentStored();
								?>
					<table border="0">
						<tr>
							<td><label for="name"><?php echo gettext("Name:"); ?></label>
								(<input type="checkbox" name="anon" value="1"<?php if ($stored['anon']) echo " CHECKED"; ?> /> <?php echo gettext("don't publish"); ?>)
							</td>
							<td><input type="text" id="name" name="name" size="20" value="<?php echo $stored['name'];?>" class="inputbox" />
							</td>
						</tr>
						<tr>
							<td><label for="email"><?php echo gettext("E-Mail:"); ?></label></td>
							<td><input type="text" id="email" name="email" size="20" value="<?php echo $stored['email'];?>" class="inputbox" />
							</td>
						</tr>
						<tr>
							<td><label for="website"><?php echo gettext("Site:"); ?></label></td>
							<td><input type="text" id="website" name="website" size="40" value="<?php echo $stored['website'];?>" class="inputbox" /></td>
						</tr>
												<?php if (getOption('Use_Captcha')) {
 													$captchaCode=generateCaptcha($img); ?>
 													<tr>
 													<td><label for="code"><?php echo gettext("Enter Captcha:"); ?>
 													<img src=<?php echo "\"$img\"";?> alt="Code" align="bottom"/>
 													</label></td>
 													<td><input type="text" id="code" name="code" size="20" class="inputbox" /><input type="hidden" name="code_h" value="<?php echo $captchaCode;?>"/></td>
 													</tr>
												<?php } ?>
							<tr><td colspan="2"><input type="checkbox" name="private" value="1"<?php if ($stored['private']) echo " CHECKED"; ?> /> <?php echo gettext("Private (don't publish)"); ?></td></tr>
					</table>
					<textarea name="comment" rows="6" cols="40"><?php echo $stored['comment']; ?></textarea>
					<br />
					<input type="submit" value="<?php echo gettext('Add Comment'); ?>" class="pushbutton" /></div>
				</form>
			</div>
		</div>
				<?php } else { echo gettext('Comments are closed.'); } ?>
	<?php printRSSLink("Comments-image","",gettext("Subscribe to comments"),""); } ?>
	</div>
		<?php } ?>
</div>

<div id="credit"><?php printRSSLink('Gallery','','RSS', ' | '); ?> <?php printCustomPageURL(gettext("Archive View"),"archive"); ?> | 
<?php printZenphotoLink(); ?>
</div>

<?php if (function_exists('printAdminToolbox')) printAdminToolbox(); ?>

</body>
</html>
