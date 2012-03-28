<?php

require 'config.php';


$mysqli = new mysqli($server, $username, $password, $db) or die('There was a problem connecting');
$stmt = $mysqli->prepare("SELECT * FROM comments ORDER BY id");
$stmt->execute();
$stmt->bind_result($id, $name, $email, $comment); 

while($row = $stmt->fetch()) : ?>

<li>
	<h3> <?php echo $name; ?> </h3>
	<p> <?php echo $comment; ?> </p>
</li>

<?php endwhile; ?>