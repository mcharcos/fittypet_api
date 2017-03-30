<?php

require_once 'DB.class.php';

/*
 * Table format: id, uuid, title, author, language, createtime
 * Book-Category relationship: categories_id, books_id
 **/
class BOOKS
{
    public function __construct() {
		
	}
		
	// This function gets the list of categories
	public function get_list(){
				
        // Open db instance
        $db = new DB();
		
		$conn = $db->connect_db();
        $result = pg_query($conn, "select * from book"); // should return only a given number of parameters not all
	    if (!$result) {
			error_log( "An error occurred while retrieving book list.\n");
			return null;
	    }
		return pg_fetch_all($result);
	}
	
	// This function returns the details of given book
	// I am assuming that the request uses the book's universal unique identifier
	public function get_details($book_id, $isuuid=false){
				
        // Open db instance
        $db = new DB();
				
		$conn = $db->connect_db();
		if ($isuuid) {
			$result = pg_query($conn, "select * from book where uuid='".$book_id."'");
		} else {
			$result = pg_query($conn, "select * from book where id=".$book_id);
			
		}
	
	    if (!$result) {
			echo "An error occurred while retrieving book details.\n";
			return null;
	    }
		
		return pg_fetch_all($result);
	}
}
?>