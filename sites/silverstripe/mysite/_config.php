<?php

global $project;
$project = 'mysite';

global $databaseConfig;
$databaseConfig = array(
	"type" => "MySQLDatabase",
	"server" => "127.0.0.1", 
	"username" => "sebastian-engel", 
	"password" => "jMuaeObS4a", 
	"database" => "sengel_silverstripe",
);

// Sites running on the following servers will be
// run in development mode. See
// http://doc.silverstripe.com/doku.php?id=devmode
// for a description of what dev mode does.
Director::set_dev_servers(array(
	'localhost',
	'127.0.0.1',
));

// This line set's the current theme. More themes can be
// downloaded from http://www.silverstripe.com/themes/
SSViewer::set_theme('blackcandy');

?>