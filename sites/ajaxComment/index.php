<?php

if(isset($_POST['submit'])) {
	$post = array();

	foreach($_POST as $key=>$value) {
		if(isset($_POST[$key]) && strlen(trim($value)) >= 2) {
			$post[$key] = $value;
		}
		else $error = true;
	
		if($key === 'email' ) {
			if(!filter_var($value, FILTER_VALIDATE_EMAIL)) $error = true;
		}
	} // end foreach
	
	if(!$error) {
		require 'leaveComment.php';
	}
}

?>
<!DOCTYPE html>

<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"> 
	<title>ajaxComments</title>
	<style type="text/css" media="screen">
	body {
		font-family: helvetica, arial;
		line-height: 1.4em;
	}
	#container {
		width: 700px;
		margin: 10px auto 150px;
		color: #454545;
	}

	ul {
		margin: 0;
		padding: 0;
		list-style: none;
	}

	h3 {
		margin: 0;
		padding: 0;
		color: black;
	}

	h2 {
		color: #292929;
		font-size: 40px;
		margin-top: 40px;
	}

	p {
		font-size: 14px;
	}

	#addComment {
		margin-top: 40px;
		position: relative;
	}

	input, textarea {
		padding: .4em;
	}

	#comments li {
		border-top: 1px solid white;
		border-bottom: 1px solid #bcbbbb;
		padding: 20px 0 14px;
	}

	#comments li:last-child {
		border-bottom: none;
	}
	#comments li:first-child {
		border-top: none;
		padding-top: 0;
	}

	#comments, #addComment {
		background: #e3e3e3;
		border: 1px solid #bcbbbb;
		padding: 2em;
		-moz-border-radius: 2px;
		-webkit-border-radius: 2px;
	}

	input[type=text] {
		width: 70%;
	}
	textarea {
		width: 100%;
	}

	.error {font-style: italic; color: red;}
	
	.overlay {
		width: 100%;
		height: 100%;
		background: black url(loader.gif) no-repeat 50% 50%;
		position: absolute;
		left: 0;
		top: 0;
		display: none;
		opacity: .9;
	}	


	</style>
</head>
<body>
	
	<div id="container">
	
		<h2>ajaxComments</h2>

		<ul id="comments"> <?php require 'getItemsFromDatabase.php'; ?> </ul>
		
		<h2 id="leaveAComment">Leave a Comment</h2>		
		<div id="addComment">
			<form action="index.php" method="post">
				<p><input type="text" id="name" name="name" value="<?php echo $_POST['name'];?>" />
				<p><input type="text" id="email" name="email" value="<?php echo $_POST['email'];?>" />
				<p><textarea name="comment" id="comment" rows="8" cols="40"><?php echo $_POST['comment'];?></textarea>
								
				<p><input type="submit" name="submit" id="submit" value="Post Comment"></p>
				<?php if(isset($error)) echo "<p class='error'>Please fill out each field correctly.</p>"; ?>
			</form>
		</div>
	
	</div> <!-- end container-->
	
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.min.js" type="text/javascript" charset="utf-8"></script>	

<script type="text/javascript">
	
$('#submit').click(function() {

	var name = $('#name').val().replace(/[^\w\d ]+/gi, ''),
		email = $('#email').val().match(/^([a-zA-Z0-9_\-\.]+)@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/i) ? $('#email').val() : null,
		comment = $('#comment').val();

	if(name.length < 2 || comment.length < 4 || email === null) {	
		if($('.error').length === 0) {
			$('form').append('<p class="error">Please fill out each field.</p>');
		}
		return false;
	}

	$.post(
		'leaveComment.php', {
	
		'name' : name, 
		'email' : email, 
		'comment' : comment 
		}, 
		
		function(r) {			
			$('.error').fadeOut(200);
			
			$('<div class="overlay"></div>')
				.appendTo('#addComment')
	   	        .fadeIn(1000, function() {
			       $('#comments')
			  	       .append('<li>' + r + '</li>')
			  		       .children(':last')
			  			   .height($('#comments li:last').height())
			  			   .hide()
			  			   .slideDown(800, function() {	
						       var bodyHeight = $('html').height();
			  				   $('#addComment').fadeOut(1000, function() {
							       $('html').height(bodyHeight);
								   $('h2#leaveAComment').fadeOut(200, function(){$(this).text('Thank you for your comment!').fadeIn(200)});
							   });
						   });			
	   		  });
		}
		
	); // end post
	
	return false; // disable submit click
	
});
	
</script>
     
</body>
</html>	