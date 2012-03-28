<?php
function getDateCompleteMonth($i, $numberofdays, $belegtetage){
    $sql = "SELECT
        *   
    FROM ereignisse
    WHERE 
        FROM_UNIXTIME(sdate, '%Y%m') < ".date("Ym",$i)."
        AND
        FROM_UNIXTIME(edate, '%Y%m') > ".date("Ym",$i)."
        AND
        active = 1
    ";
    $result = mysql_query($sql);
    if (!$result) {
        echo mysql_errno() . ": " . mysql_error() . "\n";
    }
    
    if (mysql_num_rows($result) != 0){
        //$belegtetage-array vollschreiben   
                for($i=1;$i<=$numberofdays;$i++){
                $belegtetage[$i] = 1;
        }        
        $i == 0;
        while ($row = mysql_fetch_assoc($result)) {  // NULL ist Šquivalent zu false
            // $row ist nun das Array mit den Werten           
            for ($i = 0; $i < sizeof($row); $i++){
                next($row);
            }
        }
    }
    
    return $belegtetage;
}

function getDatePreviousMonth($i, $numberofdays, $belegtetage){
    $sql = "SELECT
        FROM_UNIXTIME(edate, '%e')   
    FROM ereignisse
    WHERE 
        FROM_UNIXTIME(sdate, '%Y%m') < ".date("Ym",$i)."
        AND
        FROM_UNIXTIME(edate, '%Y%m') = ".date("Ym",$i)."
        AND
        active = 1
    ";
    $result = mysql_query($sql);
    if (!$result) {
        echo mysql_errno() . ": " . mysql_error() . "\n";
    }
    
    if (mysql_num_rows($result) != 0){
        $i == 0;
        while ($row = mysql_fetch_assoc($result)) {  // NULL ist Šquivalent zu false   
            // $row ist nun das Array mit den Werten           
            for ($i = 0; $i < sizeof($row); $i++)
            {
                //$belegtetage-array vollschreiben        
                for($i=1;$i<=(current($row));$i++){
                    $belegtetage[$i] = 1;
                }
                next($row);
            }
        }
    }
    
    return $belegtetage;
}

function getDateFollowMonth($i, $numberofdays, $belegtetage){
    $sql = "SELECT
        FROM_UNIXTIME(sdate, '%e')   
    FROM ereignisse
    WHERE 
        FROM_UNIXTIME(sdate, '%Y%m') = ".date("Ym",$i)."
        AND
        FROM_UNIXTIME(edate, '%Y%m') > ".date("Ym",$i)." 
        AND
        active = 1     
    ";
    $result = mysql_query($sql);
    if (!$result) {
        echo mysql_errno() . ": " . mysql_error() . "\n";
    }
    
     if (mysql_num_rows($result) != 0){
                
        $i == 0;
        while ($row = mysql_fetch_assoc($result)) {  // NULL ist Šquivalent zu false
            // $row ist nun das Array mit den Werten           
            for ($i = 0; $i < sizeof($row); $i++)
            {
                //$belegtetage-array vollschreiben        
                for($i=(current($row));$i<=$numberofdays;$i++){
                    $belegtetage[$i] = 1;
                }
                next($row);
            }
        }
    }
    
    return $belegtetage;
}

function getDateActualMonth($i, $numberofdays, $belegtetage){
    $sql = "SELECT
        FROM_UNIXTIME(sdate, '%e'),
        FROM_UNIXTIME(edate, '%e') 
    FROM ereignisse
    WHERE 
        FROM_UNIXTIME(sdate, '%Y%m') = ".date("Ym",$i)."
        AND
        FROM_UNIXTIME(edate, '%Y%m') = ".date("Ym",$i)."
        AND
        active = 1
    ";
    $result = mysql_query($sql);
    if (!$result) {
        echo mysql_errno() . ": " . mysql_error() . "\n";
    }
    
    if (mysql_num_rows($result) != 0){
        $j == 0;
        while ($row = mysql_fetch_assoc($result)) {  // NULL ist Šquivalent zu false
            // $row ist nun das Array mit den Werten                     
            for ($j = 0; $j < sizeof($row)/2; $j++)
            {   
                //$belegtetage-array vollschreiben        
                for($i=(current($row));$i<=(end($row));$i++){
                    $belegtetage[$i] = 1;
                }
                next($row);
            }
            
        }
    }
    
    return $belegtetage;
}

/* Day functions */

function getDateCompleteDay($i){
    $row = array();
    $sql = "SELECT
        id   
    FROM 
        ereignisse
    WHERE 
        FROM_UNIXTIME(sdate, '%Y%m%d') < ".date("Ymd",$i)."
        AND
        FROM_UNIXTIME(edate, '%Y%m%d') > ".date("Ymd",$i)."
        AND
        active = 1
    ";
    $result = mysql_query($sql);
    if (!$result) {
        echo mysql_errno() . ": " . mysql_error() . "\n";
    }
    
    if (mysql_num_rows($result) != 0){     
        $i == 0;
        $row = mysql_fetch_row($result);
    }
    
    return $row;
}
function getDatePreviousDay($i){
    $row = array();
    $sql = "SELECT
                id 
            FROM 
                ereignisse
            WHERE 
                FROM_UNIXTIME(sdate, '%Y%m%d') < ".date("Ymd",$i)."
                AND
                FROM_UNIXTIME(edate, '%Y%m%d') = ".date("Ymd",$i)."
                AND
                active = 1
            ";
    $result = mysql_query($sql);
    if (!$result) {
        echo mysql_errno() . ": " . mysql_error() . "\n";
    }
    
    if (mysql_num_rows($result) != 0){
        $i == 0;
        $row = mysql_fetch_row($result);
    }
    
    return $row;
}
function getDateFollowDay($i){
    $row = array();
    $sql = "SELECT
                id 
            FROM 
                ereignisse
            WHERE 
                FROM_UNIXTIME(sdate, '%Y%m%d') = ".date("Ymd",$i)."
                AND
                FROM_UNIXTIME(edate, '%Y%m%d') > ".date("Ymd",$i)." 
                AND
                active = 1     
            ";
    $result = mysql_query($sql);
    if (!$result) {
        echo mysql_errno() . ": " . mysql_error() . "\n";
    }
    
    if (mysql_num_rows($result) != 0){                
        $i == 0;
        $row = mysql_fetch_row($result);
    }   
    
    return $row;
}
function getDateActualDay($i){
    $row = array();
    $sql = "SELECT
                id
            FROM 
                ereignisse
            WHERE 
                FROM_UNIXTIME(sdate, '%Y%m%d') = ".date("Ymd",$i)."
                AND
                FROM_UNIXTIME(edate, '%Y%m%d') = ".date("Ymd",$i)."
                AND
                active = 1
            ";
    $result = mysql_query($sql);
    if (!$result) {
        echo mysql_errno() . ": " . mysql_error() . "\n";
    }
    
    if (mysql_num_rows($result) != 0){                
        $i == 0;
        $row = mysql_fetch_row($result);
    }   
    
    return $row;
}

function getDateDetails($id){
    $sql = "SELECT
                *
            FROM
                ereignisse
            WHERE
                id = '".$id."'";
    $result = mysql_query($sql);
    if (!$result) {
        echo mysql_errno() . ": " . mysql_error() . "\n";
    }
    if (mysql_num_rows($result) != 0){     
        $i == 0;
        $row = mysql_fetch_row($result);
    }
    return $row;
}

function getPreviousDay($day, $month, $year){
	if($day==1){
		if($month==1){
			$month = 12;
			$day = date("t",mktime(0, 0, 0, $month, $day, $year));
			$year--;
		}
		else{
			$month--;			
			$day = date("t",mktime(0, 0, 0, $month, $day, $year));
		}
	}
	else {
		$day--;
	}	
	return "<a href='tag.php?tag=".$day."&amp;monat=".$month."&amp;jahr=".$year."'><img src='img/l_arrow.png' alt='arrow_right_black' title='".$day.".".$month.".".$year."' height='13' /></a>";
}

function getNextDay($day, $month, $year){
	if($day==date("t",mktime(0, 0, 0, $month, $day, $year))){
		if($month==12){
			$month = 1;
			$day = 1;
			$year++;
		}
		else{
			$month++;			
			$day = 1;
		}
	}
	else {
		$day++;
	}	
	return "<a href='tag.php?tag=".$day."&amp;monat=".$month."&amp;jahr=".$year."'><img src='img/r_arrow.png' alt='arrow_right_black' title='".$day.".".$month.".".$year."' height='13' /></a>";}

function getPreviousMonth($month, $year, $a_monat){
	if($month == 1){
	   $month = 12;
	   $year--;
	}
	else {
	   $month--;
	}
	return "<a href='index.php?monat=".$month."&amp;jahr=".$year."'><img src='img/l_arrow.png' alt='arrow_right_black' title='".$a_monat[$month]."' height='13' /></a>";
}

function getNextMonth($month, $year, $a_monat){
	if($month == 12){
	   $month = 1;
	   $year++;
	}
	else {
	   $month++;
	}
	return "<a href='index.php?monat=".$month."&amp;jahr=".$year."'><img src='img/r_arrow.png' alt='arrow_right_black' title='".$a_monat[$month]."' height='13' /></a>";
}

function getPreviousYear($year){
	$year--;
	return "<a href='jahr.php?jahr=".$year."'><img src='img/l_arrow.png' alt='arrow_right_black' title='".$year."' height='13' /></a>";
}
function getNextYear($year){
	$year++;
	return "<a href='jahr.php?jahr=".$year."'><img src='img/r_arrow.png' alt='arrow_right_black' title='".$year."' height='13' /></a>";
}

?>