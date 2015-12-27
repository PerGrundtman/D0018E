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
			
			<?php cart(); ?>
			
				<div id="shopping_cart"> 
					
					<span style="float:right; font-size:18px; padding: 5px; line-height: 40px;">

					Welcome guest! <b style="color: yellow">Shopping Cart - </b> Total Items: <?php total_items(); ?> Total Price: <?php total_price(); ?> <a href="cart.php" style="color:yellow">Go to cart</a>
					
					</span>
				
				</div>
			<!-- DEBUG: Print IP-->
				<?php echo $ip=getIp(); ?>
			
				<div id="products_box">
					<?php getPro(); ?>
					<?php getCatPro(); ?>
					<?php getBrandPro(); ?>
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