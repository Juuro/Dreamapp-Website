<?php defined('SYSPATH') OR die('No direct access allowed.');
/**
 * Security helper class.
 *
 * $Id: security.php 19191 2008-12-15 05:35:20Z bharat $
 *
 * @package    Core
 * @author     Kohana Team
 * @copyright  (c) 2007-2008 Kohana Team
 * @license    http://kohanaphp.com/license.html
 */
class security_Core {

	/**
	 * Sanitize a string with the xss_clean method.
	 *
	 * @param   string  string to sanitize
	 * @return  string
	 */
	public static function xss_clean($str)
	{
		return Input::instance()->xss_clean($str);
	}

	/**
	 * Remove image tags from a string.
	 *
	 * @param   string  string to sanitize
	 * @return  string
	 */
	public static function strip_image_tags($str)
	{
		return preg_replace('#<img\s.*?(?:src\s*=\s*["\']?([^"\'<>\s]*)["\']?[^>]*)?>#is', '$1', $str);
	}

	/**
	 * Remove PHP tags from a string.
	 *
	 * @param   string  string to sanitize
	 * @return  string
	 */
	public static function encode_php_tags($str)
	{
		return str_replace(array('<?', '?>'), array('&lt;?', '?&gt;'), $str);
	}

} // End security