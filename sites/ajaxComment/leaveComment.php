<?php
require 'config.php';

if(IS_AJAX) {
	$post['name'] = $_POST['name']; 
	$post['email'] = $_POST['email']; 
	$post['comment'] = $_POST['comment'];
} 


$mysqli = new mysqli($server, $username, $password, $db) or die('There was a problem connecting');

if($stmt = $mysqli->prepare("INSERT INTO comments VALUES(NULL,?,?,?)")) {

	$stmt->bind_param('sss', $post['name'], $post['email'], $post['comment']);

	if(!$stmt->execute()) die($mysqli->error);
	$stmt->close();

	if(IS_AJAX) {
		echo "<h3>" .$post['name'] . "</h3>";
		echo "<p>" . $post['comment'] . "</p>";
	}
	header('location:index.php');
	
}

else echo 'ERROR!';