<!DOCTYPE>

<?php
include ("functions/functions.php"); //include the functions.php library we created
?>


<html>
	<head>
		<title> Ripped like Van Damme </title>
		
		
		<link rel = "stylesheet" href = "styles/style.css" media = "all"/>
	</head>
<body>
	<!-- Main Container starts here -->
	<div class ="main_wrapper">
	
		<!-- Header starts here -->
		<div class = "header_wrapper" > 
		
			<img width="267px" src="images/vandamme1.gif" />
			<img width="200px" src="images/vandamme2.gif" />

		</div>
		<!-- Header ends here -->
		
		<!-- Navigation Bar starts here -->
		<div class = "menubar"> 
			
			<ul id="menu">     <!-- unordered list -->
				<!-- List Item -->
				<li> <a href = "index.php">Home</a> </li>  
				<li> <a href = "all_products.php">All Products</a> </li>  
				<li> <a href = "customer/my_account.php">My Account</a> </li>  
				<li> <a href = "#">Sign Up</a> </li>  
				<li> <a href = "cart.php">Shopping Cart</a> </li>
				<li> <a href = "#">Contact</a> </li>  				
			</ul>
		<!--<div id="form">
			<form method="get" action="results.php" enctype = "multipart/form-data">
				<input type="text" name="user_query" placeholder="Search a Product"/>
				<input type="submit" name="search" value="Search" />
			</form>
		</div> -->
		
		</div>
		<!--Navigation bar ENDS here -->
		
		
		<!-- Content wrapper starts here -->
		<div class = "content_wrapper">
		
		
			<div id="sidebar" >
				<div id="sidebar_title">Categories</div>
				
				<ul id="cats">
				
					<?php
					
						getCats();
					
					?>
					
					
					
				</ul>
				
			<div id="sidebar_title">Brands</div>
				
				<ul id="cats">
					<?php getBrands(); ?>
					
				</ul>
				
			</div>
		
			<div id="content_area" >
			
				<div id="shopping_cart"> 
					
					<span style="float:right; font-size:18px; padding: 5px; line-height: 40px;">

					Welcome guest! <b style="color: yellow">Shopping Cart - </b> Total Items: Total Price:  <a href="cart.php" style="color:yellow">Go to cart</a>
					
					</span>
				
				</div>
			
			
				<div id="products_box">
				<?php
				$get_pro = "select * from products";
				
				
				$run_pro = mysqli_query($con, $get_pro);
				
				// each instance of products is (one-by-one) assigned to $row_pro, and 
				// it's corresponding attributes are assigned to temp variables which are displayed
				while($row_pro=mysqli_fetch_array($run_pro)){
				
					$pro_id = $row_pro['product_id'];
					$pro_cat = $row_pro['product_cat'];
					$pro_brand = $row_pro['product_brand'];
					$pro_title = $row_pro['product_title'];
					$pro_price = $row_pro['product_price'];
					$pro_image = $row_pro['product_image'];
					
					
					// details.php?. '?' makes it a URL link or GET request
					// Makes a dynamic link for each product
					// TODO: make a button for 'Details'
					echo "
						<div id='single_product'>
							
							<h3> $pro_title </h3>
							<img src='admin_area/product_images/$pro_image' width='180' height='180' />
							<p><b> $ $pro_price </b></p>
							
							
							<a href='details.php?pro_id=$pro_id' style='float:left;'> Details </a>
							<a href='index.php?pro_id=$pro_id'><button style='float:right'>Add to Cart</button></a>

						</div>
						
						
					";
				}
	?>
				</div>
				
			</div>
		
		</div>
		<!-- Content wrapper ENDS here -->
		
		
		<div id="footer" >
		
		<h2 style="text-align:center; padding-top: 30px;">&copy; 2015 by Per & Tobbe</h2>
		
		</div>
	</div>
	<!-- Main Container ends here -->
		
</body>
</html>