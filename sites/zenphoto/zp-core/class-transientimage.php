<?php
/**
 * class transientimage
 * @package classes
 */

// force UTF-8 Ø

class Transientimage extends _Image {
	/**
	 * creates a transient image (that is, one that is not stored in the database)
	 *
	 * @param object $gallery
	 * @param string $image the full path to the image
	 * @return transientimage
	 */
	function Transientimage(&$album, $image) {
		if (!is_object($album)) return NULL;
		$this->album = $album;
		$this->localpath = $image;
		
		$filename = makeSpecialImageName($image);
		$this->filename = $filename;
		$this->displayname = substr(basename($image), 0, strrpos(basename($image), '.'));
		if (empty($this->displayname)) $this->displayname = $this->filename;
		$this->filemtime = filemtime($this->localpath);
		$this->comments = null;
		if (is_valid_video($filename)) {
			$this->video = true;
		}
		parent::PersistentObject('images', array('filename'=>$filename, 'albumid'=>$this->album->id), 'filename', false, true);
	}
}
?>