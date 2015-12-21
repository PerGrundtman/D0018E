<!DOCTYPE>

<?php
//to make each session unique and we save all variables into this specific session like quantity and stuff
session_start();

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
		<div id="form">
			<form method="get" action="results.php" enctype = "multipart/form-data">
				<input type="text" name="user_query" placeholder="Search a Product"/>
				<input type="submit" name="search" value="Search" />
			</form>
		</div>
		
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
							
							$ip = getIp();
							
							$sel_price = "SELECT * FROM cart WHERE ip_add='$ip' ";
							
							$run_price = mysqli_query($con, $sel_price);
							
							while ($p_price=mysqli_fetch_array($run_price)){
								$pro_id = $p_price['p_id'];
								$pro_price = "SELECT * FROM products WHERE product_id='$pro_id'";
								$run_pro_price = mysqli_query($con, $pro_price);
								
								while ($pp_price = mysqli_fetch_array($run_pro_price)){
									$product_price = array($pp_price['product_price']);
									$product_title = $pp_price['product_title'];
									$product_image = $pp_price['product_image'];
									$single_price = $pp_price['product_price'];
									$values = array_sum($product_price);
									$total += $values;
						
						?>
						
						<tr align="center">
							<td><input type="checkbox" name="remove[]" value="<?php echo $pro_id ?>"/></td>
							<td><?php echo $product_title; ?><br>
							<img src="admin_area/product_images/<?php echo $product_image;?>" width="60" height="60"/>

							</td>
							<td> <input type="text" size="4" name="qty" value="<?php echo $_SESSION['qty']; ?>"/></td>
							
							<?php 
							
							function updatecart(){
								
								global $con;
							
								if(isset($_POST['update_cart'])){
									$qty = $_POST['qty'];
									$update_qty = "update cart set qty='$qty'";
									$run_qty = mysqli_query($con, $update_qty);
									//we target the qty field inside the table
									$_SESSION['qty']=$qty;
									//default array superglobal array
									$total = $total*$qty;
									
								}
							?>
							
							<td> <?php echo "$" . $single_price ?></td>
						</tr>
					
						
							<?php 
								}
							} 
							?>
							<tr align="right">
							<td colspan="4"> <b>Sub Total: </b></td>
							<td> <?php echo "$" . $total; ?> </td>
						</tr>
							<tr align="center">
								<td colspan="2"> <input type="submit" name="update_cart" value="Update_Cart" /> </td>
								<td> <input type="submit" name="continue" value="Continue Shopping" / </td>
								<td> <button><a href = "checkout.php" style="text-decoration:none; color: black;"> Checkout</a> </button></td>
							</tr>
						</table>
					</form>
					<?php
					$ip = getIp();
					//the remove button is boxed and we want to update the cart.
					//Running a loop, input target is 'remove', make it remove local var $remove_id
						if(isset($_POST['update_cart'])){
							//we get the values from the remove fields and put it into local var $remove_id (remove is an array so need to loop through it)
							//and we make an SQL query to delete from cart table where p_id = $remove_id 
							//so the specific product from the specific user will be removed from the cart
							foreach($_POST['remove'] as $remove_id){
								$delete_product = "DELETE FROM cart WHERE p_id ='$remove_id' AND ip_add='$ip'";
								$run_delete = mysqli_query($con, $delete_product);
								if($run_delete){
									echo "<script>window.open('cart.php', '_self')</script>";
								}
							}
						}
						if(isset($_POST['continue'])){
							
							echo "<script>window.open('index.php', '_self')</script>";
						}
						//if this function is not active or not working, it will not generate an error
						//'@', cuz if you push update and there is no value given, it should not crash
						echo @$up_cart = updatecart();
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