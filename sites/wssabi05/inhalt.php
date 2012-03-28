
<div align="left">
<?php
    if(isset($_GET['section']) AND isset($dateien[$_GET['section']])) {
        include $dateien[$_GET['section']];
    } else {
        include $dateien['news'];
    }
	
?>
</div>