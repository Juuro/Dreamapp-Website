<?php

class BinarySearchTree {

    private class TreeNode {
        global $value;
        global $left;
        global $right;
        
        TreeNode($newvalue){
            $this->value = $newvalue;
        }
    }
    
    $root = new TreeNode($newvalue);
    
    function addKey($elem){
        $root = addKey($root, $elem);
    }
    
    function search($elem) {
        return search($root, $elem);
    }
}

?>