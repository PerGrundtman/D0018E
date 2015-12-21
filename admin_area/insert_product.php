<!DOCTYPE>

<?php 

include ("includes/db.php"); //we're already in the 'admin_area' folder

?>

<html>
	<head>
		<title>Inserting Product</title>
			<!--reference https://www.tinymce.com/ -->
			<script src="//cdn.tinymce.com/4/tinymce.min.js"></script>
			<script>tinymce.init({ selector:'textarea' });</script>
	</head>
	



<body bgcolor="skyblue">

	<!-- multipart/form-data: to insert multi media types e.g. insert images, videos etc-->
	<form action="insert_product.php" method="post" enctype="multipart/form-data">
	
		<table align="center" width="700" border="2" bgcolor="white">
			
			<!-- tr = table rows-->
			<!-- td = table cell-->
			<!-- colspan = merges several 'td's' inside a 'tr'-->
			<tr align="center">
				<td colspan="7"> <h2> Insert New Post Here </h2></td>
			</tr>
			
			<tr>
				<td align="right"><b>Product Title:</b></td>
				<td><input type="text" name=" product_title" size="60" required/></td>
			</tr>
			<tr>
				<td align="right"><b>Product Category:</b></td>
				<td>
				<!-- a list of categories. We can get the data which is coming through the form, using php from post method into our DB-->
				<select name="product_cat" required/>
					<option>Select a Category</option>
					<?php

							$get_cats = "select * from categories";	//define MySQL query
							
							$run_cats = mysqli_query($con, $get_cats);	//run the query
								
							//bring the data
							while ($row_cats=mysqli_fetch_array($run_cats)) { //fetching the query above in a local variable row_cats
								
							$cat_id = $row_cats['cat_id'];	//get the cat_id column in the category table etc..
							$cat_title = $row_cats['cat_title'];
								
							//so e.g. cat_title is the variable that brings the data directly from the table in our db, dynamically
							
							//we need to pass the $cat_id to the select-tag above (product_cat). So the $cat_id will pass it's value to the select-tag "product_cat". Voila!
								echo "<option value='$cat_id'>$cat_title</option>";
							}
					
					?>
				
				</select>
				
				</td>
			</tr>
			
			<tr>
				<td align="right"><b>Product Brand:</b></td>
				<td>
				
				<select name="product_brand" required/>
					<option>Select a Brand</option>
					<?php

							$get_brands = "select * from brands";	//define MySQL query
	
							$run_brands = mysqli_query($con, $get_brands);	//run the query
							
							//bring the data
							//fetching the query above in a local variable row_cats
							while ($row_brands=mysqli_fetch_array($run_brands)) { 
							
								$brand_id = $row_brands['brand_id'];	//get the brand_id column in the category table etc..
								$brand_title = $row_brands['brand_title'];
								
								//so e.g. cat_title is the variable that brings the data directly from the table in our db, dynamically
								echo "<option value='$brand_id'>$brand_title </option>";
							}
	
	
					
					?>
				
				</select>
				
				
				</td>
			</tr>
			<tr>
				<td align="right"><b>Product Image:</b></td>
				<td><input type="file" name=" product_image" required/></td>
			</tr>
			<tr>
				<td align="right"><b>Product Price:</b></td>
				<td><input type="text" name=" product_price" required/></td>
			</tr>
			<tr>
				<td align="right"><b>Product Description:</b></td>
				<td><textarea name="product_desc" cols="20" rows="10" ></textarea></td>
			</tr>
			<tr>
				<td align="right"><b>Product Keywords:</b></td>
				<td><input type="text" name=" product_keywords" size="50" required /></td>
			</tr>
			<tr align="center">
				
				<td colspan="7"><input type="submit" name="insert_post" value="Insert Product Now" /></td>
			</tr>
		</table>
	
	
	</form>

</body>
</html>


<?php
	//if the submit button 'insert_post is clicked then upload the data to our DB 
	//$_POST - is a global PHP variable. We give it value 'insert_post'
	if(isset($_POST['insert_post'])){
	
		//getting the data from the form
		$product_title = $_POST['product_title'];
		$product_cat = $_POST['product_cat'];
		$product_brand = $_POST['product_brand'];
		$product_price = $_POST['product_price'];
		$product_desc = $_POST['product_desc'];
		$product_keywords = $_POST['product_keywords'];
		
		$product_image = $_FILES['product_image']['name']; //retrieving the image
		$product_image_tmp = $_FILES['product_image']['tmp_name'];
		
		//first temp name and then the filepath to which the images are saved
		//move_uploaded_file is a php function
		move_uploaded_file($product_image_tmp, "product_images/$product_image");
		
		$insert_product = "insert into products (product_cat, product_brand, product_title, product_price, product_desc, product_image, product_keywords) values('$product_cat','$product_brand','$product_title','$product_price','$product_desc','$product_image','$product_keywords')";
		
		$insert_pro = mysqli_query($con, $insert_product);
		
		
		
		if($insert_pro){
		
		echo "<script>alert ('Product has been inserted!')</script>";
		//refreshes the page
		echo "<script> window.open('insert_product.php', '_self')</script>";
		
		}
	}

?>


