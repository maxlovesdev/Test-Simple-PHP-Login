<?php 

//Connects to your Database 
$conect = mysqli_connect("localhost", "root", "", "test_login") or die(mysqli_connect_error()); 

//Checks if there is a login cookie
if(isset($_COOKIE['ID_your_site'])){
 	$username = mysqli_real_escape_string($conect, $_COOKIE['ID_your_site']); 
 	$pass = $_COOKIE['Key_your_site'];
 	$check = mysqli_query($conect, "SELECT * FROM users WHERE username = '$username'") or die(mysqli_error($conect));

 	while($info = mysqli_fetch_array($check)){
 		if ($pass != $info['password']){
 			// wrong cookie password, clear and show login form
 			setcookie('ID_your_site', '', time() - 3600);
 			setcookie('Key_your_site', '', time() - 3600);
		} else {
 			// already logged in, go to members area
 			header("Location: members.php");
 			exit();
		}
 	}
 }

 //if the login form is submitted 
 if (isset($_POST['submit'])) {

	// makes sure they filled it in
 	if(!$_POST['username']){
 		die('You did not fill in a username.');
 	}
 	if(!$_POST['pass']){
 		die('You did not fill in a password.');
 	}

 	// checks it against the database
 	$username = mysqli_real_escape_string($conect, $_POST['username']);
 	$check = mysqli_query($conect, "SELECT * FROM users WHERE username = '$username'") or die(mysqli_error($conect));

 //Gives error if user doesn't exist
 $check2 = mysqli_num_rows($check);
 if ($check2 == 0){
	die('That user does not exist in our database.<br /><br />If you think this is wrong <a href="login.php">try again</a>.');
}

while($info = mysqli_fetch_array($check)){
	$pass = md5(stripslashes($_POST['pass']));

	//gives error if the password is wrong
 	if ($pass != $info['password']){
 		die('Incorrect password, please <a href="login.php">try again</a>.');
 	}
	
	else{ // if login is ok then we add a cookie 
		$hour = time() + 3600; 
		setcookie('ID_your_site', stripslashes($_POST['username']), $hour); 
		setcookie('Key_your_site', $pass, $hour);

		//then redirect them to the members area 
		header("Location: members.php");
		exit();
	}
}
}
else{
// if they are not logged in 
?>

 <form action="<?php echo $_SERVER['PHP_SELF']?>" method="post"> 

 <table border="0"> 

 <tr><td colspan=2><h1>Login</h1></td></tr> 

 <tr><td>Username:</td><td> 

 <input type="text" name="username" maxlength="40"> 

 </td></tr> 

 <tr><td>Password:</td><td> 

 <input type="password" name="pass" maxlength="50"> 

 </td></tr> 

 <tr><td colspan="2" align="right"> 

 <input type="submit" name="submit" value="Login"> 

 </td></tr> 

 </table> 

 </form> 

 <p>Don't have an account? <a href="add.php"><button type="button">Sign Up</button></a></p>

 <?php 
 }
 ?> 
