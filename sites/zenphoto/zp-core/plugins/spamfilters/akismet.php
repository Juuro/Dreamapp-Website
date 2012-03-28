<?php

/**
 * This is plugin for Akismet SPAM filtering.
 * @author based on the Akismet Hack by GameDudeX ported to plugin functionality by Thinkdreams
 * @version 1.0.0
 * @package plugins	 
 */
 
/**
 * This implements the standard SpamFilter class for the Akismet spam filter.
 *
 */
class SpamFilter  {
 
	/**
	 * The SpamFilter class instantiation function.
	 *
	 * @return SpamFilter
	 */
	function SpamFilter() {
		setOptionDefault('Akismet_key', '');
		setOptionDefault('Forgiving', 0);
	}												
 
	/**
	 * The admin options interface
	 * called from admin Options tab
	 *  returns an array of the option names the theme supports
	 *  the array is indexed by the option name. The value for each option is an array:
	 *          'type' => 0 says for admin to use a standard textbox for the option
	 *          'type' => 1 says for admin to use a standard checkbox for the option
	 *          'type' => 2 will cause admin to call handleOption to generate the HTML for the option
	 *          'desc' => text to be displayed for the option description.
	 *
	 * @return array
	 */
	function getOptionsSupported() {
		return array(	gettext('Akismet key') => array('key' => 'Akismet_key', 'type' => 0, 'desc' => gettext('Proper operation requires an Akismet key obtained by signing up for a <a href="http://www.wordpress.com">Wordpress.com</a> account.')),
									gettext('Forgiving') => array('key' => 'Forgiving', 'type' => 1, 'desc' => gettext('Mark suspected SPAM for moderation rather than as SPAM')));

	}
	
 	/**
 	 * Handles custom formatting of options for Admin (of which, there are none for Akismet)
 	 *
 	 * @param string $option the option name of the option to be processed
 	 * @param mixed $currentValue the current value of the option (the "before" value)
 	 */
	function handleOption($option, $currentValue) {
	}

	/**
	 * The function for processing a message to see if it might be SPAM
   *       returns:
   *         0 if the message is SPAM
   *         1 if the message might be SPAM (it will be marked for moderation)
   *         2 if the message is not SPAM
	 *
	 * @param string $author Author field from the posting
	 * @param string $email Email field from the posting
	 * @param string $website Website field from the posting
	 * @param string $body The text of the comment
	 * @param string $imageLink A link to the album/image on which the post was made
	 * @param string $ip the IP address of the comment poster
	 * 
	 * @return int
	 */
	function filterMessage($author, $email, $website, $body, $imageLink, $ip) {
		 	
		$commentData = array(
				'author'    => $author,
				'email'     => $email,
				'website'   => $website,
				'body'      => $body,
				'permalink' => $imageLink
		 );
		 
												
		$zp_galUrl = FULLWEBPATH;  // Sets the webpath for the Akismet server
		$zp_akismetKey = getOption('Akismet_key');
		$forgive = getOption('Forgiving');
		$die = 2;  // good comment until proven bad
		
	$akismet = new Akismet($zp_galUrl, $zp_akismetKey, $commentData);
		
	if ($akismet->errorsExist()) {
		// TODO: Add more improved error handling (maybe)
		// echo "Couldn't connected to Akismet server!";
		// print_r ($akismet->getErrors());
		$die = 1; // mark for moderation if we can't check for Spam
		
		} else {
			if ($akismet->isSpam()) {
		// Message is spam according to Akismet
		// echo 'Spam detected';
		// echo "bad message.";
		
				$die = $forgive;
			} else {
		// Message is not spam according to Akismet
		// echo "spam filter is true. good message.";
		
			}
		}
		return $die;
	}

}  // end of class SpamFilter

// Error constants
define("AKISMET_SERVER_NOT_FOUND",	0);
define("AKISMET_RESPONSE_FAILED",	1);
define("AKISMET_INVALID_KEY",		2);

/**
 * 01.26.2006 12:29:28est
 * 
 * Akismet PHP4 class
 * 
 * Base class to assist in error handling between Akismet classes
 * 
 * <b>Usage</b>
 * <code>
 *    $comment = array(
 *           'author'    => 'viagra-test-123',
 *           'email'     => 'test@example.com',
 *           'website'   => 'http://www.example.com/',
 *           'body'      => 'This is a test comment',
 *           'permalink' => 'http://yourdomain.com/yourblogpost.url',
 *        );
 *
 *    $akismet = new Akismet('http://www.yourdomain.com/', 'YOUR_WORDPRESS_API_KEY', $comment);
 *
 *    if($akismet->isError()) {
 *        echo"Couldn't connected to Akismet server!";
 *    } else {
 *        if($akismet->isSpam()) {
 *            echo"Spam detected";
 *        } else {
 *            echo"yay, no spam!";
 *        }
 *    }
 * </code>
 * 
 * @author Bret Kuhns {@link www.miphp.net}
 * @link http://www.miphp.net/blog/view/php4_akismet_class/
 * @version 0.3.3
 * @license http://www.opensource.org/licenses/mit-license.php MIT License 
 */

class AkismetObject {
	var $errors = array();
	
	
	/**
	 * Add a new error to the errors array in the object
	 *
	 * @param	String	$name	A name (array key) for the error
	 * @param	String	$string	The error message
	 * @return void
	 */ 
	// Set an error in the object
	function setError($name, $message) {
		$this->errors[$name] = $message;
	}
	

	/**
	 * Return a specific error message from the errors array
	 *
	 * @param	String	$name	The name of the error you want
	 * @return mixed	Returns a String if the error exists, a false boolean if it does not exist
	 */
	function getError($name) {
		if($this->isError($name)) {
			return $this->errors[$name];
		} else {
			return false;
		}
	}
	
	
	/**
	 * Return all errors in the object
	 *
	 * @return String[]
	 */ 
	function getErrors() {
		return (array)$this->errors;
	}
	
	
	/**
	 * Check if a certain error exists
	 *
	 * @param	String	$name	The name of the error you want
	 * @return boolean
	 */ 
	function isError($name) {
		return isset($this->errors[$name]);
	}
	
	
	/**
	 * Check if any errors exist
	 *
	 * @return boolean
	 */
	function errorsExist() {
		return (count($this->errors) > 0);
	}
	
	
}





// Used by the Akismet class to communicate with the Akismet service
class AkismetHttpClient extends AkismetObject {
	var $akismetVersion = '1.1';
	var $con;
	var $host;
	var $port;
	var $apiKey;
	var $blogUrl;
	var $errors = array();
	
	
	// Constructor
	function AkismetHttpClient($host, $blogUrl, $apiKey, $port = 80) {
		$this->host = $host;
		$this->port = $port;
		$this->blogUrl = $blogUrl;
		$this->apiKey = $apiKey;
	}
	
	
	// Use the connection active in $con to get a response from the server and return that response
	function getResponse($request, $path, $type = "post", $responseLength = 1160) {
		$this->_connect();
		
		if($this->con && !$this->isError(AKISMET_SERVER_NOT_FOUND)) {
			$request  = 
					strToUpper($type)." /{$this->akismetVersion}/$path HTTP/1.1\r\n" .
					"Host: ".((!empty($this->apiKey)) ? $this->apiKey."." : null)."{$this->host}\r\n" .
					"Content-Type: application/x-www-form-urlencoded; charset=utf-8\r\n" .
					"Content-Length: ".strlen($request)."\r\n" .
					"User-Agent: Akismet PHP4 Class\r\n" .
					"\r\n" .
					$request
				;
			$response = "";

			@fwrite($this->con, $request);

			while(!feof($this->con)) {
				$response .= @fgets($this->con, $responseLength);
			}

			$response = explode("\r\n\r\n", $response, 2);
			return $response[1];
		} else {
			$this->setError(AKISMET_RESPONSE_FAILED, "The response could not be retrieved.");
		}
		
		$this->_disconnect();
	}
	
	
	// Connect to the Akismet server and store that connection in the instance variable $con
	function _connect() {
		if(!($this->con = @fsockopen($this->host, $this->port))) {
			$this->setError(AKISMET_SERVER_NOT_FOUND, "Could not connect to akismet server.");
		}
	}
	
	
	// Close the connection to the Akismet server
	function _disconnect() {
		@fclose($this->con);
	}
	
	
}





// The controlling class. This is the ONLY class the user should instantiate in
// order to use the Akismet service!
class Akismet extends AkismetObject {
	var $apiPort = 80;
	var $akismetServer = 'rest.akismet.com';
	var $akismetVersion = '1.1';
	var $http;
	
	var $ignore = array(
			'HTTP_COOKIE',
			'HTTP_X_FORWARDED_FOR',
			'HTTP_X_FORWARDED_HOST',
			'HTTP_MAX_FORWARDS',
			'HTTP_X_FORWARDED_SERVER',
			'REDIRECT_STATUS',
			'SERVER_PORT',
			'PATH',
			'DOCUMENT_ROOT',
			'SERVER_ADMIN',
			'QUERY_STRING',
			'PHP_SELF',
			'argv'
		);
	
	var $blogUrl = "";
	var $apiKey  = "";
	var $comment = array();
	
	
	/**
	 * Constructor
	 * 
	 * Set instance variables, connect to Akismet, and check API key
	 * 
	 * @param	String	$blogUrl	The URL to your own blog
	 * @param 	String	$apiKey		Your wordpress API key
	 * @param 	String[]	$comment	A formatted comment array to be examined by the Akismet service
	 */
	function Akismet($blogUrl, $apiKey, $comment) {
		$this->blogUrl = $blogUrl;
		$this->apiKey  = $apiKey;
		
		// Populate the comment array with information needed by Akismet
		$this->comment = $comment;
		$this->_formatCommentArray();
		
		if(!isset($this->comment['user_ip'])) {
			$this->comment['user_ip'] = ($_SERVER['REMOTE_ADDR'] != getenv('SERVER_ADDR')) ? $_SERVER['REMOTE_ADDR'] : getenv('HTTP_X_FORWARDED_FOR');
		}
		if(!isset($this->comment['user_agent'])) {
			$this->comment['user_agent'] = $_SERVER['HTTP_USER_AGENT'];
		}
		if(!isset($this->comment['referrer'])) {
			$this->comment['referrer'] = $_SERVER['HTTP_REFERER'];
		}
		$this->comment['blog'] = $blogUrl;
		
		// Connect to the Akismet server and populate errors if they exist
		$this->http = new AkismetHttpClient($this->akismetServer, $blogUrl, $apiKey);
		if($this->http->errorsExist()) {
			$this->errors = array_merge($this->errors, $this->http->getErrors());
		}
		
		// Check if the API key is valid
		if(!$this->_isValidApiKey($apiKey)) {
			$this->setError(AKISMET_INVALID_KEY, "Your Akismet API key is not valid.");
		}
	}
	
	
	/**
	 * Query the Akismet and determine if the comment is spam or not
	 * 
	 * @return	boolean
	 */
	function isSpam() {
		$response = $this->http->getResponse($this->_getQueryString(), 'comment-check');
		
		return ($response == "true");
	}
	
	
	/**
	 * Submit this comment as an unchecked spam to the Akismet server
	 * 
	 * @return	void
	 */
	function submitSpam() {
		$this->http->getResponse($this->_getQueryString(), 'submit-spam');
	}
	
	
	/**
	 * Submit a false-positive comment as "ham" to the Akismet server
	 *
	 * @return	void
	 */
	function submitHam() {
		$this->http->getResponse($this->_getQueryString(), 'submit-ham');
	}
	
	
	/**
	 * Check with the Akismet server to determine if the API key is valid
	 *
	 * @access	Protected
	 * @param	String	$key	The Wordpress API key passed from the constructor argument
	 * @return	boolean
	 */
	function _isValidApiKey($key) {
		$keyCheck = $this->http->getResponse("key=".$this->apiKey."&blog=".$this->blogUrl, 'verify-key');
			
		return ($keyCheck == "valid");
	}
	
	
	/**
	 * Format the comment array in accordance to the Akismet API
	 *
	 * @access	Protected
	 * @return	void
	 */
	function _formatCommentArray() {
		$format = array(
				'type' => 'comment_type',
				'author' => 'comment_author',
				'email' => 'comment_author_email',
				'website' => 'comment_author_url',
				'body' => 'comment_content'
			);
		
		foreach($format as $short => $long) {
			if(isset($this->comment[$short])) {
				$this->comment[$long] = $this->comment[$short];
				unset($this->comment[$short]);
			}
		}
	}
	
	
	/**
	 * Build a query string for use with HTTP requests
	 *
	 * @access	Protected
	 * @return	String
	 */
	function _getQueryString() {
		foreach($_SERVER as $key => $value) {
			if(!in_array($key, $this->ignore)) {
				if($key == 'REMOTE_ADDR') {
					$this->comment[$key] = $this->comment['user_ip'];
				} else {
					$this->comment[$key] = $value;
				}
			}
		}

		$query_string = '';

		foreach($this->comment as $key => $data) {
			$query_string .= $key . '=' . urlencode(stripslashes($data)) . '&';
		}

		return $query_string;
	}
	
	
}
?>
