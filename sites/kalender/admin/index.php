<?php

include "auth.php";
include "../inc/db.php";

?>

<!DOCTYPE HTML>

<!-- <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd"> -->
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="de" lang="de">
<head>
	<meta http-equiv="Content-type" content="text/html;charset=UTF-8" />
	
	
	<script type="text/javascript" src="js/ltrim.js"></script>
	<script type="text/javascript" src="js/sort_table.js"></script>
	
	
	
<script type="text/javascript" >
window.onload = function() {
	SortTable.init();
}
</script>
	
	
	<script type="text/javascript" src="js/custom.js"></script>	
	
	
<title>Belegungen</title>
<link rel="stylesheet" type="text/css" href="css/style.css" />
</head>
<body>

<p id="backto">
	<a href="../" title="Haben Sie sich Verlaufen?">&larr; Zurück zum Kalender</a>
</p>
<p id="logoff">
	Angemeldet als <?php echo $_SESSION['name']; ?> &bull; <a href="logout.php">abmelden</a>
</p>


<div id="wrapper">
	
	<h1>Belegungen</h1>
	
	<?php
	if(isset($_COOKIE)){
		$lala = $_COOKIE['username'];
		$lulu = $_COOKIE['password'];
	}
	
	if(isset($_POST['delete'])){
		$sql = 'DELETE FROM
					ereignisse 
				WHERE ID='.$_POST['id'].'';
		mysql_query($sql);
	}
	
	if(isset($_POST['active'])){
		$sql = 'UPDATE 
					ereignisse 
				SET 
					active='.$_POST['active'].' 
				WHERE 
					id = '.$_POST['id'].'';
		mysql_query($sql);
	}
	
	
	$sql = 'SELECT 
				* 
			FROM 
				ereignisse
	        ORDER BY
	            sdate'; 
				
	$result = mysql_query($sql);
	if (!$result) {
	    die ('Etwas stimmte mit dem Query nicht: '.$db->error);
	}
	
	echo "<p class='newbooking'><a href='neu.php'><img src='../img/add_16.png' alt='add_16' width='16' height='16'/> Neue Belegung</a></p>";
	echo "<table id='admin-datelist' class='sortable'>";
	echo	"<thead>";
	echo 	"<tr>";
	echo		"<th>#</th>";
	echo		"<th>ID</th>";
	echo		"<th class='no_sort'>l&ouml;schen</th>";
	echo		"<th class='no_sort'>Aktivit&auml;t</th>";
	echo		"<th title='ignore_case'>Titel</th>";
	echo		"<th>Anreise</th>";
	echo		"<th>Abreise</th>";
	echo		"<th title='ignore_case'>Notizen</th>";
	echo	"</tr>";
	echo 	"</thead>";
	
	echo 	"<tbody>";
	
	$i=0;
	while ($row = mysql_fetch_assoc($result)) {
			$i++;
			echo "<tr ";
			
			if (($i%2)!=0){
				echo "class='markedbg'";
			}
			echo ">";
			echo "<td>".$i."</td>";
			echo "<td>".$row['id']."</td>";
			echo "<td><form action='index.php' method='post' class='form'>";
			echo "<input type='hidden' name='id' value='".$row['id']."' />";
			if($row['active']==0){
				echo "<input type='hidden' name='delete' value='0' />";
				echo "<input class='submit' type='submit' value='l&ouml;schen' title='l&ouml;schen'/>";
			}			
			
			echo "</form></td>";
			
			if($row['active']==1){
	    		echo "<td class='active'><form action='index.php' method='post' class='form'>";
		       	echo "<input type='hidden' name='id' value='".$row['id']."' />";
				echo "<input type='hidden' name='active' value='0' />";
				echo "<input class='submit' type='submit' value='deaktivieren'/>";
				echo "</form></td>";
			}
			elseif($row['active']==0){   
	    		echo "<td class='inactive'><form action='index.php' method='post' class='form'>";
		       	echo "<input type='hidden' name='id' value='".$row['id']."' />";
				echo "<input type='hidden' name='active' value='1' />";
				echo "<input class='submit' type='submit' value='aktivieren'/>";
	    		echo "</form></td>";
			}
			
			echo "<td>".$row['title']."</td>";
			echo "<td>".date("d.m.Y",$row['sdate'])."</td>";
			echo "<td>".date("d.m.Y",$row['edate'])."</td>";
			echo "<td>".$row['notizen']."</td>";
			echo "</tr>";
	}
	echo	"</tbody>";
	echo "</table>";
	
	mysql_close($link);
	unset($result);
	
	
	unset($_POST);
	
	include "../inc/footer.php";
	?>

</div>

</body>
</html>