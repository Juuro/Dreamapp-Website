<?php
/**
 * search class
 * @package classes
 */

// force UTF-8 Ø


//*************************************************************
//*ZENPHOTO SEARCH ENGINE CLASS *******************************
//*************************************************************
define('SEARCH_TITLE', 0x1);
define('SEARCH_DESC', 0x2);
define('SEARCH_TAGS', 0x4);
define('SEARCH_FILENAME', 0x8); // includes folder for albums
define('SEARCH_LOCATION', 0x10);
define('SEARCH_CITY', 0x20);
define('SEARCH_STATE', 0x40);
define('SEARCH_COUNTRY', 0x80);
define('SEARCH_EXIFMake', 0x100);
define('SEARCH_EXIFModel', 0x200); 
define('SEARCH_EXIFExposureTime', 0x400);
define('SEARCH_EXIFFNumber', 0x800);
define('SEARCH_EXIFFocalLength', 0x1000);
define('SEARCH_EXIFISOSpeedRatings', 0x2000);
define('SEARCH_EXIFExposureBiasValue', 0x4000);
define('SEARCH_EXIFMeteringMode', 0x8000);
define('SEARCH_EXIFFlash', 0x10000);
define('SEARCH_EXIFContrast', 0x20000);
define('SEARCH_EXIFSharpness',  0x40000);
define('SEARCH_EXIFSaturation', 0x80000);
define('SEARCH_EXIFWhiteBalance',	0x100000);

class SearchEngine
{
	var $words;
	var $dates;
	var $fields;
	var $page;
	var $images;
	var $albums;
	var $dynalbumname;
	var $zp_search_fields;			// translatable names
	var $zp_search_fieldnames;	// database field names
	var $zp_search_all_fields;
	
	/**
	 * Constuctor
	 *
	 * @return SearchEngine
	 */
	function SearchEngine() {
		$this->zp_search_fields= array (gettext('Title')=>SEARCH_TITLE, gettext('Description')=>SEARCH_DESC, gettext('Tags')=>SEARCH_TAGS,
																		gettext('File/Folder name')=>SEARCH_FILENAME,
																		gettext('Location')=>SEARCH_LOCATION, gettext('City')=>SEARCH_CITY, gettext('State')=>SEARCH_STATE,
																		gettext('Country')=>SEARCH_COUNTRY, 
																		gettext('Camera Maker')=>SEARCH_EXIFMake, gettext('Camera Model')=>SEARCH_EXIFModel,
																		gettext('Shutter Speed')=>SEARCH_EXIFExposureTime, gettext('Aperture')=>SEARCH_EXIFFNumber, gettext('Focal Length')=>SEARCH_EXIFFocalLength, gettext('ISO Sensitivity')=>SEARCH_EXIFISOSpeedRatings,
																		gettext('Exposure Compensation')=>SEARCH_EXIFExposureBiasValue, gettext('Metering Mode')=>SEARCH_EXIFMeteringMode, gettext('Flash Fired')=>SEARCH_EXIFFlash,
																		gettext('Contrast Setting')=>SEARCH_EXIFContrast, gettext('Sharpness Setting')=>SEARCH_EXIFSharpness, gettext('Saturation Setting')=>SEARCH_EXIFSaturation,
																		gettext('White Balance')=>SEARCH_EXIFWhiteBalance
																		);
		
		$this->zp_search_fieldnames = array ('title'=>SEARCH_TITLE, 'desc'=>SEARCH_DESC,'File/Folder name'=>SEARCH_FILENAME,
																				'Location'=>SEARCH_LOCATION, 'City'=>SEARCH_CITY, 'State'=>SEARCH_STATE,
																				'Country'=>SEARCH_COUNTRY,
																				'EXIFMake'=>SEARCH_EXIFMake, 'EXIFModel'=>SEARCH_EXIFModel,
																				'EXIFExposureTime'=>SEARCH_EXIFExposureTime, 'EXIFFNumber'=>SEARCH_EXIFFNumber, 'EXIFFocalLength'=>SEARCH_EXIFFocalLength, 'EXIFISOSpeedRatings'=>SEARCH_EXIFISOSpeedRatings,
																				'EXIFExposureBiasValue'=>SEARCH_EXIFExposureBiasValue, 'EXIFMeteringMode'=>SEARCH_EXIFMeteringMode, 'EXIFFlash'=>SEARCH_EXIFFlash,
																				'EXIFContrast'=>SEARCH_EXIFContrast, 'EXIFSharpness'=>SEARCH_EXIFSharpness, 'EXIFSaturation'=>SEARCH_EXIFSaturation,
																				'EXIFWhiteBalance'=>SEARCH_EXIFWhiteBalance
																				);
																		
		$this->zp_search_all_fields = SEARCH_TAGS;
		foreach ($this->zp_search_fieldnames as $value) {
			$this->zp_search_all_fields = $this->zp_search_all_fields + $value;		
		}		
		
		if (isset($_REQUEST['words'])) {
			$this->words = $_REQUEST['words'];
		} else {
			$this->words = '';
		}
		if (isset($_REQUEST['date'])) {
			$this->dates = sanitize($_REQUEST['date'], 3);
		} else {
			$this->dates = '';
		}
		$this->fields = $this->parseQueryFields();
		$this->images = null;
		$this->albums = null;
	}

	/**
	 * Returns an array of the enabled search fields
	 *
	 * @return array
	 */
	function allowedSearchFields() {
		$fields = getOption('search_fields');
		$setlist = array();
		foreach ($this->zp_search_fields as $key=>$value) {
			if ($fields & $value) {
				$setlist[$key] = $value;
			}
		}
		return $setlist;
	}
	
	/**
	 * returns the search fields bitmap
	 *
	 * @return bits
	 */
	function getFields() {
		$fields = $this->fields;
		if ($fields == $this->zp_search_all_fields) $fields = 0;
		return $fields;
	}
	
	/**
	 * creates a search query from the search words
	 *
	 * @return string
	 */
	function getSearchParams() {
		global $_zp_page;
		$r = '';
		$w = urlencode(trim($this->words));
		if (!empty($w)) { $r .= '&words=' . $w; }
		$d = trim($this->dates);
		if (!empty($d)) { $r .= '&date=' . $d; }
		$f = trim($this->fields);
		if (!empty($f)) { $r .= '&searchfields=' . $f; }
		$a = $this->dynalbumname;
		if ($a) { $r .= '&albumname=' . $a; }
		if ($_zp_page != 1) {
			$this->page = $_zp_page;
			$r .= '&page=' . $_zp_page;
		}
		return $r;
	}
	/**
	 * Parses and stores a search string
	 * NOTE!! this function assumes that the 'words' part of the list has been urlencoded!!!
	 *
	 * @param string $paramstr the string containing the search words
	 */
	function setSearchParams($paramstr) {
		$params = explode('&', $paramstr);
		foreach ($params as $param) {
			$e = strpos($param, '=');
			$p = substr($param, 0, $e);
			$v = substr($param, $e + 1);
			switch($p) {
				case 'words':
					$this->words = urldecode($v);
					break;
				case 'date':
					$this->dates = $v;
					break;
				case 'searchfields':
					$this->fields = $v;
					break;
				case 'page':
					$this->page = $v;
					break;
				case 'albumname':
					$this->dynalbumname = $v;
					break;
			}
		}
	}

	/**
	 * Returns the search words variable
	 *
	 * @return string
	 */
	function getSearchWords() {
		return $this->words;
	}

	/**
	 * Returns the search dates variable
	 *
	 * @return string
	 */
	function getSearchDate() {
		return $this->dates;
	}

	/**
	 * Returns the search fields variable
	 *
	 * @return bit
	 */
	function getSearchFields() {
		return $this->fields;
	}

	/**
	 * Parses a search string
	 * Items within quotations are treated as atomic
	 * AND, OR and NOT are converted to &, |, and !
	 *
	 * Returns an array of search elements
	 *
	 * @return array
	 */
	function getSearchString() {
		$searchstring = trim($this->words);
		$opChars = array ('&'=>1, '|'=>1, '!'=>1, ','=>1, '('=>2);
		$c1 = ' ';
		$result = array();
		$target = "";
		$i = 0;
		do {
			$c = substr($searchstring, $i, 1);
			switch ($c) {
				case "'":
				case '"':
				case '`':
					$j = strpos($searchstring, $c, $i+1);
					if ($j !== false) {
						$target .= substr($searchstring, $i+1, $j-$i-1);
						$i = $j;
					} else {
						$target .= $c;
					}
					$c1 = $c;
					break;
				case ',':
					if (!empty($target)) {
						$r = trim($target);
						if (!empty($r)) {
							$result[] = $r;
							$target = '';
						}
					}
					$c2 = substr($searchstring, $i+1, 1);
					if (!(isset($opChars[$c2]) || isset($opChars[$c1]))) {
						$result[] = '|';
						$c1 = $c;
					}
					break;
				case '&':
				case '|':
				case '!':
				case '(':
				case ')':
					if (!empty($target)) {
						$r = trim($target);
						if (!empty($r)) {
							$result[] = $r;
							$target = '';
						}
					}
					$c1 = $c;
					$target = '';
					$result[] = $c;
					break;
				case 'A':
					if (substr($searchstring, $i, 4) == 'AND ') {
						$searchstring = substr($searchstring, 3);
						if (!empty($target)) {
							$r = trim($target);
							if (!empty($r)) {
								$result[] = $r;
								$target = '';
							}
						}
						$c1 = $c;
						$target = '';
						$result[] = '&';
						break;
					}
				case 'O':
					if (substr($searchstring, $i, 3) == 'OR ') {
						$searchstring = substr($searchstring, 2);
						if (!empty($target)) {
							$r = trim($target);
							if (!empty($r)) {
								$result[] = $r;
								$target = '';
							}
						}
						$c1 = $c;
						$target = '';
						$result[] = '|';
						break;
					}
				case 'N':
					if (substr($searchstring, $i, 4) == 'NOT ') {
						$searchstring = substr($searchstring, 3);
						if (!empty($target)) {
							$r = trim($target);
							if (!empty($r)) {
								$result[] = $r;
								$target = '';
							}
						}
						$c1 = $c;
						$target = '';
						$result[] = '!';
						break;
					}
					default:
					$c1 = $c;
					$target .= $c;
					break;
			}
		} while ($i++ < strlen($searchstring));
		if (!empty($target)) { $result[] = trim($target); }
		return $result;
	}

	/**
	 * Returns the number of albums found in a search
	 *
	 * @return int
	 */
	function getNumAlbums() {
		if (is_null($this->albums)) {
			$this->getAlbums(0);
		}
		return count($this->albums);
	}

	/**
	 * Returns the set of fields from the url query/post
	 * @return int
	 * @since 1.1.3
	 */
	function parseQueryFields() {
		if (isset($_REQUEST['searchfields'])) {
			$fields = 0+strip($_GET['searchfields']);
		} else {
			$fields = 0;
			foreach ($_REQUEST as $key=>$value) {
				if (strpos($key, '_SEARCH_') !== false) {
					$fields = $fields | $value;
				}
			}
		}
		if ($fields == 0) {
			$fields = ~0 & getOption('search_fields');
		}
		return $fields;
	}

	/**
	 * returns the sql string for a search
	 * @param string $searchstring the search target
	 * @param string $searchdate the date target
	 * @param string $tbl the database table to search
	 * @param int $fields which fields to perform the search on
	 * @return string
	 * @since 1.1.3
	 */
	function getSearchSQL($searchstring, $searchdate, $tbl, $fields) {
		global $_zp_current_album;
		$sql = 'SELECT DISTINCT `id`, `show`,`title`,`desc`';
		if ($tbl=='albums') {
			$fields = $fields & (SEARCH_TITLE + SEARCH_DESC + SEARCH_FILENAME); // these are all albums have
			$sql .= ",`folder`";
		} else {
			$sql .= ",`albumid`,`filename`,`location`,`city`,`state`,`country`";
		}
		$sql .= " FROM ".prefix($tbl)." WHERE ";
		if(!zp_loggedin()) { $sql .= "`show` = 1 AND ("; }
		$join = "";
		$nrt = 0;
		foreach($searchstring as $singlesearchstring){
			switch ($singlesearchstring) {
				case '&':
					$join .= " AND ";
					break;
				case '!':
					$join .= " NOT ";
					break;
				case '|':
					$join .= " OR ";
					break;
				case '(':
				case ')':
					$join .= $singlesearchstring;
					break;
				default:
					$subsql = "";
					$nr = 0;
					$singlesearchstring = sanitize($singlesearchstring, 3);
					
					foreach ($this->zp_search_fieldnames as $fieldname=>$value) {
						if (($value & $fields)) {
							if ($value == SEARCH_FILENAME) {
								if ($tbl == 'albums') {
									$fieldname = 'folder';
								} else {
									$fieldname = 'filename';
								}
							} else {
								$fieldname = strtolower($fieldname);
							}
							$nr++;
							if ($nr > 1) { $subsql .= " OR "; } // add OR for more searchstrings
							$subsql .= ' `'.$fieldname.'` LIKE "%'.mysql_real_escape_string($singlesearchstring).'%"';
						}
					}					
					if ($nr > 0) {
						$nrt++;
						$sql .= $join;
						$join = "";
						$sql .= "($subsql)";
					}
			}
		}
		$sql .= $join;

		if (!empty($searchdate)) {
			if ($nrt > 1) { $sql = $sql." AND "; }
			$nrt++;
			if ($searchdate == "0000-00") {
				$sql .= "`date`=\"0000-00-00 00:00:00\"";
			} else {
				$d1 = $searchdate."-01 00:00:00";
				$d = strtotime($d1);
				$d = strtotime('+ 1 month', $d);
				$d2 = substr(date('Y-m-d H:m:s', $d), 0, 7) . "-01 00:00:00";
				$sql .= "`date` >= \"$d1\" AND `date` < \"$d2\"";
			}
		}

		if(!zp_loggedin()) { $sql .= ")"; }
		if ($nrt == 0) { return NULL; } // no valid fields
		if ($tbl == 'albums') {
			if (empty($this->dynalbumname)) {
				$key = subalbumSortKey(getOption('gallery_sorttype'));
				if ($key != '`sort_order`') {
					if (getOption('gallery_sortdirection')) {
						$key .= " DESC";
					}
				}
			} else {
				$gallery = new Gallery();
				$album = new Album($gallery, $this->dynalbumname);
				$key = $album->getSubalbumSortKey();
				if ($key != '`sort_order`') {
					if ($album->getSortDirection('album')) {
						$key .= " DESC";
					}
				}
			}
		} else {
			$hidealbums = getNotViewableAlbums();
			if (!is_null($hidealbums)) {
				foreach ($hidealbums as $id) {
					$sql .= ' AND `albumid`!='.$id;
				}
			}
			if (empty($this->dynalbumname)) {
				$key = albumSortKey(getOption('image_sorttype'));
				if ($key != '`sort_order`') {
					if (getOption('image_sortdirection')) {
						$key .= " DESC";
					}
				}
			} else {
				$gallery = new Gallery();
				$album = new Album($gallery, $this->dynalbumname);
				$key = $album->getSortKey();
				if ($key != '`sort_order`') {
					if ($album->getSortDirection('image')) {
						$key .= " DESC";
					}
				}
			}
		}
		$sql .= " ORDER BY ".$key;
		return $sql;
	}

	/**
	 * Searches the table for tags
	 * Returns an array of database records.
	 *
	 * @param string $searchstring
	 * @param string $tbl set to 'albums' or 'images'
	 * @param array $idlist list of ids seeding the search from the other fields
	 * @return array
	 */
	function searchTags($searchstring, $tbl, $idlist) {
		$allIDs = null;
		$exact = getOption('exact_tag_match');
		$sql = 'SELECT t.`name`, o.`objectid` FROM '.prefix('tags').' AS t, '.prefix('obj_to_tag').' AS o WHERE t.`id`=o.`tagid` AND o.`type`="'.$tbl.'" AND (';
		foreach($searchstring as $singlesearchstring){
			switch ($singlesearchstring) {
				case '&':
				case '!':
				case '|':
				case '(':
				case ')':
					break;
				default:
					$targetfound = true;
					if ($exact) {
						$sql .= '`name` = "'.mysql_real_escape_string($singlesearchstring).'" OR ';
					} else {
						$sql .= '`name` LIKE "%'.mysql_real_escape_string($singlesearchstring).'%" OR ';
					}
			}
		}
		$sql = substr($sql, 0, strlen($sql)-4).') ORDER BY t.`id`';
		$objects = query_full_array($sql, true);
		if (is_array($objects)) {
			$tagid = '';
			$taglist = array();

			foreach ($objects as $object) {
				$tagid = strtolower($object['name']);
				if (!isset($taglist[$tagid]) || !is_array($taglist[$tagid])) {
					$taglist[$tagid] = array();
				}
				$taglist[$tagid][] = $object['objectid'];
			}
			$op = '';
			$idstack = array();
			$opstack = array();
			while (count($searchstring) > 0) {
				$singlesearchstring = array_shift($searchstring);
				switch ($singlesearchstring) {
					case '&':
					case '!':
					case '|':
						$op = $op.$singlesearchstring;
						break;
					case '(':
						array_push($idstack, $idlist);
						array_push($opstack, $op);
						$idlist = array();
						$op = '';
						break;
					case ')':
						$objectid = $idlist;
						$idlist = array_pop($idstack);
						$op = array_pop($opstack);
						switch ($op) {
							case '&':
								if (is_array($objectid)) {
									$idlist = array_intersect($idlist, $objectid);
								} else {
									$idlist = array();
								}
								break;
							case '!':
								break; // what to do with initial NOT?
							case '&!':
								if (is_array($objectid)) {
									$idlist = array_diff($idlist, $objectid);
								}
								break;
							case '';
							case '|':
								if (is_array($objectid)) {
									$idlist = array_merge($idlist, $objectid);
								}
								break;
						}
						$op = '';
						break;
							default:
								$lookfor = strtolower($singlesearchstring);
								$objectid = NULL;
								foreach ($taglist as $key => $objlist) {
									if (($exact && $lookfor == $key) || (!$exact && preg_match('%'.$lookfor.'%', $key))) {
										if (is_array($objectid)) {
											$objectid = array_merge($objectid, $objlist);
										} else {
											$objectid = $objlist;
										}
									}
								}
								switch ($op) {
									case '&':
										if (is_array($objectid)) {
											$idlist = array_intersect($idlist, $objectid);
										} else {
											$idlist = array();
										}
										break;
									case '!':
										if (is_null($allIDs)) {
											$allIDs = array();
											$result = query_full_array("SELECT `id` FROM ".prefix($tbl));
											if (is_array($result)) {
												foreach ($result as $row) {
													$allIDs[] = $row['id'];
												}
											}
										}
										$idlist = array_merge($idlist, array_diff($allIDs, $objectid));
										break;
									case '&!':
										if (is_array($objectid)) {
											$idlist = array_diff($idlist, $objectid);
										}
										break;
									case '';
									case '|':
										if (is_array($objectid)) {
											$idlist = array_merge($idlist, $objectid);
										}
										break;
								}
								$idlist = array_unique($idlist);
								$op = '';
								break;
				}
				$idlist = array_unique($idlist);
			}
		}
		if (count($idlist)==0) {return NULL; }

		$sql = 'SELECT DISTINCT `id`,`show`,`title`,`desc`,';
		if ($tbl=='albums') {
			$sql .= "`folder` ";
		} else {
			$sql .= "`albumid`,`filename`,`location`,`city`,`state`,`country` ";
		}
		$sql .= "FROM ".prefix($tbl)." WHERE ";
		if(!zp_loggedin()) { $sql .= "`show` = 1 AND "; }
		$sql .= "(";
		foreach ($idlist as $object) {
			$sql .= '(`id`='.$object.') OR ';
		}
		$sql = substr($sql, 0, strlen($sql)-4).')';

		if ($tbl == 'albums') {
			if (empty($this->dynalbumname)) {
				$key = subalbumSortKey(getOption('gallery_sorttype'));
				if (getOption('gallery_sortdirection')) { $key .= " DESC"; }
			} else {
				$gallery = new Gallery();
				$album = new Album($gallery, $this->dynalbumname);
				$key = $album->getSubalbumSortKey();
				if ($key != '`sort_order`') {
					if ($album->getSortDirection('album')) {
						$key .= " DESC";
				 }
				}
			}
		} else {
			if (empty($this->dynalbumname)) {
				$key = albumSortKey(getOption('image_sorttype'));
				if (getOption('image_sortdirection')) { $key .= " DESC"; }
			} else {
				$gallery = new Gallery();
				$album = new Album($gallery, $this->dynalbumname);
				$key = $album->getSortKey();
				if ($key != '`sort_order`') {
					if ($album->getSortDirection('image')) {
						$key .= " DESC";
					}
				}
			}
		}
		$sql .= " ORDER BY ".$key."";
		$result = query_full_array($sql);
		return $result;
	}

	/**
	 * Returns an array of albums found in the search
	 *
	 * @return array
	 */
	function getSearchAlbums() {
		$albums = array();
		$searchstring = $this->getSearchString();
		$albumfolder = getAlbumFolder();
		if (empty($searchstring)) { return $albums; } // nothing to find
		$fields = $this->fields;
		$tagsSearch = $fields & SEARCH_TAGS;
		$fields = $fields & ~SEARCH_TAGS;
		$sql = $this->getSearchSQL($searchstring, '', 'albums', $fields);
		if (!empty($sql)) { // valid fields exist
			$search_results = query_full_array($sql, true);
		}
		if ($tagsSearch && count($searchstring) > 0) {
			$idlist = array();
			if (isset($search_results) && is_array($search_results)) {
				foreach ($search_results as $row) {
					$idlist[] = $row['id'];
				}
			}
			$search_results = $this->searchTags($searchstring, 'albums', $idlist);
		}

		if (isset($search_results) && is_array($search_results)) {
			foreach ($search_results as $row) {
				$albumname = $row['folder'];
				if ($albumname != $this->dynalbumname) {
					if (file_exists($albumfolder . UTF8ToFilesystem($albumname))) {
						if (checkAlbumPassword($albumname, $hint)) {
							$albums[] = $row['folder'];
						}
					}
				}
			}
		}
		return $albums;

	}

	/**
	 * Returns an array of album names found in the search.
	 * If $page is not zero, it returns the current page's albums
	 *
	 * @param int $page the page number we are on
	 * @return array
	 */
	function getAlbums($page=0) {
		if (is_null($this->albums)) {
			$this->albums = $this->getSearchAlbums();
		}
		if ($page == 0) {
			return $this->albums;
		} else {
			$albums_per_page = max(1, getOption('albums_per_page'));
			return array_slice($this->albums, $albums_per_page*($page-1), $albums_per_page);
		}
	}

	/**
	 * Returns the index of the album within the search albums
	 *
	 * @param string $curalbum The album sought
	 * @return int
	 */
	function getAlbumIndex($curalbum) {
		$albums = $this->getAlbums(0);
		return array_search($curalbum, $albums);
	}

	/**
	 * Returns the album following the current one
	 *
	 * @param string $curalbum the name of the current album
	 * @return object
	 */
	function getNextAlbum($curalbum) {
		$albums = $this->getAlbums(0);
		$inx = array_search($curalbum, $albums)+1;
		if ($inx >= 0 && $inx < count($albums)) {
			$gallery = new Gallery();
			return new Album($gallery, $albums[$inx]);
		}
		return null;
	}

	/**
	 * Returns the album preceding the current one
	 *
	 * @param string $curalbum the name of the current album
	 * @return object
	 */
	function getPrevAlbum($curalbum) {
		$albums = $this->getAlbums(0);
		$inx = array_search($curalbum, $albums)-1;
		if ($inx >= 0 && $inx < count($albums)) {
			$gallery = new Gallery();
			return new Album($gallery, $albums[$inx]);
		}
		return null;
	}


	/**
	 * Returns the number of images found in the search
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
	 * Returns an array of image names found in the search
	 *
	 * @return array
	 */
	function getSearchImages() {
		$images = array();
		$searchstring = $this->getSearchString();
		$searchdate = $this->dates;
		if (empty($searchstring) && empty($searchdate)) { return $images; } // nothing to find
		$albumfolder = getAlbumFolder();
		$fields = $this->fields;
		$tagsSearch = $fields & SEARCH_TAGS;
		$fields = $fields & ~SEARCH_TAGS;
		$sql = $this->getSearchSQL($searchstring, $searchdate, 'images', $fields);
		if (!empty($sql)) {  // valid fields exist
			$search_results = query_full_array($sql, true);			
		}
		if ($tagsSearch && count($searchstring) > 0) {
			$idlist = array();
			if (isset($search_results) && is_array($search_results)) {
				foreach ($search_results as $row) {
					$idlist[] = $row['id'];
				}
			}
			$search_results = $this->searchTags($searchstring, 'images', $idlist);
		}
		if (isset($search_results) && is_array($search_results)) {
			foreach ($search_results as $row) {
				$albumid = $row['albumid'];
				$query = "SELECT id, title, folder,`show` FROM ".prefix('albums')." WHERE id = $albumid";
				$row2 = query_single_row($query); // id is unique
				$albumname = $row2['folder'];
				if (file_exists($albumfolder . UTF8ToFilesystem($albumname) . '/' . UTF8ToFilesystem($row['filename']))) {
					if (checkAlbumPassword($albumname, $hint)) {
						$images[] = array('filename' => $row['filename'], 'folder' => $albumname);
					}
				}
			}
		}
		return $images;
	}

	/**
	 * Returns an array of images found in the search
	 * It will return a "page's worth" if $page is non zero
	 *
	 * @param int $page the page number desired
	 * @param int $firstPageCount count of images that go on the album/image transition page
	 * @return array
	 */
	function getImages($page=0, $firstPageCount=0) {
		if (is_null($this->images)) {
			$this->images = $this->getSearchImages();
		}
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
	 * Returns the index of this image in the search images
	 *
	 * @param string $album The folder name of the image
	 * @param string $filename the filename of the image
	 * @return int
	 */
	function getImageIndex($album, $filename) {
		if (is_null($this->images)) {
			$this->images = $this->getSearchImages();
		}
		$images = $this->getImages();
		$c = 0;
		foreach($images as $image) {
			if (($album == $image['folder']) && ($filename == $image['filename'])) {
				return $c;
			}
			$c++;
		}
		return false;
	}
	/**
	 * Returns a specific image
	 *
	 * @param int $index the index of the image desired
	 * @return object
	 */
	function getImage($index) {
		global $_zp_gallery;
		if (!is_null($this->images)) {
			$this->getImages();
		}
		if ($index >= 0 && $index < $this->getNumImages()) {
			$img = $this->images[$index];
			return newImage(new Album($_zp_gallery, $img['folder']), $img['filename']);
		}
		return false;
	}

} // search class end



?>