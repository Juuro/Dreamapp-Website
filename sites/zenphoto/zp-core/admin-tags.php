<?php
/**
 * provides the TAGS tab of admin
 * @package admin
 */
define('OFFSET_PATH', 1);
require_once(dirname(__FILE__).'/template-functions.php');
require_once(dirname(__FILE__).'/admin-functions.php');

if (!($_zp_loggedin & ADMIN_RIGHTS)) { // prevent nefarious access to this page.
	header('Location: ' . FULLWEBPATH . '/' . ZENFOLDER . '/admin.php?from=' . currentRelativeURL() );
	exit();
}

if (getOption('zenphoto_release') != ZENPHOTO_RELEASE) {
	header("Location: " . FULLWEBPATH . "/" . ZENFOLDER . "/setup.php");
	exit();
}

$gallery = new Gallery();
$_GET['page'] = 'tags';

if (isset($_REQUEST['tagsort'])) {
	$tagsort = sanitize($_REQUEST['tagsort'], 0);
	setBoolOption('tagsort', $tagsort);
} else {
	$tagsort = getOption('tagsort');
}

printAdminHeader();
echo "\n</head>";
echo "\n<body>";
printLogoAndLinks();
echo "\n" . '<div id="main">';
printTabs('tags');
echo "\n" . '<div id="content">';

if (count($_POST) > 0) {
	if (isset($_GET['newtags'])) {
		foreach ($_POST as $value) {
			if (!empty($value)) {
				$value = mysql_real_escape_string(sanitize($value, 3));
				$result = query_single_row('SELECT `id` FROM '.prefix('tags').' WHERE `name`="'.$value.'"');
				if (!is_array($result)) { // it really is a new tag
					query('INSERT INTO '.prefix('tags').' (`name`) VALUES ("' . $value . '")');
				}
			}
		}
	} // newtags
	if (isset($_GET['delete'])) {
		$kill = array();
		foreach ($_POST as $key => $value) {
			$key = postIndexDecode($key);
			$kill[] = $_zp_UTF8->strtolower($key);
		}
		if (count($kill) > 0) {
			$sql = "SELECT `id` FROM ".prefix('tags')." WHERE ";
			foreach ($kill as $tag) {
				$sql .= "`name`='".(mysql_real_escape_string($tag))."' OR ";
			}
			$sql = substr($sql, 0, strlen($sql)-4);
			$dbtags = query_full_array($sql);
			if (is_array($dbtags)) {
				$sqltags = "DELETE FROM ".prefix('tags')." WHERE ";
				$sqlobjects = "DELETE FROM ".prefix('obj_to_tag')." WHERE ";
				foreach ($dbtags as $tag) {
					$sqltags .= "`id`='".$tag['id']."' OR ";
					$sqlobjects .= "`tagid`='".$tag['id']."' OR ";
				}
				$sqltags = substr($sqltags, 0, strlen($sqltags)-4);
				query($sqltags);
				$sqlobjects = substr($sqlobjects, 0, strlen($sqlobjects)-4);
				query($sqlobjects);
			}
		}
	} // delete
	if (isset($_GET['rename'])) {
		foreach($_POST as $key=>$newName) {
			if (!empty($newName)) {
				$newName = sanitize($newName, 3);
				$key = postIndexDecode($key);
				$key = substr($key, 2); // strip off the 'R_'
				$newtag = query_single_row('SELECT `id` FROM '.prefix('tags').' WHERE `name`="'.mysql_real_escape_string($newName).'"');
				$oldtag = query_single_row('SELECT `id` FROM '.prefix('tags').' WHERE `name`="'.escape($key).'"');
				if (is_array($newtag)) { // there is an existing tag of the same name
					$existing = $newtag['id'] != $oldtag['id']; // but maybe it is actually the original in a different case.
				} else {
					$existing = false;
				}
				if ($existing) {
					query('DELETE FROM '.prefix('tags').' WHERE `id`='.$oldtag['id']);
					query('UPDATE '.prefix('obj_to_tag').' SET `tagid`='.$newtag['id'].' WHERE `tagid`='.$oldtag['id']);
				} else {
					query('UPDATE '.prefix('tags').' SET `name`="'.escape($newName).'" WHERE `id`='.$oldtag['id']);
				}
			}
		}
	} // rename
}

echo "<h1>".gettext("Tag Management")."</h1>";
if ($tagsort == 1) {
	echo '<a class="tagsort" href="?tagsort=0' .
 				'" title="'.gettext('Sort the tags alphabetically').'">';
	echo ' '.gettext('Order alphabetically').'</a>';
} else{
	echo '<p><a class="tagsort" href="?tagsort=1' .
 				'" title="'.gettext('Sort the tags by most used').'">';
	echo ' '.gettext('Order by most used').'</a></p>';
}
echo "\n<table class=\"bordered\">";
echo "\n<tr>";
echo "\n<th>".gettext("Delete tags from the gallery")."</th>";
echo "\n<th>".gettext("Rename tags")."</th>";
echo "\n<th>";
echo gettext("New tags");
echo "</th>";
echo "\n</tr>";
echo "\n<tr>";

echo "\n<td valign='top'>";
echo "\n".'<form name="tag_delete" action="?delete=true&amp;tagsort='.$tagsort.'" method="post">';
tagSelector(NULL, '', true, $tagsort);
echo "\n<p align='center'><input type=\"submit\" class=\"tooltip\" id='delete_tags' value=\"".gettext("delete checked tags")."\" title=\"".gettext("Delete all the tags checked above.")."\"/></p>";
echo "\n</form>";
echo '<p>'.gettext('To delete tags from the gallery, place a checkmark in the box for each tag you wish to delete then press the <em>delete checked tags</em> button. The brackets contain the number of times the tag appears.').'</p>';
echo "\n</td>";

echo "\n<td valign='top'>";
echo "\n".'<form name="tag_rename" action="?rename=true&amp;tagsort='.$tagsort.'" method="post">';
echo "\n<ul class=\"tagrenamelist\">";
$list = $_zp_admin_ordered_taglist;
foreach($list as $item) {
	$listitem = 'R_'.postIndexEncode($item);
	echo "\n".'<li><label for="'.$listitem.'">'.$item.'<br /><input id="'.$listitem.'" name="'.$listitem.'" type="text"';
	echo " size='33'/></label></li>";
}
echo "\n</ul>";
echo "\n<p align='center'><input type=\"submit\" class=\"tooltip\" id='rename_tags' value=\"".gettext("rename tags")."\" title=\"".gettext("Save all the changes entered above.")."\" /></p>";
echo "\n</form>";
echo '<p>'.gettext('To change the value of a tag enter a new value in the text box below the tag. Then press the <em>rename tags</em> button').'</p>';
echo "\n</td>";

echo "\n<td valign='top'>";
echo '<form name="new_tags" action="?newtags=true&amp;tagsort='.$tagsort.'"method="post">';
echo "\n<ul class=\"tagnewlist\">";
for ($i=0; $i<40; $i++) {
	echo "\n".'<li><label for="new_tag_'.$i.'"><input id="new_tag_'.$i.'" name="new_tag_'.$i.'" type="text"';
	echo " size='33'/></label></li>";
}
echo "\n</ul>";
echo "\n<p align='center'><input type=\"submit\" class=\"tooltip\" id='save_tags' value=\"".gettext("save new tags")."\" title=\"".gettext("Add all the tags entered above.")."\" /></p>";
echo "\n</form>";
echo "\n<p>".gettext("Add tags to the list by entering their names in the input fields of the <em>New tags</em> list. Then press the <em>save new tags </em>button").'</p>';
echo "\n</td>";
echo "\n</tr>";
echo "\n</table>";

echo "\n" . '</div>';
echo "\n" . '</div>';

printAdminFooter();
echo "\n</body>";
echo "\n</html>";
?>



