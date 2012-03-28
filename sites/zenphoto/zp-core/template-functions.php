<?php

/**
 * Functions used to display content in themes.
 * @package functions
 */

// force UTF-8 Ø

/**
 * Load the classes
 */
require_once(dirname(__FILE__).'/class-load.php');
require_once(dirname(__FILE__).'/functions-image.php');

/**
 * Invoke the controller to handle requests
 */
require_once(dirname(__FILE__).'/controller.php');

$_zp_conf_vars['images_first_page'] = NULL; // insure it is initialized

//******************************************************************************
//*** Template Functions *******************************************************
//******************************************************************************

/*** Generic Helper Functions *************/
/******************************************/

/**
 * Returns the zenphoto version string
 */
function getVersion() {
	return ZENPHOTO_VERSION. ' ['.ZENPHOTO_RELEASE. ']';
}

/**
 * Prints the zenphoto version string
 */
function printVersion() {
	echo getVersion();
}

/**
 * Prints the admin edit link for albums if the current user is logged-in

 * Returns true if the user is logged in
 * @param string $text text for the link
 * @param string $before text do display before the link
 * @param string $after  text do display after the link
 * @param string $title Text for the HTML title item
 * @param string $class The HTML class for the link
 * @param string $id The HTML id for the link
 * @return bool
 * @since 1.1
 */
function printAdminLink($text, $before='', $after='', $title=NULL, $class=NULL, $id=NULL) {
	if (zp_loggedin()) {
		echo $before;
		printLink(WEBPATH.'/' . ZENFOLDER . '/admin.php', $text, $title, $class, $id);
		echo $after;
		return true;
	}
	return false;
}

/**
 * Prints the admin edit link for subalbums if the current user is logged-in
 * @param string $text text for the link
 * @param string $before text do display before the link
 * @param string $after  text do display after the link
 * @since 1.1
 */
function printSubalbumAdmin($text, $before='', $after='') {
	global $_zp_current_album, $_zp_themeroot;
	if (zp_loggedin()) {
		echo $before;
		printLink(WEBPATH.'/' . ZENFOLDER . '/admin-edit.php?page=edit&album=' . urlencode($_zp_current_album->name), $text, NULL, NULL, NULL);
		echo $after;
	}
}

/**
 * Print any Javascript required by zenphoto. Every theme should include this somewhere in its <head>.
 */
function zenJavascript() {
	global $_zp_current_album, $_zp_plugin_scripts;

	echo "  <script type=\"text/javascript\" src=\"" . WEBPATH . "/" . ZENFOLDER . "/js/jquery.js\"></script>\n";
	echo "  <script type=\"text/javascript\" src=\"" . WEBPATH . "/" . ZENFOLDER . "/js/zenphoto.js.php\"></script>\n";

	if (($rights = zp_loggedin()) & (ADMIN_RIGHTS | EDIT_RIGHTS)) {
		if (in_context(ZP_ALBUM)) {
			$grant = isMyAlbum($_zp_current_album->name, EDIT_RIGHTS);
		} else {
			$grant = $rights & ADMIN_RIGHTS;
		}
		if ($grant) {
			echo "  <script type=\"text/javascript\" src=\"" . WEBPATH . "/" . ZENFOLDER . "/js/jquery.editinplace.js\"></script>\n";
		}
	}
	if (is_array($_zp_plugin_scripts)) {
		foreach ($_zp_plugin_scripts as $script) {
			echo $script."\n";
		}
	}
}

/**
 * Prints the clickable drop down toolbox on any theme page with generic admin helpers
 * @param string $id the html/css theming id
 */
function printAdminToolbox($id='admin') {
	global $_zp_current_album, $_zp_current_image, $_zp_current_search, $_zp_loggedin, $_zp_gallery_page;
	if (zp_loggedin()) {
		echo '<script type="text/javascript" src="'.WEBPATH.'/'.ZENFOLDER.'/js/admin.js"></script>';
		$zf = WEBPATH."/".ZENFOLDER;
		$dataid = $id . '_data';
		$page = getCurrentPage();
		$redirect = '';
		
		echo '<div id="' .$id. '">'."\n".'<h3><a href="javascript: toggle('. "'" .$dataid."'".');">'.gettext('Admin Toolbox').'</a></h3>'."\n"."\n</div>";
		echo '<div id="' .$dataid. '" style="display: none;">'."\n";
		
		// open the list--all links go between here and the close of the list below
		echo "<ul style='list-style-type: none;'>";
		
		// generic link to Admin.php
		echo "<li>";
		printAdminLink(gettext('Admin'), '', "</li>\n");
		// setup for return links
		if (isset($_GET['p'])) {
			$redirect = "&amp;p=" . $_GET['p'];
		}
		if ($page>1) {
			$redirect .= "&amp;page=$page";
		}
		
		if ($_zp_loggedin & (ADMIN_RIGHTS | OPTIONS_RIGHTS)) {
		// options link for all admins with options rights
			echo "<li>";
			printLink($zf . '/admin-options.php', gettext("Options"), NULL, NULL, NULL);
			echo "</li>\n";
		}
		apply_filter('admin_toolbox_global');
		
		$gal = getOption('custom_index_page');
		if (empty($gal) || !file_exists(SERVERPATH.'/'.THEMEFOLDER.'/'.getOption('current_theme').'/'.UTF8ToFilesystem($gal).'.php')) {
			$gal = 'index.php';
		} else {
			$gal .= '.php';
		}
		if ($_zp_gallery_page === $gal) { 
		// script is either index.php or the gallery index page
			if ($_zp_loggedin & (ADMIN_RIGHTS | EDIT_RIGHTS)) {
				// admin has edit rights so he can sort the gallery (at least those albums he is assigned)
				echo "<li>";
				printSortableGalleryLink(gettext('Sort gallery'), gettext('Manual sorting'));
				echo "</li>\n";
			}
			if ($_zp_loggedin & (ADMIN_RIGHTS | UPLOAD_RIGHTS)) {
				// admin has upload rights, provide an upload link for a new album
				echo "<li>";
				printLink($zf . '/admin-upload.php', gettext("New album"), NULL, NULL, NULL);
				echo "</li>\n";
			}
			apply_filter('admin_toolbox_gallery');
		} else if ($_zp_gallery_page === 'album.php') { 
		// script is album.php
			$albumname = $_zp_current_album->name;
			if (isMyAlbum($albumname, EDIT_RIGHTS)) {
				// admin is empowered to edit this album--show an edit link
				echo "<li>";
				printSubalbumAdmin(gettext('Edit album'), '', "</li>\n");
				if (!$_zp_current_album->isDynamic()) {
					echo "<li>";
					printSortableAlbumLink(gettext('Sort album'), gettext('Manual sorting'));
					echo "</li>\n";
				}
				// and a delete link
				echo "<li><a href=\"javascript: confirmDeleteAlbum('".$zf."/admin-edit.php?page=edit&amp;action=deletealbum&amp;album=" .
					urlencode(urlencode($albumname)) .
					"','".js_encode(gettext("Are you sure you want to delete this entire album?"))."','".js_encode(gettext("Are you Absolutely Positively sure you want to delete the album? THIS CANNOT BE UNDONE!")).
					"');\" title=\"".gettext("Delete the album")."\">".gettext("Delete album")."</a></li>\n";
			}
			if (isMyAlbum($albumname, UPLOAD_RIGHTS) && !$_zp_current_album->isDynamic()) {
				// provide an album upload link if the admin has upload rights for this album and it is not a dynamic album
				echo "<li>";
				printLink($zf . '/admin-upload.php?album=' . urlencode($albumname), gettext("Upload Here"), NULL, NULL, NULL);
				echo "</li>\n";
				echo "<li>";
				printLink($zf . '/admin-upload.php?new&album=' . urlencode($albumname), gettext("New Album Here"), NULL, NULL, NULL);
				echo "</li>\n";
			}
			// set the return to this album/page
			apply_filter('admin_toolbox_album');
			$redirect = "&amp;album=".urlencode($albumname)."&amp;page=$page";
			
		} else if ($_zp_gallery_page === 'image.php') {
		// script is image.php
			$albumname = $_zp_current_album->name;
			$imagename = urlencode($_zp_current_image->filename);
			if (isMyAlbum($albumname, EDIT_RIGHTS)) {
				// if admin has edit rights on this album, provide a delete link for the image.
				echo "<li><a href=\"javascript: confirmDeleteImage('".$zf."/admin-edit.php?page=edit&amp;action=deleteimage&amp;album=" .
				urlencode(urlencode($albumname)) . "&amp;image=". urlencode($imagename) . "','". js_encode(gettext("Are you sure you want to delete the image? THIS CANNOT BE UNDONE!")) . "');\" title=\"".gettext("Delete the image")."\">".gettext("Delete image")."</a>";
				echo "</li>\n";
				
				echo '<li><a href="'.$zf.'/admin-edit.php?page=edit&amp;album='.urlencode($albumname).'&amp;image='.urlencode($imagename).'&amp;tab=imageinfo#IT" title="'.gettext('Edit this image').'">'.gettext('Edit image').'</a></li>'."\n";
			}
			// set return to this image page
			apply_filter('admin_toolbox_image');
			$redirect = "&amp;album=".urlencode($albumname)."&amp;image=$imagename";
			
		} else if (($_zp_gallery_page === 'search.php') && !empty($_zp_current_search->words)) {
		// script is search.php with a search string
			if ($_zp_loggedin & (ADMIN_RIGHTS | UPLOAD_RIGHTS)) {
				// if admin has edit rights allow him to create a dynamic album from the search
				echo "<li><a href=\"".$zf."/admin-dynamic-album.php\" title=\"".gettext("Create an album from the search")."\">".gettext("Create Album")."</a></li>";
			}
			apply_filter('admin_toolbox_search');
			$redirect = "&amp;p=search" . $_zp_current_search->getSearchParams() . "&amp;page=$page";
		}
		
		// zenpage script pages
		if(function_exists('is_NewsArticle')) {
			if ($_zp_loggedin & (ADMIN_RIGHTS | ZENPAGE_RIGHTS)) {
				// admin has zenpage rights, provide link to the zenpage admin tab
				echo "<li><a href=\"".$zf."/plugins/zenpage/\">".gettext("Zenpage")."</a></li>";
				if (is_NewsArticle()) {
					// page is a NewsArticle--provide zenpage edit, delete, and Add links
					echo "<li><a href=\"".$zf."/plugins/zenpage/admin-edit.php?newsarticle&amp;edit&amp;titlelink=".urlencode(getNewsTitlelink())."\">".gettext("Edit Article")."</li>";
					?> 
					<li><a href="javascript: confirmDeleteImage('<?php echo $zf; ?>/plugins/zenpage/news-article-admin.php?del=<?php echo getNewsID(); ?>','<?php echo js_encode(gettext("Are you sure you want to delete this article? THIS CANNOT BE UNDONE!")); ?>')" title="<?php echo gettext("Delete article"); ?>"><?php echo gettext("Delete Article"); ?></a></li>
					<?php
					echo "<li><a href=\"".$zf."/plugins/zenpage/admin-edit.php?newsarticle&amp;add\">".gettext("Add Article")."</li>";
				}
				if (is_Pages()) {
					// page is zenpage page--provide edit, delete, and add links
					echo "<li><a href=\"".$zf."/plugins/zenpage/admin-edit.php?page&amp;edit&amp;titlelink=".urlencode(getPageTitlelink())."\">".gettext("Edit Page")."</li>";
					?> 
					<li><a href="javascript: confirmDeleteImage('<?php echo $zf; ?>/plugins/zenpage/page-admin.php?del=<?php echo getPageID(); ?>','<?php echo js_encode(gettext("Are you sure you want to delete this page? THIS CANNOT BE UNDONE!")); ?>')" title="<?php echo gettext("Delete page"); ?>"><?php echo gettext("Delete Page"); ?></a></li>
					<?php	
					echo "<li><a href=\"".FULLWEBPATH."/".ZENFOLDER."/plugins/zenpage/admin-edit.php?page&amp;add\">".gettext("Add Page")."</li>";
				}
			}
			apply_filter('admin_toolbox_news');
		}	
		
		// logout link
		echo "<li><a href=\"".$zf."/admin.php?logout$redirect\">".gettext("Logout")."</a></li>\n";
		
		// close the list
		echo "</ul>\n";
		echo "</div>\n";
	}
}

//*** Gallery Index (album list) Context ***
//******************************************

/**
 * Returns the raw title of the gallery.
 *
 * @return string
 */
function getGalleryTitle() {
	return get_language_string(getOption('gallery_title'));
}

/**
 * Returns a text-only title of the gallery.
 *
 * @return string
 */
function getBareGalleryTitle() {
	return html_encode(getGalleryTitle());
}

/**
 * Prints the title of the gallery.
 */
function printGalleryTitle() {
	echo getGalleryTitle();
}

/**
 * Returns the raw description of the gallery.
 *
 * @return string
 */
function getGalleryDesc() {
	return get_language_string(getOption('Gallery_description'));
}

/**
 * Returns a text-only description of the gallery.
 *
 * @return string
 */
function getBareGalleryDesc() {
	return html_encode(getGalleryDesc());
}

/**
 * Prints the description of the gallery.
 */
function printGalleryDesc() {
	echo getGalleryDesc();
}

/**
 * Returns the name of the main website as set by the "Website Title" option
 * on the gallery options tab.
 *
 * @return string
 */
function getMainSiteName() {
	return get_language_string(getOption('website_title'));
}

/**
 * Returns the URL of the main website as set by the "Website URL" option
 * on the gallery options tab.
 *
 * @return string
 */
function getMainSiteURL() {
	return getOption('website_url');
}

/**
 * Returns the URL of the main gallery page containing the current album
 *
 * @param bool $relative set to false to get the true index page
 * @return string
 */
function getGalleryIndexURL($relative=true) {
	global $_zp_current_album, $_zp_gallery_page;
	if ($relative && ($_zp_gallery_page != 'index.php')  && in_context(ZP_ALBUM)) {
		$album = getUrAlbum($_zp_current_album);
		$page = $album->getGalleryPage();
	} else {
		$page = 0;
	}
	$gallink1 = '';
	$gallink2 = '';
	$specialpage = false;
	if ($relative && $specialpage = getOption('custom_index_page')) {
		if (file_exists(SERVERPATH.'/'.THEMEFOLDER.'/'.getOption('current_theme').'/'.UTF8ToFilesystem($specialpage).'.php')) {
			$gallink1 = $specialpage.'/';
			$gallink2 = 'p='.$specialpage.'&';
		} else {
			$specialpage = false;
		}
	}
	if ($page > 1) {
		return rewrite_path("/page/".$gallink1.$page, "/index.php?".$gallink2."page=".$page);
	} else {
		if ($specialpage) {
			return rewrite_path('/page/'.$gallink1, '?'.substr($gallink2, 0, -1));
		}
		return WEBPATH . "/";
	}
}

/**
 * Returns the number of albums.
 *
 * @return int
 */
function getNumAlbums() {
	global $_zp_gallery, $_zp_current_search;
	if (in_context(ZP_SEARCH)) {
		return $_zp_current_search->getNumAlbums();
	} else {
		return $_zp_gallery->getNumAlbums();
	}
}


/*** Album AND Gallery Context ************/
/******************************************/

/**
 * WHILE next_album(): context switches to Album.
 * If we're already in the album context, this is a sub-albums loop, which,
 * quite simply, changes the source of the album list.
 * Switch back to the previous context when there are no more albums.

 * Returns true if there are albums, false if none
 *
 * @param bool $all true to go through all the albums
 * @param string $sorttype overrides default sort type
 * @param string $sortdirection overrides default sort direction
 * @return bool
 * @since 0.6
 */
function next_album($all=false, $sorttype=null, $sortdirection=NULL) {
	global $_zp_albums, $_zp_gallery, $_zp_current_album, $_zp_page, $_zp_current_album_restore, $_zp_current_search;
	if (checkforPassword()) { return false; }
	if (is_null($_zp_albums)) {
		if (in_context(ZP_SEARCH)) {
			$_zp_albums = $_zp_current_search->getAlbums($all ? 0 : $_zp_page);
		} else if (in_context(ZP_ALBUM)) {

			if ($_zp_current_album->isDynamic()) {

				$search = $_zp_current_album->getSearchEngine();

				$_zp_albums = $search->getAlbums($all ? 0 : $_zp_page);

			} else {
				$_zp_albums = $_zp_current_album->getSubAlbums($all ? 0 : $_zp_page, $sorttype, $sortdirection);

			}
		} else {
			$_zp_albums = $_zp_gallery->getAlbums($all ? 0 : $_zp_page, $sorttype, $sortdirection);
		}
		if (empty($_zp_albums)) { return false; }
		$_zp_current_album_restore = $_zp_current_album;
		$_zp_current_album = new Album($_zp_gallery, array_shift($_zp_albums));
		save_context();
		add_context(ZP_ALBUM);
		return true;
	} else if (empty($_zp_albums)) {
		$_zp_albums = NULL;
		$_zp_current_album = $_zp_current_album_restore;
		restore_context();
		return false;
	} else {
		$_zp_current_album = new Album($_zp_gallery, array_shift($_zp_albums));
		return true;
	}
}

/**
 * Returns the number of albums without printing it.
 *
 * @return int
 */
function getCurrentPage() {
	global $_zp_page;
	return $_zp_page;
}

/**
 * Returns the count of subalbums in the album
 *
 * @return int
 */
function getNumSubalbums() {
	global $_zp_current_album, $_zp_current_search;
	if (in_context(ZP_SEARCH) && is_null($_zp_current_album)) {
		return $_zp_current_search->getNumAlbums();
	} else {
		if ($_zp_current_album->isDynamic()) {
			$search = $_zp_current_album->getSearchEngine();
			return $search->getNumAlbums();
		} else {
			return count($_zp_current_album->getSubalbums());
		}
	}
	return false;
}

function resetCurrentAlbum() {
	global $_zp_images, $_zp_current_album, $_zp_conf_vars;
	$_zp_images = NULL;
	$_zp_current_album->images = NULL;
	$_zp_conf_vars['images_first_page'] =  NULL;
}

/**
 * Returns the number of pages for the current object
 *
 * @param bool $oneImagePage set to true if your theme collapses all image thumbs
 * or their equivalent to one page. This is typical with flash viewer themes
 *
 * @return int
 */
function getTotalPages($oneImagePage=false) {
	global $_zp_conf_vars;
	global $_zp_gallery, $_zp_current_album;
	if (in_context(ZP_ALBUM | ZP_SEARCH)) {
		$albums_per_page = max(1, getOption('albums_per_page'));
		if (in_context(ZP_SEARCH)) {
			$pageCount = ceil(getNumAlbums() / $albums_per_page);
		} else {
			$pageCount = ceil(getNumSubalbums() / $albums_per_page);
		}
		$imageCount = getNumImages();
		if ($oneImagePage) {
			$imageCount = min(1, $imageCount);
		}
		$images_per_page = max(1, getOption('images_per_page'));
		$pageCount = ($pageCount + ceil(($imageCount - $_zp_conf_vars['images_first_page']) / $images_per_page));
		return $pageCount;
	} else if (in_context(ZP_INDEX)) {
		if(galleryAlbumsPerPage() != 0) {
			return ceil($_zp_gallery->getNumAlbums() / galleryAlbumsPerPage());
		} else {
			return NULL;
		}
	} else {
		return null;
	}
}

/**
 * Returns the URL of the page number passed as a parameter
 *
 * @param int $page Which page is desired
 * @param int $total How many pages there are.
 * @return int
 */
function getPageURL($page, $total=null) {
	global $_zp_current_album, $_zp_gallery, $_zp_current_search, $_zp_gallery_page;
	if (is_null($total)) { $total = getTotalPages(); }
	if (in_context(ZP_SEARCH)) {
		$search = $_zp_current_search->getSearchString();
		foreach ($search as $key=>$item) {
			switch ($item) {
				case '&':
					$search[$key] = 'AND';
					break;
				case '!':
					$search[$key] = 'NOT';
					break;
				case '|':
					$search[$key] = 'OR';
					break;
			}
		}
		$searchwords = implode(' ', $search);
		$searchdate = $_zp_current_search->dates;
		$searchfields = $_zp_current_search->getFields();
		$searchpagepath = getSearchURL($searchwords, $searchdate, $searchfields, $page);
		return $searchpagepath;
	} else {
		if ($specialpage = !in_array($_zp_gallery_page, array('index.php', 'album.php', 'image.php', 'search.php'))) {
			// handle custom page
			$pg = substr($_zp_gallery_page, 0, -4);
			$pagination1 = '/page/'.$pg.'/';
			$pagination2 = 'p='.$pg.'&';
		} else {
			$pagination1 = '/page/';
			$pagination2 = '';
		}
		if ($page <= $total && $page > 0) {
			if (in_context(ZP_ALBUM)) {
				return rewrite_path( pathurlencode($_zp_current_album->name) . (($page > 1) ? "/page/" . $page . "/" : ""),
					"/index.php?album=" . pathurlencode($_zp_current_album->name) . (($page > 1) ? "&page=" . $page : "") );
			} else if (in_context(ZP_INDEX)) {
				if ($page == 1) {
					// Just return the gallery base path for ZP_INDEX (no /page/x)
					if (empty($pagination2)) {
						return rewrite_path('/', '/');
					} else {
						return rewrite_path($pagination1, "/index.php?" . substr($pagination2, 0, -1));
					}
				} else if ($page > 1) {
					return rewrite_path($pagination1 . $page . "/", "/index.php?" . $pagination2 . 'page=' . $page);
				}
			}
		}
		if ($specialpage) {
			return rewrite_path($pagination1, '?'.substr($pagination2, 0, -1));
		}
		return null;
	}
}

/**
 * Returns true if there is a next page
 *
 * @return bool
 */
function hasNextPage() { return (getCurrentPage() < getTotalPages()); }

/**
 * Returns the URL of the next page. Use within If or while loops for pagination.
 *
 * @return string
 */
function getNextPageURL() {
	return getPageURL(getCurrentPage() + 1);
}

/**
 * Prints the URL of the next page.
 *
 * @param string $text text for the URL
 * @param string $title Text for the HTML title
 * @param string $class Text for the HTML class
 * @param string $id Text for the HTML id
 */
function printNextPageLink($text, $title=NULL, $class=NULL, $id=NULL) {
	if (hasNextPage()) {
		printLink(getNextPageURL(), $text, $title, $class, $id);
	} else {
		echo "<span class=\"disabledlink\">$text</span>";
	}
}

/**
 * Returns TRUE if there is a previous page. Use within If or while loops for pagination.
 *
 * @return bool
 */
function hasPrevPage() { return (getCurrentPage() > 1); }

/**
 * Returns the URL of the previous page.
 *
 * @return string
 */
function getPrevPageURL() {
	return getPageURL(getCurrentPage() - 1);
}

/**
 * Returns the URL of the previous page.
 *
 * @param string $text The linktext that should be printed as a link
 * @param string $title The text the html-tag "title" should contain
 * @param string $class Insert here the CSS-class name you want to style the link with
 * @param string $id Insert here the CSS-ID name you want to style the link with
 */
function printPrevPageLink($text, $title=NULL, $class=NULL, $id=NULL) {
	if (hasPrevPage()) {
		printLink(getPrevPageURL(), $text, $title, $class, $id);
	} else {
		echo "<span class=\"disabledlink\">$text</span>";
	}
}

/**
 * Prints a page navigation including previous and next page links
 *
 * @param string $prevtext Insert here the linktext like 'previous page'
 * @param string $separator Insert here what you like to be shown between the prev and next links
 * @param string $nexttext Insert here the linktext like "next page"
 * @param string $class Insert here the CSS-class name you want to style the link with (default is "pagelist")
 * @param string $id Insert here the CSS-ID name if you want to style the link with this
 */
function printPageNav($prevtext, $separator, $nexttext, $class='pagenav', $id=NULL) {
	echo "<div" . (($id) ? " id=\"$id\"" : "") . " class=\"$class\">";
	printPrevPageLink($prevtext, gettext("Previous Page"));
	echo " $separator ";
	printNextPageLink($nexttext, gettext("Next Page"));
	echo "</div>\n";
}

/**
 * Prints a list of all pages.
 *
 * @param string $class the css class to use, "pagelist" by default
 * @param string $id the css id to use
 */
function printPageList($class='pagelist', $id=NULL) {
	printPageListWithNav(null, null, false, false, $class, $id);
}


/**
 * Prints a full page navigation including previous and next page links with a list of all pages in between.
 *
 * @param string $prevtext Insert here the linktext like 'previous page'
 * @param string $nexttext Insert here the linktext like 'next page'
 * @param bool $oneImagePage set to true if there is only one image page as, for instance, in flash themes
 * @param string $nextprev set to true to get the 'next' and 'prev' links printed
 * @param string $class Insert here the CSS-class name you want to style the link with (default is "pagelist")
 * @param string $id Insert here the CSS-ID name if you want to style the link with this
 */
function printPageListWithNav($prevtext, $nexttext, $oneImagePage=false, $nextprev=true, $class='pagelist', $id=NULL) {
	$total = getTotalPages($oneImagePage);
	if ($total < 2) {
		$class .= ' disabled_nav';
	}
	echo "<div" . (($id) ? " id=\"$id\"" : "") . " class=\"$class\">";
	$current = getCurrentPage();
	
	
	echo "\n<ul class=\"$class\">";
	if ($nextprev) {
		echo "\n  <li class=\"prev\">";
		printPrevPageLink($prevtext, gettext("Previous Page"));
		echo "</li>";
	}
	$j=max(1, min($current-3, $total-6));
	if ($j != 1) {
		echo "\n <li>";
		printLink(getPageURL($k=max($j-4,1), $total), '...', "Page $k");
		echo '</li>';
	}
	for ($i=$j; $i <= min($total, $j+6); $i++) {
		echo "\n  <li" . (($i == $current) ? " class=\"current\"" : "") . ">";
		printLink(getPageURL($i, $total), $i, "Page $i" . (($i == $current) ? ' '.gettext("(Current Page)") : ""));
		echo "</li>";
	}
	if ($i <= $total) {
		echo "\n <li>";
		printLink(getPageURL($k=min($j+10,$total), $total), '...', "Page $k");
		echo '</li>';
	}
	if ($nextprev) {
		echo "\n  <li class=\"next\">";
		printNextPageLink($nexttext, gettext("Next Page"));
		echo "</li>";
	}
	echo "\n</ul>";
	echo "\n</div>\n";
}

//*** Album Context ************************
//******************************************

/**
 * Sets the album passed as the current album
 *
 * @param object $album the album to be made current
 */
function makeAlbumCurrent($album) {
	global $_zp_current_album;
	$_zp_current_album = $album; 
	set_context(ZP_INDEX | ZP_ALBUM);
}

/**
 * Returns the raw title of the current album.
 *
 * @return string
 */
function getAlbumTitle() {
	if(!in_context(ZP_ALBUM)) return false;
	global $_zp_current_album;
	return $_zp_current_album->getTitle();
}

/**
 * Returns a text-only title of the current album.
 *
 * @return string
 */
function getBareAlbumTitle() {
	return html_encode(getAlbumTitle());
}

/**
 * Returns an album title taged with of Not visible or password protected status
 *
 * @return string;
 */
function getAnnotatedAlbumTitle() {
	global $_zp_current_album;
	$title = getBareAlbumTitle();
	$pwd = $_zp_current_album->getPassword();
	if (zp_loggedin() && !empty($pwd)) {
		$title .= "\n".gettext('The album is password protected.');
	} 
	if (!$_zp_current_album->getShow()) {
		$title .= "\n".gettext('The album is not published.');
	}
	return $title;
}

/**
 * Prints an encapsulated title of the current album.
 * If you are logged in you can click on this to modify the title on the fly.
 *
 * @param bool   $editable set to true to allow editing (for the admin)
 * @param string $editclass CSS class applied to element if editable
 * @param mixed $messageIfEmpty Either bool or string. If false, echoes nothing when description is empty. If true, echoes default placeholder message if empty. If string, echoes string.
 * @author Ozh
 */
function printAlbumTitle($editable=false, $editclass='', $messageIfEmpty = true) {
	if ( $messageIfEmpty === true ) {
		$messageIfEmpty = gettext('(No title...)');
	}
	printEditable('album', 'title', $editable, $editclass, $messageIfEmpty);
}

/**
 * Gets the 'n' for n of m albums
 *
 * @return int
 */
function albumNumber() {
	global $_zp_current_album, $_zp_current_image, $_zp_current_search, $_zp_gallery, $_zp_dynamic_album;
	$name = $_zp_current_album->getFolder();
	if (in_context(ZP_SEARCH)) {
		$albums = $_zp_current_search->getAlbums();
	} else if (in_context(ZP_ALBUM)) {
		if (is_null($_zp_dynamic_album)) {
			$parent = $_zp_current_album->getParent();
			if (is_null($parent)) {
				$albums = $_zp_gallery->getAlbums();
			} else {
				$albums = $parent->getSubalbums();
			}
		} else {
			$search = $_zp_dynamic_album->getSearchEngine();
			$albums = $search->getAlbums();
		}
	}
	$c = 0;
	foreach ($albums as $albumfolder) {
		$c++;
		if ($name == $albumfolder) {
			return $c;
		}
	}
	return false;
}

/**
 * Returns an array of the names of the parents of the current album.
 *
 * @param object $album optional album object to use inseted of the current album
 * @return array
 */
function getParentAlbums($album=null) {
	if(!in_context(ZP_ALBUM)) return false;
	global $_zp_current_album, $_zp_current_search, $_zp_gallery;
	$parents = array();
	if (is_null($album)) {
		if (in_context(ZP_SEARCH_LINKED) && !in_context(ZP_ALBUM_LINKED)) {
			$name = $_zp_current_search->dynalbumname;
			if (empty($name)) return $parents;
			$album = new Album($_zp_gallery, $name);
		} else {
			$album = $_zp_current_album;
		}
	}
	while (!is_null($album = $album->getParent())) {
		array_unshift($parents, $album);
	}
	return $parents;
}

/**
 * prints the breadcrumb item for the current images's album
 *
 * @param string $before Text to place before the breadcrumb
 * @param string $after Text to place after the breadcrumb
 * @param string $title Text to be used as the URL title tag
 */
function printAlbumBreadcrumb($before='', $after='', $title=NULL) {
	global $_zp_current_search, $_zp_gallery, $_zp_current_album;
	if (is_null($title)) $title = gettext('Album Thumbnails');
	echo $before;
	if (in_context(ZP_SEARCH_LINKED)) {
		$dynamic_album = $_zp_current_search->dynalbumname;
		if (empty($dynamic_album)) {
			if (!is_null($_zp_current_album)) {
				if (in_context(ZP_ALBUM_LINKED) && !in_context(ZP_IMAGE_LINKED)) {
					echo "<a href=\"" . htmlspecialchars(getAlbumLinkURL()). "\" title=\"" . html_encode($title) . "\">" . getAlbumTitle() . "</a>";
				} else {
					$after = '';
				}
			} else {
				$after = '';
			}
		} else {
			if (in_context(ZP_IMAGE) && in_context(ZP_ALBUM_LINKED)) {
				$album = $_zp_current_album;
			} else {
				$album = new Album($_zp_gallery, $dynamic_album);
			}
			echo "<a href=\"" . htmlspecialchars(getAlbumLinkURL($album)) . "\">";
			echo $album->getTitle();
			echo '</a>';
		}
	} else {
		echo "<a href=\"" . htmlspecialchars(getAlbumLinkURL()). "\" title=\"" . html_encode($title) . "\">" . getAlbumTitle() . "</a>";
	}
	echo $after;
}

/**
 * Prints the breadcrumb navigation for album, gallery and image view.
 *
 * @param string $before Insert here the text to be printed before the links
 * @param string $between Insert here the text to be printed between the links
 * @param string $after Insert here the text to be printed after the links
 */
function printParentBreadcrumb($before = '', $between=' | ', $after = ' | ') {
	global $_zp_current_search, $_zp_current_album;
	echo $before;
	if (in_context(ZP_SEARCH_LINKED)) {
		$page = $_zp_current_search->page;
		$searchwords = $_zp_current_search->words;
		$searchdate = $_zp_current_search->dates;
		$searchfields = $_zp_current_search->getFields();
		$searchpagepath = htmlspecialchars(getSearchURL($searchwords, $searchdate, $searchfields, $page));
		$dynamic_album = $_zp_current_search->dynalbumname;
		if (empty($dynamic_album)) {
			echo "<a href=\"" . $searchpagepath . "\" title=\"Return to search\">";
			echo "<em>".gettext("Search")."</em></a>";
			if (is_null($_zp_current_album)) {
				echo $after;
				return;
			} else {
				$parents = getParentAlbums();
				echo $between;
			}
		} else {
			$album = new Album($_zp_gallery, $dynamic_album);
			$parents = getParentAlbums($album);
			if (in_context(ZP_ALBUM_LINKED)) {
				array_push($parents, $album);
			}
		}
	} else {
		$parents = getParentAlbums();

	}
	$n = count($parents);
	if ($n > 0) {
		$i = 0;
		foreach($parents as $parent) {
			if ($i > 0) echo $between;
			$url = rewrite_path("/" . pathurlencode($parent->name) . "/", "/index.php?album=" . urlencode($parent->name));
			printLink($url, $parent->getTitle(), $parent->getDesc());
			$i++;
		}
		echo $after;
	}
}

/**
 * Prints a link to the 'main website'
 * Only prints the link if the url is not empty and does not point back the gallery page
 *
 * @param string $before text to precede the link
 * @param string $after text to follow the link
 * @param string $title Title text
 * @param string $class optional css class
 * @param string $id optional css id
 *  */
function printHomeLink($before='', $after='', $title=NULL, $class=NULL, $id=NULL) {
	$site = getOption('website_url');
	if (!empty($site)) {
		if (substr($site,-1) == "/") { $site = substr($site, 0, -1); }
		if (empty($name)) { $name = get_language_string(getOption('website_title')); }
		if (empty($name)) { $name = 'Home'; }
		if ($site != FULLWEBPATH) {
			echo $before;
			printLink($site, $name, $title, $class, $id);
			echo $after;
		}
	}
}

/**
 * Returns the formatted date field of the album
 *
 * @param string $format optional format string for the date
 * @return string
 */
function getAlbumDate($format=null) {
	global $_zp_current_album;
	$d = $_zp_current_album->getDateTime();
	if (empty($d) || ($d == '0000-00-00 00:00:00')) {
		return false;
	}
	if (is_null($format)) {
		return $d;
	}
	return zpFormattedDate($format, strtotime($d));
}

/**
 * Prints the date of the current album and makes it editable in place if applicable
 *
 * @param string $before Insert here the text to be printed before the date.
 * @param string $nonemessage Insert here the text to be printed if there is no date.
 * @param string $format Format string for the date formatting
 * @param bool $editable when true, enables AJAX editing in place
 * @param string $editclass CSS class applied to element if editable
 * @param mixed $messageIfEmpty Either bool or string. If false, echoes nothing when description is empty. If true, echoes default placeholder message if empty. If string, echoes string.
 * @author Ozh
 */
function printAlbumDate($before='', $nonemessage='', $format=null, $editable=false, $editclass='', $messageIfEmpty = true) {
	if (is_null($format)) {
		$format = getOption('date_format');
	}
	$date = getAlbumDate($format);
	if ($date) {
		$date = $before . $date;
	} else {
		$date = '';
		if ($nonemessage != '') {
			$messageIfEmpty = $nonemessage;
		} elseif ( $messageIfEmpty === true ) {
			$messageIfEmpty = gettext('(No date...)');
		}
	}
	
	printEditable('album', 'date', $editable, $editclass, $messageIfEmpty, false, $date);
}

/**
 * Returns the place of the album.
 *
 * @return string
 */
function getAlbumPlace() {
	global $_zp_current_album;
	return $_zp_current_album->getPlace();
}

/**
 * Prints the place of the album and make it editable
 *
 * @param bool $editable when true, enables AJAX editing in place
 * @param string $editclass CSS class applied to element if editable
 * @param mixed $messageIfEmpty Either bool or string. If false, echoes nothing when description is empty. If true, echoes default placeholder message if empty. If string, echoes string.
 * @author Ozh
 */
function printAlbumPlace($editable=false, $editclass='', $messageIfEmpty = true) {
	if ( $messageIfEmpty === true ) {
		$messageIfEmpty = gettext('(No place...)');
	}
	printEditable('album', 'place', $editable, $editclass, $messageIfEmpty, true);
}

/**
 * Returns the raw description of the current album.
 *
 * @return string
 */
function getAlbumDesc() {
	if(!in_context(ZP_ALBUM)) return false;
	global $_zp_current_album;
	return $_zp_current_album->getDesc();
}

/**
 * Returns a text-only description of the current album.
 *
 * @return string
 */
function getBareAlbumDesc() {
	return html_encode(getAlbumDesc());
}

/**
 * Prints description of the current album and makes it editable in place
 *
 * @param bool $editable when true, enables AJAX editing in place
 * @param string $editclass CSS class applied to element if editable
 * @param mixed $messageIfEmpty Either bool or string. If false, echoes nothing when description is empty. If true, echoes default placeholder message if empty. If string, echoes string.
 * @author Ozh
 */
function printAlbumDesc($editable=false, $editclass='', $messageIfEmpty = true ) {
	if ( $messageIfEmpty === true ) {
		$messageIfEmpty = gettext('(No description...)');
	}
	printEditable('album', 'desc', $editable, $editclass, $messageIfEmpty, true);
}



/**
 * Print any album or image data and make it editable in place
 *
 * @param string $context	either 'image' or 'album'
 * @param string $field		the data field to echo & edit if applicable: 'date', 'title', 'place', 'description', ...
 * @param bool   $editable 	when true, enables AJAX editing in place
 * @param string $editclass CSS class applied to element if editable
 * @param mixed  $messageIfEmpty message echoed if no value to print
 * @param bool   $convertBR	when true, converts new line characters into HTML line breaks
 * @param string $override	if not empty, print this string instead of fetching field value from database
 * @param string $label "label" text to print if the field is not empty
 * @since 1.3
 * @author Ozh
 */
function printEditable($context, $field, $editable = false, $editclass = 'editable', $messageIfEmpty = true, $convertBR = false, $override = false, $label='') {
	
	if (!$context or !$field) {
		trigger_error(gettext('printEditable() incomplete function call.'), E_USER_NOTICE);
		return false;
	}

	switch($context) {
	case 'image':
		global $_zp_current_image;
		$object = $_zp_current_image;
		break;
	case 'album':
		global $_zp_current_album;
		$object = $_zp_current_album;
		break;
	default:
		trigger_error(gettext('printEditable() incomplete function call.'), E_USER_NOTICE);
		return false;
	}
	
	$text = trim( $override !== false ? $override : $object->get($field) );
	if ($convertBR) {
		$text = str_replace("\r\n", "\n", $text);
		$text = str_replace("\n", "<br/>", $text);
	}
	
	if (empty($text)) {
		if ( $editable && zp_loggedin() ) {
			if ( $messageIfEmpty === true ) {
				$text = gettext('(...)');
			} elseif ( is_string($messageIfEmpty) ) {
				$text = $messageIfEmpty;
			}
		}
	}
	if (!empty($text)) echo $label;
	if ( $editable && zp_loggedin() ) {
		// Increment a variable to make sure all elements will have a distinct HTML id
		static $id = 1;
		$id++;
		$class= 'class="' . trim("$editclass zp_editable zp_editable_{$context}_{$field}") . '"';
		echo "<span id=\"editable_$id\" $class>" . $text . "</span>\n";
		echo "<script type=\"text/javascript\">editInPlace('editable_$id', '$context', '$field');</script>";
	} else {
		$class= 'class="' . "zp_uneditable zp_uneditable_{$context}_{$field}" . '"';
		echo "<span $class>" . $text . "</span>\n";
	}
}



/**
 * Returns the custom_data field of the current album
 *
 * @return string
 */
function getAlbumCustomData() {
	global $_zp_current_album;
	return $_zp_current_album->getCustomData();
}

/**
 * Prints the custom_data field of the current album.
 * Converts and displays line break in the admin field as <br />.
 *
 * @param bool $editable when true, enables AJAX editing in place
 * @param string $editclass CSS class applied to element if editable
 * @param mixed $messageIfEmpty Either bool or string. If false, echoes nothing when description is empty. If true, echoes default placeholder message if empty. If string, echoes string.
 * @author Ozh
 */
function printAlbumCustomData($editable = false, $editclass='', $messageIfEmpty = true) {
	if ( $messageIfEmpty === true ) {
		$messageIfEmpty = gettext('(No data...)');
	}
	printEditable('album', 'custom_data', $editable, $editclass, $messageIfEmpty, true);
}

/**
 * Sets the album custom_data field
 *
 * @param string $val The value to be set
 */
function setAlbumCustomData($val) {
	global $_zp_current_album;
	$_zp_current_album->setCustomData($val);
	$_zp_current_album->save();
}

/**
 * A composit for getting album data
 *
 * @param string $field which field you want
 * @return string
 */
function getAlbumData($field) {
	if(!in_context(ZP_IMAGE)) return false;
	global $_zp_album_image;
	return get_language_string($_zp_album_image->get($field));
}

/**
 * Prints arbitrary data from the album object and make it editable if applicable
 *
 * @param string $field the field name of the data desired
 * @param string $label text to label the field
 * @param bool $editable when true, enables AJAX editing in place
 * @param string $editclass CSS class applied to element if editable
 * @param mixed $messageIfEmpty Either bool or string. If false, echoes nothing when description is empty. If true, echoes default placeholder message if empty. If string, echoes string.
 * @author Ozh
 */
function printAlbumData($field, $label='', $editable=false, $editclass='', $messageIfEmpty = true) {
	if ( $messageIfEmpty === true ) {
		$messageIfEmpty = gettext('(No data...)');
	}
	if (empty($editclass)) $editclass = 'metadata';
	printEditable('album', $field, $editable, $editclass, $messageIfEmpty, false, false, $label);
}


/**
 * Returns the album page number of the current image
 *
 * @param object $album optional album object
 * @return integer
 */
function getAlbumPage($album = NULL) {
	global $_zp_current_album, $_zp_current_image, $_zp_current_search, $firstPageImages;
	if (is_null($album)) $album = $_zp_current_album;
	$page = 0;
	if (in_context(ZP_IMAGE) && !in_context(ZP_SEARCH)) {
		if ($_zp_current_album->isDynamic()) {
			$search = $_zp_current_album->getSearchEngine();
			$imageindex = $search->getImageIndex($_zp_current_album->name, $_zp_current_image->filename);
			$numalbums = count($search->getAlbums(0));
		} else {
			$imageindex = $_zp_current_image->getIndex();
			$numalbums = count($album->getSubalbums());
		}
		$imagepage = floor(($imageindex - $firstPageImages) / max(1, getOption('images_per_page'))) + 1;
		$albumpages = ceil($numalbums / max(1, getOption('albums_per_page')));
		if ($albumpages == 0 && $firstPageImages > 0) $imagepage++;
		$page = $albumpages + $imagepage;
	}
	return $page;
}

/**
 * Returns the album link url of the current album.
 *
 * @param object $album optional album object
 * @return string
 */
function getAlbumLinkURL($album=NULL) {
	global $_zp_current_album;
	if (is_null($album)) $album = $_zp_current_album;
	$page = getAlbumPage($album);
	if (in_context(ZP_IMAGE) && $page > 1) {
		// Link to the page the current image belongs to.
		$link = rewrite_path("/" . pathurlencode($album->name) . "/page/" . $page,
			"/index.php?album=" . urlencode($album->name) . "&page=" . $page);
	} else {
		$link = rewrite_path("/" . pathurlencode($album->name) . "/",
			"/index.php?album=" . urlencode($album->name));
	}
	return $link;
}

/**
 * Prints the album link url of the current album.
 *
 * @param string $text Insert the link text here.
 * @param string $title Insert the title text here.
 * @param string $class Insert here the CSS-class name with with you want to style the link.
 * @param string $id Insert here the CSS-id name with with you want to style the link.
 */
function printAlbumLink($text, $title, $class=NULL, $id=NULL) {
	printLink(getAlbumLinkURL(), $text, $title, $class, $id);
}

/**
 * Print a link that allows the user to sort the current album if they are logged in.
 * If they are already sorting, the Save button is displayed.
 *
 * @param string $text Insert the link text here.
 * @param string $title Insert the title text here.
 * @param string $class Insert here the CSS-class name with with you want to style the link.
 * @param string $id Insert here the CSS-id name with with you want to style the link.
 */
function printSortableAlbumLink($text, $title, $class=NULL, $id=NULL) {
	global $_zp_sortable_list, $_zp_current_album;
	if (zp_loggedin()) {
		if (!isset($_GET['sortable'])) {
			printLink(WEBPATH . "/" . ZENFOLDER . "/admin-albumsort.php?page=edit&album=" . urlencode($_zp_current_album->getFolder()),
			$text, $title, $class, $id);
		} else {
			$_zp_sortable_list->printForm(getAlbumLinkURL(), 'POST', gettext('Save'), 'button');
		}
	}
}

/**
 * Print a link that allows the user to sort the Gallery if they are logged in.
 * If they are already sorting, the Save button is displayed.
 *
 * @param string $text Insert the link text here.
 * @param string $title Insert the title text here.
 * @param string $class Insert here the CSS-class name with with you want to style the link.
 * @param string $id Insert here the CSS-id name with with you want to style the link.
 */
function printSortableGalleryLink($text, $title, $class=NULL, $id=NULL) {
	global $_zp_sortable_list, $_zp_current_album;
	if (zp_loggedin()) {
		if (!isset($_GET['sortable'])) {
			printLink(WEBPATH . "/" . ZENFOLDER . "/admin-edit.php?page=edit", $text, $title, $class, $id);
		} else {
			$_zp_sortable_list->printForm(WEBPATH . "/" . ZENFOLDER . "/admin-edit.php?page=edit", 'POST', gettext('Save'), 'button');
		}
	}
}

/**
 * Returns the name of the defined album thumbnail image.
 *
 * @return string
 */
function getAlbumThumb() {
	global $_zp_current_album;
	return $_zp_current_album->getAlbumThumb();
}

/**
 * Returns an img src link to the password protect thumb substitute
 *
 * @param string $extra extra stuff to put in the HTML
 * @return string
 */
function getPasswordProtectImage($extra) {
	global $_zp_themeroot;
	$image = $_zp_themeroot."/images/err-passwordprotected.gif\"";
	$themedir = SERVERPATH . "/themes/".basename($_zp_themeroot);
	$imagebase = $themedir."/images/err-passwordprotected.gif";
	if (file_exists(UTF8ToFilesystem($imagebase))) {
		return "<img src=\"".$image." ".$extra." />";
	} else {
		return "<img src=\"". WEBPATH . '/' . ZENFOLDER."/images/err-passwordprotected.gif\" ".
						$extra."\" />";
	}
}

/**
 * Prints the album thumbnail image.
 *
 * @param string $alt Insert the text for the alternate image name here.
 * @param string $class Insert here the CSS-class name with with you want to style the link.
 * @param string $id Insert here the CSS-id name with with you want to style the link.
 *  */
function printAlbumThumbImage($alt, $class=NULL, $id=NULL) {
	global $_zp_current_album, $_zp_themeroot;
	if (!$_zp_current_album->getShow()) {
		$class .= " not_visible";
	} else {
		$pwd = $_zp_current_album->getPassword();
		if (zp_loggedin() && !empty($pwd)) {
			$class .= " password_protected";
		}
	}
	$class = trim($class);
	if (!getOption('use_lock_image') || checkAlbumPassword($_zp_current_album->name, $hint)) {
		echo "<img src=\"" . htmlspecialchars(getAlbumThumb()) . "\" alt=\"" . html_encode($alt) . "\"" .
		(($class) ? " class=\"$class\"" : "") . (($id) ? " id=\"$id\"" : "") . " />";
	} else {
		echo getPasswordProtectImage("\" width=\"".getOption('thumb_crop_width')."\"");
	}
}

/**
 * Returns a link to a custom sized thumbnail of the current album
 *
 * @param int $size the size of the image to have
 * @param int $width width
 * @param int $height height
 * @param int $cropw crop width
 * @param int $croph crop height
 * @param int $cropx crop part x axis
 * @param int $cropy crop part y axis
 *
 * @return string
 */

function getCustomAlbumThumb($size, $width=NULL, $height=NULL, $cropw=NULL, $croph=NULL, $cropx=NULL, $cropy=null) {
	global $_zp_current_album;
	$thumb = $_zp_current_album->getAlbumThumbImage();
	return $thumb->getCustomImage($size, $width, $height, $cropw, $croph, $cropx, $cropy, true);
}

/**
 * Prints a link to a custom sized thumbnail of the current album
 *
 * @param string $alt Alt atribute text
 * @param int $size size
 * @param int $width width
 * @param int $height height
 * @param int $cropw cropwidth
 * @param int $croph crop height
 * @param int $cropx crop part x axis
 * @param int $cropy crop part y axis
 * @param string $class css class
 * @param string $id css id
 *
 * @return string
 */
function printCustomAlbumThumbImage($alt, $size, $width=NULL, $height=NULL, $cropw=NULL, $croph=NULL, $cropx=NULL, $cropy=null, $class=NULL, $id=NULL) {
	global $_zp_current_album;
	if (!$_zp_current_album->getShow()) {
		$class .= " not_visible";
	} else {
		$pwd = $_zp_current_album->getPassword();
		if (zp_loggedin() && !empty($pwd)) {
			$class .= " password_protected";
		}
	}
	$class = trim($class);
	/* set the HTML image width and height parameters in case this image was "imageDefault.png" substituted for no thumbnail then the thumb layout is preserved */
	if ($sizeW = max(is_null($width) ? 0: $width, is_null($cropw) ? 0 : $cropw)) {
		$sizing = ' width="' . $sizeW . '"';
	} else {
		$sizing = null;
	}
	if ($sizeH = max(is_null($height) ? 0 : $height, is_null($croph) ? 0 : $croph)) {
		$sizing = $sizing . ' height="' . $sizeH . '"';
	}
	if (!getOption('use_lock_image') || checkAlbumPassword($_zp_current_album->name, $hint)){
		echo "<img src=\"" . htmlspecialchars(getCustomAlbumThumb($size, $width, $height, $cropw, $croph, $cropx, $cropy)). "\"" . $sizing . " alt=\"" . html_encode($alt) . "\"" .
		(($class) ? " class=\"$class\"" : "") .	(($id) ? " id=\"$id\"" : "") . " />";
	} else {
		echo getPasswordProtectImage($sizing);
	}
}

/**
 * Called by xxxMaxSpace functions to compute the parameters to be passed to xxCustomXXX functions.
 *
 * @param int $width maxspace width
 * @param int $height maxspace height
 * @param object $image the image in question
 * @param bool $thumb true if for a thumbnail
 */
function getMaxSpaceContainer(&$width, &$height, $image, $thumb=false) {
	global $_zp_gallery;
	$imagename = $image->filename;
	if (!isImagePhoto($image) & $thumb) {
		$imgfile = $image->getThumbImageFile();
		$image = get_image($imgfile);
		$s_width = imagesx($image);
		$s_height = imagesy($image);
	} else {
		$s_width = $image->get('width');
		if ($s_width == 0) $s_width = max($width,$height);
		$s_height = $image->get('height');
		if ($s_height == 0) $s_height = max($width,$height);
	}
	
	$newW = round($height/$s_height*$s_width);
	$newH = round($width/$s_width*$s_height);
	if (DEBUG_IMAGE) debugLog("getMaxSpaceContainer($width, $height, $imagename, $thumb): \$s_width=$s_width; \$s_height=$s_height; \$newW=$newW; \$newH=$newH;");
	if ($newW > $width) {
		$height = $newH;
	} else {
		$width = $newW;
	}
}

	/**
 * Returns a link to a uncropped custom sized version of the current album thumb within the given height and width dimensions.
  *
 * @param int $width width
 * @param int $height height
 * @return string
 */
function getCustomAlbumThumbMaxSpace($width, $height) {
	global $_zp_current_album;
	$albumthumb = $_zp_current_album->getAlbumThumbImage();
	getMaxSpaceContainer($width, $height, $albumthumb, true);
	return getCustomAlbumThumb(NULL, $width, $height, NULL, NULL, NULL, NULL);
}

/**
 * Prints a uncropped custom sized album thumb within the given height and width dimensions.
 * Note: a class of 'not_visible' or 'password_protected' will be added as appropriate
 * 
 * @param string $alt Alt text for the url
 * @param int $width width
 * @param int $height height
 * @param string $class Optional style class
 * @param string $id Optional style id
 * @param bool $thumbStandin set true to inhibit watermarking
 */
function printCustomAlbumThumbMaxSpace($alt='', $width, $height, $class=NULL, $id=NULL) {
	global $_zp_current_album;
	$albumthumb = $_zp_current_album->getAlbumThumbImage();
	getMaxSpaceContainer($width, $height, $albumthumb, true);
	printCustomAlbumThumbImage($alt, NULL, $width, $height, NULL, NULL, NULL, NULL, $class, $id);
}

/**
 * Returns the next album
 *
 * @return object
 */
function getNextAlbum() {
	global $_zp_current_album, $_zp_current_search, $_zp_gallery;
	if (in_context(ZP_SEARCH) || in_context(ZP_SEARCH_LINKED)) {
		$nextalbum = $_zp_current_search->getNextAlbum($_zp_current_album->name);
	} else if (in_context(ZP_ALBUM)) {
		if ($_zp_current_album->isDynamic()) {
			$search = $_zp_current_album->getSearchEngine();
			$nextalbum = $search->getNextAlbum($_zp_current_album->name);
		} else {
			$nextalbum = $_zp_current_album->getNextAlbum();
		}
	} else {
		return null;
	}
	return $nextalbum;
}

/**
 * Get the URL of the next album in the gallery.
 *
 * @return string
 */
function getNextAlbumURL() {
	$nextalbum = getNextAlbum();
	if ($nextalbum) {
		return rewrite_path("/" . pathurlencode($nextalbum->name),
												"/index.php?album=" . urlencode($nextalbum->name));
	}
	return false;
}

/**
 * Returns the previous album
 *
 * @return object
 */
function getPrevAlbum() {
	global $_zp_current_album, $_zp_current_search;
	if (in_context(ZP_SEARCH) || in_context(ZP_SEARCH_LINKED)) {
		$prevalbum = $_zp_current_search->getPrevAlbum($_zp_current_album->name);
	} else if(in_context(ZP_ALBUM)) {
		if ($_zp_current_album->isDynamic()) {
			$search = $_zp_current_album->getSearchEngine();
			$prevalbum = $search->getPrevAlbum($_zp_current_album->name);
		} else {
			$prevalbum = $_zp_current_album->getPrevAlbum();
		}
	} else {
		return null;
	}
	return $prevalbum;
}

/**
 * Get the URL of the previous album in the gallery.
 *
 * @return string
 */
function getPrevAlbumURL() {
	$prevalbum = getPrevAlbum();
	if ($prevalbum) {
		return rewrite_path("/" . pathurlencode($prevalbum->name),
												"/index.php?album=" . urlencode($prevalbum->name));
	}
	return false;
}

/**
 * Returns true if this page has image thumbs on it
 *
 * @return bool
 */
function isImagePage() {
	global $_zp_page, $firstPageImages;
	$imagestart = getTotalPages(true);
	if (isset($firstPageImages) && $firstPageImages) $imagestart --; // then images start on the last album page.
	return $_zp_page >= $imagestart;
}

/**
 * Returns true if this page has album thumbs on it
 *
 * @return bool
 */
function isAlbumPage() {
	global $_zp_page;
	if (in_context(ZP_SEARCH)) {
		$pageCount = Ceil(getNumAlbums() / getOption('albums_per_page'));
	} else {
		$pageCount = Ceil(getNumSubalbums() / getOption('albums_per_page'));
	}
	return ($_zp_page <= $pageCount);
}

/**
 * Returns the number of images in the album.
 *
 * @return int
 */
function getNumImages() {
	global $_zp_current_album, $_zp_current_search;
	if ((in_context(ZP_SEARCH_LINKED) && !in_context(ZP_ALBUM_LINKED)) || in_context(ZP_SEARCH) && is_null($_zp_current_album)) {
		return $_zp_current_search->getNumImages();
	} else {
		if ($_zp_current_album->isDynamic()) {
			$search = $_zp_current_album->getSearchEngine();
			return $search->getNumImages();
		} else {
			return $_zp_current_album->getNumImages();
		}
	}
	return false;
}

/**
* Returns the count of all the images in the album and any subalbums
*
* @param object $album The album whose image count you want
* @return int
* @since 1.1.4
*/

function getTotalImagesIn($album) {
	global $_zp_gallery;
	$sum = $album->getNumImages();
	$subalbums = $album->getSubalbums(0);
	while (count($subalbums) > 0) {
		$albumname = array_pop($subalbums);
		$album = new Album($_zp_gallery, $albumname);
		$sum = $sum + getTotalImagesIn($album);
	}
	return $sum;
}


/**
 * Returns the next image on a page.
 * sets $_zp_current_image to the next image in the album.

 * Returns true if there is an image to be shown
 *
 * @param bool $all set to true disable pagination
 * @param int $firstPageCount the number of images which can go on the page that transitions between albums and images
 * @param string $sorttype overrides the default sort type
 * @param string $sortdirection overrides the default sort direction.
 * @param bool $overridePassword the password check
 * @return bool
 *
 * @return bool
 */
function next_image($all=false, $firstPageCount=0, $sorttype=null, $sortdirection=NULL, $overridePassword=false) {
	global $_zp_images, $_zp_current_image, $_zp_current_album, $_zp_page, $_zp_current_image_restore,
				 $_zp_conf_vars, $_zp_current_search, $_zp_gallery;
	if (!$overridePassword) { if (checkforPassword()) { return false; } }
	$imagePageOffset = getTotalPages(true) - 1; /* gives us the count of pages for album thumbs */
	if ($all) {
		$imagePage = 1;
	} else {
		$_zp_conf_vars['images_first_page'] = $firstPageCount;  /* save this so pagination can see it */
		$imagePage = $_zp_page - $imagePageOffset;
	}
	if ($firstPageCount > 0 && $imagePageOffset > 0) {
		$imagePage = $imagePage + 1;  /* can share with last album page */
	}
	if ($imagePage <= 0) {
		return false;  /* we are on an album page */
	}
	if (is_null($_zp_images)) {
		if (in_context(ZP_SEARCH)) {
			$searchtype = true;
			$_zp_images = $_zp_current_search->getImages($all ? 0 : ($imagePage), $firstPageCount);
		} else {
			if ($_zp_current_album->isDynamic()) {
				$searchtype = true;
				$search = $_zp_current_album->getSearchEngine();
				$_zp_images = $search->getImages($all ? 0 : ($imagePage), $firstPageCount);
			} else {
				$_zp_images = $_zp_current_album->getImages($all ? 0 : ($imagePage), $firstPageCount, $sorttype, $sortdirection);
			}
		}
		if (empty($_zp_images)) { return false; }
		$_zp_current_image_restore = $_zp_current_image;
		$img = array_shift($_zp_images);
		if (is_array($img)) {

			$_zp_current_image = newImage(new Album($_zp_gallery, $img['folder']), $img['filename']);
		} else {
			$_zp_current_image = newImage($_zp_current_album, $img);
		}
		save_context();
		add_context(ZP_IMAGE);
		return true;
	} else if (empty($_zp_images)) {
		$_zp_images = NULL;
		$_zp_current_image = $_zp_current_image_restore;
		restore_context();
		return false;
	} else {
		$img = array_shift($_zp_images);
		if (is_array($img)) {
			$_zp_current_image = newImage(new Album($_zp_gallery, $img['folder']), $img['filename']);
		} else {
			$_zp_current_image = newImage($_zp_current_album, $img);
		}
		return true;
	}
}

//*** Image Context ************************
//******************************************

/**
 * Sets the image passed as the current image
 *
 * @param object $image the image to become current
 */
function makeImageCurrent($image) {
	if (!is_object($image)) return;
	global $_zp_current_album, $_zp_current_image;
	$_zp_current_image = $image;
	$_zp_current_album = $_zp_current_image->getAlbum(); 
	set_context(ZP_INDEX | ZP_ALBUM | ZP_IMAGE);
}

/**
 * Returns the raw title of the current image.
 *
 * @return string
 */
function getImageTitle() {
	if(!in_context(ZP_IMAGE)) return false;
	global $_zp_current_image;
	return $_zp_current_image->getTitle();
}

/**
 * Returns a text-only title of the current image.
 *
 * @return string
 */
function getBareImageTitle() {
	return html_encode(getImageTitle());
}

/**
 * Returns the image title taged with not visible annotation.
 *
 * @return string
 */
function getAnnotatedImageTitle() {
	global $_zp_current_image;
	$title = getBareImageTitle();
	if (!$_zp_current_image->getShow()) {
		$title .= "\n".gettext('The image is marked not visible.');
	}
	return $title;
}
/**
 * Prints title of the current image and make it editable in place
 *
 * @param bool   $editable if set to true and the admin is logged in allows editing of the title
 * @param string $editclass CSS class applied to element if editable
 * @param mixed $messageIfEmpty Either bool or string. If false, echoes nothing when description is empty. If true, echoes default placeholder message if empty. If string, echoes string.
 * @author Ozh
 */
function printImageTitle($editable=false, $editclass='editable imageTitleEditable', $messageIfEmpty = true ) {
	if ( $messageIfEmpty === true ) {
		$messageIfEmpty = gettext('(No title...)');
	}
	printEditable('image', 'title', $editable, $editclass, $messageIfEmpty);
}

/**
 * Returns the 'n' of n of m images
 *
 * @return int
 */
function imageNumber() {
	global $_zp_current_image, $_zp_current_search, $_zp_current_album;
	$name = $_zp_current_image->getFileName();
	if (in_context(ZP_SEARCH)  || (in_context(ZP_SEARCH_LINKED) && !in_context(ZP_ALBUM_LINKED))) {
		$images = $_zp_current_search->getImages();
		$c = 0;
		foreach ($images as $image) {
			$c++;
			if ($name == $image['filename']) {
				return $c;
			}
		}
	} else {
		if ($_zp_current_album->isDynamic()) {
			$search = $_zp_current_album->getSearchEngine();
			$images = $search->getImages();
			$c = 0;
			foreach ($images as $image) {
				$c++;
				if ($name == $image['filename']) {
					return $c;
				}
			}
		} else {
			return $_zp_current_image->getIndex()+1;
		}
	}
	return false;
}

/**
 * Returns the image date of the current image in yyyy-mm-dd hh:mm:ss format.
 * Pass it a date format string for custom formatting
 *
 * @param string $format formatting string for the data
 * @return string
 */
function getImageDate($format=null) {
	if(!in_context(ZP_IMAGE)) return false;
	global $_zp_current_image;
	$d = $_zp_current_image->getDateTime();
	if (empty($d) || ($d == '0000-00-00 00:00:00') ) {
		return false;
	}
	if (is_null($format)) {
		return $d;
	}
	return zpFormattedDate($format, strtotime($d));
}

/**
 * Prints the date of the current album and makes it editable in place if applicable
 *
 * @param string $before Insert here the text to be printed before the date.
 * @param string $nonemessage Insert here the text to be printed if there is no date.
 * @param string $format Format string for the date formatting
 * @param bool $editable when true, enables AJAX editing in place
 * @param string $editclass CSS class applied to element if editable
 * @param mixed $messageIfEmpty Either bool or string. If false, echoes nothing when description is empty. If true, echoes default placeholder message if empty. If string, echoes string.
 * @author Ozh
 */
function printImageDate($before='', $nonemessage='', $format=null, $editable=false, $editclass='', $messageIfEmpty = true) {
	if (is_null($format)) {
		$format = getOption('date_format');
	}
	$date = getImageDate($format);
	if ($date) {
		$date = $before . $date;
	} else {
		$date = '';
		if ($nonemessage != '') {
			$messageIfEmpty = $nonemessage;
		} elseif ( $messageIfEmpty === true ) {
			$messageIfEmpty = gettext('(No date...)');
		}
	}
	
	printEditable('image', 'date', $editable, $editclass, $messageIfEmpty, false, $date);
}

// IPTC fields
/**
 * Returns the Location field of the current image
 *
 * @return string
 */
function getImageLocation() {
	if(!in_context(ZP_IMAGE)) return false;
	global $_zp_current_image;
	return $_zp_current_image->getLocation();
}

/**
 * Returns the City field of the current image
 *
 * @return string
 */
function getImageCity() {
	if(!in_context(ZP_IMAGE)) return false;
	global $_zp_current_image;
	return $_zp_current_image->getcity();
}

/**
 * Returns the State field of the current image
 *
 * @return string
 */
function getImageState() {
	if(!in_context(ZP_IMAGE)) return false;
	global $_zp_current_image;
	return $_zp_current_image->getState();
}

/**
 * Returns the Country field of the current image
 *
 * @return string
 */
function getImageCountry() {
	if(!in_context(ZP_IMAGE)) return false;
	global $_zp_current_image;
	return $_zp_current_image->getCountry();
}

/**
 * Returns the raw description of the current image.
 * new lines are replaced with <br/> tags
 *
 * @return string
 */
function getImageDesc() {
	if(!in_context(ZP_IMAGE)) return false;
	global $_zp_current_image;
	return $_zp_current_image->getDesc();
}

/**
 * Returns a text-only description of the current image.
 *
 * @return string
 */
function getBareImageDesc() {
	return html_encode(getImageDesc());
}

/**
 * Prints the description of the current image.
 * Converts and displays line breaks set in the admin field as <br />.
 *
 * @param bool $editable set true to allow editing by the admin
 * @param string $editclass CSS class applied to element when editable
 * @param mixed $messageIfEmpty Either bool or string. If false, echoes nothing when description is empty. If true, echoes default placeholder message if empty. If string, echoes string.
 * @author Ozh
 */
function printImageDesc($editable=false, $editclass='', $messageIfEmpty = true) {
	if ( $messageIfEmpty === true ) {
		$messageIfEmpty = gettext('(No description...)');
	}
	printEditable('image', 'desc', $editable, $editclass, $messageIfEmpty, true);
}

/**
 * A composit for getting image data
 *
 * @param string $field which field you want
 * @return string
 */
function getImageData($field) {
	if(!in_context(ZP_IMAGE)) return false;
	global $_zp_current_image;
	return get_language_string($_zp_current_image->get($field));
}

/**
 * Returns the custom_data field of the current image
 *
 * @return string
 */
function getImageCustomData() {
	Global $_zp_current_image;
	return $_zp_current_image->getCustomData();
}

/**
 * Prints the custom_data field of the current image.
 * Converts and displays line breaks set in the admin field as <br />.
 *
 * @return string
 */
function printImageCustomData() {
	$data = getImageCustomData();
	$data = str_replace("\r\n", "\n", $data);
	$data = str_replace("\n", "<br/>", $data);
	echo $data;
}

/**
 * Sets the image custom_data field
 *
 * @param string $val
 */
function setImageCustomData($val) {
	Global $_zp_current_image;
	$_zp_current_image->setCustomData($val);
	$_zp_current_image->save();
}

/**
 * Prints arbitrary data from the image object and make it editable if applicable
 *
 * @param string $field the field name of the data desired
 * @param string $label text to label the field.
 * @param bool $editable when true, enables AJAX editing in place
 * @param string $editclass CSS class applied to element if editable
 * @param mixed $messageIfEmpty Either bool or string. If false, echoes nothing when description is empty. If true, echoes default placeholder message if empty. If string, echoes string.
 * @author Ozh
 */
function printImageData($field, $label='', $editable=false, $editclass='', $messageIfEmpty = true) {
	if ( $messageIfEmpty === true ) {
		$messageIfEmpty = gettext('(No data...)');
	}
	if (empty($editclass)) $editclass = 'metadata';
	printEditable('image', $field, $editable, $editclass, $messageIfEmpty, false, false, $label);
}

/**
 * Get the unique ID of the current image.
 *
 * @return int
 */
function getImageID() {
	if (!in_context(ZP_IMAGE)) return false;
	global $_zp_current_image;
	return $_zp_current_image->id;
}

/**
 * Print the unique ID of the current image.
 */
function printImageID() {
	if (!in_context(ZP_IMAGE)) return false;
	global $_zp_current_image;
	echo "image_".getImageID();
}

/**
 * Get the sort order of this image.
 *
 * @return string
 */
function getImageSortOrder() {
	if (!in_context(ZP_IMAGE)) return false;
	global $_zp_current_image;
	return $_zp_current_image->getSortOrder();
}

/**
 * Print the sort order of this image.
 */
function printImageSortOrder() {
	if (!in_context(ZP_IMAGE)) return false;
	echo getImageSortOrder();
}

/**
 * True if there is a next image
 *
 * @return bool
 */
function hasNextImage() {
	global $_zp_current_image;
	if (is_null($_zp_current_image)) return false;
	return $_zp_current_image->getNextImage();
}
/**
 * True if there is a previous image
 *
 * @return bool
 */
function hasPrevImage() {
	global $_zp_current_image;
	if (is_null($_zp_current_image)) return false;
	return $_zp_current_image->getPrevImage();
}

/**
 * Returns the url of the next image.
 *
 * @return string
 */
function getNextImageURL() {
	if(!in_context(ZP_IMAGE)) return false;
	global $_zp_current_album, $_zp_current_image;
	if (is_null($_zp_current_image)) return false;
	$nextimg = $_zp_current_image->getNextImage();
	return rewrite_path("/" . pathurlencode($nextimg->album->name) . "/" . urlencode($nextimg->filename) . im_suffix(),
		"/index.php?album=" . urlencode($nextimg->album->name) . "&image=" . urlencode($nextimg->filename));
}

/**
 * Returns the url of the previous image.
 *
 * @return string
 */
function getPrevImageURL() {
	if(!in_context(ZP_IMAGE)) return false;
	global $_zp_current_album, $_zp_current_image;
	if (is_null($_zp_current_image)) return false;
	$previmg = $_zp_current_image->getPrevImage();
	return rewrite_path("/" . pathurlencode($previmg->album->name) . "/" . urlencode($previmg->filename) . im_suffix(),
		"/index.php?album=" . urlencode($previmg->album->name) . "&image=" . urlencode($previmg->filename));
}

/**
* Returns the url of the first image in current album.
*
* @return string
* @author gerben
*/
function getFirstImageURL() {
	global $_zp_current_album;
	if (is_null($_zp_current_album)) return false;
	$firstimg = $_zp_current_album->getImage(0);
	return rewrite_path("/" . pathurlencode($_zp_current_album->name) . "/" . urlencode($firstimg->filename) . im_suffix(),
											"/index.php?album=" . urlencode($_zp_current_album->name) . "&image=" . urlencode($firstimg->filename));
}

/**
* Returns the url of the last image in current album.
*
* @return string
*/
function getLastImageURL() {
	global $_zp_current_album;
	if (is_null($_zp_current_album)) return false;
	$lastimg = $_zp_current_album->getImage($_zp_current_album->getNumImages() - 1);
	return rewrite_path("/" . pathurlencode($_zp_current_album->name) . "/" . urlencode($lastimg->filename) . im_suffix(),
											"/index.php?album=" . urlencode($_zp_current_album->name) . "&image=" . urlencode($lastimg->filename));
}

/**
 * Prints out the javascript to preload the next and previous images
 *
 */
function printPreloadScript() {
	global $_zp_current_image;
	$size = getOption('image_size');
	if (hasNextImage() || hasPrevImage()) {
		echo "<script type=\"text/javascript\">\n";
		if (hasNextImage()) {
			$nextimg = $_zp_current_image->getNextImage();
			echo "  nextimg = new Image();\n  nextimg.src = \"" . $nextimg->getSizedImage($size) . "\";\n";
		}
		if (hasPrevImage()) {
			$previmg = $_zp_current_image->getPrevImage();
			echo "  previmg = new Image();\n  previmg.src = \"" . $previmg->getSizedImage($size) . "\";\n";
		}
		echo "</script>\n\n";
	}
}

/**
 * Returns the thumbnail of the previous image.
 *
 * @return string
 */
function getPrevImageThumb() {
	if(!in_context(ZP_IMAGE)) return false;
	global $_zp_current_image;
	if (is_null($_zp_current_image)) return false;
	$img = $_zp_current_image->getPrevImage();
	return $img->getThumb();
}

/**
 * Returns the thumbnail of the next image.
 *
 * @return string
 */
function getNextImageThumb() {
	if(!in_context(ZP_IMAGE)) return false;
	global $_zp_current_image;
	if (is_null($_zp_current_image)) return false;
	$img = $_zp_current_image->getNextImage();
	return $img->getThumb();
}

/**
 * Returns the url of the current image.
 *
 * @return string
 */
function getImageLinkURL() {
	if(!in_context(ZP_IMAGE)) return false;
	global $_zp_current_image;
	if (is_null($_zp_current_image)) return false;
	return $_zp_current_image->getImageLink();
}

/**
 * Prints the link to the current  image.
 *
 * @param string $text text for the link
 * @param string $title title tag for the link
 * @param string $class optional style class for the link
 * @param string $id optional style id for the link
 */
function printImageLink($text, $title, $class=NULL, $id=NULL) {
	printLink(getImageLinkURL(), $text, $title, $class, $id);
}

/**
 * Print the entire <div> for a thumbnail. If we are in sorting mode, then only
 * the image is inserted, if not, then the hyperlink to the image is also added.
 *
 * @author Todd Papaioannou (lucky@luckyspin.org)
 * @since  1.0.0
 */
function printImageDiv() {
	if (!isset($_GET['sortable'])) {
		echo '<a href="'.htmlspecialchars(getImageLinkURL()).'" title="'.html_encode(getImageTitle()).'">';
	}
	printImageThumb(getImageTitle());

	if (!isset($_GET['sortable'])) {
		echo '</a>';
	}
}

/**
 * Returns the EXIF infromation from the current image
 *
 * @return array
 */
function getImageEXIFData() {
	global $_zp_current_image;
	if (is_null($_zp_current_image)) return false;
	return $_zp_current_image->getExifData();
}

/**
 * Prints image data. 
 * 
 * Deprecated, use printImageMetadata
 *
 */
function printImageEXIFData() {
	trigger_error(gettext('printImageEXIFData is deprecated. Use printImageMetadata().'), E_USER_NOTICE);
	if (isImageVideo()) {
	} else {
		printImageMetadata(); 
	} 
}

/**
 * Prints the EXIF data of the current image, and make each value editable in place if applicable
 *
 * @param string $title title tag for the class
 * @param bool $toggle set to true to get a javascript toggle on the display of the data
 * @param string $id style class id
 * @param string $class style class
 * @param bool $editable set true to allow editing by the admin
 * @param string $editclass CSS class applied to element when editable
 * @param mixed $messageIfEmpty Either bool or string. If false, echoes nothing when description is empty. If true, echoes default placeholder message if empty. If string, echoes string.
 * @author Ozh
 */
function printImageMetadata($title=NULL, $toggle=true, $id='imagemetadata', $class=null, $editable = false, $editclass='', $messageIfEmpty = '') {

	if (false === ($exif = getImageEXIFData()))
		return;

	global $_zp_exifvars, $_zp_current_image;

	if (is_null($title))
		$title = gettext('Image Info');
	
	// EXIF values will be editable only with sufficient privileges and if values are stored in the database
	$editable = ( $editable && zp_loggedin() && ( $_zp_current_image->get('EXIFValid') == 1 ) );

	if ( $messageIfEmpty === true ) {
		$messageIfEmpty = gettext('(No data)');
	}			

	$dataid = $id . '_data';
	echo "<div" . (($class) ? " class=\"$class\"" : "") . (($id) ? " id=\"$id\"" : "") . ">\n";
	if ($toggle) echo "<a href=\"javascript:toggle('$dataid');\">";
	echo "<span class='metadata_title'>$title</span>";
	if ($toggle) echo "</a>\n";

	echo "<table id=\"$dataid\"" . ($toggle ? " style=\"display: none;\"" : '') . ">\n";
	foreach ($exif as $field => $value) {
		$display = $_zp_exifvars[$field][3];
		if ($display) {
			$label = $_zp_exifvars[$field][2];
			echo "<tr><td class=\"label\">$label:</td><td class=\"value\">";
			printEditable('image', $field, $editable, $editclass, $messageIfEmpty, false, $value);
			echo "</td></tr>\n";
		}
	}
	echo "</table>\n</div>\n";
	
}

/**
 * Returns a link to a custom sized version of he current image
 *
 * @param int $size size
 * @param int $width width
 * @param int $height height
 * @param int $cw crop width
 * @param int $ch crop height
 * @param int $cx crop x axis
 * @param int $cy crop y axis
 * @return string
 */
function getSizeCustomImage($size, $width=NULL, $height=NULL, $cw=NULL, $ch=NULL, $cx=NULL, $cy=NULL) {
	if(!in_context(ZP_IMAGE)) return false;
	global $_zp_current_image, $_zp_flash_player;
	if (is_null($_zp_current_image)) return false;
	$h = $_zp_current_image->getHeight();
	$w = $_zp_current_image->getWidth();
	if (isImageVideo()) { // size is determined by the player
		return array($w, $h);
	}
	$h = $_zp_current_image->getHeight();
	$w = $_zp_current_image->getWidth();
	$side = getOption('image_use_side'); 
	$us = getOption('image_allow_upscale');

	$args = getImageParameters(array($size, $width, $height, $cw, $ch, $cx, $cy, null));
	@list($size, $width, $height, $cw, $ch, $cx, $cy, $quality, $thumb, $crop, $thumbstandin, $thumbWM, $adminrequest) = $args;
	if (!empty($size)) {
		$dim = $size;
		$width = $height = false;
	} else if (!empty($width)) {
		$dim = $width;
		$size = $height = false;
	} else if (!empty($height)) {
		$dim = $height;
		$size = $width = false;
	} else {
		$dim = 1;
	}

	if ($w == 0) {
		$hprop = 1;
	} else {
		$hprop = round(($h / $w) * $dim);
	}
	if ($h == 0) {
		$wprop = 1;
	} else {
		$wprop = round(($w / $h) * $dim);
	}
	
	if (($size && ($side == 'longest' && $h > $w) || ($side == 'height') || ($side == 'shortest' && $h < $w))	|| $height) {
		// Scale the height
		$newh = $dim;
		$neww = $wprop;
	} else {
		// Scale the width
		$neww = $dim;
		$newh = $hprop;
	}
	if (!$us && $newh >= $h && $neww >= $w) {
		return array($w, $h);
	} else {
		if ($cw && $cw < $neww) $neww = $cw;
		if ($ch && $ch < $newh) $newh = $ch;
		if ($size && $ch && $cw) { $neww = $cw; $newh = $ch; }
		return array($neww, $newh);
	}
}

/**
 * Returns an array [width, height] of the default-sized image.
 *
 * @return array
 */
function getSizeDefaultImage() {
	return getSizeCustomImage(getOption('image_size'));
}

/**
 * Returns an array [width, height] of the original image.
 *
 * @return array
 */
function getSizeFullImage() {
	global $_zp_current_image;
	if (is_null($_zp_current_image)) return false;
	return array($_zp_current_image->getWidth(), $_zp_current_image->getHeight());
}

/**
 * The width of the default-sized image (in printDefaultSizedImage)
 *
 * @return int
 */
function getDefaultWidth() {
	$size = getSizeDefaultImage(); return $size[0];
}

/**
 * Returns the height of the default-sized image (in printDefaultSizedImage)
 *
 * @return int
 */
function getDefaultHeight() {
	$size = getSizeDefaultImage(); return $size[1];
}

/**
 * Returns the width of the original image
 *
 * @return int
 */
function getFullWidth() {
	global $_zp_current_image;
	if (is_null($_zp_current_image)) return false;
	return $_zp_current_image->getWidth();
}

/**
 * Returns the height of the original image
 *
 * @return int
 */
function getFullHeight() {
	global $_zp_current_image;
	if (is_null($_zp_current_image)) return false;
	return $_zp_current_image->getHeight();
}

/**
 * Returns true if the image is landscape-oriented (width is greater than height)
 *
 * @return bool
 */
function isLandscape() {
	if (getFullWidth() >= getFullHeight()) return true;
	return false;
}

/**
 * Returns the url to the default sized image.
 *
 * @return string
 */
function getDefaultSizedImage() {
	global $_zp_current_image;
	if (is_null($_zp_current_image)) return false;
	return $_zp_current_image->getSizedImage(getOption('image_size'));
}

/**
 * Show video player with video loaded or display the image.
 *
 * @param string $alt Alt text
 * @param string $class Optional style class
 * @param string $id Optional style id
 */
function printDefaultSizedImage($alt, $class=NULL, $id=NULL) {
	global $_zp_current_image;
	if (is_null($_zp_current_image)) return;
	if (!$_zp_current_image->getShow()) {
		$class .= " not_visible";
	}
	$album = $_zp_current_image->getAlbum();
	$pwd = $album->getPassword();
	if (zp_loggedin() && !empty($pwd)) {
		$class .= " password_protected";
	}
	if (isImagePhoto()) { //Print images
		echo '<img src="' . htmlspecialchars(getDefaultSizedImage()) . '" alt="' . html_encode($alt) . '"' .
			' title="' . html_encode($alt) . '"'.
			' width="' . getDefaultWidth() . '" height="' . getDefaultHeight() . '"' .
			(($class) ? " class=\"$class\"" : "") .
			(($id) ? " id=\"$id\"" : "") . " />";
	} else { // better be a plugin class then
		echo $_zp_current_image->getBody();
	}
}

/**
 * Returns the url to the thumbnail of the current image.
 *
 * @return string
 */
function getImageThumb() {
	global $_zp_current_image;
	if (is_null($_zp_current_image)) return false;
	return $_zp_current_image->getThumb();
}
/**
 * @param string $alt Alt text
 * @param string $class optional class tag
 * @param string $id optional id tag
 */
function printImageThumb($alt, $class=NULL, $id=NULL) {
	global $_zp_current_image;
	if (is_null($_zp_current_image)) return;
	if (!$_zp_current_image->getShow()) {
		$class .= " not_visible";
	}
	$album = $_zp_current_image->getAlbum();
	$pwd = $album->getPassword();
	if (zp_loggedin() && !empty($pwd)) {
		$class .= " password_protected";
	}
	if (getOption('thumb_crop') && !is_null($cy = $_zp_current_image->get('thumbY'))) {
		$ts = getOption('thumb_size');
		$sw = getOption('thumb_crop_width');
		$sh = getOption('thumb_crop_height');
		$cx = $_zp_current_image->get('thumbX');
		$cw = $_zp_current_image->get('thumbW');
		$ch = $_zp_current_image->get('thumbH');
		// upscale to thumb_size proportions
		if ($sw == $sh) { // square crop, set the size/width to thumbsize
			$sw = $sh = $ts;
		} else {
			if ($sw > $sh) {
				$r = $ts/$sw;
				$sw = $ts;
				$sh = $sh * $r;
			} else {
				$r = $ts/$sh;
				$sh = $ts;
				$sh = $r * $sh;
			}
		}
		$url = getCustomImageURL(NULL, $sw, $sh, $cw, $ch, $cx, $cy, true);
	} else {
		$url = getImageThumb();
	}

	$h = getOption('thumb_crop_height');
	if (!empty($h)) {
		$h = " height=\"$h\"";
	}
	$w = getOption('thumb_crop_width');
	if (!empty($w)) {
		$w = " width=\"$w\"";
	}
	$class = trim($class);
	echo "<img src=\"" . htmlspecialchars($url) . "\" alt=\"" . html_encode($alt) . "\"" .
	((getOption('thumb_crop')) ? $w.$h : "") .
	(($class) ? " class=\"$class\"" : "") .
	(($id) ? " id=\"$id\"" : "") . " />";
}

/**
 * Returns the url to original image.
 * It will return a protected image is the option "protect_full_image" is set
 *
 * @return string
 */
function getFullImageURL() {
	global $_zp_current_image;
	if (is_null($_zp_current_image)) return false;
	$outcome = getOption('protect_full_image');
	if ($outcome == 'No access') return null;
	$url = getUnprotectedImageURL();
	if (is_valid_video($url)) {  // Download, Protected View, and Unprotected access all allowed
		$album = $_zp_current_image->getAlbum();
		$folder = $album->getFolder();
		$original = checkVideoOriginal(getAlbumFolder() . $folder, $_zp_current_image->getFileName());
		if ($original) {
			return getAlbumFolder(WEBPATH) .  $folder . "/" .$original;
		} else {
			return $url;
		}
	} else { // normal image
		if ($outcome == 'Unprotected') {
			return $url;
		} else {
			return getProtectedImageURL();
		}
	}
}

/**
 * Returns the "raw" url to the image in the albums folder
 *
 * @return string
 *
 */
function getUnprotectedImageURL() {
	global $_zp_current_image;
	if (is_null($_zp_current_image)) return false;
	return $_zp_current_image->getFullImage();
}
/**
 * Returns an url to the password protected/watermarked current image
 *
 * @return string
 **/
function getProtectedImageURL() {
	if(!in_context(ZP_IMAGE)) return false;
	global $_zp_current_image, $_zp_current_album;
	if (is_null($_zp_current_image)) return false;
	$suffix = strtolower(substr(strrchr($_zp_current_image->filename, "."), 1));
	$cache_file = $_zp_current_album->name . "/" . substr($_zp_current_image->filename, 0, -strlen($suffix)-1) . '_FULL.' . $suffix;
	$cache_path = SERVERCACHE . '/' . $cache_file;
	if (file_exists(UTF8ToFilesystem($cache_path))) {
		return WEBPATH . CACHEFOLDER . pathurlencode($cache_file);
	} else {
		$path = $_zp_current_image->getImageLink();
		if (getOption('mod_rewrite')) {
			$path .= "?p=*full-image";
		} else {
			$path .= "&p=*full-image";
		}
		return $path;
	}
}

/**
 * Returns a link to the current image custom sized to $size
 *
 * @param int $size The size the image is to be
 */
function getSizedImageURL($size) {
	getCustomImageURL($size);
}

/**
 * Returns the url to the  image in that dimensions you define with this function.
 *
 * @param int $size the size of the image to have
 * @param int $width width
 * @param int $height height
 * @param int $cropw cropwidth
 * @param int $croph crop height
 * @param int $cropx crop part x axis
 * @param int $cropy crop part y axis
 * @param bool $thumbStandin set true to inhibit watermarking
 * @return string
 */
function getCustomImageURL($size, $width=NULL, $height=NULL, $cropw=NULL, $croph=NULL, $cropx=NULL, $cropy=NULL, $thumbStandin=false) {
	global $_zp_current_image;
	if (is_null($_zp_current_image)) return false;
	return $_zp_current_image->getCustomImage($size, $width, $height, $cropw, $croph, $cropx, $cropy, $thumbStandin);
}

/**
 * Print normal video or custom sized images.
 * Note: a class of 'not_visible' or 'password_protected' will be added as appropriate
 *
 * @param string $alt Alt text for the url
 * @param int $size size
 * @param int $width width
 * @param int $height height
 * @param int $cropw crop width
 * @param int $croph crop height
 * @param int $cropx crop x axis
 * @param int $cropy crop y axis
 * @param string $class Optional style class
 * @param string $id Optional style id
 * @param bool $thumbStandin set true to inhibit watermarking

 * */
function printCustomSizedImage($alt, $size, $width=NULL, $height=NULL, $cropw=NULL, $croph=NULL, $cropx=NULL, $cropy=NULL, $class=NULL, $id=NULL, $thumbStandin=false) {
	global $_zp_current_image;
	if (is_null($_zp_current_image)) return;
	if (!$_zp_current_image->getShow()) {
		$class .= " not_visible";
	}
	$album = $_zp_current_image->getAlbum();
	$pwd = $album->getPassword();
	if (zp_loggedin() && !empty($pwd)) {
		$class .= " password_protected";
	}
	if (isImagePhoto() || $thumbStandin) {
		echo '<img src="' . htmlspecialchars(getCustomImageURL($size, $width, $height, $cropw, $croph, $cropx, $cropy, $thumbStandin)) . '"' .
			' alt="' . html_encode($alt) . '"' .
			' title="' . html_encode($alt) . '"' .
			(($class) ? ' class="'.$class.'"' : '') .
			(($id) ? ' id="'.$id.'"' : '') . ' />';
	} else { // better be a plugin
		echo $_zp_current_image->getBody();
	}
}

/**
 * Returns a link to a uncropped custom sized version of the current image within the given height and width dimensions.
 * Use for sized images.
 *
 * @param int $width width
 * @param int $height height
 * @return string
 */
function getCustomSizedImageMaxSpace($width, $height) {
	global $_zp_current_image;
	if (is_null($_zp_current_image)) return false;
	getMaxSpaceContainer($width, $height, $_zp_current_image);
	return getCustomImageURL(NULL, $width, $height);
}

/**
 * Returns a link to a uncropped custom sized version of the current image within the given height and width dimensions.
 * Use for sized thumbnails.
 *
 * @param int $width width
 * @param int $height height
 * @return string
 */
function getCustomSizedImageThumbMaxSpace($width, $height) {
	global $_zp_current_image;
	if (is_null($_zp_current_image)) return false;
	getMaxSpaceContainer($width, $height, $_zp_current_image, true);
	return getCustomImageURL(NULL, $width, $height, NULL, NULL, NULL, NULL, true);
}

/**
 * Creates image thumbnails which will fit uncropped within the width & height parameters given
 *
 * @param string $alt Alt text for the url
 * @param int $width width
 * @param int $height height
 * @param string $class Optional style class
 * @param string $id Optional style id
  */
function printCustomSizedImageThumbMaxSpace($alt='',$width,$height,$class=NULL,$id=NULL) {
	global $_zp_current_image;
	if (is_null($_zp_current_image)) return;
	getMaxSpaceContainer($width, $height, $_zp_current_image, true);
	printCustomSizedImage($alt, NULL, $width, $height, NULL, NULL, NULL, NULL, $class, $id, true);
}

/**
 * Print normal video or uncropped within the given height and width dimensions. Use for sized images or thumbnails in an album.
 * Note: a class of 'not_visible' or 'password_protected' will be added as appropriate
 * 
 * @param string $alt Alt text for the url
 * @param int $width width
 * @param int $height height
 * @param string $class Optional style class
 * @param string $id Optional style id
 */
function printCustomSizedImageMaxSpace($alt='',$width,$height,$class=NULL,$id=NULL, $thumb=false) {
	global $_zp_current_image;
	if (is_null($_zp_current_image)) return;
	getMaxSpaceContainer($width, $height, $_zp_current_image, $thumb);
	printCustomSizedImage($alt, NULL, $width, $height, NULL, NULL, NULL, NULL, $class, $id, $thumb);
}


/**
 * This function is considered deprecated. 
 * Please use the new replacement get/printCustomSizedImageMaxSpace(). 
 * 
 * Prints out a sized image up to $maxheight tall (as width the value set in the admin option is taken)
 *
 * @param int $maxheight how bif the picture should be
 */
function printCustomSizedImageMaxHeight($maxheight) {
	trigger_error(gettext('printCustomSizedImageMaxHeight is deprecated. Use printCustomSizedImageMaxSpace().'), E_USER_NOTICE);
	if (getFullWidth() === getFullHeight() OR getDefaultHeight() > $maxheight) {
		printCustomSizedImage(getImageTitle(), null, null, $maxheight, null, null, null, null, null, null);
	} else {
		printDefaultSizedImage(getImageTitle());
	}
}

/**
 * Prints link to an image of specific size
 * @param int $size how big
 * @param string $text URL text
 * @param string $title URL title
 * @param string $class optional URL class
 * @param string $id optional URL id
 */
function printSizedImageLink($size, $text, $title, $class=NULL, $id=NULL) {
	printLink(getSizedImageURL($size), $text, $title, $class, $id);
}

/**

* Retuns the count of comments on the current image
*
* @return int
*/
function getCommentCount() {
	global $_zp_current_image, $_zp_current_album, $_zp_current_zenpage_page, $_zp_current_zenpage_news;
	if (in_context(ZP_IMAGE) & in_context(ZP_ALBUM)) {
		if (is_null($_zp_current_image)) return false;
		return $_zp_current_image->getCommentCount();
	} else if (!in_context(ZP_IMAGE) & in_context(ZP_ALBUM)) {
		if (is_null($_zp_current_album)) return false;
		return $_zp_current_album->getCommentCount();
	}
	if(function_exists('is_News')) {
		if(is_News()) {
			return $_zp_current_zenpage_news->getCommentCount();
		}
		if(is_Pages()) {
			return $_zp_current_zenpage_page->getCommentCount();
		}
	}
}

/**
 * Returns true if neither the album nor the image have comments closed
 *
 * @return bool
 */
function getCommentsAllowed() {
	global $_zp_current_image, $_zp_current_album;
	if (in_context(ZP_IMAGE)) {
		if (is_null($_zp_current_image)) return false;
		return $_zp_current_image->getCommentsAllowed();
	} else {
		return $_zp_current_album->getCommentsAllowed();
	}
}

/**
 * Iterate through comments; use the ZP_COMMENT context.
 * Return true if there are more comments
 * @param  bool $desc set true for desecnding order
 *
 * @return bool
 */
function next_comment($desc=false) {
	global $_zp_current_image, $_zp_current_album, $_zp_current_comment, $_zp_comments, $_zp_current_zenpage_page, $_zp_current_zenpage_news;
	//ZENPAGE: comments support
	if (is_null($_zp_current_comment)) {
		if (in_context(ZP_IMAGE) AND in_context(ZP_ALBUM)) {
			if (is_null($_zp_current_image)) return false;
			$_zp_comments = $_zp_current_image->getComments(false, false, $desc);
		} else if (!in_context(ZP_IMAGE) AND in_context(ZP_ALBUM)) {
			$_zp_comments = $_zp_current_album->getComments(false, false, $desc);
		}
		if(function_exists('is_NewsArticle')) {
			if (is_NewsArticle()) {
				$_zp_comments = $_zp_current_zenpage_news->getComments(false, false, $desc);
			}
			if(is_Pages()) {
				$_zp_comments = $_zp_current_zenpage_page->getComments(false, false, $desc);
			}
		}
		if (empty($_zp_comments)) { return false; }
		$_zp_current_comment = array_shift($_zp_comments);
		add_context(ZP_COMMENT);
		return true;
	} else if (empty($_zp_comments)) {
		$_zp_comments = NULL;
		$_zp_current_comment = NULL;
		rem_context(ZP_COMMENT);
		return false;
	} else {
		$_zp_current_comment = array_shift($_zp_comments);
		if ($_zp_current_comment['anon']) {
			$_zp_current_comment['name'] = '<'.gettext("Anonymous").'>';
		}
		return true;
	}
}

/**
 * Returns the data from the last comment posted
 * @param bool $numeric Set to true for old themes to get 0->6 indices rather than descriptive ones
 *
 * @return array
 */
function getCommentStored($numeric=false) {
	global $_zp_comment_stored;
	$stored = array('name'=>$_zp_comment_stored[0],'email'=>$_zp_comment_stored[1],
							 'website'=>$_zp_comment_stored[2],'comment'=>$_zp_comment_stored[3],
							 'saved'=>$_zp_comment_stored[4],'private'=>$_zp_comment_stored[5],
							 'anon'=>$_zp_comment_stored[6]);
	if ($numeric) {
		return Array_merge($stored);
	}
	return $stored;
}

/*** Comment Context **********************/
/******************************************/

/**
 * Returns the comment author's name
 *
 * @return string
 */
function getCommentAuthorName() { global $_zp_current_comment; return $_zp_current_comment['name']; }

/**
 * Returns the comment author's email
 *
 * @return string
 */
function getCommentAuthorEmail() { global $_zp_current_comment; return $_zp_current_comment['email']; }
/**
 * Returns the comment author's website
 *
 * @return string
 */
function getCommentAuthorSite() { global $_zp_current_comment; return $_zp_current_comment['website']; }
/**
 * Prints a link to the author

 *
 * @param string $title URL title tag
 * @param string $class optional class tag
 * @param string $id optional id tag
 */
function printCommentAuthorLink($title=NULL, $class=NULL, $id=NULL) {
	global $_zp_current_comment;
	$site = $_zp_current_comment['website'];
	$name = $_zp_current_comment['name'];
	if ($_zp_current_comment['anon']) {
		$name = substr($name, 1, strlen($name)-2); // strip off the < and >
	}
	$namecoded = htmlspecialchars($_zp_current_comment['name'],ENT_QUOTES);
	if (empty($site)) {
		echo $namecoded;
	} else {
		if (is_null($title)) {
			$title = "Visit ".$name;
		}
		printLink($site, $namecoded, $title, $class, $id);
	}
}

/**
 * Returns a formatted date and time for the comment.
 * Uses the "date_format" option for the formatting unless
 * a format string is passed.
 *
 * @param string $format 'strftime' date/time format
 * @return string
 */
function getCommentDateTime($format = NULL) {
	if (is_null($format)) {
		$format = getOption('date_format');
	}
	global $_zp_current_comment;
	return myts_date($format, $_zp_current_comment['date']);
}

/**
 * Retrieves the date of the current comment.
 * 
 * Deprecated--use getCommentDateTime()
 * 
 * Returns a formatted date
 *
 * @param string $format how to format the result
 * @return string
 */
function getCommentDate($format = NULL) {
	trigger_error(gettext('getCommentDate is deprecated. Use getCommentDateTime().'), E_USER_NOTICE);
	if (is_null($format)) {
		$format = getOption('date_format');
		$time_tags = array('%H', '%I', '%R', '%T', '%r');
		foreach ($time_tags as $tag) { // strip off any time formatting
			$t = strpos($format, $tag);
			if ($t !== false) {
				$format = trim(substr($format, 0, $t));
			}
		}
	}
	global $_zp_current_comment;
	return myts_date($format, $_zp_current_comment['date']);
}
/**
 * Retrieves the time of the current comment.
 * 
 * Deprecated--use getCommentDateTime()
 * 
 * Returns a formatted time

 * @param string $format how to format the result
 * @return string
 */
function getCommentTime($format = '%I:%M %p') {
	trigger_error(gettext('getCommentTime is deprecated. Use getCommentDateTime().'), E_USER_NOTICE);
	global $_zp_current_comment;
	return myts_date($format, $_zp_current_comment['date']);
}

/**
 * Returns the body of the current comment
 *
 * @return string
 */
function getCommentBody() {
	global $_zp_current_comment;
	return str_replace("\n", "<br />", stripslashes($_zp_current_comment['comment']));
}

/**
 * Creates a link to the admin comment edit page for the current comment
 *
 * @param string $text Link text
 * @param string $before text to go before the link
 * @param string $after text to go after the link
 * @param string $title title text
 * @param string $class optional css clasee
 * @param string $id optional css id
 */
function printEditCommentLink($text, $before='', $after='', $title=NULL, $class=NULL, $id=NULL) {
	global $_zp_current_comment;
	if (zp_loggedin()) {
		echo $before;
		printLink(WEBPATH . '/' . ZENFOLDER . '/admin-comments.php?page=editcomment&id=' . $_zp_current_comment['id'], $text, $title, $class, $id);
		echo $after;
	}
}
/**
 * returns an error message if a comment possting was not accepted
 *
 */
function getCommentErrors() {
	global $_zp_comment_error;
	if (isset($_zp_comment_error)) {
		switch ($_zp_comment_error) {
			case  0: return false;
			case -1: return gettext("You must supply an e-mail address.");
			case -2: return gettext("You must enter your name."); break;
			case -3: return gettext("You must supply an WEB page URL.");
			case -4: return gettext("Captcha verification failed.");
			case -5: return gettext("You must enter something in the comment text.");
			case  1: return gettext("Your comment failed the SPAM filter check.");
			case  2: return gettext("Your comment has been marked for moderation.");
			default: return sprintf(gettext('Comment error "%d" not defined.'), $_zp_comment_error);
		}
	}
	return false; 
}

/**
 * Tool to put an out error message if a comment possting was not accepted
 *
 * @param string $class optional division class for the message
 */
function printCommentErrors($class = 'error') {
	$s = getCommentErrors();
	if ($s) {	
		echo '<div class="'.$class.'">'.$s.'</div>';
	}
}
/**
 * Creates an URL for to download of a zipped copy of the current album
 */
function printAlbumZip(){
	global $_zp_current_album;
	echo'<a href="' . WEBPATH . '/' . ZENFOLDER . "/album-zip.php?album=" . urlencode($_zp_current_album->name) .
		'" title="'.gettext('Download Zip of the Album').'">'.gettext('Download a zip file of this album').'</a>';
}

/**
 * Gets latest comments for images and albums
 *
 * @param int $number how many comments you want.
 * @param string $type	"all" for all latest comments of all images and albums
 * 											"image" for the lastest comments of one specific image
 * 											"album" for the latest comments of one specific album
 * @param int $itemID the ID of the element to get the comments for if $type != "all"
 */
function getLatestComments($number,$type="all",$itemID="") {
	$itemID = sanitize_numeric($itemID);
	if (zp_loggedin()) {
		$passwordcheck1 = "";
		$passwordcheck2 = "";
	} else {

		$albumscheck = query_full_array("SELECT * FROM " . prefix('albums'). " ORDER BY title");
		foreach ($albumscheck as $albumcheck) {
			if(!checkAlbumPassword($albumcheck['folder'], $hint)) {
				$albumpasswordcheck1= " AND i.albumid != ".$albumcheck['id'];
				$albumpasswordcheck2= " AND a.id != ".$albumcheck['id'];
				$passwordcheck1 = $passwordcheck1.$albumpasswordcheck1;
				$passwordcheck2 = $passwordcheck2.$albumpasswordcheck2;
			}
		}
	}
	switch ($type) {
		case "image":
			$whereImages = " WHERE i.show = 1 AND i.id = ".$itemID." AND c.ownerid = ".$itemID." AND i.albumid = a.id AND c.private = 0 AND c.inmoderation = 0 AND (c.type IN (".zp_image_types("'") ."))".$passwordcheck1;
			break;
		case "album":
			$whereAlbums = " WHERE a.show = 1 AND a.id = ".$itemID." AND c.ownerid = ".$itemID." AND c.private = 0 AND c.inmoderation = 0 AND c.type = 'albums'".$passwordcheck2;
			break;
		case "all":
			$whereImages = " WHERE i.show = 1 AND c.ownerid = i.id AND i.albumid = a.id AND c.private = 0 AND (c.type IN (".zp_image_types("'") ."))".$passwordcheck1;
			$whereAlbums = " WHERE a.show = 1 AND c.ownerid = a.id AND c.private = 0 AND c.type = 'albums'".$passwordcheck2;
			break;
	}
	$comments_images = array();
	$comments_albums = array();
	if ($type === "all" OR $type === "image") {
		$comments_images = query_full_array("SELECT c.id, i.title, i.filename, a.folder, a.title AS albumtitle, c.name, c.type, c.website,"
		. " c.date, c.anon, c.comment FROM ".prefix('comments')." AS c, ".prefix('images')." AS i, ".prefix('albums')." AS a "
		. $whereImages
		. " ORDER BY c.id DESC LIMIT $number");
	} 
	if ($type === "all" OR $type === "album") {
		$comments_albums = query_full_array("SELECT c.id, a.folder, a.title AS albumtitle, c.name, c.type, c.website,"
		. " c.date, c.anon, c.comment FROM ".prefix('comments')." AS c, ".prefix('albums')." AS a "
		. $whereAlbums
		. " ORDER BY c.id DESC LIMIT $number");
	}
	$comments = array();
	foreach ($comments_albums as $comment) {
		$comments[$comment['id']] = $comment;
	}
	foreach ($comments_images as $comment) {
		$comments[$comment['id']] = $comment;
	}
	krsort($comments);
	return array_slice($comments, 0, $number);
}


/**
 * Prints out latest comments for images and albums
 *
 * @param int $number how many comments you want.
 * @param string $shorten the number of characters to shorten the comment display
 * @param string $type	"all" for all latest comments of all images and albums
 * 											"image" for the lastest comments of one specific image
 * 											"album" for the latest comments of one specific album
 * @param int $itemID the ID of the element to get the comments for if $type != "all"
 */
function printLatestComments($number, $shorten='123',$type="all",$itemID="") {
	if(getOption('mod_rewrite')) {
		$albumpath = "/"; $imagepath = "/"; $modrewritesuffix = getOption('mod_rewrite_image_suffix');
	} else {
		$albumpath = "/index.php?album="; $imagepath = "&amp;image="; $modrewritesuffix = "";
	}
	$comments = getLatestComments($number,$type,$itemID);
	echo "<ul id=\"showlatestcomments\">\n";
	foreach ($comments as $comment) {
		if($comment['anon'] === "0") {
			$author = " ".gettext("by")." ".$comment['name'];
		} else {
			$author = "";
		}
		$album = $comment['folder'];
		if($comment['type'] != "albums" AND $comment['type'] != "news" AND $comment['type'] != "pages") { // check if not comments on albums or Zenpage items
			$imagetag = $imagepath.$comment['filename'].$modrewritesuffix;
		} else {
			$imagetag = "";
		}
		$date = $comment['date'];
		$albumtitle = $comment['albumtitle'];
		if ($comment['title'] == "") $title = $image; else $title = get_language_string($comment['title']);
		$website = $comment['website'];
		$shortcomment = truncate_string($comment['comment'], $shorten);
		if(!empty($title)) {
			$title = ": ".$title;
		}
		echo "<li><a href=\"".WEBPATH.$albumpath.$album.$imagetag."\" class=\"commentmeta\">".$albumtitle.$title.$author."</a><br />\n";
		echo "<span class=\"commentbody\">".$shortcomment."</span></li>";
	}
	echo "</ul>\n";
}

/**
 * Returns the hitcounter for the page viewed (image.php and album.php only).
 * Deprecated, use getHitcounter()
 *
 * @param string $option "image" for image hit counter (default), "album" for album hit counter
 * @param bool $viewonly set to true if you don't want to increment the counter.
 * @param int $id Optional record id of the object if not the current image or album
 * @return string
 * @since 1.1.3
 */
function hitcounter($option='image', $viewonly=false, $id=NULL) {
	trigger_error(gettext('hitcounter is deprecated. Use getHitcounter().'), E_USER_NOTICE);
	switch($option) {
		case "image":
			if (is_null($id)) {
				$id = getImageID();
			}
			$dbtable = prefix('images');
			break;
		case "album":
			if (is_null($id)) {
				$id = getAlbumID();
			}
			$dbtable = prefix('albums');
			break;
	}
	$sql = "SELECT `hitcounter` FROM $dbtable WHERE `id` = $id";
	$result = query_single_row($sql);
	$resultupdate = $result['hitcounter'];
	return $resultupdate;
}

/**
 * returns the hitcounter for the current page or for the object passed
 *
 * @param object $obj the album or page object for which the hitcount is desired
 * @return string
 */
function getHitcounter($obj=NULL) {
	global $_zp_current_album, $_zp_current_image, $_zp_gallery_page;
	if (is_null($obj)) {
		switch ($_zp_gallery_page) {
			case 'album.php':
				$obj = $_zp_current_album;
				break;
			case 'image.php':
				$obj = $_zp_current_image;
				break;
			default: return NULL; // not a valid object for hitcounter
				break;
		}
	}
	return $obj->get('hitcounter');
}

/**
 * Returns a where clause for filter password protected album.
 * Used by the random images functions.
 *
 * If the viewer is not logged in as ADMIN this function fails all password protected albums.
 * It does not check to see if the viewer has credentials for an album.
 *
 * @return string
 */

function getProtectedAlbumsWhere() {
	$result = query_single_row("SELECT MAX(LENGTH(folder) - LENGTH(REPLACE(folder, '/', ''))) AS max_depth FROM " . prefix('albums') );
	$max_depth = $result['max_depth'];

	$sql = "SELECT level0.id FROM " . prefix('albums') . " AS level0 ";
        $where = " WHERE (level0.password > ''";
	$i = 1;
	while ($i <= $max_depth) {
		$sql = $sql . " LEFT JOIN " . prefix('albums') . "AS level" . $i . " ON level" . $i . ".id = level" . ($i - 1) . ".parentid";
		$where = $where . " OR level" . $i . ".password > ''";
		$i++;
	}
	$sql = $sql . $where . " )";

	$result = query_full_array($sql);
	if ($result) {
		$albumWhere = prefix('albums') . ".id not in (";
		foreach ($result as $row) {
			$albumWhere = $albumWhere . $row['id'] . ", ";
		}
		$albumWhere = substr($albumWhere, 0, -2) . ')';
	} else {
		$albumWhere = '';
	}
	
	if (!empty($albumWhere)) $albumWhere = ' AND '.$albumWhere;
	return $albumWhere;
}

/**
 * Returns a randomly selected image from the gallery. (May be NULL if none exists)
 * @param bool $daily set to true and the picture changes only once a day.
 *
 * @return object
 */
function getRandomImages($daily = false) {
	global $_zp_gallery;
	if ($daily) {
		$potd = unserialize(getOption('picture_of_the_day'));
		if (date('Y-m-d', $potd['day']) == date('Y-m-d')) {
			$album = new Album($_zp_gallery, $potd['folder']);
			$image = newImage($album, $potd['filename']);
			if ($image->exists)	return $image;
		}
	}
	if (zp_loggedin()) {
		$albumWhere = '';
		$imageWhere = '';
	} else {
		$albumWhere = " AND " . prefix('albums') . ".show = 1" . getProtectedAlbumsWhere() ;
		$imageWhere = " AND " . prefix('images') . ".show=1";
	}
	$c = 0;
	while ($c < 10) {
		$result = query_single_row('SELECT COUNT(*) AS row_count ' .
                                ' FROM '.prefix('images'). ', '.prefix('albums').
                                ' WHERE ' . prefix('albums') . '.folder!="" AND '.prefix('images').'.albumid = ' .
																prefix('albums') . '.id ' .    $albumWhere . $imageWhere );
		$rand_row = rand(1, $result['row_count']);

		$result = query_single_row('SELECT '.prefix('images').'.filename, '.prefix('albums').'.folder ' .
                                ' FROM '.prefix('images').', '.prefix('albums') .
                                ' WHERE '.prefix('images').'.albumid = '.prefix('albums').'.id  ' . $albumWhere .
																$imageWhere . ' LIMIT ' . $rand_row . ', 1');

		$imageName = $result['filename'];
		if (is_valid_image($imageName)) {
			$album = new Album($_zp_gallery, $result['folder']);
			$image = newImage($album, $imageName );
			if ($daily) {
				$potd = array('day' => time(), 'folder' => $result['folder'], 'filename' => $imageName);
				setOption('picture_of_the_day', serialize($potd));
			}
			return $image;
		}
		$c++;
	}
	return NULL;
}

/**
 * Returns  a randomly selected image from the album or its subalbums. (May be NULL if none exists)
 *
 * @param string $rootAlbum optional album folder from which to get the image.
 *
 * @return object
 */
function getRandomImagesAlbum($rootAlbum=null) {
	global $_zp_current_album, $_zp_gallery, $_zp_current_search;
	if (empty($rootAlbum)) {
		$album = $_zp_current_album;
	} else {
		$album = new Album($_zp_gallery, $rootAlbum);
	}
	if ($album->isDynamic()) {
		$search = $album->getSearchEngine();
		$images = $search->getImages(0);
		$image = NULL;
		shuffle($images);
		while (count($images) > 0) {
			$randomImage = array_pop($images);
			if (is_valid_image($randomImage['filename'])) {
				$image = newImage(new Album(new Gallery(), $randomImage['folder']), $randomImage['filename']);
				return $image;
			}
		}
	} else {
		if (zp_loggedin()) {
			$imageWhere = '';
			$albumNotWhere = '';
		} else {
			$imageWhere = " AND " . prefix('images'). ".show=1";
			$albumNotWhere = getProtectedAlbumsWhere();
		}
		$albumInWhere = '';

		$albumfolder = $album->getFolder();
		$query = "SELECT id FROM " . prefix('albums') . " WHERE " . prefix('albums') . ".show = 1 AND folder LIKE '" . mysql_real_escape_string($albumfolder) . "%'";
		$result = query_full_array($query);
		$albumInWhere = prefix('albums') . ".id in (";
		foreach ($result as $row) {
			$albumInWhere = $albumInWhere . $row['id'] . ", ";
		}

		$albumInWhere =  ' AND '.substr($albumInWhere, 0, -2) . ')';

		$c = 0;
		while ($c < 10) {
			$result = query_single_row('SELECT COUNT(*) AS row_count ' .
				' FROM '.prefix('images'). ', '.prefix('albums').
				' WHERE ' . prefix('albums') . '.folder!="" AND '.prefix('images').'.albumid = ' .
				prefix('albums') . '.id ' . $albumInWhere . $albumNotWhere . $imageWhere );
			$rand_row = rand(1, $result['row_count']);

			$result = query_single_row('SELECT '.prefix('images').'.filename, '.prefix('albums').'.folder ' .
				' FROM '.prefix('images').', '.prefix('albums') .
				' WHERE '.prefix('images').'.albumid = '.prefix('albums').'.id  ' . $albumInWhere .  $albumNotWhere .
				$imageWhere . ' LIMIT ' . $rand_row . ', 1');

			$imageName = $result['filename'];
			if (is_valid_image($imageName)) {
				$image = newImage(new Album(new Gallery(), $result['folder']), $imageName );
				return $image;
			}
			$c++;
		}

	}
	return null;
}

/**
 * Puts up random image thumbs from the gallery
 *
 * @param int $number how many images
 * @param string $class optional class
 * @param string $option what you want selected: all for all images, album for selected ones from an album
 * @param string $rootAlbum optional album from which to get the images
 * @param integer $width the width/cropwidth of the thumb if crop=true else $width is longest size.
 * @param integer $height the height/cropheight of the thumb if crop=true else not used
 * @param bool $crop 'true' (default) if the thumb should be cropped, 'false' if not
 */
function printRandomImages($number=5, $class=null, $option='all', $rootAlbum='',$width=100,$height=100,$crop=true) {
	if (!is_null($class)) {
		$class = ' class="' . $class . '"';
	}
	echo "<ul".$class.">";
	for ($i=1; $i<=$number; $i++) {
		echo "<li>\n";
		switch($option) {
			case "all":
				$randomImage = getRandomImages(); break;
			case "album":
				$randomImage = getRandomImagesAlbum($rootAlbum); break;
		}
		$randomImageURL = htmlspecialchars(getURL($randomImage));
		echo '<a href="' . $randomImageURL . '" title="'.sprintf(gettext('View image: %s'), html_encode($randomImage->getTitle())) . '">';
		if($crop) {
			echo "<img src=\"".htmlspecialchars($randomImage->getCustomImage(NULL, $width, $height, $width, $height, NULL, NULL, TRUE))."\" alt=\"" . html_encode($randomImage->getTitle()) . "\" />\n";
		} else {
			echo "<img src=\"".htmlspecialchars($randomImage->getCustomImage($width, NULL, NULL, NULL, NULL, NULL, NULL, TRUE))."\" alt=\"" . html_encode($randomImage->getTitle()) . "\" />\n";
		}
		echo "</a></li>\n";
	}
	echo "</ul>";
}

/**
 * Shortens a string to $length
 * 
 * Deprecated: use truncate_string
 *
 * @param string $string the string to be shortened
 * @param int $length the desired length for the string
 * @return string
 */
function my_truncate_string($string, $length) {
	trigger_error(gettext('my_truncate_string is deprecated. Use truncate_string().'), E_USER_NOTICE);
	if (strlen($string) > $length) {
		$short = substr($string, 0, $length);
		return $short. '...';
	} else {
		return $string;
	}
}

/**
 * Returns a list of tags for either an image or album, depends on the page called from
 *
 * @return string
 * @since 1.1
 */
function getTags() {
	if(in_context(ZP_IMAGE)) {
		global $_zp_current_image;
		return $_zp_current_image->getTags();
	} else if (in_context(ZP_ALBUM)) {
		global $_zp_current_album;
		return $_zp_current_album->getTags();
	}
}

/**
 * Prints a list of tags, editable by admin
 *
 * @param string $option links by default, if anything else the
 *               tags will not link to all other photos with the same tag
 * @param string $preText text to go before the printed tags
 * @param string $class css class to apply to the div surrounding the UL list
 * @param string $separator what charactor shall separate the tags
 * @param bool   $editable true to allow admin to edit the tags
 * @param string $editclass CSS class applied to editable element if editable
 * @param mixed $messageIfEmpty Either bool or string. If false, echoes nothing when description is empty. If true, echoes default placeholder message if empty. If string, echoes string.
 * @since 1.1
 */
function printTags($option='links', $preText=NULL, $class='taglist', $separator=', ', $editable=TRUE, $editclass='', $messageIfEmpty = true ) {
	$singletag = getTags();
	$tagstring = implode(', ', $singletag);
 	if ($tagstring === '' or $tagstring === NULL ) {
		$preText = '';
		if ( $messageIfEmpty === true && $editable && zp_loggedin() ) {
			$tagstring = gettext('(No tags...)');
		} elseif ( is_string($messageIfEmpty) ) {
			$tagstring = $messageIfEmpty;
		}
	}
	
	$object =  in_context(ZP_IMAGE) ? 'image' : 'album' ;
	if ($editable && zp_loggedin()) {
		printEditable($object, '_update_tags', true, $editclass, $tagstring);
	} else {
		if (count($singletag) > 0) {
			if (!empty($preText)) {
				echo "<span class=\"tags_title\">".$preText."</span>";
			}
			echo "<ul class=\"".$class."\">\n";
			$ct = count($singletag);
			for ($x = 0; $x < $ct; $x++) {
				if ($x === $ct - 1) { $separator = ""; }
				if ($option === "links") {
					$links1 = "<a href=\"".htmlspecialchars(getSearchURL($singletag[$x], '', SEARCH_TAGS, 0, 0))."\" title=\"".html_encode($singletag[$x])."\" rel=\"nofollow\">";
					$links2 = "</a>";
				}
				echo "\t<li>".$links1.$singletag[$x].$links2.$separator."</li>\n";
			}
			echo "</ul>";
		} else {
			echo "$tagstring";
		}
	}
}

/**
 * Either prints all of the galleries tgs as a UL list or a cloud
 *
 * @param string $option "cloud" for tag cloud, "list" for simple list
 * @param string $class CSS class
 * @param string $sort "results" for relevance list, "abc" for alphabetical, blank for unsorted
 * @param bool $counter TRUE if you want the tag count within brackets behind the tag
 * @param bool $links set to TRUE to have tag search links included with the tag.
 * @param int $maxfontsize largest font size the cloud should display
 * @param int $maxcount the maximum count for a tag to appear in the output
 * @param int $mincount the minimum count for a tag to appear in the output
 * @param int $limit set to limit the number of tags displayed to the top $numtags
 * @since 1.1
 */
function printAllTagsAs($option,$class='',$sort='abc',$counter=FALSE,$links=TRUE,$maxfontsize=2,$maxcount=50,$mincount=10, $limit=NULL) {
	define('MINFONTSIZE', 0.8);

	$option = strtolower($option);
	if ($class != "") { $class = "class=\"".$class."\""; }
	$tagcount = getAllTagsCount();
	if (!is_array($tagcount)) { return false; }
	if ($sort == "results") {
			arsort($tagcount);
	}
	if (!is_null($limit)) {
		$tagcount = array_slice($tagcount, 0, $limit);
	}
	echo "<ul ".$class.">\n";
	foreach ($tagcount as $key=>$val) {
		if(!$counter) {
			$counter = "";
		} else {
			$counter = " (".$val.") ";
		}
		if ($option == "cloud") { // calculate font sizes, formula from wikipedia
			if ($val <= $mincount) {
				$size = MINFONTSIZE;
			} else {
				$size = min(max(round(($maxfontsize*($val-$mincount))/($maxcount-$mincount), 2), MINFONTSIZE), $maxfontsize);
			}
			$size = str_replace(',','.', $size);
			$size = " style=\"font-size:".$size."em;\"";
		} else {
			$size = '';
		}
		if ($val >= $mincount) {
			if(!$links) {
				echo "\t<li$size>".$key.$counter."</li>\n";
			} else {
				$key = str_replace('"', '', $key);
				echo "\t<li><a href=\"".
					htmlspecialchars(getSearchURL($key, '', SEARCH_TAGS, 0, 0))."\"$size rel=\"nofollow\">".
					$key.$counter."</a></li>\n";
			}
		}

	} // while end
	echo "</ul>\n";
}

/**
 * Retrieves a list of all unique years & months from the images in the gallery
 *
 * @param string $order set to 'desc' for the list to be in descending order
 * @return array
 */
function getAllDates($order='asc') {
	$alldates = array();
	$cleandates = array();
	$sql = "SELECT `date` FROM ". prefix('images');
	if (!zp_loggedin()) {
		$sql .= " WHERE `show` = 1";
	}
	$hidealbums = getNotViewableAlbums();	
	if (!is_null($hidealbums)) {
		if (zp_loggedin()) {
			$sql .= ' WHERE ';
		} else {
			$sql .= ' AND ';
		}
		foreach ($hidealbums as $id) {
			$sql .= '`albumid`!='.$id.' AND ';
		}
		$sql = substr($sql, 0, -5);
	}
	$result = query_full_array($sql);
	foreach($result as $row){
		$alldates[] = $row['date'];
	}
	foreach ($alldates as $adate) {
		if (!empty($adate)) {
			$cleandates[] = substr($adate, 0, 7) . "-01";
		}
	}
	$datecount = array_count_values($cleandates);
	if ($order == 'desc') {
		krsort($datecount);
	} else {
		ksort($datecount);
	}
	return $datecount;
}
/**
 * Prints a compendum of dates and links to a search page that will show results of the date
 *
 * @param string $class optional class
 * @param string $yearid optional class for "year"
 * @param string $monthid optional class for "month"
 * @param string $order set to 'desc' for the list to be in descending order
 */
function printAllDates($class='archive', $yearid='year', $monthid='month', $order='asc') {
	if (!empty($class)){ $class = "class=\"$class\""; }
	if (!empty($yearid)){ $yearid = "class=\"$yearid\""; }
	if (!empty($monthid)){ $monthid = "class=\"$monthid\""; }
	$datecount = getAllDates($order);
	$lastyear = "";
	echo "\n<ul $class>\n";
	$nr = 0;
	while (list($key, $val) = each($datecount)) {
		$nr++;
		if ($key == '0000-00-01') {
			$year = "no date";
			$month = "";
		} else {
			$dt = strftime('%Y-%B', strtotime($key));
			$year = substr($dt, 0, 4);
			$month = substr($dt, 5);
		}

		if ($lastyear != $year) {
			$lastyear = $year;
			if($nr != 1) {  echo "</ul>\n</li>\n";}
			echo "<li $yearid>$year\n<ul $monthid>\n";
		}
		echo "<li><a href=\"".htmlspecialchars(getSearchURl('', substr($key, 0, 7), 0, 0))."\" rel=\"nofollow\">$month ($val)</a></li>\n";
	}
	echo "</ul>\n</li>\n</ul>\n";
}

/**
 * Produces the url to a custom page (e.g. one that is not album.php, image.php, or index.php)
 *
 * @param string $linktext Text for the URL
 * @param string $page page name to include in URL
 * @param string $q query string to add to url
 * @param string $album optional album for the page
 * @return string
 */
function getCustomPageURL($page, $q='', $album='') {
	global $_zp_current_album;
	$result = '';
	if (getOption('mod_rewrite')) {
		if (!empty($album)) {
			$album = '/'.urlencode($album);
		}
		$result .= WEBPATH.$album."/page/$page";
		if (!empty($q)) { $result .= "?$q"; }
	} else {
		if (!empty($album)) {
			$album = "&album=$album";
		}
		$result .= WEBPATH."/index.php?p=$page".$album;
		if (!empty($q)) { $result .= "&$q"; }
	}
	return $result;
}

/**
 * Prints the url to a custom page (e.g. one that is not album.php, image.php, or index.php)
 *
 * @param string $linktext Text for the URL
 * @param string $page page name to include in URL
 * @param string $q query string to add to url
 * @param string $prev text to insert before the URL
 * @param string $next text to follow the URL
 * @param string $class optional class
 */
function printCustomPageURL($linktext, $page, $q='', $prev='', $next='', $class=NULL) {
	if (!is_null($class)) {
		$class = 'class="' . $class . '";';
	}
	echo $prev."<a href=\"".htmlspecialchars(getCustomPageURL($page, $q))."\" $class title=\"".html_encode($linktext)."\">".htmlspecialchars($linktext)."</a>".$next;
}

/**
 * Returns the URL to an image (This is NOT the URL for the image.php page)
 *
 * @param object $image the image
 * @return string
 */
function getURL($image) {
	if (getOption('mod_rewrite')) {
		return WEBPATH . "/" . pathurlencode($image->getAlbumName()) . "/" . urlencode($image->filename);
	} else {
		return WEBPATH . "/index.php?album=" . pathurlencode($image->getAlbumName()) . "&image=" . urlencode($image->filename);
	}
}
/**
 * Returns the record number of the album in the database
 * @return int
 */
function getAlbumId() {
	global $_zp_current_album;
	if (!isset($_zp_current_album)) { return null; }
	return $_zp_current_album->getAlbumId();
}

/**
 * Prints a RSS link
 *
 * @param string $option type of RSS: "Gallery" feed for the whole gallery
 * 																		"Album" for only the album it is called from
 * 																		"Collection" for the album it is called from and all of its subalbums
 * 																		"Comments" for all comments
 * 																		"Comments-image" for comments of only the image it is called from
 * 																		"Comments-album" for comments of only the album it is called from
 * @param string $prev text to before before the link
 * @param string $linktext title of the link
 * @param string $next text to appear after the link
 * @param bool $printIcon print an RSS icon beside it? if true, the icon is zp-core/images/rss.gif
 * @param string $class css class
 * @param string $lang optional to display a feed link for a specific language. Enter the locale like "de_DE" (the locale must be installed on your Zenphoto to work of course). If empty the locale set in the admin option or the language selector (getOption('locale') is used.
 * @since 1.1
 */
function printRSSLink($option, $prev, $linktext, $next, $printIcon=true, $class=null, $lang='') {
	global $_zp_current_album;
	$host = htmlentities($_SERVER["HTTP_HOST"], ENT_QUOTES, 'UTF-8');
	if ($printIcon) {
		$icon = ' <img src="' . FULLWEBPATH . '/' . ZENFOLDER . '/images/rss.gif" alt="RSS Feed" />';
	} else {
		$icon = '';
	}
	if (!is_null($class)) {
		$class = 'class="' . $class . '"';
	}
	if(empty($lang)) {
		$lang = getOption("locale");
	}
	switch($option) {
		case "Gallery":
			echo $prev."<a $class href=\"http://".$host.WEBPATH."/rss.php?lang=".$lang."\" rel=\"nofollow\">".$linktext."$icon</a>".$next;
			break;
		case "Album":
			echo $prev."<a $class href=\"http://".$host.WEBPATH."/rss.php?albumtitle=".urlencode(getAlbumTitle())."&amp;albumname=".urlencode($_zp_current_album->getFolder())."&amp;lang=".$lang."\" rel=\"nofollow\">".$linktext."$icon</a>".$next;
			break;
		case "Collection":
			echo $prev."<a $class href=\"http://".$host.WEBPATH."/rss.php?albumtitle=".urlencode(getAlbumTitle())."&amp;folder=".urlencode($_zp_current_album->getFolder())."&amp;lang=".$lang."\" rel=\"nofollow\">".$linktext."$icon</a>".$next;
			break;
		case "Comments":
			echo $prev."<a $class href=\"http://".$host.WEBPATH."/rss-comments.php?lang=".$lang."\" rel=\"nofollow\">".$linktext."$icon</a>".$next;
			break;
		case "Comments-image":
			echo $prev."<a $class href=\"http://".$host.WEBPATH."/rss-comments.php?id=".getImageID()."&amp;title=".urlencode(getImageTitle())."&amp;type=image&amp;lang=".$lang."\" rel=\"nofollow\">".$linktext."$icon</a>".$next;
			break;
		case "Comments-album":
			echo $prev."<a $class href=\"http://".$host.WEBPATH."/rss-comments.php?id=".getAlbumID()."&amp;title=".urlencode(getAlbumTitle())."&amp;type=album&amp;lang=".$lang."\" rel=\"nofollow\">".$linktext."$icon</a>".$next;
			break;
	}
}

/**
 * Returns the RSS link for use in the HTML HEAD
 *
 * @param string $option type of RSS: "Gallery" feed for the whole gallery
 * 																		"Album" for only the album it is called from
 * 																		"Collection" for the album it is called from and all of its subalbums
 * 																		 "Comments" for all comments
 * 																		"Comments-image" for comments of only the image it is called from
 * 																		"Comments-album" for comments of only the album it is called from
 * @param string $linktext title of the link
 * @param string $lang optional to display a feed link for a specific language. Enter the locale like "de_DE" (the locale must be installed on your Zenphoto to work of course). If empty the locale set in the admin option or the language selector (getOption('locale') is used.
 *
 *
 * @return string
 * @since 1.1
 */
function getRSSHeaderLink($option, $linktext='', $lang='') {
	global $_zp_current_album;
	$host = htmlentities($_SERVER["HTTP_HOST"], ENT_QUOTES, 'UTF-8');
	if(empty($lang)) {
		$lang = getOption("locale");
	}
	switch($option) {
		case "Gallery":
			return "<link rel=\"alternate\" type=\"application/rss+xml\" title=\"".html_encode($linktext)."\" href=\"http://".$host.WEBPATH."/rss.php?lang=".$lang."\" />\n";
		case "Album":
			return "<link rel=\"alternate\" type=\"application/rss+xml\" title=\"".html_encode($linktext)."\" href=\"http://".$host.WEBPATH."/rss.php?albumtitle=".urlencode(getAlbumTitle())."&amp;albumname=".urlencode($_zp_current_album->getFolder())."&amp;lang=".$lang."\" />\n";
		case "Collection":
			return "<link rel=\"alternate\" type=\"application/rss+xml\" title=\"".html_encode($linktext)."\" href=\"http://".$host.WEBPATH."/rss.php?albumtitle=".urlencode(getAlbumTitle())."&amp;folder=".urlencode($_zp_current_album->getFolder())."&amp;lang=".$lang."\" />\n";
		case "Comments":
			return "<link rel=\"alternate\" type=\"application/rss+xml\" title=\"".html_encode($linktext)."\" href=\"http://".$host.WEBPATH."/rss-comments.php?lang=".$lang."\" />\n";
		case "Comments-image":
			return "<link rel=\"alternate\" type=\"application/rss+xml\" title=\"".html_encode($linktext)."\" href=\"http://".$host.WEBPATH."/rss-comments.php?id=".getImageID()."&amp;title=".urlencode(getImageTitle())."&amp;type=image&amp;lang=".$lang."\" />\n";
		case "Comments-album":
			return "<link rel=\"alternate\" type=\"application/rss+xml\" title=\"".html_encode($linktext)."\" href=\"http://".$host.WEBPATH."/rss-comments.php?id=".getAlbumID()."&amp;title=".urlencode(getAlbumTitle())."&amp;type=album&amp;lang=".$lang."\" />\n";
	
	}
}

/**
 * Prints the RSS link for use in the HTML HEAD
 *
 * @param string $option type of RSS (Gallery, Album, Collection, Comments)
 * @param string $linktext title of the link
 *
 * @since 1.1.6
 */
function printRSSHeaderLink($option, $linktext) {
	echo getRSSHeaderLink($option, $linktext);
}


//*** Search functions *******************************************************
//****************************************************************************

/**
 * Returns a search URL
 *
 * @param string $words the search words target
 * @param string $dates the dates that limit the search
 * @param int $fields the fields on which to search
 * @param int $page the page number for the URL
 * @return string
 * @since 1.1.3
 */
function getSearchURL($words, $dates, $fields, $page) {
	if ($mr = getOption('mod_rewrite')) {
		$url = WEBPATH."/page/search/";
	} else {
		$url = WEBPATH."/index.php?p=search";
	}
	if (($fields != 0) && empty($dates)) {
		if($mr) {
			if ($fields == SEARCH_TAGS) {
				$url .= "tags/";
			} else {
				$url .= "fields$fields/";
			}
		} else {
			$url .= "&searchfields=$fields";
		}
	}

	if (!empty($words)) {
		if($mr) {
			$url .= urlencode($words);
		} else {
			$url .= "&words=".urlencode($words);
		}
	}
	if (!empty($dates)) {
		if($mr) {
			$url .= "archive/$dates";
		} else {
			$url .= "&date=$dates";
		}
	}
	if ($page > 1) {
		if ($mr) {
			$url .= "/$page";
		} else {
			$url .= "&page=$page";
		}
	}
	return $url;
}

/**
 * Prints the search form
 *
 * Search works on a list of tokens entered into the search form.
 *
 * Tokens may be part of boolean expressions using &, |, !, and parens. (Comma is retained as a synonom of | for
 * backwords compatibility.) If tokens are separated by spaces, the OR function is presumed.
 *
 * Tokens may be enclosed in quotation marks to create exact pattern matches or to include the boolean operators and
 * parens as part of the tag..
 *
 * @param string $prevtext text to go before the search form
 * @param string $id css id for the search form, default is 'search'
 * @param string $buttonSource optional path to the image for the button
 * @param string $buttontext optional text for the button ("Search" will be the default text)
 * @param string $iconsource optional theme based icon for the search fields toggle
 * @since 1.1.3
 */
function printSearchForm($prevtext=NULL, $id='search', $buttonSource=NULL,$buttontext='', $iconsource=NULL) {
	global $_zp_adminJS_loaded;
	if(empty($buttontext)) {
		$buttontext = gettext("Search");
	} else {
		$buttontext = sanitize($buttontext);
	}
	if (checkforPassword(true)) { return; }
	$zf = WEBPATH."/".ZENFOLDER;
	$dataid = $id . '_data';
	$searchwords = (isset($_POST['words']) ? html_encode(sanitize($_REQUEST['words'],0),false) : '');

	$fields = getOption('search_fields');
	if (empty($buttonSource)) {
		$type = 'submit';
	} else {
		$buttonSource = 'src="' . $buttonSource . '" alt="'.$buttontext.'"';
		$type = 'image';
	}
	if (empty($iconsource)) {
		$iconsource = WEBPATH.'/'.ZENFOLDER.'/images/searchfields_icon.png';
	}
	if (getOption('mod_rewrite')) { $searchurl = '/page/search/'; } else { $searchurl = "/index.php?p=search"; }
	$engine = new SearchEngine();
	$fields = array_flip($engine->allowedSearchFields());
	if (!$_zp_adminJS_loaded) {
		$_zp_adminJS_loaded = true;
	?>
		<script type="text/javascript" src="<?php echo WEBPATH.'/'.ZENFOLDER; ?>/js/admin.js"></script>
	<?php
	}
	?>
	<div id="search"><!-- search form -->

	<form method="post" action="<?php echo WEBPATH.$searchurl; ?>" id="search_form">
	<?php echo $prevtext; ?>
	<input type="text" name="words" value="<?php  echo $searchwords; ?>" id="search_input" size="10" />
	<?php if(count($fields) > 1) { ?>
		<a href="javascript: toggle('searchextrashow');"><img src="<?php echo $iconsource; ?>" alt="<?php echo gettext('select search fields'); ?>" id="searchfields_icon" /></a>
	<?php } ?>
	<input type="<?php echo $type; ?>" value="<?php echo $buttontext; ?>" class="pushbutton" id="search_submit" <?php echo $buttonSource; ?> />
	<br />
	<?php
	if (count($fields) > 1) {
		natcasesort($fields);
		$fields = array_flip($fields);
		$query_fields = $engine->parseQueryFields();
		?>
		<ul style="display:none;" id="searchextrashow">
		<?php
		foreach ($fields as $key=>$item) {
			echo '<li><label for="_SEARCH_'.$item.'"><input id="_SEARCH_'.$item.'" name="_SEARCH_'.$item.'" type="checkbox"';		
			if ($item & $query_fields) {
				echo ' checked="checked" ';
			}
			echo ' value="'.$item.'"  /> ' . $key . "</label></li>"."\n";
		}
		?>
		</ul>
		<?php 
	}
	?>
	</form>
	</div><!-- end of search form -->
	<?php
}

/**
 * Returns the a sanitized version of the search string
 *
 * @return string
 * @since 1.1
 */
function getSearchWords() {
	global $_zp_current_search;
	if (!in_context(ZP_SEARCH)) { return ''; }
	$opChars = array ('('=>2, '&'=>1, '|'=>1, '!'=>1, ','=>1);
	$searchstring = $_zp_current_search->getSearchString();
	$sanitizedwords = '';
	if (is_array($searchstring)) {
		foreach($searchstring as $singlesearchstring){
			switch ($singlesearchstring) {
				case '&':
					$sanitizedwords .= " &amp; ";
					break;
				case '!':
				case '|':
				case '(':
				case ')':
					$sanitizedwords .= " $singlesearchstring ";
					break;
				default:
					$setQuote = false;
					foreach ($opChars as $char => $value) {
						if ((strpos($singlesearchstring, $char) !== false)) $setQuote = true;
					}
					if ($setQuote) {
						$sanitizedwords .= '&quot;'.sanitize($singlesearchstring, 3).'&quot;';
					} else {
						$sanitizedwords .= ' '.sanitize($singlesearchstring, 3).' ';
					}
			}
		}
	}
	return $sanitizedwords;
}

/**
 * Returns the date of the search
 *
 * @param string $format formatting of the date, default 'F Y'
 * @return string
 * @since 1.1
 */
function getSearchDate($format='%B %Y') {
	if (in_context(ZP_SEARCH)) {
		global $_zp_current_search;
		$date = $_zp_current_search->getSearchDate();
		if (empty($date)) { return ""; }
		if ($date == '0000-00') { return gettext("no date"); };
		$dt = strtotime($date."-01");
		return zpFormattedDate($format, $dt);
	}
	return false;
}

define("IMAGE", 1);
define("ALBUM", 2);
/**
 * Checks to see if comment posting is allowed for an image/album

 * Returns true if comment posting should be allowed
 *
 * @param int $what the degree of control desired allowed values: ALBUM, IMAGE, and ALBUM+IMAGE
 * @return bool
 */
function openedForComments($what=3) {
	global $_zp_current_image, $_zp_current_album;
	$result = true;
	if (IMAGE & $what) { $result = $result && $_zp_current_image->getCommentsAllowed(); }
	if (ALBUM & $what) { $result = $result && $_zp_current_album->getCommentsAllowed(); }
	return $result;
}

/**
 * Finds the name of the themeColor option selected on the admin options tab

 * Returns a path and name of the theme css file. Returns the value passed for defaultcolor if the
 * theme css option file does not exist.
 *
 * @param string &$zenCSS path to the css file
 * @param string &$themeColor name of the css file
 * @param string $defaultColor name of the default css file
 * @return string
 * @since 1.1
 */
function getTheme(&$zenCSS, &$themeColor, $defaultColor) {
	global $_zp_themeroot;
	$themeColor = getOption('Theme_colors');
	$zenCSS = $_zp_themeroot . '/styles/' . $themeColor . '.css';
	$unzenCSS = str_replace(WEBPATH, '', $zenCSS);
	if (!file_exists(SERVERPATH . UTF8ToFileSystem($unzenCSS))) {
		$zenCSS = $_zp_themeroot. "/styles/" . $defaultColor . ".css";
		return ($themeColor == '');
	} else {
		return true;
	}
}

/**
 * Passed # of album columns, # of image columns of the theme.
 *
 * NOTE: The values for these numbers of columns are determined by the theme
 * CSS. They should be set to how many images or albums are displayed in a row.
 * If you get this wrong, your theme will not behave as you expect.
 *
 * Updates (non-persistent) images_per_page and albums_per_page so that the rows are filled.
 *
 * This means that the value you set for the images per page and albums per page options may
 * not be the same as what actually gets shown. First, they will be rounded to be an even multiple
 * rows. So, if you have 6 columns of album thumbs your albums per page shown will be a multiple of
 * six (assuming that there are enough albums.) Second, there may be a page where both image and
 * album thumbs are shown--the "transition" page. Fewer than images_per_page will appear
 * on this page.
 *
 * The "non-persistent" update means that the actual values for these options are not changed. Just
 * the values that will be used for the display of the particular page.
 *
 * Returns # of images that will go on the album/image transition page.
 *
 * When you have albums containing both subalbums and images there may be a page where the album
 * thumbnails do not fill the page. This function returns a count of the images that can be used to
 * fill out this transition page. The return value should be passed as the second parameter to
 * next_image() so that the page is filled out with the proper number of images. If you do not
 * pass this parameter it is assumed that album thumbs and image thumbs are not to be placed on
 * the same (transition) page. (If you do not wish to have an album/image transition page you need
 * not use this function at all.)
 *
 * This function (combined with the parameter to next_image) impacts the pagination computations
 * zenphoto makes. For this reason, it is important to make identical calls to the function from
 * your theme's index.php, albums.php and image.php pages. Otherwise page and breadcrumb navigation
 * may not be correct.
 *
 * @param int $albumColumns number of album columns on the page
 * @param int $imageColumns number of image columns on the page
 * @return int
 * @since 1.1
 */
function normalizeColumns($albumColumns, $imageColumns) {
	global $_zp_current_album, $firstPageImages;
	$albcount = max(1, getOption('albums_per_page'));
	if (($albcount % $albumColumns) != 0) {
		setOption('albums_per_page', $albcount = ((floor($albcount / $albumColumns) + 1) * $albumColumns), false);
	}
	$imgcount = max(1, getOption('images_per_page'));
	if (($imgcount % $imageColumns) != 0) {
		setOption('images_per_page', $imgcount = ((floor($imgcount / $imageColumns) + 1) * $imageColumns), false);
	}
	if (in_context(ZP_ALBUM | ZP_SEARCH)) {
		if (in_context(ZP_SEARCH)) {
			$count = getNumAlbums();
		} else {

			$count = GetNumSubalbums();

		}
		if ($count == 0) {
			return 0;
		}
		$rowssused = ceil(($count % $albcount) / $albumColumns);     /* number of album rows unused */
		$leftover = floor(max(1, getOption('images_per_page')) / $imageColumns) - $rowssused;
		$firstPageImages = max(0, $leftover * $imageColumns);  /* number of images that fill the leftover rows */
		if ($firstPageImages == $imgcount) {
			return 0;
		} else {
			return $firstPageImages;
		}
	}
	return false;
}

//************************************************************************************************
// album password handling
//************************************************************************************************

/**
 * Checks to see if a password is needed
 * displays a password form if log-on is required
 *
 * Returns true if a login form has been displayed
 *
 * The password protection is hereditary. This normally only impacts direct url access to an album or image since if
 * you are going down the tree you will be stopped at the first place a password is required.
 *
 * If the gallery is password protected then every album & image will require that password.
 *
 * If an album is password protected then all subalbums and images treed below that album will require
 * the password. If there are multiple passwords in the tree and you direct link, the password that is
 * required will be that of the nearest parent that has a password. (The gallery is the ur-parrent to all
 * albums.)
 *
 * @param bool $silent set to true to inhibit the logon form
 * @return bool
 * @since 1.1.3
 */
function checkforPassword($silent=false) {
	global $_zp_current_album, $_zp_current_search, $_zp_gallery, $_zp_loggedin;
	if (zp_loggedin(MAIN_RIGHTS | VIEWALL_RIGHTS | ALL_ALBUMS_RIGHTS)) { return false; }  // you're the admin, you don't need the passwords.
	if (in_context(ZP_SEARCH)) {  // search page
		$hash = getOption('search_password');
		$show = (getOption('search_user') != '');
		$hint = get_language_string(getOption('search_hint'));
		$authType = 'zp_search_auth';
		if (empty($hash)) {
			$hash = getOption('gallery_password');
			$show = (getOption('gallery_user') != '');
			$hint = get_language_string(getOption('gallery_hint'));
			$authType = 'zp_gallery_auth';
		}
		if (!empty($hash)) {
			if (zp_getCookie($authType) != $hash) {
				if (!$silent) {
					printPasswordForm($hint, true, getOption('login_user_field') || $show);
				}
				return true;
			}
		}
	} else if (isset($_GET['album'])) {  // album page
		list($album, $image) = rewrite_get_album_image('album','image');
		if (checkAlbumPassword($album, $hint)) {
			return false;
		} else {
			if (!$silent) {
				$alb = new Album($_zp_gallery, $album);
				printPasswordForm($hint, true,  getOption('login_user_field') || $alb->getUser() != '');
			}
			return true;
		}
	} else {  // index page
		if ($_zp_loggedin) return false;
		$hash = getOption('gallery_password');
		$hint = get_language_string(getOption('gallery_hint'));
		if (!empty($hash)) {
			if (zp_getCookie('zp_gallery_auth') != $hash) {
				if (!$silent) {
					printPasswordForm($hint, true, getOption('login_user_field') || getOption('gallery_user') != '');
				}
				return true;
			}
		}
	}
	return false;
}

/**
 * Prints the album password form
 *
 * @param string $hint hint to the password
 * @param bool $showProtected set false to supress the password protected message
 * @param bool $showuser set true to force the user name filed to be present
 *
 *@since 1.1.3
 */
function printPasswordForm($hint, $showProtected=true, $showuser=NULL) {
	global $_zp_login_error, $_zp_password_form_printed, $_zp_current_search, $_zp_gallery_page,
					$_zp_current_album, $_zp_current_image;
	if (is_null($showuser)) { $showuser = getOption('login_user_field'); }
	if ($_zp_password_form_printed) { return; }
	$_zp_password_form_printed = true;
	if ($_zp_login_error) {
		echo "<div class=\"errorbox\" id=\"message\"><h2>".gettext("There was an error logging in.")."</h2><br/>".gettext("Check your user and password and try again.")."</div>";
	}
	switch($_zp_gallery_page) {
		case 'index.php':
			$action = "";
			break;
		case 'album.php':
			$action = '&amp;album='.urlencode($_zp_current_album->name);
			break;
		case 'image.php':
			$action = '&amp;album='.urlencode($_zp_current_album->name).'&amp;image='.urlencode($_zp_current_image->filename);
		case 'full-image.php':
			$action = '&amp;album='.urlencode($_zp_current_album->name).'&amp;image='.urlencode($_zp_current_image->filename).'&amp;p=*full-image';
			break;
		default:
		if (in_context(ZP_SEARCH)) {
			$action = "&amp;p=search" . $_zp_current_search->getSearchParams();
		} else {
			$action = '&amp;p='.substr($_zp_gallery_page, 0, -4);
		}
	}
	if ($showProtected && !$_zp_login_error) {
		echo "\n<p>".gettext("The page you are trying to view is password protected.")."</p>";
	}
	echo "\n<br/>";
	echo "\n  <form name=\"password\" action=\"?userlog=1$action\" method=\"POST\">";
	echo "\n    <input type=\"hidden\" name=\"password\" value=\"1\" />";

	echo "\n    <table>";
	if ($showuser) {
		echo "\n      <tr><td style=\"text-align:right\">".gettext("Login")." </td><td style=\"text-align:left;\"><input type=\"text\" size=\"38\" name=\"user\" /></td></tr>";
	}
	echo "\n      <tr><td style=\"text-align:right\">".gettext("Password")." </td><td style=\"text-align:left;\"><input type=\"password\" size=\"40\" name=\"pass\" /></td></tr>";
	echo "\n      <tr><td></td><td style=\"text-align:left\" ><input class=\"button\" type=\"submit\" value=\"".gettext("Submit")."\" /></td></tr>";
	if (!empty($hint)) {
		echo "\n      <tr><td style=\"text-align:left\">".sprintf(gettext("Hint: %s"), $hint) . "</td></tr>";
	}
	echo "\n    </table>";
	echo "\n  </form>";
	$registerpage = getOption('user_registration_page');
	if (!empty($registerpage) && file_exists(SERVERPATH.'/'.THEMEFOLDER.'/'.getOption('current_theme').'/'.UTF8ToFilesystem($registerpage).'.php')) {
		if (getOption('mod_rewrite')) {
			$link = '/page/'.$registerpage;
		} else {
			$link = 'index.php?p='.$registerpage;
		}
		printLink($link,get_language_string(getOption('user_registration_text')),get_language_string(getOption('user_registration_tip')));
	}
}

/**
 * Shell for calling the installed captcha generator.
 * Returns a captcha string and captcha image URI
 *
 * @param string $img the captcha image URI
 * @return string
 */
function generateCaptcha(&$img) {
	global $_zp_captcha;
	return $_zp_captcha->generateCaptcha($img);
}

/**
 * Simple captcha for comments.
 *
 * Prints a captcha entry field for a form such as the comments form.
 * @param string $preText lead-in text
 * @param string $midText text that goes between the captcha image and the input field
 * @param string $postText text that closes the captcha
 * @param int $size the text-width of the input field
 * @since 1.1.4
 **/
function printCaptcha($preText='', $midText='', $postText='', $size=4) {
	global $_zp_captcha;
	if (getOption('Use_Captcha')) {
		$captchaCode = $_zp_captcha->generateCaptcha($img);
		$inputBox =  "<input type=\"text\" id=\"code\" name=\"code\" size=\"" . $size . "\" class=\"inputbox\" />";
		$captcha = "<input type=\"hidden\" name=\"code_h\" value=\"" . $captchaCode . "\" />" .
 						"<label for=\"code\"><img src=\"" . $img . "\" alt=\"Code\" style=\"vertical-align:bottom\"/></label>&nbsp;";

		echo $preText;
		echo $captcha;
		echo $midText;
		echo $inputBox;
		echo $postText;
	}
}

/**
 * prints the zenphoto logo and link
 *
 */
function printZenphotoLink() {
	echo gettext("Powered by <a href=\"http://www.zenphoto.org\" title=\"A simpler web photo album\"><span id=\"zen-part\">zen</span><span id=\"photo-part\">PHOTO</span></a>");	
}

/**
 * Returns truncated html formatted content
 *
 * @param string $articlecontent the source string
 * @param int $shorten new size
 * @param string $shortenindicator
 * @return string
 */
function shortenContent($articlecontent, $shorten, $shortenindicator) {
	$short = truncate_string($articlecontent, $shorten, '');
	// drop open tag strings
	$open = strrpos($short, '<');
	if ($open > strrpos($short, '>')) {
		$short = substr($short, 0, $open);
	}
	// drop unbalanced tags
	$short = sanitize($short.'</p>', 1);
	// insert the elipsis
	$i = strrpos($short, '</p>');
	if ($i == strlen($short) - 4) {
		$short = substr($short, 0, -4).' '.$shortenindicator.'</p>';
	} else {
		$short .= ' '.$shortenindicator;
	}
	return $short;
}

/**
 * Expose some informations in a HTML comment
 *
 * @param string $obj the path to the page being loaded
 * @param array $plugins list of activated plugins
 * @param string $theme The theme being used
 * @param string $filters list of the activated filters
 */
function exposeZenPhotoInformations( $obj = '', $plugins = '', $theme = '', $filters = '' ) {
	global $zenpage_version, $_zp_filters;

	$a = basename($obj);
	if ($a != 'full-image.php') {
		if (defined('RELEASE')) {
			$official = 'Official Build';
		} else {
			$official = 'SVN';
		}
		echo "\n<!-- zenphoto version " . ZENPHOTO_VERSION . " [" . ZENPHOTO_RELEASE . "] ($official)";
		if (isset($zenpage_version)) echo ' zenpage version '.$zenpage_version.' ['.ZENPAGE_RELEASE.'] ';
		echo " THEME: " . $theme . " (" . $a . ") { memory: ".INI_GET('memory_limit')." }";
		echo ' PLUGINS: ';
		if (count($plugins) > 0) {
			sort($plugins);
			foreach ($plugins as $plugin) {
				echo $plugin.' ';
			}
		} else {
			echo 'none';
		}
		if (count($filters) > 0) {
			ksort($filters);
			echo 'FILTERS: ';
			foreach ($filters as $filter=>$array_of_priority) {
				foreach ($array_of_priority as $priority=>$array_of_filters) {
					echo "$filter [";
					foreach ($array_of_filters as $data) {
						echo "$priority: ".$data['script'].'=>'.$data['function'];
					}
					echo '] ';
				}
			}
		} else {
			echo 'none';
		}
		echo " -->";
	}
}

?>
