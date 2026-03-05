<?php 

//Connects to your Database 
$conect = mysqli_connect("localhost", "root", "", "test_login") or die(mysqli_connect_error());
$error = '';

//Checks if there is a login cookie
if(isset($_COOKIE['ID_your_site'])){
 	$username = mysqli_real_escape_string($conect, $_COOKIE['ID_your_site']); 
 	$pass = $_COOKIE['Key_your_site'];
 	$check = mysqli_query($conect, "SELECT * FROM users WHERE username = '$username'") or die(mysqli_error($conect));

 	while($info = mysqli_fetch_array($check)){
 		if ($pass != $info['password']){
 			setcookie('ID_your_site', '', time() - 3600);
 			setcookie('Key_your_site', '', time() - 3600);
		} else {
 			header("Location: members.php");
 			exit();
		}
 	}
 }

 //if the login form is submitted 
 if (isset($_POST['submit'])) {

 	if(!$_POST['username']){
 		$error = 'You did not fill in a username.';
 	} elseif(!$_POST['pass']){
 		$error = 'You did not fill in a password.';
 	} else {
	 	$username = mysqli_real_escape_string($conect, $_POST['username']);
	 	$check = mysqli_query($conect, "SELECT * FROM users WHERE username = '$username'") or die(mysqli_error($conect));
	 	$check2 = mysqli_num_rows($check);

	 	if ($check2 == 0){
			$error = 'That user does not exist in our database.';
		} else {
			while($info = mysqli_fetch_array($check)){
				$pass = md5(stripslashes($_POST['pass']));
				if ($pass != $info['password']){
					$error = 'Incorrect password, please try again.';
				} else {
					$hour = time() + 3600; 
					setcookie('ID_your_site', stripslashes($_POST['username']), $hour); 
					setcookie('Key_your_site', $pass, $hour);
					header("Location: members.php");
					exit();
				}
			}
		}
	}
 }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.css" rel="stylesheet">
    <style>
        @import url('https://fonts.googleapis.com/css?family=Karla:400,700&display=swap');
        .font-family-karla { font-family: karla; }
    </style>
</head>
<body class="bg-white font-family-karla h-screen">

    <div class="w-full flex flex-wrap">

        <!-- Login Section -->
        <div class="w-full md:w-1/2 flex flex-col">

            <div class="flex justify-center md:justify-start pt-12 md:pl-12 md:-mb-24">
                <a href="#" class="bg-black text-white font-bold text-xl p-4">MyApp</a>
            </div>

            <div class="flex flex-col justify-center md:justify-start my-auto pt-8 md:pt-0 px-8 md:px-24 lg:px-32">
                <p class="text-center text-3xl">Welcome.</p>

                <?php if ($error): ?>
                    <p class="text-red-500 text-center mt-4"><?php echo htmlspecialchars($error); ?></p>
                <?php endif; ?>

                <form class="flex flex-col pt-3 md:pt-8" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                    <div class="flex flex-col pt-4">
                        <label for="username" class="text-lg">Username</label>
                        <input type="text" id="username" name="username" placeholder="Your username" maxlength="40"
                            value="<?php echo isset($_POST['username']) ? htmlspecialchars($_POST['username']) : ''; ?>"
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 mt-1 leading-tight focus:outline-none focus:shadow-outline">
                    </div>

                    <div class="flex flex-col pt-4">
                        <label for="pass" class="text-lg">Password</label>
                        <input type="password" id="pass" name="pass" placeholder="Password" maxlength="50"
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 mt-1 leading-tight focus:outline-none focus:shadow-outline">
                    </div>

                    <input type="submit" name="submit" value="Log In"
                        class="bg-black text-white font-bold text-lg hover:bg-gray-700 p-2 mt-8 cursor-pointer">
                </form>

                <div class="text-center pt-12 pb-12">
                    <p>Don't have an account? <a href="add.php" class="underline font-semibold">Register here.</a></p>
                </div>
            </div>

        </div>

        <!-- Image Section -->
        <div class="w-1/2 shadow-2xl">
            <img class="object-cover w-full h-screen hidden md:block" src="./img/background.png" alt="Background">
        </div>

    </div>

</body>
</html>
