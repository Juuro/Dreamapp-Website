<?php
/**
 * Create sortable lists
 * @package classes
 */

// force UTF-8 Ø

/**
 * Initializes a sortable list and echoes needed javascript. Can be called multiple times in a page.
 * 
 * @param object $jQuerySortable the jQuerySortable instance for the sort
 * @param string $sortContainerID The HTML id of container that will contain the sortable elements.
 * @param string $orderedList     The array that will contain the ordered elements.
 * @param string $sortableElement The elements that will be sorted (eg 'div', 'img', '.someclass')
 * @param string $extraOptions    Additional options to be passed to jQuery.sortable
 * 
 * @author Todd Papaioannou (lucky@luckyspin.org)
 * @since  1.0.0
 */
function zenSortablesHeader(&$jQuerySortable, $sortContainerID, $orderedList, $sortableElement, $extraOptions="") {
	$options = "cursor:'move', tolerance:'tolerance', opacity:0.8, update:function(){populateHiddenVars();}";
	if ($extraOptions)
		$options .= ', '.$extraOptions;
	$jQuerySortable->addList($sortContainerID, $orderedList, $sortableElement, $options);
	$jQuerySortable->printJavascript();
}

/**
 * Insert the Save button that will POST the sortable list
 *
 * @param object $jQuerySortable the jQuerySortable instance for the sort
 * @param string $link  The destination of the POST operation.
 * @param string $label The label for the button.
 *
 * @author Todd Papaioannou (lucky@luckyspin.org)
 * @since  1.0.0
 */
function zenSortablesSaveButton(&$jQuerySortable, $link, $label="Save") {
	$jQuerySortable->printForm($link, 'POST', $label, 'button');
}


/**
 * Handles the POST operation of the sorted list.
 * 
 * @param object $jQuerySortable the jQuerySortable instance for the sort
 * @param string $orderedList     The list of ordered elements to be saved.
 * @param string $sortContainerID The parent container for the sortable elements.
 * @param string $dbtable         The database table that will be updated.
 * 
 * @author Todd Papaioannou (lucky@luckyspin.org)
 * @since  1.0.0
 */
function zenSortablesPostHandler(&$jQuerySortable, $orderedList, $sortContainerID, $dbtable) {
	if (isset($_POST['sortableListsSubmitted'])) {
		$orderArray = $jQuerySortable->getOrderArray($_POST[$orderedList], $sortContainerID);
		foreach($orderArray as $item) {
			saveSortOrder($dbtable, $item['element'], $item['order']);
		}
	}
}


/**
 * Save the new sort order for a sortable item.
 *
 * @param string $dbtable   The dababase table that will be updated.
 * @param string $id        The id of the sortable item, as defined in the id column.
 * @param string $sortorder The new sort order for this item.
 * 
 * @author Todd Papaioannou (lucky@luckyspin.org)
 * @since  1.0.0 
 */
function saveSortOrder($dbtable, $id, $sortorder) {
	// This is a nasty hack really, but it works.. The hack being we need id_XX in the element id.
	$real_id = substr($id, 0, 3);
	
	query("UPDATE ".prefix($dbtable)." SET `sort_order`='" . mysql_real_escape_string($sortorder) .
				"' WHERE `id`=".$id);
}



/**
 * jQuery sortable class
 *
 * This class implements the jQuery sortable plugin. Based on Todd Papaioannou's work with Scriptaculous for zenphoto 1.0.0
 *
 * @author Ozh
 * @since 1.2.3
 */
class jQuerySortable {
	var $lists = array();
	var $jsPath;
	var $debugging = false;
	var $jquery_init;
	
	function jQuerySortable($jsPath) {
		$this->jsPath = $jsPath;
		$this->jquery_init = false;
		$this->debugging = false;
	}
	
	function debug() {
		$this->debugging = true ;
	}

	function printJavascript() {
		// Stuff echoed only once, no matter how many sortable elements are initialized in the page
		if (!$this->jquery_init) {
		?>		
		<script src="<?php echo $this->jsPath;?>/jquery.ui.zenphoto.js" type="text/javascript"></script>
		<script type="text/javascript">
			// <![CDATA[
			function populateHiddenVars() {
				<?php foreach($this->lists as $list) { ?>
					jQuery('#<?php echo $list['input'];?>').val(jQuery('#<?php echo $list['list'];?>').sortable('serialize',{key:'<?php echo $list['list'];?>'}));
				<?php } ?>
				return true;
			}
			// ]]>
		</script>
		<?php
			$this->jquery_init = true;
		}?>
		<script type="text/javascript">
			// <![CDATA[
			jQuery(document).ready(function(){
			<?php foreach($this->lists as $list) { ?>
				jQuery('#<?php echo $list['list'];?>')
					.sortable({items:'<?php echo $list['items'];?>'<?php echo $list['additionalOptions'];?>});
			<?php } ?>
			});
			// ]]>
		</script>
		<?php
	}
	
	function addList($list, $input, $tag = 'li', $additionalOptions = '') {
		if ($additionalOptions != '')
			$additionalOptions = ','.$additionalOptions;
		$this->lists[] = array("list" => $list, "input" => $input, "items" => $tag, "additionalOptions" => $additionalOptions);
	}
	
	function printHiddenInputs() {
		$inputType = ($this->debugging === true) ? 'text' : 'hidden';

		foreach($this->lists as $list) {
			if ($this->debugging)
				echo '<br clear="all">'.$list['input'].': ';
			?>
			<input type="<?php echo $inputType;?>" name="<?php echo $list['input'];?>" id="<?php echo $list['input'];?>" style='width:100%'>
			<?php
		}
		if ($this->debugging)
			echo '<br>';
	}

	function printForm($action, $method = 'POST', $submitText = 'Submit', $submitClass = '',$formName = 'sortableListForm') {
		?>
		<form action="<?php echo $action;?>" method="<?php echo $method;?>" name="<?php echo $formName;?>" id="<?php echo $formName;?>">
			<?php $this->printHiddenInputs();?>
			<br clear="all"/>
			<input type="hidden" name="sortableListsSubmitted" value="true">
			<input type="submit" value="<?php echo $submitText;?>" class="<?php echo $submitClass;?>">
		</form>
		<?php
	}
	
	function getOrderArray($input, $listname, $itemKeyName = 'element', $orderKeyName = 'order') {
		parse_str($input,$inputArray);
		$orderArray = array();
		if (isset($inputArray[$listname])) {
			$inputArray = $inputArray[$listname];
			for($i=0;$i<count($inputArray);$i++) {
				$orderArray[] = array($itemKeyName => $inputArray[$i], $orderKeyName => $i +1);
			}
		}
		return $orderArray;
	}
}

?>
