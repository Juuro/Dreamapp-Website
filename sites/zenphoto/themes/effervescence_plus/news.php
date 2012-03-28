<?php require ('customfunctions.php');
define('ALBUMCOLUMNS', 3);
define('IMAGECOLUMNS', 5);
$themeResult = getTheme($zenCSS, $themeColor, 'effervescence');
normalizeColumns(ALBUMCOLUMNS, IMAGECOLUMNS);?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<?php zenJavascript(); ?>
	<title><?php echo getBareGalleryTitle(); ?> | <?php echo gettext('Archive'); ?></title>
	<link rel="stylesheet" href="<?php echo  $zenCSS ?>" type="text/css" />
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
				<span><?php printHomeLink('', ' | '); ?>
				<?php
				if (getOption('custom_index_page') === 'gallery') {
				?>
				<a href="<?php echo htmlspecialchars(getGalleryIndexURL(false));?>" title="<?php echo gettext('Main Index'); ?>"><?php echo gettext('Home');?></a> | 
				<?php	
				}					
				?>
				<a href="<?php echo htmlspecialchars(getGalleryIndexURL());?>" title="<?php echo gettext('Albums Index'); ?>"><?php echo getGalleryTitle();?></a></span> 
				<?php printNewsIndexURL(gettext("News")," | ");  printCurrentNewsCategory(" | ".gettext('Category')." - "); ?><?php printNewsTitle(" | "); ?>
			</div>
		</div> <!-- wrapnav -->

		<!-- Random Image -->
		<?php printHeadingImage(getRandomImages()); ?>
	</div> <!-- header -->

	<!-- Wrap Main Body -->
	<div id="content">
	
		<small>&nbsp;</small>
		<div id="main2">
			<div id="content-left">
<?php 
if (!checkForPassword()) {
// single news article
	if(is_NewsArticle()) {  
		?>  
	  <?php if(getPrevNewsURL()) { ?><div class="singlenews_prev"><?php printPrevNewsLink(); ?></div><?php } ?>
	  <?php if(getPrevNewsURL()) { ?><div class="singlenews_next"><?php printNextNewsLink(); ?></div><?php } ?>
	  <?php if(getPrevNewsURL() OR getPrevNewsURL()) { ?><br clear:both /><?php } ?>
	  <h3><?php printNewsTitle(); ?></h3> 
	
	  <div class="newsarticlecredit">
	  	<span class="newsarticlecredit-left"> <?php 
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
		<?php printCodeblock(1); ?>
		<?php printNewsContent(); ?>
	   <?php printCodeblock(2); ?>
	  </div>  
	<?php 
	// COMMENTS TEST
	if (getOption('zenpage_comments_allowed')) { ?>
					<div id="comments">
			<?php $num = getCommentCount(); echo ($num == 0) ? "" : ("<h3>".gettext("Comments")." ($num)</h3>"); ?>
				<?php while (next_comment()){  ?>
				<div class="comment">
					<div class="commentmeta">
						<span class="commentauthor"><?php printCommentAuthorLink(); ?></span> <?php gettext("says:"); ?>
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
							
				<?php if (zenpageOpenedForComments()) { ?>
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
	
					<?php } else { echo gettext('Comments are closed.'); } ?> 
	
	
	</div><?php } // comments allowed - end
	} else {
	// news article loop
	  while (next_news()) {?> 
	 <div class="newsarticle"> 
	    <h3><?php printNewsTitleLink(); ?><?php echo " <span class='newstype'>[".getNewsType()."]</span>"; ?></h3>
	        <div class="newsarticlecredit"><span class="newsarticlecredit-left"><?php printNewsDate();?> | <?php echo gettext("Comments:"); ?> <?php echo getCommentCount(); ?> | </span>
	<?php
	if(is_GalleryNewsType()) {
		echo gettext("Album:")."<a href='".getNewsAlbumURL()."' title='".getBareNewsAlbumTitle()."'> ".getNewsAlbumTitle()."</a>";
	} else {
		printNewsCategories(", ",gettext("Categories: "),"newscategories");
	}
	?>
	</div>
	    <?php printCodeblock(1); ?>
	    <?php printNewsContent(); ?>
	    <?php printCodeblock(2); ?>
	    <p><?php printNewsReadMoreLink(); ?></p>
	    
	    </div>	
	<?php
	  } 
	  printNewsPageListWithNav(gettext('next &raquo;'), gettext('&laquo; prev'));
	} 
}?> 

			</div><!-- content left-->
			<div id="sidebar">
			<?php include("sidebar.php"); ?>
			</div><!-- sidebar -->
			<br style="clear:both" />
		</div> <!-- main2 -->
		
	</div> <!-- content -->

<?php printFooter('news'); ?>

</body>
</html>