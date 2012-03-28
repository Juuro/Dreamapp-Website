<?php 

function mysql_timestamp2german($t) { 
    return sprintf("%02d.%02d.%04d", 
                substr($t, 8, 2), 
                substr($t, 5, 2), 
                substr($t, 0, 4)); 
}

function get_unixtime($u) {
    return mktime(0, 0, 0, substr($u, 5, 2), substr($u, 8, 2), substr($u, 0, 4));
}

$db = @new mysqli('127.0.0.1', 'sebastian-engel', 'jMuaeObS4a', 'sengel_concerts');
if (mysqli_connect_errno()) {
    die ('Konnte keine Verbindung zur Datenbank aufbauen: '.mysqli_connect_error().'('.mysqli_connect_errno().')');
}
$sql = 'SELECT
    *
FROM
    concerts
ORDER BY date DESC';
$result = $db->query($sql);
if (!$result) {
    die ('Etwas stimmte mit dem Query nicht: '.$db->error);
}

while ($row = $result->fetch_assoc()) {

	echo get_unixtime($row['date'])." >= ".time()." ";
    if(get_unixtime($row['date']) >= time()){
        echo "<em>";
    }
    echo mysql_timestamp2german($row['date'])."  ";
    if(!isset($row['url'])){
        echo "<b>".$row['artist']."</b>";
    }
    else {
        echo "<a href='".$row['url']."'><b>".$row['artist']."</b></a>";
    }
    echo " ".$row['city']." ".$row['location']." <br />\n";
    if(get_unixtime($row['date']) >= time()){
        echo "</em>";
    }

}


echo "<br />".$result->num_rows." insgesamt<br />\n";

$result->close();
unset($result);

?>