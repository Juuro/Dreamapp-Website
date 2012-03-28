<?php
/**
 * This is a "simple" SPAM filter. 
 * It uses a word black list and checks for excessive URLs
 * 
 * @author Stephen Billard (sbillard)
 * @version 1.0.0
 * @package plugins	 
 */
 
/**
 * This implements the standard SpamFilter class for the Simple spam filter.
 *
 */
class SpamFilter  {

	var $wordsToDieOn = array('cialis','ebony','nude','porn','porno','pussy','upskirt','ringtones','phentermine','viagra', 'levitra'); /* the word black list */
	
	var $patternsToDieOn = array('\[url=.*\]');
	
	var $excessiveURLCount = 5;
	
	/**
	 * The SpamFilter class instantiation function.
	 *
	 * @return SpamFilter
	 */
	function SpamFilter() {
		setOptionDefault('Words_to_die_on', implode(',', $this->wordsToDieOn));
		setOptionDefault('Patterns_to_die_on', implode(' ', $this->patternsToDieOn));
		setOptionDefault('Excessive_URL_count', $this->excessiveURLCount);
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
		return array(	gettext('Words to die on') => array('key' => 'Words_to_die_on', 'type' => 2, 'desc' => gettext('SPAM blacklist words (separate with commas)')),
									gettext('Patterns to die on') => array('key' => 'Patterns_to_die_on', 'type' => 2, 'desc' => gettext('SPAM blacklist <a href="http://en.wikipedia.org/wiki/Regular_expression">regular expressions</a> (separate with spaces)')),
									gettext('Excessive URL count') => array('key' => 'Excessive_URL_count', 'type' => 0, 'desc' => gettext('Message is considered SPAM if there are more than this many URLs in it')),
									gettext('Forgiving') => array('key' => 'Forgiving', 'type' => 1, 'desc' => gettext('Mark suspected SPAM for moderation rather than as SPAM')));
	}
	
 	/**
 	 * Handles custom formatting of options for Admin
 	 *
 	 * @param string $option the option name of the option to be processed
 	 * @param mixed $currentValue the current value of the option (the "before" value)
 	 */
 	function handleOption($option, $currentValue) {
 		if ($option=='Words_to_die_on') {
 			$list = explode(',', $currentValue);
 			sort($list);
	 		echo '<textarea name="' . $option . '" cols="42" rows="4">' . implode(',', $list) . "</textarea>\n";
 		} else if ($option=='Patterns_to_die_on') {
	 		echo '<textarea name="' . $option . '" cols="42" rows="2">' . $currentValue . "</textarea>\n";
	 }
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
		$forgive = getOption('Forgiving');
		$list = getOption('Words_to_die_on');
		$list = strtolower($list);
		$this->wordsToDieOn = explode(',', $list);
		$list = getOption('Patterns_to_die_on');
		$list = strtolower($list);
		$this->patternsToDieOn = explode(' ', $list);
		$this->excessiveURLCount = getOption('Excessive_URL_count');
		$die = 2;  // good comment until proven bad
		if ($body) {
			if (($num = substr_count($body, 'http://')) >= $this->excessiveURLCount) { // too many links
				$die = $forgive;
			} else {
				if ($pattern = $this->hasSpamPattern($body)) {
					$die = $forgive;
				} else {
					if ($spamWords = $this->hasSpamWords($body)) {
						$die = $forgive;
					}
				}
			}
		}
		return $die;  
	}

	/**
	 * Tests to see if the text contains any of the SPAM trigger patterns
	 *
	 * @param string $text The message to be parsed
	 * @return bool
	 */
	function hasSpamPattern($text) {
		$patterns = $this->patternsToDieOn;
		foreach ($patterns as $pattern) {
			if (eregi('('.trim($pattern).')', $text, $matches)) {
				return $matches[1];
			}
		}
		return false;
	}
	
	/**
	 * Tests to see if the text contains any of the list of SPAM trigger words
	 *
	 * @param string $text The text of the message to be examined.
	 * @return bool
	 */
	function hasSpamWords($text) {
		$words = $this->getWords($text);
		$blacklist = $this->wordsToDieOn;
		$intersect = array_intersect($blacklist , $words);
		return $intersect ;
	}
	
	function getWords($text, $notUnique=false) {
		if ($notUnique) {
			return preg_split("/[\W]+/", strtolower(strip_tags($text)));
		} else {
			return array_unique(preg_split("/[\W]+/", strtolower(strip_tags($text))));
		}
	}

}

?>
