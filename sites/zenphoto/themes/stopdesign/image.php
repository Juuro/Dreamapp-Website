<?php if (!defined('WEBPATH')) die(); 
require_once('normalizer.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<?php zenJavascript(); ?>
	<title><?php echo getBareImageTitle();?></title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<link rel="stylesheet" type="text/css" media="screen, projection" href="<?php echo $_zp_themeroot ?>/css/master.css" />
	<link rel="stylesheet" href="<?php echo FULLWEBPATH . "/" . ZENFOLDER ?>/js/thickbox.css" type="text/css" />
	<script type="text/javascript">var blogrelurl = "<?php echo $_zp_themeroot ?>";</script>
	<script type="text/javascript" src="<?php echo $_zp_themeroot ?>/js/rememberMe.js"></script>
	<script type="text/javascript" src="<?php echo $_zp_themeroot ?>/js/comments.js"></script>
	<script type="text/javascript" src="<?php echo FULLWEBPATH . "/" . ZENFOLDER ?>/js/thickbox.js"></script>
	<?php
		printRSSHeaderLink('Gallery','Gallery RSS');
		setOption('thumb_crop_width', 85, false);
		setOption('thumb_crop_height', 85, false);
		setOption('images_per_page', getOption('images_per_page') - 1, false);
		if (!isImagePhoto($_zp_current_image)) echo '<style type="text/css"> #prevnext a strong {display:none;}</style>';
	?>
</head>

<body class="photosolo">
		<?php echo getGalleryTitle(); ?><?php if (getOption('Allow_search')) {  printSearchForm(); } ?>

		<div id="content" class="v">

			<div id="desc">
				<?php if (!checkForPassword(true)) { ?>
					<h1><?php printImageTitle(true); ?></h1>
					<div id="descText"><?php printImageDesc(true); ?></div>
				<?php } ?>
			</div>

			<?php
				$ls = isLandscape();
				setOption('image_size', 480, false);
				$w = getDefaultWidth();
				$h = getDefaultHeight();
				if ($ls) {
					$wide = '';
				} else {
					$wide = "style=\"width:".($w+22)."px;\"";
				}
			?>
			<div class="main" <?php echo $wide; ?>>
				<?php if ($show = !checkForPassword()) { ?>
					<p id="photo">
					<strong>
						<?php printCustomSizedImage(getImageTitle(), null, $ls?480:null, $ls?null:480); ?>
					</strong>
					</p>
				<?php } ?>
			</div>
			<?php if ($show) { ?>
			<div id="meta">
				<ul>
					<li class="count"><?php
					 if (($num = getNumImages()) > 1) { printf(gettext('%1$u of %2$u photos'), imageNumber(), getNumImages()); }
					 ?></li>
					<li class="date"><?php printImageDate(); ?></li>
					<li class="tags"><?php echo getAlbumPlace(); ?></li>
					<li class="exif">
				<?php
					if (getImageEXIFData()) {echo "<a href=\"#TB_inline?height=345&amp;width=300&amp;inlineId=imagemetadata\" title=\"".gettext("image details")."\" class=\"thickbox\">".gettext('Image Info')."</a>";
						printImageMetadata('', false);
						echo "&nbsp;/&nbsp;";
					}
				?><a href="<?php echo htmlspecialchars(getFullImageURL());?>" title="<?php echo getBareImageTitle();?>"><?php echo gettext('Full Size'); ?></a>
 					</li>
				</ul>
			</div>
			<?php if (function_exists('printShutterfly')) printShutterfly(); ?>

			<div class="main">
				<?php if (getOption('Allow_comments')) { ?>
					<!-- BEGIN #commentblock -->
					<div id="commentblock">

					<h2>
					<?php $showhide = "<a href=\"#comments\" id=\"showcomments\"><img src=\"" .
						$_zp_themeroot . "/images/btn_show.gif\" width=\"35\" height=\"11\" alt=\"".gettext("SHOW")."\" /></a> <a href=\"#content\" id=\"hidecomments\"><img src=\"" .
						$_zp_themeroot . "/images/btn_hide.gif\" width=\"35\" height=\"11\" alt=\"".gettext("HIDE")."\" /></a>";
 						$num = getCommentCount(); 
 						if ($num == 0) echo "<h2>".gettext("No comments yet")."</h2>";
 						if ($num == 1) echo "<h2>" .gettext('1 comment so far').' '. "$showhide</h2>";
 						if ($num > 1) echo "<h2>".sprintf(gettext('%u comments so far'),$num).' '. "$showhide</h2>";
 					?>
					</h2>
					<?php printCommentErrors(); ?>

					<!-- BEGIN #comments -->
					<div id="comments">
						<dl class="commentlist">
						<?php
							$autonumber = 0;
							while (next_comment()):
								$autonumber++;
						?>
							<dt id="comment<?php echo $autonumber; ?>">
								<a href="#comment<?php echo $autonumber; ?>" class="postno" title="<?php printf(gettext('Link to Comment %u'),$autonumber); ?>"><?php echo $autonumber; ?>.</a>
								<em>On <?php echo getCommentDateTime();?>, <?php printf(gettext('%s wrote:'),printCommentAuthorLink()); ?></em>
							</dt>
							<dd><p><?php echo getCommentBody();?><?php printEditCommentLink(gettext('Edit'), ' | ', ''); ?></p></dd>
							<?php endwhile; ?>
						</dl>

						<?php if (OpenedForComments()) { ?>
							<p class="mainbutton" id="addcommentbutton"><a href="#addcomment" class="btn"><img src="<?php echo $_zp_themeroot ?>/images/btn_add_a_comment.gif" alt="" width="116" height="21" /></a></p>
						<?php } else { echo '<h2>'.gettext('Comments are closed').'</h2>'; } ?>

						<!-- BEGIN #addcomment -->
						<?php if ($_zp_comment_error) {
							echo '<div id="addcomment" style="display: block;">';
						} else {
							echo '<div id="addcomment" style="display: none;">';
						}
						$stored = getCommentStored(); ?>
						<h2><?php gettext("Add a comment") ?></h2>
						<form method="post" action="#" id="comments-form">
							<input type="hidden" name="comment" value="1" />
							<input type="hidden" name="remember" value="1" />
							<table cellspacing="0">
								<tr valign="top" align="left" id="row-name">
									<th><label for="name"><?php echo gettext('Name'); ?>:</label></th>
									<td><input tabindex="1" id="name" name="name" class="text" value="<?php echo $stored['name'];?>" />
										(<input type="checkbox" name="anon" value="1"<?php if ($stored['anon']) echo " CHECKED"; ?> /> <?php echo gettext("don't publish"); ?>)
									</td>
								</tr>
								<tr valign="top" align="left" id="row-email">
									<th><label for="email"><?php echo gettext('Email'); ?>:</label></th>
									<td><input tabindex="2" id="email" name="email" class="text" value="<?php echo $stored['email'];?>" /> <em><?php echo gettext("(not displayed)"); ?></em></td>
								</tr>
								<tr valign="top" align="left">
									<th><label for="website"><?php echo gettext('URL'); ?>:</label></th>
									<td><input tabindex="3" type="text" name="website" id="website" class="text" value="<?php echo $stored['website'];?>" /></td>
								</tr>
								<?php printCaptcha("<tr valign=\"top\" align=\"left\"><th><label for=\"captcha\">" .gettext('Enter Captcha'), ":</label></th><td>", "</td></tr>\n", 8); ?>
								<tr valign="top" align="left">
									<th><label for="private"><?php echo gettext('Private comment'); ?>:</label></th>
									<td><input type="checkbox" name="private" value="1"<?php if ($stored['private']) echo " CHECKED"; ?> /> <?php echo gettext("Private (don't publish)"); ?></td>
								</tr>
								<tr valign="top" align="left">
									<th><label for="comment"><?php echo gettext('Comment'); ?>:</label></th>
									<td><textarea tabindex="4" id="comment" name="comment" rows="10" cols="40"><?php echo $stored['comment']; ?></textarea></td>
								</tr>
								<tr valign="top" align="left">
									<th class="buttons">&nbsp;</th>
									<td class="buttons">
										<!--<input type="submit" name="preview" tabindex="5" value="Preview" id="btn-preview" />-->
										<input type="submit" name="post" tabindex="6" value="Post" id="btn-post" />
										<p><?php echo gettext('Avoid clicking &ldquo;Post&rdquo; more than once.'); ?></p>
									</td>
								</tr>
							</table>
						</form>

					</div>
					<!-- END #addcomment -->

					</div>
					<!-- END #comments -->

					</div>
					<!-- END #commentblock -->
					<?php }
				} ?>

				</div>

				<div id="prevnext">
					<?php
					$img = $_zp_current_image->getPrevImage();
					if ($img) { 
						if ($img->getWidth() >= $img->getHeight()) {
							$iw = 89;
							$ih = NULL;
							$cw = 89;
							$ch = 67;
						} else {
							$iw = NULL;
							$ih = 89;
							$ch = 89;
							$cw = 67;
						}
					 	?>
						<div id="prev"><span class="thumb"><span>
							<em style="background-image:url('<?php echo htmlspecialchars($img->getCustomImage(NULL, $iw, $ih, $cw, $ch, NULL, NULL, true)); ?>')">
							<a href="<?php echo getPrevImageURL();?>" accesskey="z" style="background:#fff;">
							<strong style="width:<?php echo round(($w+20)/2); ?>px; height:<?php echo $h+20; ?>px;"><?php echo gettext('Previous'); ?>: </strong>Crescent</a>
							</em></span></span></div>
					<?php 
					} 
					$img = $_zp_current_image->getNextImage();
					if ($img) { 
						if ($img->getWidth() >= $img->getHeight()) {
							$iw = 89;
							$ih = NULL;
							$cw = 89;
							$ch = 67;
						} else {
							$iw = NULL;
							$ih = 89;
							$ch = 89;
							$cw = 67;
						}?>
						<div id="next"><span class="thumb"><span>
						<em style="background-image:url('<?php echo htmlspecialchars($img->getCustomImage(NULL, $iw, $ih, $cw, $ch, NULL, NULL, true)); ?>')">
						<a href="<?php echo getNextImageURL();?>" accesskey="x" style="background:#fff;">
						<strong style="width:<?php echo round(($w+20)/2); ?>px; height:<?php echo $h+20; ?>px;"><?php echo gettext('Next'); ?>: </strong>Sagamor</a>
						</em></span></span></div>
					<?php } ?>
				</div>

		</div>

		<p id="path">
			<?php printHomeLink('', ' > '); ?>
			<a href="<?php echo htmlspecialchars(getGalleryIndexURL(false));?>" title="<?php echo gettext('Main Index'); ?>"><?php echo gettext('Home');?></a> &gt;
			<a href="<?php echo htmlspecialchars(getGalleryIndexURL());?>" title="<?php echo gettext('Albums Index'); ?>"><?php echo getGalleryTitle();?></a> &gt; <?php printParentBreadcrumb("", " > ", " > "); printAlbumBreadcrumb("", " > "); echo getImageTitle(); ?>
		</p>

		<div id="footer">
			<hr />
			<p>
				<?php echo gettext('<a href="http://stopdesign.com/templates/photos/">Photo Templates</a> from Stopdesign.'); ?>
				<?php printZenphotoLink(); ?>
			</p>
		</div>
		<?php if (function_exists('printAdminToolbox')) printAdminToolbox(); ?>
</body>
</html>
