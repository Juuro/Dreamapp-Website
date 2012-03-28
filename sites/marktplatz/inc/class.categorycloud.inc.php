<?php

class CategoryCloud {
	/** 
     * The database object 
     * 
     * @var object 
     */ 
    private $_db; 
 
    /** 
     * Checks for a database object and creates one if none is found 
     * 
     * @param object $db 
     * @return void 
     */ 
    public function __construct($db=NULL) 
    { 
        if(is_object($db)) 
        { 
            $this->_db = $db; 
        } 
        else 
        { 
            $dsn = "mysql:host=".DB_HOST.";dbname=".DB_NAME; 
            $this->_db = new PDO($dsn, DB_USER, DB_PASS); 
        } 
    }
    
    /**
     * Get size og categories table
     *
     * @return int	number of categories
     */
    public function countCat()
    {
	    $sql = "SELECT COUNT(id) AS theCount 
	           	FROM categories";
	                
	    if($stmt = $this->_db->prepare($sql)) {
            $stmt->execute(); 
            $row = $stmt->fetch();
            return $row['theCount'];
        }                
	}
	
	/**
	 *
	 *
	 * @return String with HTML-Code for Categorycloud
	 */
	 public function getCatSize($small, $big, $limit)
	 {	
	 	$numberofsizes = ($big-$small)+1;
	 	
	 	$sql = "SELECT count
	 			FROM categories
	 			WHERE count>0
	 			ORDER BY
        		count DESC
  				LIMIT $limit";
	 	$stmt = $this->_db->prepare($sql);
	 	$stmt->execute();
        while($row = $stmt->fetch()){
        	$min=$row['count'];
        }
                
        $sql = "SELECT min(count) AS min, max(count) AS max 
	 			FROM categories 
	 			WHERE count != 0";
	 	$stmt = $this->_db->prepare($sql);
	 	$stmt->execute();
        $row = $stmt->fetch();
        $max = $row['max'];
        
        $numberofcounts = ($max-$min)+1;
        
	 	$quotient = $numberofcounts/$numberofsizes;
	 	
	 		 	
	 	$sql = "SELECT name, count
	 			FROM categories
	 			WHERE count>0
	 			ORDER BY
        		count DESC
  				LIMIT $limit";
	 	$cloudstring = null;
	 	            
	    if($stmt = $this->_db->prepare($sql)) {
            $stmt->execute(); 
            while($row = $stmt->fetch()){
            	$fontsize=$small+floor(($row['count']-$min)/$quotient);
            	$cloudstring .= "<a href=\"\" style=\"font-size:".$fontsize."px\" class=\"cloud-link\" title=\"".$fontsize."\">".$row['name']."</a> ";
            }            
            
            return $cloudstring;
        } 
	 }
	 
	 
	 
}

?>