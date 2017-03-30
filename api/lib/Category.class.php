<?php
/*
 * Table format: id, iconcolor, iconurl, name, description, parent_id, listorder
 * Book-Category relationship: categories_id, books_id
 */
require_once 'DB.class.php';
class CATEGORY
{
    public function __construct() {
		
	}
	
	// This function gets the list of categories
	public function get_list(){
				
        // Open db instance
        $db = new DB();
		
		$conn = $db->connect_db();
		
        $result = pg_query($conn, "select * from category"); // should return only a given number of parameters not all
	    if (!$result) {
			error_log( "An error occurred while retrieving category list.\n");
			return null;
	    }
		return pg_fetch_all($result);
	}
	
	// This function returns the details of given category
	public function get_details($category_id){
				
        // Open db instance
        $db = new DB();
		
		$conn = $db->connect_db();
        $result = pg_query($conn, "select * from category where id=".$category_id);
	    if (!$result) {
			error_log( "An error occurred while retrieving category details.\n");
			return null;
	    }
		return pg_fetch_all($result);
	}
		
	// This function returns the books of given category id
	public function get_books_byid($category_id){
				
        // Open db instance
        $db = new DB();
		
		$conn = $db->connect_db();
        $result = pg_query($conn, "select * from category_book where categories_id=".$category_id);
		
	    if (!$result) {
			error_log( "An error occurred while retrieving category books in get_books_byid.\n");
			return null;
	    }
		
		// For each row of the results, retrieve the book info
		while($row = pg_fetch_assoc($result)){
			$result_book = pg_query($conn, "select * from book where id=".$row['books_id']);
			$firstrow = pg_fetch_assoc($result_book);
			$array_output[] = $firstrow; //array('book' => $firstrow['name'];	    
		}
		return $array_output;
	}
	
	// This function returns the books of given category id
	public function get_books_byname($category_name){
				
        // Open db instance
        $db = new DB();
		
		$conn = $db->connect_db();
        $result = pg_query($conn, "select * from category where name='".$category_name."'");
		
	    if (!$result) {
			error_log( "An error occurred while retrieving category books in get_books_byname.\n");
			return null;
	    }
		
		if (pg_num_rows($result) == 0) {
			return array();
		}
		
		$row = pg_fetch_assoc($result);
		
		return $this->get_books_byid($row['id']);
	}
}
?>