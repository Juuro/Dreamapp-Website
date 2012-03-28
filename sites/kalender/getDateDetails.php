<?php
include "admin/auth.php";
include "functions.php";	
include "inc/db.php";
include "inc/read-cookie.php";

$timestamp = $_GET['timestamp'];

$belegungen = array_merge(getDateCompleteDay($timestamp), getDatePreviousDay($timestamp), getDateFollowDay($timestamp), getDateActualDay($timestamp));

if(count($belegungen) != 0){
    for($i=0;$i<count($belegungen);$i++){
        $datedetails = getDateDetails($belegungen[$i]);
        
        for ($j=1;$j<count($datedetails)-2;$j++){
            if(preg_match("/^\d{10}$/",$datedetails[$j])){
                $datedetails[$j] = date("d.m.Y",$datedetails[$j])." ".date("H:i",$datedetails[$j])." Uhr";
            }
        }
        ?>
        
        <p>von: <b><?php echo $datedetails[2] ?></b></p><p>bis: <b><?php echo $datedetails[3] ?></b></p><p><?php echo $datedetails[1] ?></p>
        
        <?php
    }
}

?>