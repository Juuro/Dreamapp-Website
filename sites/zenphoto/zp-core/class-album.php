<?php
/**
 * Album Class
 * @package classes
 */

// force UTF-8 Ø

class Album extends PersistentObject {

	var $name;             // Folder name of the album (full path from the albums folder)
	var $localpath;				 // Latin1 full server path to the album
	var $exists = true;    // Does the folder exist?
	var $images = null;    // Full images array storage.
	var $subalbums = null; // Full album array storage.
	var $parent = null;    // The parent album name
	var $parentalbum = null; // The parent album's album object (lazy)
	var $gallery;
	var $searchengine;           // cache the search engine for dynamic albums
	var $comments;      // Image comment array.
	var $commentcount;  // The number of comments on this image.
	var $index;
	var $themeoverride;
	var $lastimagesort = NULL;  // remember the order for the last album/image sorts
	var $lastsubalbumsort = NULL;
	var $albumthumbnail = NULL; // remember the album thumb for the duration of the script

	/**
	 * Constructor for albums
	 *
	 * @param object &$gallery The parent gallery
	 * @param string $folder folder name of the album
	 * @param bool $cache load from cache if present
	 * @return Album
	 */
	function Album(&$gallery, $folder, $cache=true) {
		$folder = sanitize_path($folder);
		$this->name = $folder;
		$this->gallery = &$gallery;
		if (empty($folder)) {
			$this->localpath = getAlbumFolder();
		} else {
			$this->localpath = getAlbumFolder() . UTF8ToFilesystem($folder) . "/";
		}
		if (hasDyanmicAlbumSuffix($folder)) {
			$this->localpath = substr($this->localpath, 0, -1);
		}

		// Second defense against upward folder traversal:
		if(!file_exists($this->localpath) || strpos($this->localpath, '..') !== false) {
			$this->exists = false;
			return NULL;
		}
		$new = parent::PersistentObject('albums', array('folder' => $this->name), 'folder', $cache, empty($folder));
		if (hasDyanmicAlbumSuffix($folder)) {
			if ($new || (filemtime($this->localpath) > $this->get('mtime'))) {
				$data = file_get_contents($this->localpath);
				while (!empty($data)) {
					$data1 = trim(substr($data, 0, $i = strpos($data, "\n")));
					if ($i === false) {
						$data1 = $data;
						$data = '';
					} else {
						$data = substr($data, $i + 1);
					}
					if (strpos($data1, 'WORDS=') !== false) {
						$words = "words=".urlencode(substr($data1, 6));
					}
					if (strpos($data1, 'THUMB=') !== false) {
						$thumb = trim(substr($data1, 6));
						$this->set('thumb', $thumb);
					}
					if (strpos($data1, 'FIELDS=') !== false) {

						$fields = "&searchfields=".trim(substr($data1, 7));
					}
				}
				if (!empty($words)) {
					if (empty($fields)) {
						$fields = '&searchfields=4';
					}
					$this->set('search_params', $words.$fields);
				}

				$this->set('dynamic', 1);
				$this->set('mtime', filemtime($this->localpath));
				if ($new) {
					$title = $this->get('title');
					$this->set('title', substr($title, 0, -4));
					$this->setDateTime(strftime('%Y/%m/%d %T', filemtime($this->localpath)));
				}
				$this->folder = $folder;
				$this->save();
			}
		}
		if ($new) apply_filter('new_album', $this);
	}

	/**
	 * Sets default values for a new album
	 *
	 * @return bool
	 */
	function setDefaults() {
		// Set default data for a new Album (title and parent_id)
		$parentalbum = $this->getParent();
		$title = trim($this->name);
		if (!is_null($parentalbum)) {
			$this->set('parentid', $parentalbum->getAlbumId());
			$title = substr($title, strrpos($title, '/')+1);
		}
		$this->set('title', sanitize($title, 2));

		return true;
	}

	/**
	 * Returns the folder on the filesystem
	 *
	 * @return string
	 */
	function getFolder() { return $this->name; }

	/**
	 * Returns the id of this album in the db
	 *
	 * @return int
	 */
	function getAlbumID() { return $this->id; }

	/**
	 * Returns The parent Album of this Album. NULL if this is a top-level album.
	 *
	 * @return object
	 */
	function getParent() {
		if (is_null($this->parentalbum)) {
			$slashpos = strrpos($this->name, "/");
			if ($slashpos) {
				$parent = substr($this->name, 0, $slashpos);
				$parentalbum = new Album($this->gallery, $parent);
				if ($parentalbum->exists) {
					return $parentalbum;
				}
			}
		} else if ($this->parentalbum->exists) {
			return $this->parentalbum;
		}
		return NULL;
	}

	/**
	 * Returns the album guest user
	 *
	 * @return string
	 */
	function getUser() { return $this->get('user');	}

	/**
	 * Sets the album guest user
	 *
	 * @param string $user
	 */
	function setUser($user) { $this->set('user', $user);	}

	/**
	 * Returns the album password
	 *
	 * @return string
	 */
	function getPassword() { return $this->get('password'); }

	/**
	 * Sets the encrypted album password
	 *
	 * @param string $pwd the cleartext password
	 */
	function setPassword($pwd) {
		if (empty($pwd)) {
			$this->set('password', "");
		} else {
			$this->set('password', passwordHash($this->get('user'), $pwd));
		}
	}

	/**
	 * Returns the password hint for the album
	 *
	 * @return string
	 */
	function getPasswordHint() {
		$t =  $this->get('password_hint');
		return get_language_string($t);
	}

	/**
	 * Sets the album password hint
	 *
	 * @param string $hint the hint text
	 */
	function setPasswordHint($hint) { $this->set('password_hint', $hint); }


	/**
	 * Returns the album title
	 *
	 * @return string
	 */
	function getTitle() {
		$t = $this->get('title');
		return get_language_string($t);
	}

	/**
	 * Stores the album title
	 *
	 * @param string $title the title
	 */
	function setTitle($title) { $this->set('title', $title); }


	/**
	 * Returns the album description
	 *
	 * @return string
	 */
	function getDesc() {
		$t = $this->get('desc');
		return get_language_string($t);
	}

	/**
	 * Stores the album description
	 *
	 * @param string $desc description text
	 */
	function setDesc($desc) { $this->set('desc', $desc); }


	/**
	 * Returns the tag data of an album
	 *
	 * @return string
	 */
	function getTags() {
		return readTags($this->id, 'albums');
	}

	/**
	 * Stores tag information of an album
	 *
	 * @param string $tags the tag string
	 */
	function setTags($tags) {
		if (!is_array($tags)) {
			$tags = explode(',', $tags);
		}
		storeTags(filterTags($tags), $this->id, 'albums');
	}


	/**
	 * Returns the unformatted date of the album
	 *
	 * @return int
	 */
	function getDateTime() { return $this->get('date'); }

	/**
	 * Stores the album date
	 *
	 * @param string $datetime formatted date
	 */
	function setDateTime($datetime) {
		if ($datetime == "") {
			$this->set('date', '0000-00-00 00:00:00');
		} else {
			$newtime = dateTimeConvert($datetime);
			if ($newtime === false) return;
			$this->set('date', $newtime);
		}
	}


	/**
	 * Returns the place data of an album
	 *
	 * @return string
	 */
	function getPlace() {
		$t =  $this->get('place');
		return get_language_string($t);
	}

	/**
	 * Stores the album place
	 *
	 * @param string $place text for the place field
	 */
	function setPlace($place) { $this->set('place', $place); }


	/**
	 * Returns either the subalbum sort direction or the image sort direction of the album
	 *
	 * @param string $what 'image_sortdirection' if you want the image direction,
	 *        'album_sortdirection' if you want it for the album
	 *
	 * @return string
	 */
	function getSortDirection($what) {
		if ($what == 'image') {
			$direction = $this->get('image_sortdirection');
			$type = $this->get('sort_type');
		} else {
			$direction = $this->get('album_sortdirection');
			$type = $this->get('subalbum_sort_type');
		}
		if (empty($type)) { // using inherited type, so use inherited direction
			$parentalbum = $this->getParent();
			if (is_null($parentalbum)) {
				if ($what == 'image') {
					$direction = getOption('image_sortdirection');
				} else {
					$direction = getOption('gallery_sortdirection');
				}
			} else {
				$direction = $parentalbum->getSortDirection($what);
			}
		}
		return $direction;
	}

	/**
	 * sets sort directions for the album
	 *
	 * @param string $what 'image_sortdirection' if you want the image direction,
	 *        'album_sortdirection' if you want it for the album
	 * @param string $val the direction
	 */
	function setSortDirection($what, $val) {
		if ($val) { $b = 1; } else { $b = 0; }
		if ($what == 'image') {
			$this->set('image_sortdirection', $b);
		} else {
			$this->set('album_sortdirection', $b);
		}
	}

	/**
	 * Returns the sort type of the album
	 * Will return a parent sort type if the sort type for this album is empty
	 *
	 * @return string
	 */
	function getSortType() {
		$type = $this->get('sort_type');
		if (empty($type)) {
			$parentalbum = $this->getParent();
			if (is_null($parentalbum)) {
				$type = getOption('image_sorttype');
			} else {
				$type = $parentalbum->getSortType();
			}
		}
		return $type;
	}

	/**
	 * Stores the sort type for the album
	 *
	 * @param string $sorttype the album sort type
	 */
	function setSortType($sorttype) { $this->set('sort_type', $sorttype); }

	/**
	 * Returns the sort type for subalbums in this album.
	 *
	 * Will return a parent sort type if the sort type for this album is empty.
	 *
	 * @return string
	 */
	function getSubalbumSortType() {
		$type = $this->get('subalbum_sort_type');
		if (empty($type)) {
			$parentalbum = $this->getParent();
			if (is_null($parentalbum)) {
				$type = getOption('gallery_sorttype');
			} else {
				$type = $parentalbum->getSubalbumSortType();
			}
		}
		return $type;
	}

	/**
	 * Stores the subalbum sort type for this abum
	 *
	 * @param string $sorttype the subalbum sort type
	 */
	function setSubalbumSortType($sorttype) { $this->set('subalbum_sort_type', $sorttype); }

	/**
	 * Returns the image sort order for this album
	 *
	 * @return string
	 */
	function getSortOrder() { return $this->get('sort_order'); }

	/**
	 * Stores the image sort order for this album
	 *
	 * @param string $sortorder image sort order
	 */
	function setSortOrder($sortorder) { $this->set('sort_order', $sortorder); }

	/**
	 * Returns the DB key associated with the sort type
	 *
	 * @param string $sorttype the sort type
	 * @return string
	 */
	function getSortKey($sorttype=null) {
		if (is_null($sorttype)) { $sorttype = $this->getSortType(); }
		return albumSortKey($sorttype);
	}

	/**
	 * Returns the DB key associated with the subalbum sort type
	 *
	 * @param string $sorttype subalbum sort type
	 * @return string
	 */
	function getSubalbumSortKey($sorttype=null) {
		if (empty($sorttype)) { $sorttype = $this->getSubalbumSortType(); }
		return subalbumSortKey($sorttype);
	}


	/**
	 * Returns true if the album is published
	 *
	 * @return bool
	 */
	function getShow() { return $this->get('show'); }

	/**
	 * Stores the published value for the album
	 *
	 * @param bool $show True if the album is published
	 */
	function setShow($show) { $this->set('show', $show ? 1 : 0); }

	/**
	 * Returns all folder names for all the subdirectories.
	 *
	 * @param string $page  Which page of subalbums to display.
	 * @param string $sorttype The sort strategy
	 * @param string $sortdirection The direction of the sort
	 * @return array
	 */

	function getSubAlbums($page=0, $sorttype=null, $sortdirection=null) {
		if (is_null($this->subalbums) || $sorttype.$sortdirection !== $this->lastsubalbumsort ) {
			$dirs = $this->loadFileNames(true);
			$subalbums = array();

			foreach ($dirs as $dir) {
				$dir = $this->name . '/' . $dir;
				$subalbums[] = $dir;
			}
			$key = $this->getSubalbumSortKey($sorttype);
			if ($key != '`sort_order`') {
				if (is_null($sortdirection)) {
					if ($this->getSortDirection('album')) { $key .= ' DESC'; }
				} else {
					$key .= ' ' . $sortdirection;
				}
			}
			$sortedSubalbums = sortAlbumArray($this, $subalbums, $key);
			$this->subalbums = $sortedSubalbums;
			$this->lastsubalbumsort = $sorttype.$sortdirection;
		}
		if ($page == 0) {
			return $this->subalbums;
		} else {
			$albums_per_page = max(1, getOption('albums_per_page'));
			return array_slice($this->subalbums, $albums_per_page*($page-1), $albums_per_page);
		}
	}

	/**
	 * Returns a of a slice of the images for this album. They will
	 * also be sorted according to the sort type of this album, or by filename if none
	 * has been set.
	 *
	 * @param  string $page  Which page of images should be returned. If zero, all images are returned.
	 * @param int $firstPageCount count of images that go on the album/image transition page
	 * @param  string $sorttype optional sort type
	 * @param  string $sortdirection optional sort direction
	 * @return array
	 */
	function getImages($page=0, $firstPageCount=0, $sorttype=null, $sortdirection=null) {
		if (is_null($this->images) || $sorttype.$sortdirection !== $this->lastimagesort) {
			if ($this->isDynamic()) {
				$searchengine = $this->getSearchEngine();
				$images = $searchengine->getSearchImages();
			} else {
				// Load, sort, and store the images in this Album.
				$images = $this->loadFileNames();
				$images = $this->sortImageArray($images, $sorttype, $sortdirection);
			}
			$this->images = $images;
			$this->lastimagesort = $sorttype.$sortdirection;
		}
		// Return the cut of images based on $page. Page 0 means show all.
		if ($page == 0) {
			return $this->images;
		} else {
			// Only return $firstPageCount images if we are on the first page and $firstPageCount > 0
			if (($page==1) && ($firstPageCount>0)) {
				$pageStart = 0;
				$images_per_page = $firstPageCount;

			} else {
				if ($firstPageCount>0) {
					$fetchPage = $page - 2;
				} else {
					$fetchPage = $page - 1;
				}
				$images_per_page = max(1, getOption('images_per_page'));
				$pageStart = $firstPageCount + $images_per_page * $fetchPage;

			}
			$slice = array_slice($this->images, $pageStart , $images_per_page);

			return $slice;
		}
	}


	/**
	 * sortImageArray will sort an array of Images based on the given key. The
	 * key must be one of (filename, title, sort_order) at the moment.
	 *
	 * @param array $images The array of filenames to be sorted.
	 * @param  string $sorttype optional sort type
	 * @param  string $sortdirection optional sort direction
	 * @return array
	 */
	function sortImageArray($images, $sorttype=NULL, $sortdirection=NULL) {

		$mine = isMyAlbum($this->name, ALL_RIGHTS);
		$key = $this->getSortKey($sorttype);
		$direction = '';
		if ($key != '`sort_order`') { // manual sort is always ascending
			if (!is_null($sortdirection)) {
				$direction = ' '.$sortdirection;
			} else {
				if ($this->getSortDirection('image')) {
					$direction = ' DESC';
				}
			}
		}
		$result = query($sql = "SELECT `filename`, `title`, `sort_order`, `title`, `show`, `id` FROM " . prefix("images")
										. " WHERE `albumid`= '" . $this->id . "' ORDER BY " . $key . $direction);
		$loop = 0;
		do {
			$hidden = array();
			$results = array();
			while ($row = mysql_fetch_assoc($result)) {
				$results[] = $row;
			}
			if ($key == 'title') {
				$results = sortByMultilingual($results, 'title', $direction == ' DESC');
			} else if ($key == 'filename') {
				if ($direction == 'DESC') $order = 'dsc'; else $order = 'asc';
				$results = sortMultiArray($results, 'filename', $order, true, false);
			}
			$i = 0;
			$flippedimages = array_flip($images);
			$images_to_keys = array();
			$images_in_db = array();
			$images_invisible = array();
				foreach ($results as $row) { // see what images are in the database so we can check for visible
				$filename = $row['filename'];
				if (isset($flippedimages[$filename])) { // ignore db entries for images that no longer exist.
					if ($row['show'] || $mine) {  // unpublished content available only to someone with rights on the album
						$images_to_keys[$filename] = $i;
						$i++;
					}
					$images_in_db[] = $filename;
				} else {
					$id = $row['id'];
					query("DELETE FROM ".prefix('images')." WHERE `id`=$id"); // delete the record
					query("DELETE FROM ".prefix('comments')." WHERE `type` IN (".zp_image_types("'").") AND `ownerid`= '$id'"); // remove image comments
				}
			}
			// Place the images not yet in the database before those with sort columns.
			// This is consistent with the sort oder of a NULL sort_order key in manual sorts
			// but will almost certainly be wrong in all other cases.
			$images_not_in_db = array_diff($images, $images_in_db);
			if (count($images_not_in_db) > 0) {
				$loop ++;
				foreach($images_not_in_db as $filename) {
					$imgobj = newImage($this, $filename); // force it into the database
					$images_to_keys[$filename] = $i;
					$i++;
				}
			} else {
				$loop = 0;
			}
		} while ($loop==1);
		
		$images = array_flip($images_to_keys);
		ksort($images);
		$images_ordered = array();
		foreach($images as $image) {
			$images_ordered[] = $image;
		}
		return $images_ordered;
	}


	/**
	 * Returns the number of images in this album (not counting its subalbums)
	 *
	 * @return int
	 */
	function getNumImages() {
		if (is_null($this->images)) {
			$this->getImages(0);
		}
		return count($this->images);
	}

	/**
	 * Returns an image from the album based on the index passed.
	 *
	 * @param int $index
	 * @return int
	 */
	function getImage($index) {
		$images = $this->getImages();
		if ($index >= 0 && $index < count($images)) {
			if ($this->isDynamic()) {
				$album = new Album($this->gallery, $images[$index]['folder']);
				return newImage($album, $images['filename']);
			} else {
				return newImage($this, $this->images[$index]);
			}
			return false;
		}
	}

	/**
	 * Gets the album's set thumbnail image from the database if one exists,
	 * otherwise, finds the first image in the album or sub-album and returns it
	 * as an Image object.
	 *
	 * @return Image
	 */
	function getAlbumThumbImage() {
		
		if (!is_null($this->albumthumbnail)) return $this->albumthumbnail;

		$albumdir = $this->localpath;
		$thumb = $this->get('thumb');
		$i = strpos($thumb, '/');
		if ($root = ($i === 0)) {
			$thumb = substr($thumb, 1); // strip off the slash
			$albumdir = getAlbumFolder();
		}
		$shuffle = $thumb != '1';
		if (!empty($thumb) && $thumb != '1' && file_exists($albumdir.UTF8ToFilesystem($thumb))) {
			if ($i===false) {
				return newImage($this, $thumb);
			} else {
				$pieces = explode('/', $thumb);
				$i = count($pieces);
				$thumb = $pieces[$i-1];
				unset($pieces[$i-1]);
				$albumdir = implode('/', $pieces);
				if (!$root) { $albumdir = $this->name . "/" . $albumdir; } else { $albumdir = $albumdir . "/";}
				$this->albumthumbnail = newImage(new Album($this->gallery, $albumdir), $thumb);
				return $this->albumthumbnail;
			}
		} else if ($this->isDynamic()) {
			$this->getImages(0, 0, 'ID', 'DESC');
			$thumbs = $this->images;
			if (!is_null($thumbs)) {
				if ($shuffle) {
					shuffle($thumbs);
				}
				while (count($thumbs) > 0) {
					$thumb = array_shift($thumbs);
					if (is_valid_image($thumb['filename'])) {
						$alb = new Album($this->gallery, $thumb['folder']);
						$thumb = newImage($alb, $thumb['filename']);
						if ($thumb->getShow()) {
							$this->albumthumbnail = $thumb;
							return $thumb;
						}
					}
				}
			}
		} else {
			$this->getImages(0, 0, 'ID', 'DESC');
			$thumbs = $this->images;
			if (!is_null($thumbs)) {
				if ($shuffle) {
					shuffle($thumbs);
				}
				while (count($thumbs) > 0) {
					$thumb = array_shift($thumbs);
					if (is_valid_image($thumb)) {
						$thumb = newImage($this, $thumb);
						if ($thumb->getShow()) {
							$this->albumthumbnail = $thumb;
							return $thumb;
						}
					}
				}
			}
			// Otherwise, look in sub-albums.
			$subalbums = $this->getSubAlbums();
			if (!is_null($subalbums)) {
				if ($shuffle) {
					shuffle($subalbums);
				}
				while (count($subalbums) > 0) {
					$folder = array_pop($subalbums);
					$subalbum = new Album($this->gallery, $folder);
					$pwd = $subalbum->getPassword();
					if (($subalbum->getShow() && empty($pwd)) || isMyALbum($folder, ALL_RIGHTS)) {
						$thumb = $subalbum->getAlbumThumbImage();
						if (strtolower(get_class($thumb)) !== 'transientimage' && $thumb->exists) {
							$this->albumthumbnail =  $thumb;
							return $thumb;
						}
					}
				}
			}
			//jordi-kun - no images, no subalbums, check for videos
			$dp = opendir($albumdir);
			while ($thumb = readdir($dp)) {
				if (is_file($albumdir.$thumb) && is_valid_video($thumb)) {
					$othersThumb = checkObjectsThumb($albumdir, $thumb);
					if (!empty($othersThumb)) {
						$thumb = newImage($this, $othersThumb);
						if ($this->getShow()) {
							$this->albumthumbnail = $thumb;
							return $thumb;
						}
					}
				}
			}
		}
		
		$nullimage = SERVERPATH.'/'.ZENFOLDER.'/images/imageDefault.png';
		if (OFFSET_PATH == 0) { // check for theme imageDefault.png if we are in the gallery
			$theme = '';
			$uralbum = getUralbum($this);
			$albumtheme = $uralbum->getAlbumTheme();
			if (!empty($albumtheme)) {
				$theme = $albumtheme;
			} else {
				$theme = $this->gallery->getCurrentTheme();
			}
			if (!empty($theme)) {
				$themeimage = SERVERPATH.'/'.THEMEFOLDER.'/'.$theme.'/images/imageDefault.png';
				if (file_exists(UTF8ToFilesystem($themeimage))) {
					$nullimage = $themeimage;
				}
			}
		}
		$this->albumthumbnail = new transientimage($this, $nullimage);
		return $this->albumthumbnail;
	}

	/**
	 * Gets the thumbnail URL for the album thumbnail image as returned by $this->getAlbumThumbImage();
	 * @return string
	 */
	function getAlbumThumb() {
		$image = $this->getAlbumThumbImage();
		return $image->getThumb('album');
	}

	/**
	 * Stores the thumbnail path for an album thumg
	 *
	 * @param string $filename thumbnail path
	 */
	function setAlbumThumb($filename) { $this->set('thumb', $filename); }

	/**
	 * Returns an URL to the album, including the current page number
	 *
	 * @return string
	 */
	function getAlbumLink() {
		global $_zp_page;

		$rewrite = pathurlencode($this->name) . '/';
		$plain = '/index.php?album=' . urlencode($this->name). '/';
		if ($_zp_page) {
			$rewrite .= "page/$_zp_page";
			$plain .= "&page=$_zp_page";
		}
		return rewrite_path($rewrite, $plain);
	}

	/**
	 * Returns the album following the current album
	 *
	 * @return object
	 */
	function getNextAlbum() {
		if (is_null($parent = $this->getParent())) {
			$albums = $this->gallery->getAlbums(0);
		} else {
			$albums = $parent->getSubAlbums(0);
		}
		$inx = array_search($this->name, $albums)+1;
		if ($inx >= 0 && $inx < count($albums)) {
			return new Album($parent, $albums[$inx]);
		}
		return null;
	}

	/**
	 * Returns the album prior to the current album
	 *
	 * @return object
	 */
	function getPrevAlbum() {
		if (is_null($parent = $this->getParent())) {
			$albums = $this->gallery->getAlbums(0);
		} else {
			$albums = $parent->getSubAlbums(0);
		}
		$inx = array_search($this->name, $albums)-1;
		if ($inx >= 0 && $inx < count($albums)) {
			return new Album($paraent, $albums[$inx]);
		}
		return null;
	}

	/**
	 * Returns the page number in the gallery of this album
	 *
	 * @return int
	 */
	function getGalleryPage() {
		if ($this->index == null)
			$this->index = array_search($this->name, $this->gallery->getAlbums(0));
		return floor(($this->index / galleryAlbumsPerPage())+1);
	}

	/**
	 * changes the parent of an album for move/copy
	 *
	 * @param string $newfolder The folder name of the new parent
	 */
	function updateParent($newfolder) {
		$this->name = $newfolder;
		$parentname = dirname($newfolder);
		if ($parentname == '/' || $parentname == '.') $parentname = '';
		if (empty($parentname)) {
			$this->set('parentid', NULL);
		} else {
			$parent = new Album($this->gallery, $parentname);
			$this->set('parentid', $parent->getAlbumid());
		}
		$this->save();
	}

	/**
	 * Delete the entire album PERMANENTLY. Be careful! This is unrecoverable.
	 * Returns true if successful
	 *
	 * @return bool
	 */
	function deleteAlbum() {
		if (!$this->isDynamic()) {
			foreach ($this->getSubAlbums() as $folder) {
				$subalbum = new Album($album, $folder);
				$subalbum->deleteAlbum();
			}
			foreach($this->getImages() as $filename) {
				$image = newImage($this, $filename);
				$image->deleteImage(true);
			}
			chdir($this->localpath);
			$filelist = safe_glob('*');
			foreach($filelist as $file) {
				if (($file != '.') && ($file != '..')) {
					unlink($this->localpath . $file); // clean out any other files in the folder
				}
			}
		}
		query("DELETE FROM " . prefix('options') . "WHERE `ownerid`=" . $this->id);
		query("DELETE FROM " . prefix('comments') . "WHERE `type`='albums' AND `ownerid`=" . $this->id);
		query("DELETE FROM " . prefix('albums') . " WHERE `id` = " . $this->id);
		if ($this->isDynamic()) {
			return unlink($this->localpath);
		} else {
			return rmdir($this->localpath);
		}
	}

	/**
	 * Move this album to the location specified by $newfolder, copying all
	 * metadata, subalbums, and subalbums' metadata with it.
	 * @param $newfolder string the folder to move to, including the name of the current folder (possibly renamed).
	 * @return boolean true on success and false on failure.
	 *
	 */
	function moveAlbum($newfolder) {
		// First, ensure the new base directory exists.
		if ($this->isDynamic()) { // be sure there is a .alb suffix
			if (substr($newfolder, -4) != '.alb') {
				$newfolder .= '.alb';
			}
		}
		$oldfolder = $this->name;
		$dest = getAlbumFolder().UTF8ToFilesystem($newfolder);
		// Check to see if the destination already exists
		if (file_exists($dest)) {
			// Disallow moving an album over an existing one.
			return false;
		}
		if (substr($newfolder, count($oldfolder)) == $oldfolder) {
			// Disallow moving to a subfolder of the current folder.
			return false;
		}
		if ($this->isDynamic()) {
			if (@rename($this->localpath, $dest))	{
				$oldf = mysql_real_escape_string($oldfolder);
				$sql = "UPDATE " . prefix('albums') . " SET folder='" . mysql_real_escape_string($newfolder) . "' WHERE `id` = '".$this->getAlbumID()."'";
				$success = query($sql);
				$this->updateParent($newfolder);
				if ($success) {
					return $newfolder;
				}
			}
			return false;
		} else {
			if (mkdir_recursive(dirname($dest)) === TRUE) {
				// Make the move (rename).
				$rename = @rename($this->localpath, $dest);
				// Then: rename the cache folder
				$cacherename = @rename(SERVERCACHE . '/' . $oldfolder, SERVERCACHE . '/' . $newfolder);
				// Then: go through the db and change the album (and subalbum) paths. No ID changes are necessary for a move.
				// Get the subalbums.
				$oldf = mysql_real_escape_string($oldfolder);
				$sql = "SELECT id, folder FROM " . prefix('albums') . " WHERE folder LIKE '$oldf%'";
				$result = query_full_array($sql);
				foreach ($result as $subrow) {
					$newsubfolder = $subrow['folder'];
					$newsubfolder = $newfolder . substr($newsubfolder, strlen($oldfolder));
					$newsubfolder = mysql_real_escape_string($newsubfolder);
					$sql = "UPDATE ".prefix('albums'). " SET folder='$newsubfolder' WHERE id=".$subrow['id'];
					$subresult = query($sql);
					// Handle result here.
				}
				$this->updateParent($newfolder);
				return $newfolder;
			}
		}
		return false;
	}
	/**
	 * Rename this album folder. Alias for moveAlbum($newfoldername);
	 * @param $newfolder the new folder name of this album (including subalbum paths)
	 * @return boolean true on success or false on failure.
	 */
	function renameAlbum($newfolder) {
		return $this->moveAlbum($newfolder);
	}

	/**
	 * Replicates the database data for copied albums.
	 * Returns the success of the replication.
	 *
	 * @param array $subrow the Row of data
	 * @param string $oldfolder the folder name of the old album
	 * @param string $newfolder the folder name of the new album
	 * @param bool $owner_row set to true if this is the owner album (and we have to change the parent ID)
	 * @return bool
	 */
	function replicateDBRow($subrow, $oldfolder, $newfolder, $owner_row) {
		$newsubfolder = $subrow['folder'];
		$newsubfolder = $newfolder . substr($newsubfolder, strlen($oldfolder));
		$newsubfolder = mysql_real_escape_string($newsubfolder);
		$subrow['folder'] = $newsubfolder;

		if ($owner_row) {
			$parentname = dirname($newfolder);
			if ($parentname == '/' || $parentname == '.') $parentname = '';
			if (empty($parentname)) {
				$subrow['parentid'] = NULL;
			} else {
				$parent = new Album($this->gallery, $parentname);
				$subrow['parentid'] =  $parent->getAlbumid();
			}
		}

		// From PersistentObject::copy()
		$insert_data = $subrow;
		unset($insert_data['id']);
		if (empty($insert_data)) { return true; }
		$sql = 'INSERT INTO ' . prefix('albums') . ' (';
		$i = 0;
		foreach(array_keys($insert_data) as $col) {
			if ($i > 0) $sql .= ", ";
			$sql .= "`$col`";
			$i++;
		}
		$sql .= ') VALUES (';
		$i = 0;
		foreach(array_values($insert_data) as $value) {
			if ($i > 0) $sql .= ', ';
			if (is_null($value)) {
				$sql .= "NULL";
			} else {
				$sql .= "'" . mysql_real_escape_string($value) . "'";
			}
			$i++;
		}
		$sql .= ');';
		return query($sql);
	}

	/**
	 * Copy this album to the location specified by $newfolder, copying all
	 * metadata, subalbums, and subalbums' metadata with it.
	 * @param $newfolder string the folder to copy to, including the name of the current folder (possibly renamed).
	 * @return boolean true on success and false on failure.
	 *
	 */
	function copyAlbum($newfolder) {
		// First, ensure the new base directory exists.
		$oldfolder = $this->name;
		$dest = getAlbumFolder().'/'.UTF8ToFilesystem($newfolder);
		// Check to see if the destination directory already exists

		if (file_exists($dest)) {
			// Disallow moving an album over an existing one.
			return false;
		}
		if (substr($newfolder, count($oldfolder)) == $oldfolder) {
			// Disallow copying to a subfolder of the current folder (infinite loop).
			return false;
		}
		if ($this->isDynamic()) {
			if (@copy($this->localpath, $dest)) {
				$oldf = mysql_real_escape_string($oldfolder);
				$sql = "SELECT * FROM " . prefix('albums') . " WHERE `id` = '".$this->getAlbumID()."'";
				$subrow = query_single_row($sql);
				$success = $this->replicateDBRow($subrow, $oldfolder, $newfolder, true);
				return $success;
			} else {
				return false;
			}
		} else {
			if (mkdir_recursive(dirname($dest)) === TRUE) {
				// Make the move (rename).
				$num = dircopy($this->localpath, $dest);
				// Get the subalbums.
				$oldf = mysql_real_escape_string($oldfolder);
				$sql = "SELECT * FROM " . prefix('albums') . " WHERE folder LIKE '$oldf%'";
				$result = query_full_array($sql);

				$allsuccess = true;
				foreach ($result as $subrow) {
					$success = $this->replicateDBRow($subrow, $oldfolder, $newfolder, $subrow['folder'] == $oldfolder);
					if (!($success == true && mysql_affected_rows() == 1)) {
						$allsuccess = false;
					}
				}
				return $allsuccess;
			}
		}
		return false;
	}

	/**
	 * Returns true of comments are allowed
	 *
	 * @return bool
	 */
	function getCommentsAllowed() { return $this->get('commentson'); }

	/**
	 * Stores the value for comments allwed
	 *
	 * @param bool $commentson true if comments are enabled
	 */
	function setCommentsAllowed($commentson) { $this->set('commentson', $commentson ? 1 : 0); }

	/**
	 * For every image in the album, look for its file. Delete from the database
	 * if the file does not exist. Same for each sub-directory/album.
	 *
	 * @param bool $deep set to true for a thorough cleansing
	 */
	function garbageCollect($deep=false) {
		if (is_null($this->images)) $this->getImages();
		$result = query("SELECT * FROM ".prefix('images')." WHERE `albumid` = '" . $this->id . "'");
		$dead = array();
		$live = array();

		$files = $this->loadFileNames();

		// Does the filename from the db row match any in the files on disk?
		while($row = mysql_fetch_assoc($result)) {
			if (!in_array($row['filename'], $files)) {
				// In the database but not on disk. Kill it.
				$dead[] = $row['id'];
			} else if (in_array($row['filename'], $live)) {
				// Duplicate in the database. Kill it.
				$dead[] = $row['id'];
				// Do something else here? Compare titles/descriptions/metadata/update dates to see which is the latest?
			} else {
				$live[] = $row['filename'];
			}
		}

		if (count($dead) > 0) {
			$sql = "DELETE FROM ".prefix('images')." WHERE `id` = '" . array_pop($dead) . "'";
			$sql2 = "DELETE FROM ".prefix('comments')." WHERE `type`='albums' AND `ownerid` = '" . array_pop($dead) . "'";
			foreach ($dead as $id) {
				$sql .= " OR `id` = '$id'";
				$sql2 .= " OR `ownerid` = '$id'";
			}
			query($sql);
			query($sql2);
		}

		// Get all sub-albums and make sure they exist.
		$result = query("SELECT * FROM ".prefix('albums')." WHERE `folder` LIKE '" . mysql_real_escape_string($this->name) . "/%'");
		$dead = array();
		$live = array();
		// Does the dirname from the db row exist on disk?
		while($row = mysql_fetch_assoc($result)) {
			if (!is_dir(getAlbumFolder() . UTF8ToFilesystem($row['folder'])) || in_array($row['folder'], $live)
			|| substr($row['folder'], -1) == '/' || substr($row['folder'], 0, 1) == '/') {
				$dead[] = $row['id'];
			} else {
				$live[] = $row['folder'];
			}
		}
		if (count($dead) > 0) {
			$sql = "DELETE FROM ".prefix('albums')." WHERE `id` = '" . array_pop($dead) . "'";
			$sql2 = "DELETE FROM ".prefix('comments')." WHERE `type`='albums' AND `ownerid` = '" . array_pop($dead) . "'";
			foreach ($dead as $albumid) {
				$sql .= " OR `id` = '$albumid'";
				$sql2 .= " OR `ownerid` = '$albumid'";
			}
			query($sql);
			query($sql2);
		}

		if ($deep) {
			foreach($this->getSubAlbums(0) as $dir) {
				$subalbum = new Album($this->gallery, $dir);
				// Could have been deleted if it didn't exist above...
				if ($subalbum->exists)
				$subalbum->garbageCollect($deep);
			}
		}
	}


	/**
	 * Simply creates objects of all the images and sub-albums in this album to
	 * load accurate values into the database.
	 */
	function preLoad() {
		if (!$this->isDynamic()) return; // nothing to do
		$images = $this->getImages(0);
		$subalbums = $this->getSubAlbums(0);
		foreach($subalbums as $dir) {
			$album = new Album($this->gallery, $dir);
			$album->preLoad();
		}
	}


	/**
	 * Load all of the filenames that are found in this Albums directory on disk.
	 * Returns an array with all the names.
	 *
	 * @param  $dirs Whether or not to return directories ONLY with the file array.
	 * @return array
	 */
	function loadFileNames($dirs=false) {
		if ($this->isDynamic()) {  // there are no 'real' files
			return array();
		}
		$albumdir = $this->localpath;
		if (!is_dir($albumdir) || !is_readable($albumdir)) {
			if (!is_dir($albumdir)) {
				$msg = sprintf(gettext("Error: The album %s cannot be found."), $this->name);
			} else {
				$msg = sprintf(gettext("Error: The album %s is not readable."), $this->name);
			}
			die($msg);
		}
		$dir = opendir($albumdir);
		$files = array();
		$others = array();

		while (false !== ($file = readdir($dir))) {
			$file8 = FilesystemToUTF8($file);
			if ($dirs && (is_dir($albumdir.$file) && (substr($file, 0, 1) != '.') || hasDyanmicAlbumSuffix($file))) {
				$files[] = $file8;
			} else if (!$dirs && is_file($albumdir.$file)) {
				if (is_valid_other_type($file)) {
					$files[] = $file8;
					$others[] = $file8;
				} else if (is_valid_image($file)) {
					$files[] = $file8;
				}
			}
		}
		closedir($dir);
		if (count($others) > 0) {
			$others_thumbs = array();
			foreach($others as $other) {
				$others_root = substr($other, 0, strrpos($other,"."));
				foreach($files as $image) {
					$image_root = substr($image, 0, strrpos($image,"."));
					if ($image_root == $others_root && $image != $other) {
						$others_thumbs[] = $image;
					}
				}
			}
			$files = array_diff($files, $others_thumbs);
		}

		if ($dirs) $filter = 'album_filter'; else $filter = 'image_filter';
		return apply_filter($filter, $files);
	}

	/**
	 * Returns an array of comments for this album
	 *
	 * @param bool $moderated if false, ignores comments marked for moderation
	 * @param bool $private if false ignores private comments
	 * @param bool $desc set to true for descending order
	 * @return array
	 */
	function getComments($moderated=false, $private=false, $desc=false) {
		$sql = "SELECT *, (date + 0) AS date FROM " . prefix("comments") .
 			" WHERE `type`='albums' AND `ownerid`='" . $this->id . "'";
		if (!$moderated) {
			$sql .= " AND `inmoderation`=0";
		}
		if (!$private) {
			$sql .= " AND `private`=0";
		}
		$sql .= " ORDER BY id";
		if ($desc) {
			$sql .= ' DESC';
		}
		$comments = query_full_array($sql);
		$this->comments = $comments;
		return $this->comments;
	}

	/**
	 * Adds comments to the album
	 * assumes data is coming straight from GET or POST
	 *
	 * Returns a code for the success of the comment add:
	 *    0: Bad entry
	 *    1: Marked for moderation
	 *    2: Successfully posted
	 *
	 * @param string $name Comment author name
	 * @param string $email Comment author email
	 * @param string $website Comment author website
	 * @param string $comment body of the comment
	 * @param string $code Captcha code entered
	 * @param string $code_ok Captcha md5 expected
	 * @param string $ip the IP address of the comment poster
	 * @param bool $private set to true if the comment is for the admin only
	 * @param bool $anon set to true if the poster wishes to remain anonymous
	 * @return int
	 */
	function addComment($name, $email, $website, $comment, $code, $code_ok, $ip, $private, $anon) {
		$goodMessage = postComment($name, $email, $website, $comment, $code, $code_ok, $this, $ip, $private, $anon);
		return $goodMessage;
	}

	/**
	 * Returns the count of comments in the album. Ignores comments in moderation
	 *
	 * @return int
	 */
	function getCommentCount() {
		if (is_null($this->commentcount)) {
			if ($this->comments == null) {
				$count = query_single_row("SELECT COUNT(*) FROM " . prefix("comments") . " WHERE `type`='albums' AND `inmoderation`=0 AND `private`=0 AND `ownerid`=" . $this->id);
				$this->commentcount = array_shift($count);
			} else {
				$this->commentcount = count($this->comments);
			}
		}
		return $this->commentcount;
	}

	/**
	 * returns the custom data field
	 *
	 * @return string
	 */
	function getCustomData() {
		$t =  $this->get('custom_data');
		return get_language_string($t);
	}

	/**
	 * Sets the custom data field
	 *
	 * @param string $val the value to be put in custom_data
	 */
	function setCustomData($val) { $this->set('custom_data', $val); }

	/**
	 * Returns true if the album is "dynamic"
	 *
	 * @return bool
	 */
	function isDynamic() {
		return $this->get('dynamic');
	}

	/**
	 * Returns the search parameters for a dynamic album
	 *
	 * @return string
	 */
	function getSearchParams() {
		return $this->get('search_params');
	}

	/**
	 * Sets the search parameters of a dynamic album
	 *
	 * @param string $params The search string to produce the dynamic album
	 */
	function setSearchParams($params) {
		$this->set('search_params', $params);
	}

	/**
	 * Returns the search engine for a dynamic album
	 *
	 * @return object
	 */
	function getSearchEngine() {
		if (!$this->isDynamic()) return null;
		if (!is_null($this->searchengine)) return $this->searchengine;
		$this->searchengine = new SearchEngine();
		$params = $this->getSearchParams();
		$params .= '&albumname='.$this->name;
		$this->searchengine->setSearchParams($params);
		return $this->searchengine;
	}

	/**
	 * Returns the theme for the album
	 *
	 * @return string
	 */
	function getAlbumTheme() {
		return $this->get('album_theme');
	}
	/**
	 * Sets the theme of the album
	 *
	 * @param string $theme
	 */
	function setAlbumTheme($theme) {
		$this->set('album_theme', $theme);
	}

}
?>