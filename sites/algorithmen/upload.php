<?php
	$uploaddir = '/home/sebastian-engel.de/home/twoseb.de/sites/algorithmen/uploads/';
	$uploadfile = $uploaddir. basename($_FILES['thefile']['name']);

	print "<pre>";
	print $_FILES['thefile']['error'];
	if(move_uploaded_file($_FILES['thefile']['tmp_name'], $uploadfile)) {
		print "File is valid, and was successfully uploaded.";
		print "Here's some more debugging info:\n";
		print_r($_FILES);
	} else {
		print "Possible file upload attack!  Here's some debugging info:\n";
		print_r($_FILES);
	}
	print "</pre>";

?>

<html>
<head>
</head>
<body>

<form action="upload.php" method="post" class="form" enctype="multipart/form-data">
<p>
	<label for="photo">Foto (JPG)</label>
	<input name="thefile" type="file" id="photo" class="required">
</p>
<p>
	<input class="submit" type="submit" value="Abschicken"/>
</p>
<form action="/bewerben/" method="post" class="form" enctype="multipart/form-data">

</body>
</html>