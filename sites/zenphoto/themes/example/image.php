<?php $startTime = array_sum(explode(" ",microtime())); if (!defined('WEBPATH')) die(); normalizeColumns(1, 7);?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<?php zenJavascript(); ?>
	<title><?php echo getBareGalleryTitle(); ?></title>
	<link rel="stylesheet" href="<?php echo $_zp_themeroot ?>/zen.css" type="text/css" />
	<link rel="stylesheet" href="<?php echo FULLWEBPATH . "/" . ZENFOLDER ?>/js/thickbox.css" type="text/css" />
	<?php printRSSHeaderLink('Gallery',gettext('Gallery RSS')); echo "\n"; ?>
	<script src="<?php echo FULLWEBPATH . "/" . ZENFOLDER ?>/js/thickbox.js" type="text/javascript"></script>


</head>
<body>

<div id="main">
	<div id="gallerytitle">
			<h2><span><?php printHomeLink('', ' | '); ?><a href="<?php echo htmlspecialchars(getGalleryIndexURL());?>" title="<?php echo gettext('Albums Index'); ?>"><?php echo getGalleryTitle();?></a>
      | <?php printParentBreadcrumb(); printAlbumBreadcrumb("", " | "); ?></span> <?php printImageTitle(true); ?></h2>
	</div>

	<hr />
	<!-- The Image -->
	<?php if (!checkForPassword()) { ?>
		<div class="image">
		<div class="imgnav">
			<?php if (hasPrevImage()) { ?> <a class="prev" href="<?php echo htmlspecialchars(getPrevImageURL());?>" title="<?php echo gettext('Previous Image'); ?>">&laquo; <?php echo gettext("prev"); ?></a>
			<?php } if (hasNextImage()) { ?> <a class="next" href="<?php echo htmlspecialchars(getNextImageURL());?>" title="<?php echo gettext('Next Image'); ?>"><?php echo gettext("next");?> &raquo;</a><?php } ?>
		</div>

				<a href="<?php echo htmlspecialchars(getFullImageURL());?>" title="<?php echo getBareImageTitle();?>">
				<?php printDefaultSizedImage(getImageTitle()); ?></a>

				<div id="image_data">
					<div id="fullsize_download_link">
						<em>
						<a href="<?php echo htmlspecialchars(getFullImageURL());?>" title="<?php echo getBareImageTitle();?>"><?php echo gettext("Original Size:"); ?>
							<?php echo getFullWidth() . "x" . getFullHeight(); ?>
						</a>
						</em>
					</div>

					<div id="meta_link">
						<?php
							if (getImageEXIFData()) {echo "<a href=\"#TB_inline?height=345&amp;width=300&amp;inlineId=imagemetadata\" title=\"".gettext("Image Info")."\" class=\"thickbox\">".gettext("Image Info")."</a>";
								printImageMetadata('', false);
							}
					?>
					</div>

					<br clear="all" />
					<?php printImageDesc(true); ?>
					<?php printTags('links', gettext('<strong>Tags:</strong>').' ', 'taglist', ''); ?>
					<?php if (function_exists('zenPaypal')) { zenPaypal(NULL, true); } ?>
					<?php if (function_exists('googleCheckout')) {
						printGoogleCartWidget();
						googleCheckout(NULL, true);
					} ?>



					<?php if (function_exists('printShutterfly')) printShutterfly(); ?>
					<?php if (function_exists('printImageMap')) printImageMap(); ?>
          <div class="rating"><?php if (function_exists('printImageRating')) printImageRating(); ?></div>
				</div>

				<?php if (getOption('Allow_comments')) { ?>
				<div id="comments">
					<div class="commentcount">
					<?php 
					$num = getCommentCount(); 
					switch ($num) {
						case 0:
							echo gettext('<h3>No Comments</h3>');
							break;
						case 1:
							echo gettext('<h3>1 Comment</h3>');
							break;
						default:
							printf(gettext('<h3>%u Comments</h3>'), $num);
					}
					?></div>

						<?php while (next_comment()):  ?>
						<div class="comment">
							<div class="commentmeta">
									<span class="commentauthor"><?php printCommentAuthorLink(); ?></span>
									| <span class="commentdate"><?php echo getCommentDateTime();?></span>
 							</div>
								<div class="commentbody"><?php echo getCommentBody();?></div>
						</div>
						<?php endwhile; ?>

						<div class="imgcommentform">
				<?php if (OpenedForComments()) { ?>
							<!-- If comments are on for this image AND album... -->
							<h3><?php echo gettext("Add a comment:"); ?></h3>
							<form id="commentform" action="#comments" method="post">
									<input type="hidden" name="comment" value="1" />
									<input type="hidden" name="remember" value="1" />
										<?php printCommentErrors();
										$stored = getCommentStored();?>
									<table border="0">
										<tr><td><label for="name"><?php echo gettext("Name:"); ?></label>
										(<input type="checkbox" name="anon" value="1"<?php if ($stored['anon']) echo " CHECKED"; ?> /> <?php echo gettext("don't publish"); ?>)
										</td>
										<td><input type="text" name="name" size="20" value="<?php echo $stored['name'];?>" />
										</td></tr>
										<tr><td><label for="email"><?php echo gettext("E-Mail (won't be public):"); ?></label></td> <td><input type="text" name="email" size="20" value="<?php echo $stored['email'];?>" /> </td></tr>
										<tr><td><label for="website"><?php echo gettext("Site:"); ?></label></td> <td><input type="text" name="website" size="30" value="<?php echo $stored['website'];?>" /></td></tr>
												<?php printCaptcha('<tr><td>'.gettext('Enter').' ', ':</td><td>', '</td></tr>'); ?>
										<tr><td colspan="2"><input type="checkbox" name="private" value="1" <?php if ($stored['private']) echo " CHECKED"; ?>/> <?php echo gettext("Private (don't publish)"); ?></td></tr>
									</table>
									<textarea name="comment" rows="6" cols="40"><?php echo $stored['comment']; ?></textarea><br />
									<input type="submit" value="Add Comment" />
							</form>
						</div>
				<?php } else { echo gettext('Comments are closed.'); } ?>
				</div>
				<?php } ?>

		</div>
		<?php } ?>

		<div id="credit">
		<?php printRSSLink('Gallery','','RSS', ' | '); ?>
		<?php printZenphotoLink(); ?>
		 | <?php printCustomPageURL(gettext("Archive View"),"archive"); ?><br />
			<?php printf(gettext("%u seconds"), round((array_sum(explode(" ",microtime())) - $startTime),4)); ?>
		</div>
</div>

<?php if (function_exists('printAdminToolbox')) printAdminToolbox(); ?>

</body>
</html>
