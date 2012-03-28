<?php

for ($i=0; $i < sizeof($nodes); $i++){
    echo "Key: ".$nodes[$i]->key."<br />";
    echo "Parent: ".$nodes[$i]->parent->key."<br />";
    echo "IsLeft:".$nodes[$i]->isleft."<br />";
    echo "IsRight: ".$nodes[$i]->isright."<br />";
    echo "LeftChild: ".$nodes[$i]->left."<br />";
    echo "RightChild: ".$nodes[$i]->right."<br />";
    echo "<hr noshade width='150px' color='#000000' align='left' size='1px' />";
}
echo "Size: ".sizeof($nodes)."<br />";


?>