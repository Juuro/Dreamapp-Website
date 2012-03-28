<?php

include 'db.php';

?>

<html>
<head>
<title>Grundlagen der Internettechnologien - Students</title>
<link href="css/style.css" type="text/css" rel="stylesheet" /> 
</head>
<body>

<?php

$query = "SELECT * FROM student";

$result = mysql_query($query);

echo "<table class='students'>";
echo "<tr>";
echo "<th>MtkNr</th>";
echo "<th>Nachname</th>";
echo "<th>Vorname</th>";
echo "<th>Fach</th>";
echo "</tr>";
while($row = mysql_fetch_object($result))
{
    echo "<tr>";
    echo "<td>".$row->mtknr."</td>";
    echo "<td>".$row->nname."</td>";
    echo "<td>".$row->vname."</td>";
    echo "<td>".$row->fach."</td>";    
    echo "</tr>";
}
echo "</table>";

?>

</body>
</html>