<?php

    include 'db.php';

?>

<!DOCTYPE html >
<html>
<head>
    <meta http-equiv="X-UA-Compatible" content="chrome=1">

    <!--
        /**
        * o------------------------------------------------------------------------------o
        * | This file is part of the RGraph package - you can learn more at:             |
        * |                                                                              |
        * |                          http://www.rgraph.net                               |
        * |                                                                              |
        * | This package is licensed under the RGraph license. For all kinds of business |
        * | purposes there is a small one-time licensing fee to pay and for non          |
        * | commercial  purposes it is free to use. You can read the full license here:  |
        * |                                                                              |
        * |                      http://www.rgraph.net/LICENSE.txt                       |
        * o------------------------------------------------------------------------------o
        */
    -->
    <title>iPhone acceleration</title>
    
    <meta name="keywords" content="rgraph html5 canvas example line chart" />
    <meta name="description" content="RGraph: Javascript charts library - Line chart example" />

    <link rel="stylesheet" href="../css/website.css" type="text/css" media="screen" />
    <link rel="icon" type="image/png" href="../images/favicon.png">
    
    <!-- Place this tag in your head or just before your close body tag -->
    <script type="text/javascript" src="https://apis.google.com/js/plusone.js"></script>

    <script src="./libraries/RGraph.common.core.js" ></script>
    <script src="./libraries/RGraph.common.context.js" ></script>
    <script src="./libraries/RGraph.common.annotate.js" ></script>
    <script src="./libraries/RGraph.common.tooltips.js" ></script>
    <script src="./libraries/RGraph.common.zoom.js" ></script>
    <script src="./libraries/RGraph.common.resizing.js" ></script>
    <script src="./libraries/RGraph.line.js" ></script>
    <!--[if IE 8]><script src="./excanvas/excanvas.original.js"></script><![endif]-->
    
    <?php
        
        $sql1 = "SELECT updatedHeading FROM `PDR`";
        $result1 = mysql_query($sql1);
        
        $sql2 = "SELECT updatedHeading2 FROM `PDR`";
        $result2 = mysql_query($sql2);
        
        $sql3 = "SELECT realHeading FROM `PDR`";
        $result3 = mysql_query($sql3);
        
    ?>

    <script>
        window.onload = function ()
        {
            var line1 = new RGraph.Line('line1', 
                [<?php while ($row1 = mysql_fetch_assoc($result1)) { echo $row1['updatedHeading'].","; } ?>], 
                [<?php while ($row2 = mysql_fetch_assoc($result2)) { echo $row2['updatedHeading2'].","; } ?>],
                [<?php while ($row3 = mysql_fetch_assoc($result3)) { echo $row3['realHeading'].","; } ?>]);
            line1.Set('chart.background.barcolor1', 'white');
            line1.Set('chart.background.barcolor2', 'white');
            line1.Set('chart.background.grid', true);
            line1.Set('chart.linewidth', 1);
            line1.Set('chart.gutter.left', 35);
            //line1.Set('chart.hmargin', 5);
            line1.Set('chart.shadow', false);
            line1.Set('chart.tickmarks', true);
            //line1.Set('chart.colors', ['red', 'green']);
            line1.Set('chart.key', ['updatedHeading','updatedHeading2','realHeading']);
            line1.Set('chart.key.shadow', false);
            line1.Set('chart.key.shadow.offsetx', 0);
            line1.Set('chart.key.shadow.offsety', 0);
            line1.Set('chart.key.shadow.blur', 15);
            line1.Set('chart.key.shadow.color', '#ddd');
            line1.Set('chart.key.rounded', false);
            line1.Set('chart.key.position', 'graph');
            line1.Set('chart.key.position.x', line1.Get('chart.gutter.left') + 5);
            line1.Set('chart.key.position.y', 370)
            //line1.Set('chart.xaxispos', 'center');
            line1.Set('chart.title', 'iPhone Heading');
            line1.Draw();
            
            /*
            var line2 = new RGraph.Line('line2', [6,5,4,5,6,4,1,2,3], [7,8,9,9,8,7,8,7,6]);
            line2.Set('chart.labels', ['13th','14th','15th','16th','15th','16th','17th','18th','19th']);
            line2.Set('chart.title', 'Range of fuel consumption');
            line2.Set('chart.title.vpos', 0.5);
            line2.Set('chart.background.barcolor1', 'white');
            line2.Set('chart.background.barcolor2', 'white');
            line2.Set('chart.filled', true);
            line2.Set('chart.filled.range', true);
            line2.Set('chart.fillstyle', 'rgba(128,255,128,0.5)');
            line2.Set('chart.linewidth', 2);
            line2.Set('chart.colors', ['green']);
            line2.Set('chart.hmargin', 5);
            line2.Draw();
            */
        }
    </script>



</head>
<body>
    <div>
        <canvas id="line1" width="1200" height="500">[Please wait...]</canvas>
        <!--<canvas id="line2" width="475" height="250">[Please wait...]</canvas>-->
    </div>

</body>
</html>