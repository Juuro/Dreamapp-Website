<?php require_once ('customfunctions.php');
define('ALBUMCOLUMNS', 3);
define('IMAGECOLUMNS', 5);
$themeResult = getTheme($zenCSS, $themeColor, 'effervescence');
normalizeColumns(ALBUMCOLUMNS, IMAGECOLUMNS);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<?php zenJavascript(); ?>
	<title><?php echo getBareGalleryTitle(); ?> | <?php echo getBareAlbumTitle();?> | <?php echo getBareImageTitle();?></title>
	<link rel="stylesheet" href="<?php echo $zenCSS ?>" type="text/css" />
	<link rel="stylesheet" href="<?php echo FULLWEBPATH . "/" . ZENFOLDER ?>/js/thickbox.css" type="text/css" />
	<script type="text/javascript" src="<?php echo  $_zp_themeroot ?>/scripts/bluranchors.js"></script>
	<script src="<?php echo FULLWEBPATH . "/" . ZENFOLDER ?>/js/thickbox.js" type="text/javascript"></script>

</head>

<body onload="blurAnchors()">

	<!-- Wrap Everything -->
	<div id="main4">
		<div id="main2">

			<!-- Wrap Header -->
			<div id="galleryheader">
				<div id="gallerytitle">

					<!-- Image Navigation -->
					<div class="imgnav">
						<div class="imgprevious">
							<?php
								global $_zp_current_image;
								if (hasPrevImage()) {
									$image = $_zp_current_image->getPrevImage();
									echo '<a href="' . htmlspecialchars(getPrevImageURL()) . '" title="' . html_encode($image->getTitle()) . '">&laquo; '.gettext('prev').'</a>';
								} else {
									echo '<div class="imgdisabledlink">&laquo; '.gettext('prev').'</div>';
								}
							?>
						</div>
						<div class="imgnext">
							<?php
								if (hasNextImage()) {
									$image = $_zp_current_image->getNextImage();
									echo '<a href="' . htmlspecialchars(getNextImageURL()) . '" title="' . html_encode($image->getTitle()) . '">'.gettext('next').' &raquo;</a>';
								} else {
									echo '<div class="imgdisabledlink">'.gettext('next').' &raquo;</div>';
								}
							?>
						</div>
					</div>

					<!-- Logo -->
					<div id="logo2">
						<?php printLogo(); ?>
					</div>
				</div>

				<!-- Crumb Trail Navigation -->
				<div id="wrapnav">
					<div id="navbar">
						<span>
							<?php printHomeLink('', ' | '); ?>
							<?php
							if (getOption('custom_index_page') === 'gallery') {
							?>
							<a href="<?php echo htmlspecialchars(getGalleryIndexURL(false));?>" title="<?php echo gettext('Main Index'); ?>"><?php echo gettext('Home');?></a> | 
							<?php	
							}					
							?>
							<a href="<?php echo htmlspecialchars(getGalleryIndexURL());?>" title="<?php echo gettext('Albums Index'); ?>"><?php echo getGalleryTitle();?></a> |
							<?php printParentBreadcrumb(); printAlbumBreadcrumb("", " | "); ?>
						</span>
						<?php printImageTitle(true); ?>
					</div>
				</div>
			</div>

			<!-- The Image -->
			<?php
				$s = getDefaultWidth() + 22;
				$wide = "style=\"width:".$s."px;";
				$s = getDefaultHeight() + 22;
				$high = " height:".$s."px;\"";
			?>
			<div id="image" <?php echo $wide.$high; ?>>
				<?php if ($show = !checkForPassword()) { ?>
					<div id="image_container">
						<a href="<?php echo htmlspecialchars(getFullImageURL());?>" title="<?php echo getBareImageTitle();?>">
							<?php printDefaultSizedImage(getImageTitle()); ?>
						</a>
					</div>
					<?php
					if (getImageEXIFData()) {
						echo "<div id=\"exif_link\"><a href=\"#TB_inline?height=400&amp;width=300&amp;inlineId=imagemetadata\" title=\"".gettext("image details from exif")."\" class=\"thickbox\">".gettext('Image Info')."</a></div>";
						printImageMetadata('', false);
					}
				} ?>
			</div>
			<br clear="all" />
		</div>

		<!-- Image Description -->
		<?php if ($show) { ?>
			<div id="description">
			<?php
				printImageDesc(true);
			?>
			</div>
			<?php
				if (function_exists('printImageMap')) {
					echo '<div id="map_link">';
					printImageMap();
					echo '</div>';
				}
		}
		if (function_exists('printShutterfly')) printShutterfly();
		?>
	</div>

	<!-- Wrap Bottom Content -->
	<?php if ($show && getOption('Allow_comments')) { ?>
		<div id="content">

			<!-- Headings -->
			<div id="bottomheadings">
				<div class="bottomfull">
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
					?>
				</div>
			</div>

			<!-- Wrap Comments -->
			<div id="main3">
				<div id="comments">
					<?php while (next_comment()):  ?>
						<div class="comment">
							<div class="commentinfo">
								<h4><?php printCommentAuthorLink(); ?></h4>: on <?php echo getCommentDateTime(); printEditCommentLink('Edit', ', ', ''); ?>
							</div>
							<div class="commenttext">
								<?php echo getCommentBody();?>
							</div>
						</div>
					<?php endwhile; ?>
				</div>

				<!-- Comment Box -->
				<?php if (OpenedForComments()) {
					$stored = getCommentStored();?>
					<div id="commentbox">
						<h2><?php echo gettext('Leave a Reply');?></h2>
						<form id="commentform" action="#" method="post">
								<div>
									<input type="hidden" name="comment" value="1" />
									<input type="hidden" name="remember" value="1" />
									<?php printCommentErrors(); ?>
									<input type="text" name="name" id="name" class="textinput" value="<?php echo $stored['name'];?>" size="22" tabindex="1" /><label for="name"><small> <?php echo gettext('Name');?></small></label>
									(<input type="checkbox" name="anon" value="1"<?php if ($stored['anon']) echo " CHECKED"; ?> /> <?php echo gettext("don't publish"); ?>)
									<br/><input type="text" name="email" id="email" class="textinput" value="<?php echo $stored['email'];?>" size="22" tabindex="2" /><label for="email"><small> <?php echo gettext('Email');?></small></label>
												<br/><input type="text" name="website" id="website" class="textinput" value="<?php echo $stored['website'];?>" size="22" tabindex="3" /><label for="website"><small> <?php echo gettext('Website');?></small></label>
												<?php printCaptcha('<br/>', '', ' <small>'.gettext("Enter Captcha").'</small>', 8); ?>
									<br/><input type="checkbox" name="private" value="1"<?php if ($stored['private']) echo " CHECKED"; ?> /> <?php echo gettext("Private (don't publish)"); ?>
									<textarea name="comment" id="comment" rows="5" cols="100%" tabindex="4"><?php echo $stored['comment']; ?></textarea>
									<input type="submit" value="<?php echo gettext('Submit');?>" class="pushbutton" />
								</div>
						</form>
					</div>
				<?php } else {?>
					<div id="commentbox">
						<h3><?php echo gettext('Closed for comments.');?></h3>
					</div>
				<?php } ?>

			</div>
		</div>
	<?php 
	}
	printFooter('image');
	?>

</body>
</html>
