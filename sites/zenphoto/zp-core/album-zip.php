<?php
if (!defined('OFFSET_PATH')) define('OFFSET_PATH', 1);
require_once(dirname(__FILE__).'/functions.php');
require_once(dirname(__FILE__).'/auth_zp.php');

if(isset($_GET['album']) && is_dir(realpath(getAlbumFolder() . UTF8ToFilesystem($_GET['album'])))){
	createAlbumZip(sanitize_path($_GET['album']));
}

/**
 * Adds a subalbum to the zipfile being created
 *
 * @param string $base the directory of the base album
 * @param string $offset the from $base to the subalbum
 * @param string $subalbum the subalbum file name
 */
function zipAddSubalbum($base, $offset, $subalbum) {
	global $_zp_zip_list;
	$leadin = str_replace(getAlbumFolder(), '', $base);
	if (checkAlbumPassword($leadin.$offset.$subalbum, $hint)) {
		$new_offset = $offset.$subalbum.'/';
		$rp = $base.$new_offset;
		$cwd = getcwd();
		chdir($rp);
		if ($dh = opendir($rp)) {
			$_zp_zip_list[] = "./".$new_offset.'*.*';
			while (($file = readdir($dh)) !== false) {
				if($file != '.' && $file != '..'){
					if (is_dir($rp.$file)) {
						zipAddSubalbum($base, $new_offset, $file, $zip);
					}
				}
			}
			closedir($dh);
		}
		chdir($cwd);
	}
}

/**
 * Creates a zip file of the album
 *
 * @param string $album album folder
 */
function createAlbumZip($album){
	global $_zp_zip_list;
	if (!checkAlbumPassword($album, $hint)) {
		pageError();
		exit();
	}
	$album = UTF8ToFilesystem($album);
	$rp = realpath(getAlbumFolder() . $album) . '/';
	$p = $album . '/';
	include_once('archive.php');
	$dest = realpath(getAlbumFolder()) . '/' . urlencode($album) . ".zip";
	$persist = getOption('persistent_archive');
	if (!$persist  || !file_exists($dest)) {
		if (file_exists($dest)) unlink($dest);
		$z = new zip_file($dest);
		$z->set_options(array('basedir' => $rp, 'inmemory' => 0, 'recurse' => 0, 'storepaths' => 1));
		if ($dh = opendir($rp)) {
			$_zp_zip_list[] = '*.*';

			while (($file = readdir($dh)) !== false) {
				if($file != '.' && $file != '..'){
					if (is_dir($rp.$file)) {
						$base_a = explode("/", $album);
						unset($base_a[count($base_a)-1]);
						$base = implode('/', $base_a);
						zipAddSubalbum($rp, $base, $file, $z);
					}
				}
			}
			closedir($dh);
		}
		$z->add_files($_zp_zip_list);
		$z->create_archive();
	}
	header('Content-Type: application/zip');
	header('Content-Disposition: attachment; filename="' . urlencode($album) . '.zip"');
	header("Content-Length: " . filesize($dest));
	printLargeFileContents($dest);
	if (!$persist) { unlink($dest); }
}
?>