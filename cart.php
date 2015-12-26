<!DOCTYPE>

<?php
//Session variables hold information about one single user, and are available to all pages in one application, until the browser
// has been closed.
//this session_start() function needs to called here ( before any HTML tag )

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
				<li> <a href = "customer/my_account.php">My Account</a> </li>  <!--TODO: my_account.php page  -->
				<li> <a href = "#">Sign Up</a> </li>  
				<li> <a href = "cart.php">Shopping Cart</a> </li>
				<li> <a href = "#">Contact</a> </li>  				
			</ul>
			<!-- search function-->
		<!--<div id="form">
			<form method="get" action="results.php" enctype = "multipart/form-data">
				<input type="text" name="user_query" placeholder="Search a Product"/>
				<input type="submit" name="search" value="Search" />
			</form>
		</div>
		-->
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

			<!-- DEBUG: Print session ID-->
				<?php echo session_id(); ?>

				
				<!-- Inside this div is where the actual cart page contents are -->
				<div id="products_box">

					<form action="" method="post" enctype="multipart/form-data">
					
						<table align="center" width="700" bgcolor="skyblue">
						
						<tr align="center">
							<th> Remove </th>
							<th> Product(s)</th>
							<th> Quantity </th>
							<th> Total price</th>
						</tr>
						
						<?php
						$total = 0;
						global $con;
							
						$session = session_id();
							
						$sel_price = "SELECT * FROM cart WHERE session_id='$session' ";
						$run_price = mysqli_query($con, $sel_price);
						
						//we go through every item in the cart for one specific session ID in this loop.
						while ($p_price=mysqli_fetch_array($run_price)){
							$qty = $p_price['qty'];
							$pro_id = $p_price['p_id'];
						

							//Fetch information about that one product in our cart from product table instead.
							$pro_price = "SELECT * FROM products WHERE product_id='$pro_id'";
							$run_pro_price = mysqli_query($con, $pro_price);
							$run_pro_price = mysqli_fetch_array($run_pro_price);

							
							$product_price = $run_pro_price['product_price'];
							$product_title = $run_pro_price['product_title'];
							$product_image = $run_pro_price['product_image'];
							
							//code below is run when "update_cart" button is clicked. It sends the new values of quantity values in CART table to the database.
							if(isset($_POST['update_cart'])){
								$qty_row = "qty" . $pro_id; //this variable is to hold the unique name of the input box of one row.
								$qty = $_POST[$qty_row];	//this is the new value of $qty. This needs to stay so 
								$update_qty = "UPDATE cart SET qty='$qty' WHERE p_id='$pro_id' AND session_id='$session'";
								$run_qty = mysqli_query($con, $update_qty);
								}
								
							$single_total = $run_pro_price['product_price']*$qty;
							$total += $single_total;
						?>
						
							<!-- This section gives each entry in cart its own checkbox, unique image, quantity box etc. -->
							<tr align="center">
								<td><input type="checkbox" name="remove[]" value="<?php echo $pro_id; ?>"/></td>
								<td><?php echo $product_title; ?><br>
									<img src="admin_area/product_images/<?php echo $product_image;?>" width="60" height="60"/></td>

								<!-- The input code below provides unique names for each "quantity" box.-->
								<td> <input type="text" size="4" name="<?php echo "qty" . $pro_id?>" value="<?php echo $qty; ?>"/></td>		
								<td> <?php echo "$" . $single_total ?></td>
							</tr>
							
							<?php 
							//close the while loop above.
							} 
							?>
							
							<tr align="right">
								<td colspan="4"> <b>Sub Total: </b></td>
								<td> <?php echo "$" . $total; ?> </td>
						</tr>
							
							<tr align="center">
								<td colspan="2"> <input type="submit" name="update_cart" value="Update Cart"/></td>
								<td> <input type="submit" name="continue" value="Continue"</td>
								<td> <button><a href="checkout.php" style="text-decoration:none; color: black;"> Checkout </a></button></td>
							</tr> 
						</table>
					</form>
					 
					<?php 
					function updatecart(){
						$session = session_id();
						global $con;
						if(isset($_POST['update_cart'])){
							foreach($_POST['remove'] as $remove_id){
							 
							 $delete_product = "DELETE FROM cart WHERE p_id ='$remove_id' AND session_id='$session'";
							 $run_delete = mysqli_query($con, $delete_product);
							 
							 if($run_delete){
								 //refresh the page
								 echo "<script> window.open('cart.php', '_self')</script>";
							 }
						 }
					 }
					 if (isset($_POST['continue'])){
						 echo "<script> window.open('index.php', '_self')</script>";
						}
						//@ - if the function is not called or does not work; no error is thrown
						
					 } echo @$up_cart = updatecart();
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