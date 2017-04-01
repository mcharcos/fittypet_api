<?php

require_once 'DB.class.php';

/*
 * Table format: id, uuid, title, author, language, createtime
 * Book-Category relationship: categories_id, books_id
 **/
class BOOKS
{
    
    protected $paramsStr;
    
    public function __construct() {
	
	// These are the defined available fields that can be requested by the API
	$this->paramsStr = array(
			      'id' => 1,
			      'uuid' => 1,
			      'title' => 1,
			      'author' => 1,
			      'language' => 1,
			      'createtime' => 1
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
        $result = pg_query($conn, "select ".$fields." from book"); // should return only a given number of parameters not all
	    if (!$result) {
			error_log( "An error occurred while retrieving book list.\n");
			return null;
	    }
		
		$array_output = pg_fetch_all($result);
	    
		pg_close($conn);
		
		return $array_output;
	}
	
	// This function returns the details of given book
	// I am assuming that the request uses the book's universal unique identifier
	// Assumes fields are correct and will break if not. So use check_fields beforehand to make sure they are
	public function get_details($book_id, $isuuid=false, $fields="*"){
				
        // Open db instance
        $db = new DB();
				
		$conn = $db->connect_db();
		if ($isuuid) {
			$result = pg_query($conn, "select ".$fields." from book where uuid='".$book_id."'");
		} else {
			$result = pg_query($conn, "select ".$fields." from book where id=".$book_id);
			
		}
	
	    if (!$result) {
			echo "An error occurred while retrieving book details.\n";
			return null;
	    }
		
		$array_output = pg_fetch_all($result);
	    
		pg_close($conn);
		
		return $array_output;
	}
	
	// This function returns the books of given category id
	// Assumes fields are correct and will break if not. So use check_fields beforehand to make sure they are
	public function get_books_byid($category_id, $fields="*"){
				
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
			$result_book = pg_query($conn, "select ".$fields." from book where id=".$row['books_id']);
			$firstrow = pg_fetch_assoc($result_book);
			$array_output[] = $firstrow; //array('book' => $firstrow['name'];	    
		}
		
		pg_close($conn);
		
		return $array_output;
	}
	
	// This function returns the books of given category id.
	// Assumes fields are correct and will break if not. So use check_fields beforehand to make sure they are
	public function get_books_byname($category_name, $fields="*"){
				
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
		
		$result = pg_query($conn, "select * from category_book where categories_id=".$row['id']);
		
		if (!$result) {
			    error_log( "An error occurred while retrieving category books in get_books_byname (by id).\n");
			    return null;
		}
		
		// For each row of the results, retrieve the book info
		while($row = pg_fetch_assoc($result)){
			$result_book = pg_query($conn, "select ".$fields." from book where id=".$row['books_id']);
			$firstrow = pg_fetch_assoc($result_book);
			$array_output[] = $firstrow; //array('book' => $firstrow['name'];	    
		}
		
		pg_close($conn);
		
		return $array_output;
	}
}
?>