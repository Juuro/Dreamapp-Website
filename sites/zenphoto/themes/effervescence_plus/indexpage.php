<?php require ('customfunctions.php');
define('ALBUMCOLUMNS', 3);
define('IMAGECOLUMNS', 5);
$themeResult = getTheme($zenCSS, $themeColor, 'effervescence');
normalizeColumns(ALBUMCOLUMNS, IMAGECOLUMNS);?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<?php zenJavascript(); ?>
	<title><?php $mainsite = getMainSiteName(); echo (empty($mainsite))?gettext("zenphoto gallery"):$mainsite; ?></title>
	<link rel="stylesheet" href="<?php echo $zenCSS ?>" type="text/css" />
	<link rel="stylesheet" href="<?php echo FULLWEBPATH . "/" . ZENFOLDER ?>/js/thickbox.css" type="text/css" />
	<script type="text/javascript" src="<?php echo  $_zp_themeroot ?>/scripts/bluranchors.js"></script>
</head>

<body onload="blurAnchors()">

	<!-- Wrap Header -->
	<div id="header">
		<div id="gallerytitle">

		<!-- Logo -->
			<div id="logo">
			<?php printLogo(); ?>
			</div>
		</div> <!-- gallerytitle -->

		<!-- Crumb Trail Navigation -->
		<div id="wrapnav">
			<div id="navbar">
				<span><?php printHomeLink('', ' | '); echo (empty($mainsite))?'&nbsp;':$mainsite; ?></span>
			</div>
		</div> <!-- wrapnav -->

	</div> <!-- header -->

			<!-- The Image -->
			<?php
	 			makeImageCurrent(getRandomImages(true));
	 			$size = floor(getOption('image_size') * $imagereduction);
	 			if ($imagereduction != 1) setOption('image_size', $size, false);
				$s = getDefaultWidth() + 22;
				$wide = "style=\"width:".$s."px;";
				$s = getDefaultHeight() + 72;
				$high = " height:".$s."px;\"";
			?>
			<div id="image" <?php echo $wide.$high; ?>>
			<p align="center">
			<?php echo gettext('Picture of the day'); ?>
			</p>
				<div id="image_container">
					<a href="<?php echo htmlspecialchars(getGalleryIndexURL());?>" title="<?php echo gettext('Albums Index'); ?>">
						<?php printCustomSizedImage(gettext('Visit the photo gallery'), $size); ?>
					</a>
				</div>
				<?php if (!$zenpage) { ?>
				<p align="center">
				<a href="<?php echo htmlspecialchars(getGalleryIndexURL());?>" title="<?php echo gettext('Albums Index'); ?>"><?php echo gettext('Visit the photo gallery');?></a>
				</p>
				<?php } ?>
			</div> <!-- image -->
			<br />
	<?php if($zenpage)  {?>
	<!-- Wrap Main Body -->
	<div id="content">
	
		<small>&nbsp;</small>
		<div id="main2">
			<div id="content-left">
			<?php 
			while (next_news()) { ;?> 
 				<div class="newsarticle"> 
    			<h3><?php printNewsTitleLink(); ?><?php echo " <span class='newstype'>[".getNewsType()."]</span>"; ?></h3>
					<div class="newsarticlecredit">
						<span class="newsarticlecredit-left">
						<?php 
							$count = getCommentCount();
							$cat = getNewsCategories();
							printNewsDate();
							if ($count > 0) {
								echo ' | ';
						 		printf(gettext("Comments: %d"),  $count);  
							}
							if (!empty($cat)) {
								echo ' | ';
							}
							?>
						</span>

						<?php
						if (!empty($cat)) {
							printNewsCategories(", ",gettext("Categories: "),"newscategories"); 
						}
						?>
					</div> <!-- newsarticlecredit -->
	   			<?php printCodeblock(1); ?>
    			<?php printNewsContent(); ?>
    			<?php printCodeblock(2); ?>
    			<p><?php printNewsReadMoreLink(); ?></p>
    
    		</div>	
			<?php
			} 
  		printNewsPageListWithNav(gettext('next &raquo;'), gettext('&laquo; prev'));
			?> 
			</div><!-- content left-->
			
			<div id="sidebar">
			<?php include("sidebar.php"); ?>
			</div><!-- sidebar -->
			<br style="clear:both" />
		</div> <!-- main2 -->
		
	</div> <!-- content -->
	<?php } ?>
<div class="aligncenter2">
<?php printGalleryDesc(); ?>
</div>
	
<?php printFooter('index'); ?>

</body>
</html>