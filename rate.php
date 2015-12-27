<?php  
include ("admin_area/includes/db.php");

		// gets the values from the URL, to identity product and its rating
	$product_id = (int)$_GET['article']; 
	$rating = (int)$_GET['rating'];
	
	if(in_array($rating, [1,2,3,4,5])) {
		$exists = $con->query("SELECT product_id FROM products WHERE product_id={$product_id}")->num_rows ? true : false;
		
		if($exists) {
			$con->query("INSERT INTO products_ratings (product_id, rating) VALUES ({$product_id}, {$rating})");
		}
	}
	header('Location: details.php?pro_id=' . $product_id);
?>