<?php
/*
$host="utbweb.its.ltu.se";
$port=3306;
$socket="";
$user="pergru-0";
$password="1337";
$dbname="pergru0db";

$con = new mysqli($host, $user, $password, $dbname, $port, $socket)
	or die ('Could not connect to the database server' . mysqli_connect_error());
	
	*/
	
include ("admin_area/includes/db.php"); // instead of above code
//$con->close();
//TODO: Try if the $con can be made global ONLY ONCE instead of in each function

//Start a new session here, if a session has not been started yet.
if(!isset($_SESSION)){
	session_start();
}
function getIp() {
	//getting the user IP address
    $ip = $_SERVER['REMOTE_ADDR'];

 

    if (!empty($_SERVER['HTTP_CLIENT_IP'])) {

        $ip = $_SERVER['HTTP_CLIENT_IP'];

    } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {

        $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];

    }

 

    return $ip;

}
//Creating the shopping cart
function cart(){
	$session = session_id();
	//if someone clicks the add cart button
	if(isset($_GET['add_cart'])){
		
		global $con;
		
		
		
		//get the product ID  of the added product
		$pro_id = $_GET['add_cart'];
		
		//check if this product was already added by this user
		$check_pro = "SELECT * FROM cart WHERE session_id='$session' AND p_id='$pro_id' ";
		
		$run_check = mysqli_query($con, $check_pro);
		
		//if we have added this product to our cart already
		if(mysqli_num_rows($run_check)>0) {
			
			echo "";
		}
		//Else...
		else{
			$initial_qty = 1;
			$insert_pro = "INSERT into cart (p_id, session_id, qty) values ('$pro_id', '$session', '$initial_qty') ";
			
			$run_pro = mysqli_query($con, $insert_pro);
			
			echo "<script>window.open('index.php', '_self')</script>";
		}
	}

}
//getting tjhe total added items

//TODO: check if/else
function total_items(){
	global $con;
	$session = session_id();
	if(isset($_GET['add_cart'])){
		

		$get_items = "SELECT * FROM cart WHERE session_id='$session' ";
		
		$run_items = mysqli_query($con, $get_items);
		
		$count_items = mysqli_num_rows($run_items);
	}
		else{
		
		$get_items = "SELECT * FROM cart WHERE session_id='$session' ";
		
		$run_items = mysqli_query($con, $get_items);
	
		$count_items = mysqli_num_rows($run_items);
		}
		echo $count_items;
	}
	
//getting the total price of the items in the cart

	function total_price(){
		
		$total = 0;
		global $con;
		
		$session = session_id();
		
		$sel_price = "SELECT * FROM cart WHERE session_id='$session' ";
		
		$run_price = mysqli_query($con, $sel_price);
		
		while ($p_price=mysqli_fetch_array($run_price)){
			$pro_id = $p_price['p_id'];
			$pro_price = "SELECT * FROM products WHERE product_id='$pro_id'";
			$run_pro_price = mysqli_query($con, $pro_price);
			
			while ($pp_price = mysqli_fetch_array($run_pro_price)){
				$product_price = array($pp_price['product_price']);
				
				$values = array_sum($product_price);
				
				$total +=$values;
			}		
		}
		echo "$" . $total;
	}





/* function total_price(){
	global $con;
	
	$ip = getIp();
	$get_items = "SELECT * FROM cart WHERE ip_add='$ip' ";
	$run_items = mysqli_query($con, $get_items);
	$sum = 0;
	while  ($row_product=mysqli_fetch_array($run_items)){
		
		$bajs = $row_product['product_price'];
		$sum = $sum+$bajs;
	}
	
	echo $sum;
} */
	
	
//getting the categories
function getCats(){

	global $con;  //makes the variable accessible in this function

	$get_cats = "select * from categories";	//define MySQL query
	
	$run_cats = mysqli_query($con, $get_cats);	//run the query
		
	//bring the data
	while ($row_cats=mysqli_fetch_array($run_cats)) { //fetching the query above in a local variable row_cats
		
		$cat_id = $row_cats['cat_id'];	//get the cat_id column in the category table etc..
		$cat_title = $row_cats['cat_title'];
		
		//so e.g. cat_title is the variable that brings the data directly from the table in our db, dynamically
		echo "<li> <a href ='index.php?cat=$cat_id'>$cat_title </a></li>";
	
	}
}
	//getting the brands
function getBrands(){

	global $con;  //makes the variable accessible in this function

	$get_brands = "select * from brands";	//define MySQL query
	
	$run_brands = mysqli_query($con, $get_brands);	//run the query
		
	//bring the data
	while ($row_brands=mysqli_fetch_array($run_brands)) { //fetching the query above in a local variable row_cats
		
		$brand_id = $row_brands['brand_id'];	//get the brand_id column in the category table etc..
		$brand_title = $row_brands['brand_title'];
		
		//so e.g. cat_title is the variable that brings the data directly from the table in our db, dynamically
		echo "<li> <a href ='index.php?brand=$brand_id'>$brand_title </a></li>";
	
	}
}

function getPro(){
	
	//if its not set
	if(!isset($_GET['cat'])){
		if(!isset($_GET['brand'])){
	
	global $con;
	
	//get the products from our DB and print them on the page dynamically
	$get_pro = "select * from products order by RAND() LIMIT 0,6"; //TODO remove the limit so we can remove the "all products "-page ?
	
	
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
				<p><b> Price:  $ $pro_price </b></p>
				
				
				<a href='details.php?pro_id=$pro_id' style='float:left;'> Details </a>
				
				<a href='index.php?add_cart=$pro_id'><button style='float:right'>Add to Cart</button></a>

			</div>
			
			
		";
	}
}
}
}
function getCatPro(){
	
	//if its not set
	if(isset($_GET['cat'])){
		
		//when someone clicks the category, a dynamic URL will be created
		$cat_id = $_GET['cat'];
	
	global $con;
	
	//get the products from the specific cat_id from our DB and print them on the page dynamically
	$get_cat_pro = "select * from products WHERE product_cat='$cat_id'";
	
	
	$run_cat_pro = mysqli_query($con, $get_cat_pro);
	
	//counts the total record in a query
	$count_cats = mysqli_num_rows($run_cat_pro);
	
	if($count_cats==0){
		
		echo "<h2 style='padding:20px;'> No products were found in this category </h2>";
		
	}
	
	// each instance of products is (one-by-one) assigned to $row_pro, and 
	// it's corresponding attributes are assigned to temp variables which are displayed
	//getting the POST associated with this category
	while($row_cat_pro=mysqli_fetch_array($run_cat_pro)){
	
		$pro_id = $row_cat_pro['product_id'];
		$pro_cat = $row_cat_pro['product_cat'];
		$pro_brand = $row_cat_pro['product_brand'];
		$pro_title = $row_cat_pro['product_title'];
		$pro_price = $row_cat_pro['product_price'];
		$pro_image = $row_cat_pro['product_image'];
		

		
		
		
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
	}
}

function getBrandPro(){
	
	//if its not set
	if(isset($_GET['brand'])){
		
		//when someone clicks the category, a dynamic URL will be created
		$brand_id = $_GET['brand'];
	
	global $con;
	
	//get the products from the specific cat_id from our DB and print them on the page dynamically
	$get_brand_pro = "select * from products WHERE product_brand='$brand_id'";
	
	
	$run_brand_pro = mysqli_query($con, $get_brand_pro);
	
	//counts the total record in a query
	$count_brands = mysqli_num_rows($run_brand_pro);
	
	if($count_brands==0){
		
		echo "<h2 style='padding:20px;'> No products were found associated with this brand </h2>";
		
	}
	
	// each instance of products is (one-by-one) assigned to $row_pro, and 
	// it's corresponding attributes are assigned to temp variables which are displayed
	//getting the POST associated with this category
	while($row_brand_pro=mysqli_fetch_array($run_brand_pro)){
	
		$pro_id = $row_brand_pro['product_id'];
		$pro_cat = $row_brand_pro['product_cat'];
		$pro_brand = $row_brand_pro['product_brand'];
		$pro_title = $row_brand_pro['product_title'];
		$pro_price = $row_brand_pro['product_price'];
		$pro_image = $row_brand_pro['product_image'];
		
 
		// details.php?. '?' makes it a URL link or GET request
		// Makes a dynamic link for each product
		
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

}
}

//function to determine if a login should be successful or not
function login(){
	//if the login button is clicked
	if(isset($_POST['login_button'])){

		//if(empty($_POST['username']))
		/* {
			$this->HandleError("UserName is empty!");
			return false;
		}
		 
		if(empty($_POST['password']))
		{
			$this->HandleError("Password is empty!");
			return false;
		} */
		$email = trim($_POST['login_mail']);	//trim() strips the input from whitespace.
		$password = trim($_POST['login_password']);
		 
		if(!CheckLoginInDB($email,$password)){
			return;
		}
		
		//If session is started already, kill it and create a new one
		 if(isset($_SESSION)) {
			session_destroy();
			session_start();
			echo "<script> window.open('index.php', '_self')</script>";
		} 
		
		//$_SESSION[GetLoginSessionVar()] = $email;
		$_SESSION['email'] = $email;
		}
	if(isset($_POST['logout_button'])){
		if(isset($_SESSION)) {
			session_destroy();
			echo "<script> window.open('index.php', '_self')</script>";
		} 
	}
	
}

//check if a user has entered a correct email and password combination which lies in the database		
function checkLoginInDB($email, $password){
	global $con;
	$sql = "SELECT customer_email, customer_password FROM customer WHERE customer_email = '$email' AND customer_password = '$password'";
	$result = mysqli_query($con, $sql);	
	//if the email and password combination matches that of one in the database we have a match
	if (mysqli_num_rows($result) == 1){
		return true;
	}
	return false;
}	

//check if a user is logged in or not
function checkLogin()
{
     //session_start();
 
     $sessionvar = session_id();
      
     if(empty($_SESSION['email']))
     {
        return false;
     }
     return true;
}

//fetch first name from email adress in database.
function getFirstNameFromEmail($email){
	global $con;
	$fname = "";
	$sql = "SELECT customer_fname FROM customer WHERE customer_email = '$email'";
	$result = mysqli_query($con, $sql);
	//if the query was successful:
	if (mysqli_num_rows($result) == 1){
		$row = mysqli_fetch_assoc($result);
		return $row['customer_fname'];
	}
	return "";
}

//Paints a login fields if user is not logged in and a logout button if user is logged in
function paintLoginOptions($UserLoggedIn){
	if (!$UserLoggedIn){
		echo "
			<div id='login'>
				<form id='login' action='index.php' method='post' accept-charset='UTF-8'>
					<label for='login_mail'><b>E-mail:</b></label>
					<input type='text' name='login_mail' size = '4' required/>
					<label for='login_password'><b>Password:</b></label>
					<input type='password' name='login_password' size = '4' required/>
					<input type='submit' name='login_button' value='Log in'>
				</form>
			</div>
		";
	}
	else {
		echo "
			<div id='logout'>
				<form id='login' action='index.php' method='post' accept-charset='UTF-8'>
					<input type='submit' name='logout_button' value='Log out'>
				</form>
			</div>
		";
	}

}
?>