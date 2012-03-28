<?php
/**
 * provides the Plugins tab of admin
 * @package admin
 */

// force UTF-8 Ø

define('OFFSET_PATH', 1);
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
$_GET['page'] = 'plugins';

/* handle posts */
$saved = false;
if (isset($_GET['action'])) {
	if ($_GET['action'] == 'saveplugins') {
		$curdir = getcwd();
		chdir(SERVERPATH . "/" . ZENFOLDER . PLUGIN_FOLDER);
		$filelist = safe_glob('*'.'php');
		chdir($curdir);
		foreach ($filelist as $extension) {
			$extension = FilesystemToUTF8($extension);
			$opt = 'zp_plugin_'.substr($extension, 0, -4);
			setBoolOption($opt, isset($_POST[$opt]));
		}
		$saved = true;
	}
}
printAdminHeader();
echo "\n</head>";
echo "\n<body>";
printLogoAndLinks();
echo "\n" . '<div id="main">';
printTabs('plugins');
echo "\n" . '<div id="content">';

/* Page code */

if ($saved) {
	echo '<div class="messagebox" id="fade-message">';
	echo  "<h2>".gettext("Saved")."</h2>";
	echo '</div>';
}

$curdir = getcwd();
chdir(SERVERPATH . "/" . ZENFOLDER . PLUGIN_FOLDER);
$filelist = safe_glob('*'.'php');
foreach ($filelist as $key=>$plugin) {
	$filelist[$key] = FilesystemToUTF8($plugin);
}
natcasesort($filelist);

echo "<h1>Plugins</h1>\n";
echo '<p>';
echo gettext("Plugins provide optional functionality for Zenphoto.").' ';
echo gettext("They may be provided as part of the Zenphoto distribution or as offerings from third parties.").' ';
echo gettext("Plugins are placed in the <code>zp-core/plugins</code> folder and are automatically discovered.").' ';
echo gettext("If the plugin checkbox is checked, the plugin will be loaded and its functions made available to theme pages. If the checkbox is not checked the plugin is disabled and occupies no resources.");
echo "</p>\n";
echo '<form action="?action=saveplugins" method="post">'."\n";
echo '<input type="hidden" name="saveplugins" value="yes" />'."\n";
echo '<input type="submit" value='. gettext('save').' />' . "\n";
echo "<table class=\"bordered\" width=\"100%\">\n";
foreach ($filelist as $extension) {
	
	$ext = substr($extension, 0, strlen($extension)-4);
	$opt = 'zp_plugin_'.$ext;
	
	$pluginStream = file_get_contents(UTF8ToFilesystem($extension));
	$parserr = 0;
	$str = isolate('$plugin_description', $pluginStream);
	if (false === $str) {
		$plugin_description = '';
	} else {
		if (false === eval(isolate('$plugin_description', $pluginStream))) {
			$parserr = $parserr | 1;
			$plugin_description = gettext('<strong>Error parsing <em>plugin_description</em> string!</strong> Try removing semicolons from string.');
		}
	}
	$str = isolate('$plugin_author', $pluginStream);
	if (false === $str) {
		$plugin_author = '';
	} else {
		if (false === eval($str)) {
			$parserr = $parserr | 2;
			$plugin_author = gettext('<strong>Error parsing <em>plugin_author</em> string!</strong> Try removing semicolons from string.');
		}
	}
	$str = isolate('$plugin_version', $pluginStream);
	if (false === $str) {
		$plugin_version = '';
	} else {
		if (false === eval($str)) {
			$parserr = $parserr | 4;
			$plugin_version = ' '.gettext('<strong>Error parsing <em>plugin_version</em> string!</strong> Try removing semicolons from string.');
		}
	}
	$str = isolate('$plugin_URL', $pluginStream);
	if (false === $str) {
		$plugin_URL = '';
	} else {
		if (false === eval($str)) {
			$parserr = $parserr | 8;
			$plugin_URL = gettext('<strong>Error parsing <em>plugin_URL</em> string!</strong> Try removing semicolons from string.');
		}
	}
	$str = isolate('$plugin_disable', $pluginStream);
	if (false === $str) {
		$plugin_disable = false;
	} else {
		if (false === eval($str)) {
			$parserr = $parserr | 8;
			$plugin_URL = gettext('<strong>Error parsing <em>plugin_disable</em> string!</strong> Try removing semicolons from string.');
		} else {
			if ($plugin_disable) {
				setOption($opt, 0);
			}
		}
	}
	
	echo "<tr>";
	echo '<td width="30%">';
	echo '<input type="checkbox" name="'.$opt.'" value="1"';
	if ($parserr || $plugin_disable) {
		echo 'DISABLED';
	} else {
		echo checked('1', getOption($opt));
	}
	echo ' /> ';
	echo '<strong>'.$ext.'</strong>';

	if (!empty($plugin_version)) {
		echo ' v'.$plugin_version;
	}
	echo '</td>';
	echo '<td>';
	echo $plugin_description;
	if (!empty($plugin_URL)) {
		if ($parserr & 8) {
			echo '<br />'.$plugin_URL;
		} else {
			echo '<br /><a href="'.$plugin_URL.'"><strong>'.gettext("Usage information").'</strong></a>';
		}
	}
	if (!empty($plugin_author)) {
		echo '<br />';
		if (!($parserr & 2)) {
			echo '<strong>'.gettext("Author").'</strong>: ';
		}
		echo $plugin_author;
	}
	echo '</td>';
	echo "</tr>\n";
}
echo "</table>\n";
echo '<input type="submit" value='. gettext('save').' />' . "\n";
echo "</form>\n";
chdir($curdir);

echo "\n" . '</div>';  //content
echo "\n" . '</div>';  //main

printAdminFooter();
echo "\n</body>";
echo "\n</html>";
?>



