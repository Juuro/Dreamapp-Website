<?php
header('Content-type: text/html; charset=utf-8');

include_once "common/database.php"; 
$pageTitle = "Home"; 
include_once "common/header.php"; 
include_once 'inc/class.categorycloud.inc.php';

$categories = new CategoryCloud($db);
$catcloud = $categories->getCatSize(10, 32, 25);
?>

<div id="main">
	
	<div id="indexmain">
		<div id="indexsearch">
			<h1>marktplatz.cc</h1>
			<form method="get" action="index.php">
		    	<input type="search" id="indexsearchfield" class="textfield" name="search" />
		    	<!--<button type="submit" id="indexsearchbutton" name="submit" title="Suchen!"></button>-->
			</form>
		</div>
		<div id="categorys">
			<div>
				<p><?php echo $catcloud; ?></p>
			</div>
		</div>
	</div>
	
   <noscript>This site just doesn't work, period, without JavaScript</noscript>

   <!-- IF LOGGED IN -->

          <!-- Content here -->

   <!-- IF LOGGED OUT -->

          <!-- Alternate content here -->

</div>

<?php include_once "common/footer.php"; ?>