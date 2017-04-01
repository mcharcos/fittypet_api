<?php
/*
 * Table format: id, iconcolor, iconurl, name, description, parent_id, listorder
 * Book-Category relationship: categories_id, books_id
 */
require_once 'DB.class.php';
class CATEGORY
{
    
    protected $paramsStr;
    
    public function __construct() {
	
	// These are the defined available fields that can be requested by the API
	$this->paramsStr = array(
			      'id' => 1,
			      'iconcolor' => 1,
			      'iconurl' => 1,
			      'name' => 1,
			      'description' => 1,
			      'parent_id' => 1,
			      'listorder' => 1
			     );
	}
	
	// Check if the input fields correspond to columns in the database.
	// Fields is a string with comma separated column names
	public function check_fields($fields) {
	    
	    if ($fields == "*") {
		return array('error' => false, 'param' =>'');
	    }
	    
            $fields_arr = explode(',',$fields);
	    
	    foreach ($fields_arr as $element) {
		if (!isset($this->paramsStr[$element])) {
		    return array('error' => true , 'param' => $element);
		}
	    }
	     return array('error' => false, 'param' =>'');
	}
	
	// This function gets the list of categories
	// Assumes fields are correct and will break if not. So use check_fields beforehand to make sure they are
	public function get_list($fields="*"){
				
        // Open db instance
        $db = new DB();
		
		$conn = $db->connect_db();
		
        $result = pg_query($conn, "select ".$fields." from category"); // should return only a given number of parameters not all
	    if (!$result) {
			error_log( "An error occurred while retrieving category list.\n");
			return null;
	    }
		$array_output = pg_fetch_all($result);
		
		pg_close($conn);
		
		return $array_output;
	}
	
	// This function returns the details of given category
	// Assumes fields are correct and will break if not. So use check_fields beforehand to make sure they are
	public function get_details($category_id, $fields="*"){
				
        // Open db instance
        $db = new DB();
		
		$conn = $db->connect_db();
        $result = pg_query($conn, "select ".$fields." from category where id=".$category_id);
	    if (!$result) {
			error_log( "An error occurred while retrieving category details.\n");
			return null;
	    }
		$array_output = pg_fetch_all($result);
		
		pg_close($conn);
		
		return $array_output;
	}
		
}
?>