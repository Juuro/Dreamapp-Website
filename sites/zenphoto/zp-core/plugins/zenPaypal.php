<?php
/** 
 * zenPaypal -- PayPal ordering support
 * 
 * Provides a PayPal ordering form for image print ordering.
 * 
 * Plugin option 'zenPaypal_userid' allows setting the PayPal user email.
 * Plugin option 'zenPaypal_pricelist' provides the default pricelist. 
 * Plugin option 'zenPaypal_checkout_currency'
 * Plugin option 'zenPaypal_checkout_ship_cost'
 *   
 * Price lists can also be passed as a parameter to the zenPaypal() function. See also 
 * zenPaypalPricelistFromString() for parsing a string into the pricelist array. This could be used, 
 * for instance, by storing a pricelist string in the 'customdata' field of your images and then parsing and 
 * passing it in the zenPaypal() call. This would give you individual pricing by image.
 * 
 * @author Ebrahim Ezzy (Nimbuz) adapted as a plugin by Stephen Billard (sbillard)
 * @version 1.0.1
 * @package plugins 
 */

$plugin_description =   "<a href =\"http://blog.qelix.com/2008/04/07/paypal-integraion-for-zenphoto-zenpaypal/\">".
	"zenPayPal</a> -- ".gettext("Paypal Integration for Zenphoto.");
$plugin_author = gettext('Ebrahim Ezzy (Nimbuz) adapted as a plugin by Stephen Billard (sbillard)');
$plugin_version = '1.0.1';
$plugin_URL = "http://www.zenphoto.org/documentation/plugins/_plugins---zenPaypal.php.html";
$option_interface = new zenPaypalOptions();
addPluginScript('<link rel="stylesheet" href="'.FULLWEBPATH."/".ZENFOLDER.'/plugins/zenPaypal/zenPaypal.css" type="text/css" />');

/**
 * Plugin option handling class
 *
 */
class zenPaypalOptions {

	function zenPaypalOptions() {

		$pricelist = array("4x6:".gettext("Matte") => '5.75', "4x6:".gettext("Glossy") => '10.00', "4x6:".gettext("Paper") => '8.45', 
								"8x10:".gettext("Matte") => '15.00', "8x10:".gettext("Glossy") => '20.00', "8x10:".gettext("Paper") => '8.60', 
								"11x14:".gettext("Matte") => '25.65', "11x14:".gettext("Glossy") => '26.75', "11x14:".gettext("Paper") => '15.35', );
		setOptionDefault('zenPaypal_userid', "");
		$pricelistoption = '';
		foreach ($pricelist as $item => $price) {
			$pricelistoption .= $item.'='.$price.' ';
		}
		setOptionDefault('zenPaypal_pricelist', $pricelistoption);
		setOptionDefault('zenPaypal_currency', 'USD');
		setOptionDefault('zenPaypal_ship_cost', 0);
	}
	
	
	function getOptionsSupported() {
		return array(	gettext('PayPal User ID') => array('key' => 'zenPaypal_userid', 'type' => 0, 
										'desc' => gettext("Your PayPal User ID.")),
									gettext('Currency') => array('key' => 'zenPaypal_currency', 'type' => 0, 
										'desc' => gettext("The currency for your transactions.")),
									gettext('Shipping cost') => array('key' => 'zenPaypal_ship_cost', 'type' => 0, 
										'desc' => gettext("What you charge for shipping.")),
									gettext('Price list') => array('key' => 'zenPaypal_pricelist', 'type' => 3, 'multilingual' => 1,
										'desc' => gettext("Your pricelist by size and media. The format of this option is <em>price elements</em> separated by spaces.<br/>".
																			"A <em>price element</em> has the form: <em>size</em>:<em>media</em>=<em>price</em><br/>".
																			"example: <code>4x6:Matte=5.75 8x10:Glossy=20.00 11x14:Paper=15.35</code>."))
		);
	}
 	function handleOption($option, $currentValue) {
	}
}

/**
 * Parses a price list element string and returns a pricelist array
 *
 * @param string $prices A text string of price list elements in the form <size>:<media>=<price> <size>:<media>=<price> ...
 * @return array
 */
function zenPaypalPricelistFromString($prices) {
	$pricelist = array();
	$pricelistelements = explode(' ', $prices);
		foreach ($pricelistelements as $element) {
			if (!empty($element)) {
				$elementparts = explode('=', $element);
				$pricelist[$elementparts[0]] = $elementparts[1];
			}
		}
	return $pricelist;
}

/**
 * Places a Paypal button on your form
 * 
 * @param array $pricelist optional array of specific pricing for the image.
 * @param bool $pricelistlink set to true to include link for exposing pricelist
 * @param string $text The text to place for the link (defaults to "Price List")
 * @param string $textTag HTML tag for the link text. E.g. h3, ...  
 * @param string $idtag the division ID for the price list. (NB: a div named $id appended with "_data" is
 */
function zenPaypal($pricelist=NULL, $pricelistlink=false, $text=NULL, $textTag="l1", $idtag="zenPaypalPricelist") {
	if (!is_array($pricelist)) {
		$pricelist = zenPaypalPricelistFromString(getOption('zenPaypal_pricelist'));
	}
?>
<script language="javascript">

function paypalCalculateOrder(myform) {
	<?php 
	$sizes = array();
	$media = array();
	foreach ($pricelist as $key=>$price) {
		$itemparts = explode(':', $key);
		$media[] = $itemparts[1];
		$sizes[] = $itemparts[0];
		echo 'if (myform.os0.value == "'.$itemparts[0].'" && myform.os1.value == "'.$itemparts[1].'") {'."\n";
		echo 'myform.amount.value = '.$price.';'."\n";
		echo 'myform.item_name.value = "'.getImageTitle().' - Photo Size '.$itemparts[0].' - '.$itemparts[1].'";'."\n";
		echo '}'."\n";
	}
	?>        
}
</script>

<?php
$locale = getOption('locale');
if (empty($locale)) { $locale = 'en_US'; }
?>

<div id="BuyNow">
<form target="paypal" action="https://www.paypal.com/cgi-bin/webscr" method="post" name="myform">
<input type="hidden" name="on0"	value="Size"> <label>Size</label> 
	<select name="os0">
	<?php
	$media = array_unique($media);
	$sizes = array_unique($sizes);
	foreach ($sizes as $size) {
		echo '<option value="'.$size.'" selected>'.$size."\n";
	}
	 ?>
</select> 
<input type="hidden" name="on1" value="Color"> <label><?php echo gettext("Stock"); ?></label>
<select name="os1">
	<?php
	foreach ($media as $paper) {
		echo '<option value="'.$paper.'" selected>'.$paper."\n";
	}
	 ?>
</select> 
<input type="image" src="https://www.paypal.com/<?php echo $locale ?>/i/btn/x-click-butcc.gif" border="0"
	name="submit" onClick="paypalCalculateOrder(this.form)"
	alt=<?php gettext("Make payments with PayPal - it's fast, free and secure!"); ?>
	class="buynow_button"> 
<input type="hidden" name="cmd" value="_xclick">
<input type="hidden" name="business" value="<?php echo getOption('zenPaypal_userid'); ?>">
<input type="hidden" name="item_name" value="Options Change Amount"> 
<input type="hidden" name="amount" value="1.00"> 
<input type="hidden" name="shipping" value="<?php echo getOption('zenPaypal_ship_cost'); ?>"> 
<input type="hidden" name="no_note" value="1"> 
<input type="hidden" name="currency_code" value="<?php echo getOption('zenPaypal_currency'); ?>"> 
<input type="hidden" name="return" value="<?php echo 'http://'. $_SERVER['SERVER_NAME']. htmlspecialchars(getNextImageURL());?>">
<input type="hidden" name="cancel_return" value="<?php echo 'http://'. $_SERVER['SERVER_NAME'].htmlspecialchars(getImageLinkURL());?>">
</form>
<?php 
if ($pricelistlink) {
	zenPaypalPrintPricelist($pricelistlink, $text, $textTag, $idtag);
}	
?>
</div>
<?php
}

/**
 * Prints a link that will expose the zenPaypal Price list table
 *
 * @param array $pricelist the zenPaypal price list
 * @param string $text The text to place for the link (defaults to "Price List")
 * @param string $textTag HTML tag for the link text. E.g. h3, ...  
 * @param string $id the division ID for the price list. (NB: a div named $id appended with "_data" is
 * 										created for the hidden table.
 * 
 */
function zenPaypalPrintPricelist($pricelist=NULL, $text=NULL, $textTag="l1", $id="zenPaypalPricelist"){
	if (!is_array($pricelist)) {
		$pricelist = zenPaypalPricelistFromString(getOption('zenPaypal_pricelist'));
	}
	if (is_null($text)) $text = gettext("Price List");
	$dataid = $id . '_data';
	if (!empty($textTag)) {
		$textTagStart = '<'.$textTag.'>';
		$textTagEnd = '</'.$textTag.'>';
	}
	echo '<div id="' .$id. '">'."\n".$textTagStart.'<a href="javascript: toggle('. "'" .$dataid."'".');">'.$text."</a>".$textTagEnd."\n</div>";
	echo '<div id="' .$dataid. '" style="display: none;">'."\n";
	echo '<table>'."\n";
	echo '<table>'."\n";
	echo '<tr>'."\n";
	echo '<th>'.gettext("size").'</th>'."\n";
	echo '<th>'.gettext("media").'</th>'."\n";
	echo '<th>'.gettext("price").'</th>'."\n";
	echo '</tr>'."\n";
	$sizes = array();
	$media = array();
	foreach ($pricelist as $key=>$price) {
		$itemparts = explode(':', $key);
		echo '<tr>'."\n";
		echo '<td class="size">'.$itemparts[0].'</td>'."\n";
		echo '<td class="media">'.$itemparts[1].'</td>'."\n";
		echo '<td class="price">'.$price.'</td>'."\n";
		echo '</tr>'."\n";
	}
	echo '</table>'."\n";
	echo '</div>'."\n";
	echo "</div>\n";
}

?>