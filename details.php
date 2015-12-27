<!DOCTYPE>

<?php
include ("functions/functions.php"); //include the functions.php library we created
include ("admin_area/includes/db.php");
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
				<li> <a href = "#">All Products</a> </li>  
				<li> <a href = "#">My Account</a> </li>  
				<li> <a href = "#">Sign Up</a> </li>  
				<li> <a href = "#">Shopping Cart</a> </li>
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
									<?php  
									
									getBrands();
									
									?> 
								</ul> 
							</div> 
							<div id="content_area" > 
								<div id="shopping_cart">  
									<span style="float:right; font-size:18px; padding: 5px; line-height: 40px;">

									Welcome guest! <b style="color: yellow">Shopping Cart:</b> Total Items: Total Price:  <a href="cart.php" style="color:yellow">Go to cart</a>
									
									</span> 
								</div> 
								<div id="products_box">
									<?php
									//retrieves the value from $_GET Array with key 'pro_id'
									if(isset($_GET['pro_id'])) {
									
										echo "article " . $product_id =(int)$_GET['pro_id']; //cast to int for security reasons for sql injection attacks
										//get the products from our DB and print them on the page dynamically
										$get_pro = "SELECT * FROM products WHERE product_id='$product_id'";
					
										$run_pro = mysqli_query($con, $get_pro);
					
											// each instance of products is (one-by-one) assigned to $row_pro, and 
											// it's corresponding attributes are assigned to temp variables which are displayed
											while($row_pro=mysqli_fetch_array($run_pro)){
											
												$pro_id = $row_pro['product_id'];
												$pro_title = $row_pro['product_title'];
												$pro_price = $row_pro['product_price'];
												$pro_image = $row_pro['product_image'];
												$pro_desc = $row_pro['product_desc'];
												
												// details.php?. '?' makes it a URL link or GET request
												echo "
													<div id='single_product'>
														
														<h3> $pro_title </h3>
														<img src='admin_area/product_images/$pro_image' width='400' height='300' />
														
														<p><b> $ $pro_price </b></p>
														<p>$pro_desc </p>
															<a href='index.php' style='float:left;'> Go Back </a>;
														<a href='index.php?pro_id=$pro_id'><button style='float:right'>Add to Cart</button></a>
													
													</div>
									
													";
													?>
														
													<?php 
													
												// make a SQL query to calculate the average rating from a specific item. This average rating is saved in
												// the 'rating' attribute which can only be retrieved through an object. So an object is created through
												// fetch_object() which then can be manipulated to attain the desired data
												 
												//LEFT JOIN because products always exists, but not always the rating for a product, so we join from LEFT
												
												//TODO: to show the ratings immeditely in the "All products"-page, add "GROUP BY products.product_id", to the end of this query
												// and copy it to the index.php 
											$query = $con->query("
												SELECT products.product_id, products.product_title, AVG(products_ratings.rating) AS rating
												FROM products
												LEFT JOIN products_ratings
												ON products.product_id = products_ratings.product_id
												WHERE products.product_id = '$pro_id'
											");
											while($row = $query->fetch_object()){
												$articles[] = $row;
											}
											
											?>
											<?php foreach($articles as $article): ?> 
													<div class="article-rating">Rating <?php echo round($article->rating) ?>/5</div>
												<?php endforeach; ?>
											<div class="article-rate">
											
												<h3>Rate this article:</h3>
												<!--   create 5 links to a vote-function page, which will redirect you back to the details page of this product   -->
												<?php foreach(range(1,5) as $rating): ?>
													<a href="rate.php?article=<?php echo $pro_id; ?>&rating=<?php echo $rating; ?>"> <?php echo $rating ?> </a>
												<?php endforeach; ?>
												
												<?php
												
												echo "<br><br> <h3> Please add a comment </h3>"
												
												
												?>
												<form action="post_comment.php?product=<?php echo $pro_id ?>" method="POST">
													<input type="text" name="name" value="Your name">
													<textarea name="comment" cols="25" rows="2">Enter a comment</textarea><p>
													<input type="submit" value="Comment" >
													
												</form>
												<?php 
													$find_comments = mysqli_query($con, "SELECT * FROM comments WHERE id='$pro_id'");
													while ($row = mysqli_fetch_assoc($find_comments)){
														$comment_name = $row['name'];
														$comment = $row['comment'];
														
														echo "<b>$comment_name </b> said:<i> $comment </i><p>";
													}
													if(isset($_GET['error'])){
														echo "<h3><i>100 character limit, try again </i></h3>";
														
													}

												?>
																							
												<?php
												}
											}
									
											?> 
											</div>
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