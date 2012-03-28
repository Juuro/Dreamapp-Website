<?php
	include_once "common/database.php"; 
	$pageTitle = "Dashboard";

	if(isset($_SESSION['LoggedIn']) && $_SESSION['LoggedIn']==1){ 
        include_once '../inc/class.users.inc.php';
		include_once "common/header.php";
		include_once "common/sidebar.php";
?>
<article id="main">
	<div class="inside-main">
		<h1>Artikel</h1>
		
		
		
		<table class="list">
			<thead>
				<tr>
					<th class="checkbox"><input type="checkbox" name="check_all" value="0" /></th>
					<th class="article">Artikel</th>
					<th class="tags">Tags</th>
					<th class="category">Kategorie</th>
					<th class="duration">Laufzeit</th>
					<th class="price">Preis</th>
				</tr>
			</thead>
			<tbody>
				<tr class="alternate">
					<td class="checkbox center"><input type="checkbox" value="1" /></td>
					<td class="article">
						<img src="../img/article-image.png" alt="article-image" width="106" height="71" />
						<h3>Holzbadewanne</h3>
						Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis ...
						<div class="actions"><a href="">bearbeiten</a> <a href="">löschen</a> <a href="">ansehen</a></div>
					</td>
					<td class="tags">Mood</td>
					<td class="category">Mood</td>
					<td class="duration">Happy</td>
					<td class="price">Happy</td>
				</tr>
				<tr>
					<td class="checkbox center"><input type="checkbox" value="2" /></td>
					<td class="article">
						<img src="../img/article-image.png" alt="article-image" width="106" height="71" />
						<h3>Kindersitzbierflaschenhalter</h3>
						Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis ...
						<div class="actions"><a href="">bearbeiten</a> <a href="">löschen</a> <a href="">ansehen</a></div>
					</td>
					<td class="tags">Grade</td>
					<td class="category">Grade</td>
					<td class="duration">19.04.2009 - 23.06.2010</td>
					<td class="price">Passing</td>
				</tr>
			</tbody>
			<tfoot>
				<tr>
					<th class="checkbox center"><input type="checkbox" name="check_all" value="0" /></th>
					<th class="article">Artikel</th>
					<th class="tags">Tags</th>
					<th class="category">Kategorie</th>
					<th class="duration">Laufzeit</th>
					<th class="price">Preis</th>
				</tr>
			</tfoot>
		</table>
		
		
		
		
		<!--
<section class="content">
			Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Donec quam felis, ultricies nec, pellentesque eu, pretium quis, sem. Nulla consequat massa quis enim. Donec pede justo, fringilla vel, aliquet nec, vulputate eget, arcu. In enim justo, rhoncus ut, imperdiet a, venenatis vitae, justo. Nullam dictum felis eu pede mollis pretium. Integer tincidunt. Cras dapibus. Vivamus elementum semper nisi. Aenean vulputate eleifend tellus. Aenean leo ligula, porttitor eu, consequat vitae, eleifend ac, enim. Aliquam lorem ante, dapibus in, viverra quis, feugiat a, tellus.
		</section>
-->


	</div>
</article>
<?php 
	}
    else{
        header("Location: ../"); 
        exit; 
    }

    include_once "common/footer.php"; 
?>