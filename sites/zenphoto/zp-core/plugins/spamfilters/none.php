<?php
/**
 * This is a shell plugin for SPAM filtering. It does almost nothing, but serves as the template
 * for more robust SPAM filters.
 * @author Stephen Billard (sbillard)
 * @version 1.0.0
 * @package plugins	 
 */

/**
 * This implements the standard SpamFilter class for the none spam filter.
 *
 */
class SpamFilter  {
 
	/**
	 * The SpamFilter class instantiation function.
	 *
	 * @return SpamFilter
	 */
	function SpamFilter() {
		global $gallery;
		setOptionDefault('Action', 'pass');
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
		return array(gettext('Action') => array('key' => 'Action', 'type' => 5, 
										'selections' => array(gettext('pass') => 'pass', gettext('moderate') => 'moderate', gettext('reject') => 'reject'),
										'desc' => gettext('This action will be taken for all messages.')));
	}
	
 	/**
 	 * Handles custom formatting of options for Admin
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
		$strategy = getOption('Action');
		switch ($strategy) {
			case 'reject': return 0;
			case 'moderate': return 1;
		}
		return 2;
	}
}

?>
