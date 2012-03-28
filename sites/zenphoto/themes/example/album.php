<?php
if (!defined('WEBPATH')) die();
$startTime = array_sum(explode(" ",microtime()));
$themeResult = getTheme($zenCSS, $themeColor, 'light');
$firstPageImages = normalizeColumns(1, 7);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<?php zenJavascript(); ?>
	<title><?php echo getBareGalleryTitle(); ?></title>
	<link rel="stylesheet" href="<?php echo $_zp_themeroot ?>/zen.css" type="text/css" />
	<?php printRSSHeaderLink('Album',getAlbumTitle()); ?>
</head>
<body>

<div id="main">
	<div id="gallerytitle">
			<h2><span><?php printHomeLink('', ' | '); ?><a href="<?php echo htmlspecialchars(getGalleryIndexURL());?>" title="<?php echo ('Albums Index'); ?>"><?php echo getGalleryTitle();?></a> | <?php printParentBreadcrumb(); ?></span> <?php printAlbumTitle(true);?></h2>
		</div>

		( <?php printLink(getPrevAlbumURL(), "&laquo; ".gettext("Prev Album")); ?> | <?php printLink(getNextAlbumURL(), gettext("Next Album")." &raquo;"); ?> )

		<hr />
		<?php printTags('links', gettext('<strong>Tags:</strong>').' ', 'taglist', ''); ?>
	<?php printAlbumDesc(true); ?>
		<br />


	<?php printPageListWithNav("&laquo; ".gettext("prev"), gettext("next")." &raquo;"); ?>

	<!-- Sub-Albums -->
		<div id="albums">
			<?php while (next_album()): ?>
			<div class="album">
					<div class="albumthumb"><a href="<?php echo htmlspecialchars(getAlbumLinkURL());?>" title="<?php echo getAnnotatedAlbumTitle();?>">
						<?php printAlbumThumbImage(getAnnotatedAlbumTitle()); ?></a>
						</div>
					<div class="albumtitle">
									<h3><a href="<?php echo htmlspecialchars(getAlbumLinkURL());?>" title="<?php echo getAnnotatedAlbumTitle();?>">
							<?php printAlbumTitle(); ?></a></h3> <?php printAlbumDate(); ?>
								</div>
						<div class="albumdesc"><?php printAlbumDesc(); ?></div>
				</div>
				<hr />
 		<?php endwhile; ?>
		</div>

		<br />

		<div id="images">
		<?php
		if (function_exists('flvPlaylist') && getOption('Use_flv_playlist')) {
			if (getOption('flv_playlist_option') == 'playlist') {
				flvPlaylist('playlist');
			} else {
				while (next_image(false,$firstPageImages)) {
					printImageTitle();
					flvPlaylist("players");
				}

			}
		} else {
			while (next_image(false, $firstPageImages)) { ?>
				<div class="image">
					<div class="imagethumb">
							<a href="<?php echo htmlspecialchars(getImageLinkURL());?>" title="<?php echo getBareImageTitle();?>">
							<?php printImageThumb(getAnnotatedImageTitle()); ?></a>
						</div>
				</div>
		<?php
			}
		}
		?>



		<br clear="all" />
		<?php if (function_exists('printSlideShowLink')) printSlideShowLink(gettext('View Slideshow')); ?>
			<div class="rating"><?php if (function_exists('printAlbumRating')) printAlbumRating(); ?></div>
			<?php if (function_exists('printAlbumMap')) printAlbumMap(); ?>
		</div>

 <!-- begin comment block -->
				<?php if (getOption('Allow_comments')  && getCurrentPage() == 1) { ?>
				<div id="comments">
					<div class="commentcount"><?php
						$num = getCommentCount();
						switch ($num) {
							case 0:
								echo gettext("No comments");
								break;
							case 1:
								echo gettext("<strong>One</strong> comment");
								break;
							default:
								printf(gettext("<strong>%u</strong> comments on this album:"), $num);
						}					 	
				 ?> </div>

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
				<?php if (OpenedForComments(ALBUM)) { ?>
							<!-- If comments are on for this album... -->
							<h3>
								<?php echo gettext("Add a comment:"); ?>
							</h3>
							<form id="commentform" action="#comments" method="post">
									<input type="hidden" name="comment" value="1" />
									<input type="hidden" name="remember" value="1" />
										<?php printCommentErrors();
													$stored = getCommentStored(); ?>
									<table border="0">
										<tr><td>
											<label for="name"><?php echo gettext("Name:"); ?>
											(<input type="checkbox" name="anon" value="1"<?php if ($stored['anon']) echo " CHECKED"; ?> /> <?php echo gettext("don't publish"); ?>)
											</label>
											</td>
											<td><input type="text" name="name" size="20" value="<?php echo $stored['name'];?>" />
										</td></tr>
										<tr><td><label for="email"><?php echo gettext("E-Mail (won't be public):"); ?></label></td> <td><input type="text" name="email" size="20" value="<?php echo $stored['email'];?>" /> </td></tr>
										<tr><td><label for="website"><?php echo gettext("Site:"); ?></label></td> <td><input type="text" name="website" size="30" value="<?php echo $stored['website'];?>" /></td></tr>
												<?php printCaptcha('<tr><td>'.gettext('Enter').' ', ':</td><td>', '</td></tr>'); ?>
										<tr><td colspan="2"><input type="checkbox" name="private" value="1"<?php if ($stored['private']) echo " CHECKED"; ?> /> <?php echo gettext("Private (don't publish)"); ?></td></tr>
									</table>
									<textarea name="comment" rows="6" cols="40"><?php echo $stored['comment']; ?></textarea><br />
									<input type="submit" value="<?php echo gettext('Add Comment'); ?>" />
							</form>
						</div>
				<?php } else { echo gettext('Comments are closed.'); } ?>
				</div>
				<?php } ?>
<!--  end comment block -->

 		<?php printPageNav("&laquo; ".gettext("prev"), "|", gettext("next")." &raquo;"); ?>

		<div id="credit">
		<?php printRSSLink('Album', '', gettext('Album RSS'), ''); ?> | 
		<?php printZenphotoLink(); ?>
		| <?php printCustomPageURL(gettext("Archive View"),"archive"); ?>
		<?php
		if (function_exists('printUserLogout')) {
			printUserLogout(" | ");
		}
		?>
		<br />
			<?php printf(gettext("%u seconds"), round((array_sum(explode(" ",microtime())) - $startTime),4)); ?>
		</div>
</div>

<?php if (function_exists('printAdminToolbox')) printAdminToolbox(); ?>

</body>
</html>
