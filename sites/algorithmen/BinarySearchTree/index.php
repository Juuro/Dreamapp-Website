<?php
error_reporting (E_ALL);

$size = 0;

$key1 = 13;
$key2 = 45;
$key3 = 12;
$key4 = 2;
$key5 = 6;
$key6 = 6;
$key7 = 15;
$key8 = 37;
$key9 = 21;


class TreeNode{
    var $key;
    var $parent;
    var $isleft;
    var $isright;
    var $left;
    var $right;
    
    function TreeNode($key, $parent, $isleft, $isright, $left, $right){
        $this->key = $key;
        $this->parent = $parent;
        $this->isleft = $isleft;
        $this->isright = $isright;
        $this->left = $left;
        $this->right = $right;
    }
    
    function isleftChild($newkey){
        if($newkey < $this->key){
            return true;
        }
        else {
            return false;
        }
    }
    
    function isrightChild($newkey){
        if($newkey > $this->key){
            return true;
        }
        else {
            return false;
        }
    }
    
    function addKey($nodes, $newkey){    
        if ((sizeof($nodes) == 1) && ($this->parent == null) && ($this->key == null)){
            $this->key = $newkey;
            return $nodes;
        }
        else {
            if ($this->key == $newkey){
                echo "Fehler! Schl&uuml;ssel ist schon im Baum einhalten.";
            }
            else {
                //if($this->)
                $nodes[sizeof($nodes)] = new TreeNode($newkey, $this, $this->isleftChild($newkey), $this->isrightChild($newkey), null, null);
                if ($this->isrightChild($newkey)){
                    $this->right = $newkey;
                }
                elseif ($this->isleftChild($newkey)){
                    $this->left = $newkey;
                }
                return $nodes;            
            }
        }
    }
    
}


echo "<br /><b>f&uuml;ge ".$key1." hinzu</b><br />";
$nodes[0] = new TreeNode(null, null, null, null, null, null);
$nodes = $nodes[0]->addKey($nodes, $key1);
include 'schleife.php';

echo "<br /><b>f&uuml;ge ".$key2." hinzu</b><br />";
$nodes = $nodes[0]->addKey($nodes, $key2);
include 'schleife.php';

echo "<br /><b>f&uuml;ge ".$key3." hinzu</b><br />";
$nodes = $nodes[0]->addKey($nodes, $key3);
include 'schleife.php';

echo "<br /><b>f&uuml;ge ".$key4." hinzu</b><br />";
$nodes = $nodes[0]->addKey($nodes, $key4);
include 'schleife.php';

?>