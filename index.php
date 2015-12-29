<!DOCTYPE>
<?php
include ("functions/functions.php"); //include the functions.php library we created
$UserLoggedIn = checkLogin(); //boolean variable
$UserName = "Guest";
$UserEmail = "";
if ($UserLoggedIn) {
	$UserEmail = $_SESSION['email'];
	$UserName = getFirstNameFromEmail($UserEmail);
	}
	
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
				<li> <a href = "customer/my_account.php">My Account</a> </li>  
				<li> <a href = "sign_up.php">Sign Up</a> </li>
				<li> <a href = "cart.php">Shopping Cart</a> </li>
				<li> <a href = "#">Contact</a> </li>  						
			</ul>
			<!-- This is the login screen on the menubar-->
			<?php paintLoginOptions($UserLoggedIn) ?>
		</div>
		<!--Navigation bar ENDS here -->
	
		<!-- Content wrapper starts here -->
		<div class = "content_wrapper">
			<!-- Sidebar starts here -->
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
			<!--Sidebar ends here-->
			
			<!-- Content area starts here.  -->
			<div id="content_area" >
				<?php cart(); ?>
				<?php login();	?>
				<!-- This is the bar showing nr items and total price with cart. -->
				<div id="shopping_cart"> 
					<span style="float:right; font-size:18px; padding: 5px; line-height: 40px;">
					Welcome <?php echo $UserName; ?>! <b style="color: yellow">Shopping Cart - </b> Total Items: <?php total_items(); ?> Total Price: <?php total_price(); ?> <a href="cart.php" style="color:yellow">Go to cart</a>
					</span>
				</div>
				<!-- This is where specific ecommerce data is shown. -->
				<div id="products_box">
					<?php getPro(); ?>
					<?php getCatPro(); ?>
					<?php getBrandPro(); ?>
				</div>
			</div>
			<!--Content area ends here-->
		</div>
		<!-- Content wrapper ENDS here -->
		
		<!-- Footer starts here-->
		<div id="footer" >
			<h2 style="text-align:center; padding-top: 30px;">&copy; 2015 by Per & Tobbe</h2>
		</div>
		<!-- Footer ends here-->
	</div>
	<!-- Main Container ends here -->
</body>
</html>