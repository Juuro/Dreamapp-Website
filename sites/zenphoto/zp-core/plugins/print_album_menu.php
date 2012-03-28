<?php
/** printAlbumMenu for Zenphoto
  *
 * Changelog
 * 1.4.6.1: Typo in function name corrected
 *
 * 1.4.6:
 * - Some url encoding issues fixed
 * 
 * 1.4.5:
 * - Fixes some validation issues and an php warning
 * 
 * 1.4.4.5:
 * - Minor fix about a php notice for an undefined variable
 *
 * 1.4.4.4:
 * - Corrects an inconsistency about misslabeled css id and classes parameters:
 * There is now a class for the active toplevel element, so that you can use it for top and sub levels.
 * - Also now not every list item gets the active class assigned anymore...
 *
 * 1.4.4.3.
 * -  Minor bug fix, used the album title instead of the unique album folder name at one place.
 *
 * 1.4.4.2.
 * - HTML validation again (turns css id for subalbums into the valid css class) Thanks to miem for the find.
 *
 * 1.4.4.1
 * - Html validation changes
 *
 * 1.4.4:
 * - Adds new list mode option '$showsubs' to optionally always show subalbums
 * - Fixes a html validation error of using a CSS id several times for the active top level albums (now a class)
 *
 * 1.4.3.1:
 * - Some very minor code cleanup
 *
 * 1.4.3:
 * - Divided the menu into two separate functions printAlbumMenuList() and printAlbumMenuJump(). The plan to always have the jump menu
 * mode showing top level albums and sub level albums was simply easier to achieve separated than within the more complicated and especially
 * context sensitive list mode code. printAlbumMenu() remains as a wrapper function so that it can be used as before.
 * - Some documentation errors fixed
 *
 * 1.4.2:
 * - Fixes lost count for jump menu in the 1.4.1
 * - Some more code optimizations: Another helper function checkAlbumDisplayLevel() added
 * - Helper function checkIfActiveAlbum() renamed to checkSelectedAlbum()
 * - Helper function createAlbumMenuLink() extended for the jump menu variant
 *
 * 1.4.1:
 * - Jump variant: 'choose an album' text removed , now the active album is always selected.
 * 	 This adds the helper function checkIfActiveAlbum()
 * - List variant: Adds missing index link and title atribute to the links and make its name editiable and and option (see below)
 * - List variant: Adds helper function createAlbumMenuLink() to generate the link / none link and get rid of some repetive lines of code
 *
 * 1.4:
 * - New options for more layout flexibility: "list-top" for only showing the toplevel albums,
 *   							"list-sub" for showing only sublevel albums if within a toplevel album or one of its subalbums
 *
 * 1.3.3:
 * - Code reworked, now uses the gallery/album objects so that protected and unpublished
 * 	 albums as well as the album sortorder are handled automatically
 * - For better usability selected album names in the list are now not links anymore as suggested
 *   on the forum a while ago (also the former used <strong> is skipped)
 *
 * 1.3.2:
 * - turned into a plugin for zenphoto 1.1.5 svn/1.1.6
 *
 * 1.3.1:
 * - support for album passwords
 * - a little code reformatting
 * - the return of the somehow forgotten published or not published check
 *
 * 1.3:
 * - only for zenphoto 1.1. or newer
 * - nearly completly rewritten
 * - Supports 4 subalbum levels with context sensitive fold out display
 *
 * 1.2.2.3:
 * - Automatic detection if mod_rewrite is enabled but it has to be set and save in the admin options.
 * - Better looking source code thanks to spacing and linebreaks implemented by aitf311
 *
 * 1.2.2.2:
 * - Automatic disabling of the counter for main albums so that they don't show "(0)" anymore if you only use subalbums for images
 * now for subalbums, too.
 *
 * 1.2.2.1:
 * - Automatic disabling of the counter for main albums so that they don't show "(0)" anymore if you only use subalbums for images
 *
 * 1.2.2:
 * - Change Subalbum CSS-ID "$id2" to CLASS "$class" ((X)HTML Validation issue)
 * - Add htmlspecialchars to the printed album titles, so that validation does not fail because of ampersands in names.
 *
 * 1.2.1:
 * - New option for mod_rewrite (needs to be automatic...),
 * - bug fixes for the id-Tags, which didn't get used.
 *
 * 1.2: Now works with sbillard's album publishing function.
 *
 * 1.1.:
 * - Option for album list or a drop down jump menu if you want to save space
 * - Displays the number of images in the album (like e.g. wordpress does with articles)
 * - Option for disabling the counter
 * - Parameters for CSS-Ids for styling, separate ones for main album and subalbums
 * - Renamed the function name from show_album_menu() to more zp style printAlbumMenu()
 *
 * @author Malte Müller (acrylian)
 * @version 1.4.6.1
 * @package plugins
 */

$plugin_description = gettext("Adds a theme function printAlbumMenu() to print an album menu either as a nested list up to 4 sublevels (context sensitive) or as a dropdown menu.");
$plugin_author = "Malte Müller (acrylian)";
$plugin_version = '1.4.6';
$plugin_URL = "http://www.zenphoto.org/documentation/plugins/_plugins---print_album_menu.php.html";

/**
 * Prints a list of all albums context sensitive up to the 4th subalbum level.
 * Since 1.4.3 this is a wrapper function for the separate functions printAlbumMenuList() and printAlbumMenuJump().
 * that was included to remain compatiblility with older installs of this menu.
 *
 * Usage: add the following to the php page where you wish to use these menus:
 * enable this extension on the zenphoto admin plugins tab.
 * Call the function printAlbumMenu() at the point where you want the menu to appear.
 *
 * @param string $option "list" for html list, "list-top" for only the top level albums, "list-sub" for only the subalbums if in one of theme or their toplevel album
 * @param string $option2 "count" for a image counter in brackets behind the album name, "" = for no image numbers or leave blank
 * @param string $css_id insert css id for the main album list, leave blank if you don't use (only list mode)
 * @param string $css_class_topactive insert css class for the active link in the main album list (only list mode)
 * @param string $css_class insert css class for the sub album lists (only list mode)
 * @param string $css_class_active insert css class for the active link in the sub album lists (only list mode)
 * @param string $indexname insert the name how you want to call the link to the gallery index (insert "" if you don't use it, it is not printed then)
 * @param string $showsubs 'true' to always show the subalbums, 'false' for normal context sensitive behaviour (only list mode)
 * @return html list or drop down jump menu of the albums
 * @since 1.2
 */

function printAlbumMenu($option,$option2,$css_id='',$css_class_topactive='',$css_class='',$css_class_active='', $indexname="Gallery Index", $showsubs=false) {
	if($option === "list" OR $option === "list-top" OR $option === "list-sub") {
		printAlbumMenuList($option,$option2,$css_id,$css_class_topactive,$css_class,$css_class_active, $indexname, $showsubs);
	} else if ($option === "jump") {
		printAlbumMenuJump($option,$indexname);
	}
}

/**
 * Prints a nested html list of all albums context sensitive up to the 4th subalbum level.
 *
 * Usage: add the following to the php page where you wish to use these menus:
 * enable this extension on the zenphoto admin plugins tab;
 * Call the function printAlbumMenuList() at the point where you want the menu to appear.
 *
 * @param string $option "list" for html list, "list-top" for only the top level albums, "list-sub" for only the subalbums if in one of theme or their toplevel album
 * @param string $option2 "count" for a image counter in brackets behind the album name, "" = for no image numbers or leave blank
 * @param string $css_id insert css id for the main album list, leave blank if you don't use (only list mode)
 * @param string $css_id_active insert css class for the active link in the main album list (only list mode)
 * @param string $css_class insert css class for the sub album lists (only list mode)
 * @param string $css_class_active insert css class for the active link in the sub album lists (only list mode)
 * @param string $indexname insert the name (default "Gallery Index") how you want to call the link to the gallery index, insert "" if you don't use it, it is not printed then.
 * @param string $showsubs 'true' to always show the subalbums, 'false' for normal context sensitive behaviour (only list mode)
 * @return html list of the albums
 */

function printAlbumMenuList($option,$option2,$css_id='',$css_class_topactive='',$css_class='',$css_class_active='', $indexname="Gallery Index", $showsubs=false) {
	global $_zp_gallery, $_zp_current_album;
	$albumpath = rewrite_path("/", "/index.php?album=");
	if(!empty($_zp_current_album)) {
		$currentfolder = $_zp_current_album->name;
	} else {
		$currentfolder = "";
	}
	// check if css parameters are used
	if ($css_id != "") { $css_id = " id='".$css_id."'"; }
	if ($css_class_topactive != "") { $css_class_topactive = " class='".$css_class_topactive."'"; }
	if ($css_class != "") { $css_class = " class='".$css_class."'"; }
	if ($css_class_active != "") { $css_class_active = " class='".$css_class_active."'"; }

	/**** Top level start with Index link  ****/
	if($option === "list" OR $option === "list-top") {
		echo "<ul".$css_id.">\n"; // top level list
		if(!empty($indexname)) {
			echo "<li><a href='".htmlspecialchars(getGalleryIndexURL())."' title='".html_encode($indexname)."'>".$indexname."</a></li>";
		}
	}
		/**** TOPALBUM LEVEL ****/
		$gallery = $_zp_gallery;
		$albums = $_zp_gallery->getAlbums();
		foreach ($albums as $toplevelalbum) {
			$topalbum = new Album($gallery,$toplevelalbum,true);
			if($option === "list" OR $option === "list-top") {
				createAlbumMenuLink($topalbum,$option2,$css_class_topactive,$albumpath,"list");
			}
			$sub1_count = 0;

			if($option === "list" OR $option === "list-sub") { // show either only sublevels or sublevels with toplevel

				/**** SUBALBUM LEVEL 1 ****/
				$subalbums1 = $topalbum->getSubAlbums();
				foreach($subalbums1 as $sublevelalbum1) {
					$subalbum1 = new Album($gallery,$sublevelalbum1,true);

						// if 2: (if in parentalbum) OR (if in subalbum)
						if(checkAlbumDisplayLevel($subalbum1,$topalbum,$currentfolder,1) OR $showsubs) {
							$sub1_count++; // count subalbums for checking if to open or close the sublist
							if ($sub1_count === 1) { // open sublevel 1 sublist once if subalbums
								echo "<ul".$css_class.">\n";
							}
							if ($option === "list" OR $option === "list-sub") {
								createAlbumMenuLink($subalbum1,$option2,$css_class_active,$albumpath,"list");
							}
							$sub2_count = 0;

						/**** SUBALBUM LEVEL 2 ****/
						$subalbums2 = $subalbum1->getSubAlbums();
						foreach($subalbums2 as $sublevelalbum2) {
							$subalbum2 = new Album($gallery,$sublevelalbum2,true);

							// if 3
							if(checkAlbumDisplayLevel($subalbum2,$subalbum1,$currentfolder,2) OR $showsubs) {
								$sub2_count++; // count subalbums for checking if to open or close the sublist
								if ($sub2_count === 1) { // open sublevel 1 sublist once if subalbums
									echo "<ul".$css_class.">\n";
								}
								if($option === "list" OR $option === "list-sub") {
									createAlbumMenuLink($subalbum2,$option2,$css_class_active,$albumpath,"list");
								}
								$sub3_count = 0;

								/**** SUBALBUM LEVEL 3 ****/
								$subalbums3 = $subalbum2->getSubAlbums();
								foreach($subalbums3 as $sublevelalbum3) {
									$subalbum3 = new Album($gallery,$sublevelalbum3,true);

									// if 4
									if(checkAlbumDisplayLevel($subalbum3,$subalbum2,$currentfolder,3) OR $showsubs) {
										$sub3_count++; // count subalbums for checking if to open or close the sublist
										if ($sub3_count === 1) { // open sublevel 1 sublist once if subalbums
											echo "<ul".$css_class.">\n";
										}
										if($option === "list" OR $option === "list-sub") {
											createAlbumMenuLink($subalbum3,$option2,$css_class_active,$albumpath,"list");
										}
										$sub4_count = 0;

										/**** SUBALBUM LEVEL 4 ****/
										$subalbums4 = $subalbum3->getSubAlbums();
										foreach($subalbums4 as $sublevelalbum4) {
											$subalbum4 = new Album($gallery,$sublevelalbum4,true);

											// if 5
											if(checkAlbumDisplayLevel($subalbum4,$subalbum3,$currentfolder,4) OR $showsubs){
												$sub4_count++; // count subalbums for checking if to open or close the sublist
												if ($sub4_count === 1) { // open sublevel 1 sublist once if subalbums
													echo "<ul".$css_class.">\n";
												}
												if($option === "list" OR $option === "list-sub") {
													createAlbumMenuLink($subalbum4,$option2,$css_class_active,$albumpath,"list");
												}
											} // if subalbum level 4 - end
										}	// subalbum level 4 - end
										if($sub4_count > 0 AND ($option === "list" OR $option === "list-sub")) 	{ // sublevel 4 sublist end if subalbums
											echo "</ul>\n";
										}
										if($option === "list" OR $option === "list-sub")	{	// sub level 4 list item end
											echo "</li>\n";
										}
									} // if subalbum level 3 - end
								}	// subalbum level 3 - end
								if($sub3_count > 0 AND ($option === "list" OR $option === "list-sub")) { // sublevel 3 sublist end if subalbums
									echo "</ul>\n";
								}
								if($option === "list" OR $option === "list-sub") { // sub level 2 list item end
									echo "</li>\n";
								}
							} // if subalbum level 2 - end
						} // subalbum level 2 - end
						if($sub2_count > 0 AND ($option === "list" OR $option === "list-sub")) {// sublevel 2 sublist end if subalbums
							echo "</ul>\n";
						}
						if($option === "list" OR $option === "list-sub") { // sub level 1 list item end
							echo "</li>\n";
						}
					}  // if subalbum level 1 - end
				} // subalbum level 1 - end
				if($sub1_count > 0 AND ($option === "list" OR $option === "list-sub")) {// sublevel 1 sublist end if subalbums
					echo "</ul>\n";
				}
			} // main if end for option "list" or "list-sub" (subalbum loops)
			if($option === "list" OR $option === "list-top") { // top level list item end
				echo "</li>\n";
			}
			//	} // if Top level albums - end
		} // top level album loop - end
		if($option === "list" OR $option === "list-top"){
			echo "</ul>\n";
		}
} // function end


/**
 * Prints a dropdown menu of all albums up to the 4 sublevel (not context sensitive)
 * Is used by the wrapper function printAlbumMenu() if the options "jump" is choosen. For standalone use, too.
 *
 * Usage: add the following to the php page where you wish to use these menus:
 * enable this extension on the zenphoto admin plugins tab;
 * Call the function printAlbumMenuJump() at the point where you want the menu to appear.
 *
 * @param string $option "count" for a image counter in brackets behind the album name, "" = for no image numbers
 * @param string $indexname insert the name (default "Gallery Index") how you want to call the link to the gallery index, insert "" if you don't use it, it is not printed then.
 */
function printAlbumMenuJump($option="count", $indexname="Gallery Index") {
	global $_zp_gallery, $_zp_current_album;
	$albumpath = rewrite_path("/", "/index.php?album=");
	if(!empty($_zp_current_album)) {
		$currentfolder = $_zp_current_album->name;
	}
	?>
<form name="AutoListBox" action="#">
<p><select name="ListBoxURL" size="1"
		onchange="gotoLink(this.form);">
		<?php
		if(!empty($indexname)) {
			$selected = checkSelectedAlbum("", "index"); ?>
		<option <?php echo $selected; ?> value="<?php echo htmlspecialchars(getGalleryIndexURL()); ?>"><?php echo $indexname; ?></option>
		<?php }
		/**** TOPALBUM LEVEL ****/
		$gallery = $_zp_gallery;
		$albums = $_zp_gallery->getAlbums();
		foreach ($albums as $toplevelalbum) {
			$topalbum = new Album($gallery,$toplevelalbum,true);
			createAlbumMenuLink($topalbum,$option,"",$albumpath,"jump",0);

			/**** SUBALBUM LEVEL 1 ****/
			$subalbums1 = $topalbum->getSubAlbums();
			foreach($subalbums1 as $sublevelalbum1) {
				$subalbum1 = new Album($gallery,$sublevelalbum1,true);
				createAlbumMenuLink($subalbum1,$option,"",$albumpath,"jump",1);

				/**** SUBALBUM LEVEL 2 ****/
				$subalbums2 = $subalbum1->getSubAlbums();
				foreach($subalbums2 as $sublevelalbum2) {
					$subalbum2 = new Album($gallery,$sublevelalbum2,true);
					createAlbumMenuLink($subalbum2,$option,"",$albumpath,"jump",2);

					/**** SUBALBUM LEVEL 3 ****/
					$subalbums3 = $subalbum2->getSubAlbums();
					foreach($subalbums3 as $sublevelalbum3) {
						$subalbum3 = new Album($gallery,$sublevelalbum3,true);
						createAlbumMenuLink($subalbum3,$option,"",$albumpath,"jump",3);

						/**** SUBALBUM LEVEL 4 ****/
						$subalbums4 = $subalbum3->getSubAlbums();
						foreach($subalbums4 as $sublevelalbum4) {
							$subalbum4 = new Album($gallery,$sublevelalbum4,true);
							createAlbumMenuLink($subalbum4,$option,"",$albumpath,"jump",4);
						}
					}
				}
			}
		}
?>
</select></p>
<script type="text/javaScript">
<!--
function gotoLink(form) {
 	var OptionIndex=form.ListBoxURL.selectedIndex;
	parent.location = form.ListBoxURL.options[OptionIndex].value;}
//-->
</script></form>
<?php
}

/**
 * A printAlbumMenu() helper function for the list menu mode of printAlbumMenu() that only
 * generates an list item, as a link if not the current album
 * Not for standalone use.
 *
 * @param object $album the album oject
 * @param string $option2 the value of $option of the printAlbumMenu()
 * @param string $css One of the both css_active values of the printAlbumMenu()
 * @param string $albumpath the albumpath for mod_rewrite or not
 * @param string $mode "list" for list mode link, "jump" for jump mode link
 * @param int	$level level number for jump mode (0 toplevel, 1-4 sublevel)
 * @return string
 */
function createAlbumMenuLink($album,$option2,$css,$albumpath,$mode,$level='') {
	if($option2 === "count" AND $album->getNumImages() > 0) {
		$count = " (".$album->getNumImages().")";
	} else {
		$count = "";
	}
	switch($mode) {
		case "list":

			if(getAlbumID() == $album->getAlbumID()) {
				$link = "<li".$css.">".$album->getTitle().$count;
			} else {
				$link = "<li><a href='".htmlspecialchars($albumpath.pathurlencode($album->name))."' title='".html_encode($album->getTitle())."'>".html_encode($album->getTitle())."</a>".$count;
			}
			break;
		case "jump":
			$arrow = "&raquo; ";
			switch ($level) {
				case 0:
					$arrow = "";
					break;
				case 1:
					$arrow = $arrow;
					break;
				case 2:
					$arrow = $arrow.$arrow;
					break;
				case 3:
					$arrow = $arrow.$arrow.$arrow;
					break;
				case 4:
					$arrow = $arrow.$arrow.$arrow.$arrow;
					break;
			}
			$selected = checkSelectedAlbum($album->name, "album");
			$link = "<option $selected value='".htmlspecialchars($albumpath.pathurlencode($album->name))."'>".$arrow.strip_tags($album->getTitle()).$count."</option>";
			break;
	}
	echo $link;
}


/**
 * A printAlbumMenu() helper function for the jump menu mode of printAlbumMenu() that only
 * checks which the current album so that the entry in the in the dropdown jump menu can be selected
 * Not for standalone use.
 *
 * @param string $checkalbum The album title to check
 * @param string $option "index" for index level, "album" for album level
 * @return string returns nothing or "selected"
 */
function checkSelectedAlbum($checkalbum, $option) {
	global $_zp_current_album;
	$selected = "";
	switch ($option) {
		case "index":
			if($_zp_current_album->name === "") {
				$selected = "selected";
			}
			break;
		case "album":
			if($_zp_current_album->name === $checkalbum) {
				$selected = "selected";
			}
			break;
	}
	return $selected;
}

/**
 * A printAlbumMenu() helper function that checks what subalbum level should be displayed. If you are in an subalbum
 * that it itself an subalbum and containts subalbums it returns true and lets the album menu display the parent album,
 * the current level and the next sublevel
 * Not for standalone use.
 *
 * @param object $currentalbum The album object of the current album in whose level we are
 * @param object $parentalbum The album object of the parent album
 * @param string $currentfolder The current folder
 * @param int $level The level the function should check for (1-4 for sublevel 1 - 4)
 * @return bool
 */
function checkAlbumDisplayLevel($currentalbum,$parentalbum,$currentfolder,$level) {
	$sublevel_folder = explode("/",$currentalbum->name);
	$sublevel_current = explode("/", $currentfolder);
 
	switch ($level) {
		case 1:
			$sublevelfolder = $sublevel_folder[0];
			$sublevelcurrent = $sublevel_current[0];
			$sublevelcurrentfolder = $parentalbum->name;
			break;
		case 2:
			$sublevelfolder = $sublevel_folder[0]."/".$sublevel_folder[1];
			$sublevelcurrent = $sublevel_current[1];
			$sublevelcurrentfolder = $sublevel_folder[1];
			break;
		case 3:
			$sublevelfolder = $sublevel_folder[0]."/".$sublevel_folder[1]."/".$sublevel_folder[2];
			$sublevelcurrent = $sublevel_current[2];
			$sublevelcurrentfolder = $sublevel_folder[2];
			break;
		case 4:
			$sublevelfolder = $sublevel_folder[0]."/".$sublevel_folder[1]."/".$sublevel_folder[2]."/".$sublevel_folder[3];
			$sublevelcurrent = $sublevel_current[3];
			$sublevelcurrentfolder = $sublevel_folder[3];
			break;
	}
	if(!empty($currentfolder) AND !empty($parentalbum->name)) {
		// if in parentalbum) OR (if in subalbum)
		if((strpos($currentalbum->name,$parentalbum->name) === 0
		AND strpos($currentalbum->name,$currentfolder) === 0
		AND $currentfolder === $sublevelfolder)
		OR
		(getAlbumID() != $parentalbum->getAlbumID()
		AND strpos($currentalbum->name,$parentalbum->name) === 0
		AND $sublevelcurrent === $sublevelcurrentfolder)) {
			return true;
		} else {
			return false;
		}
	} else {
		return false;
	}
}


?>