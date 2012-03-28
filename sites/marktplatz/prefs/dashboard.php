<?php
	include_once "common/database.php"; 
	$pageTitle = "Dashboard";

	if(isset($_SESSION['LoggedIn']) && $_SESSION['LoggedIn']==1){ 
		include_once "common/header.php";
		include_once "common/sidebar.php";
        include_once '../inc/class.users.inc.php'
?>
<article id="main">
	<h1>Content!</h1>
	<section class="content">
		Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Donec quam felis, ultricies nec, pellentesque eu, pretium quis, sem. Nulla consequat massa quis enim. Donec pede justo, fringilla vel, aliquet nec, vulputate eget, arcu. In enim justo, rhoncus ut, imperdiet a, venenatis vitae, justo. Nullam dictum felis eu pede mollis pretium. Integer tincidunt. Cras dapibus. Vivamus elementum semper nisi. Aenean vulputate eleifend tellus. Aenean leo ligula, porttitor eu, consequat vitae, eleifend ac, enim. Aliquam lorem ante, dapibus in, viverra quis, feugiat a, tellus.
	</section>
</article>
<?php 
	}
    else{
        header("Location: ../"); 
        exit; 
    }

    include_once "common/footer.php"; 
?>