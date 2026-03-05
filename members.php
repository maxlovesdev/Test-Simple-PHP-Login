<?php
//Connects to your Database 
$conn = mysqli_connect("localhost", "root", "", "test_login") or die(mysqli_connect_error()); 

 //checks cookies to make sure they are logged in 
 if(isset($_COOKIE['ID_your_site'])){ 

 	$username = mysqli_real_escape_string($conn, $_COOKIE['ID_your_site']); 
 	$pass = $_COOKIE['Key_your_site']; 
 	$check = mysqli_query($conn, "SELECT * FROM users WHERE username = '$username'") or die(mysqli_error($conn)); 

 	while($info = mysqli_fetch_array( $check )){ 

		//if the cookie has the wrong password, they are taken to the login page 
 		if ($pass != $info['password']){
			header("Location: login.php"); 
 		}
		//otherwise they are shown the admin area
		else{
		
 			 echo "Admin Area<p>"; 
     echo "Your Content<p>"; 
     echo "<a href=logout.php>Logout</a>"; 
 		}
	}
}

 else{ //if the cookie does not exist, they are taken to the login screen 
	header("Location: login.php"); 
 }
 ?>
