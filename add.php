<?php 
//Connects to your Database 
$conn = mysqli_connect("localhost", "root", "", "test_login") or die(mysqli_connect_error());
$error = '';
$success = false;

//This code runs if the form has been submitted
if (isset($_POST['submit'])) { 

    //This makes sure they did not leave any fields blank
    if (!$_POST['username'] || !$_POST['pass'] || !$_POST['pass2']) {
        $error = 'You did not complete all of the required fields.';
    } else {
        // checks if the username is in use
        $usercheck = mysqli_real_escape_string($conn, $_POST['username']);
        $check = mysqli_query($conn, "SELECT username FROM users WHERE username = '$usercheck'") 
            or die(mysqli_error($conn));
        $check2 = mysqli_num_rows($check);

        if ($check2 != 0) {
            $error = 'Sorry, the username ' . htmlspecialchars($_POST['username']) . ' is already in use.';
        } elseif ($_POST['pass'] != $_POST['pass2']) {
            $error = 'Your passwords did not match.';
        } else {
            // encrypt and insert
            $pass = md5($_POST['pass']);
            $username = mysqli_real_escape_string($conn, $_POST['username']);
            $insert = "INSERT INTO users (username, password) VALUES ('$username', '$pass')";
            mysqli_query($conn, $insert);
            $success = true;
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.css" rel="stylesheet">
    <style>
        @import url('https://fonts.googleapis.com/css?family=Karla:400,700&display=swap');
        .font-family-karla { font-family: karla; }
    </style>
</head>
<body class="bg-white font-family-karla h-screen">

    <div class="w-full flex flex-wrap">

        <!-- Register Section -->
        <div class="w-full md:w-1/2 flex flex-col">

            <div class="flex justify-center md:justify-start pt-12 md:pl-12 md:-mb-12">
                <a href="#" class="bg-black text-white font-bold text-xl p-4">MyApp</a>
            </div>

            <div class="flex flex-col justify-center md:justify-start my-auto pt-8 md:pt-0 px-8 md:px-24 lg:px-32">
                <p class="text-center text-3xl">Join Us.</p>

                <?php if ($success): ?>
                    <div class="text-center mt-6">
                        <p class="text-green-600 font-semibold text-lg">Account created successfully!</p>
                        <p class="mt-2">You may now <a href="login.php" class="underline font-semibold">log in here.</a></p>
                    </div>
                <?php else: ?>

                    <?php if ($error): ?>
                        <p class="text-red-500 text-center mt-4"><?php echo $error; ?></p>
                    <?php endif; ?>

                    <form class="flex flex-col pt-3 md:pt-8" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                        <div class="flex flex-col pt-4">
                            <label for="username" class="text-lg">Username</label>
                            <input type="text" id="username" name="username" placeholder="Your username" maxlength="60"
                                value="<?php echo isset($_POST['username']) ? htmlspecialchars($_POST['username']) : ''; ?>"
                                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 mt-1 leading-tight focus:outline-none focus:shadow-outline">
                        </div>

                        <div class="flex flex-col pt-4">
                            <label for="pass" class="text-lg">Password</label>
                            <input type="password" id="pass" name="pass" placeholder="Password" maxlength="60"
                                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 mt-1 leading-tight focus:outline-none focus:shadow-outline">
                        </div>

                        <div class="flex flex-col pt-4">
                            <label for="pass2" class="text-lg">Confirm Password</label>
                            <input type="password" id="pass2" name="pass2" placeholder="Confirm Password" maxlength="60"
                                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 mt-1 leading-tight focus:outline-none focus:shadow-outline">
                        </div>

                        <input type="submit" name="submit" value="Register"
                            class="bg-black text-white font-bold text-lg hover:bg-gray-700 p-2 mt-8 cursor-pointer">
                    </form>

                    <div class="text-center pt-12 pb-12">
                        <p>Already have an account? <a href="login.php" class="underline font-semibold">Log in here.</a></p>
                    </div>

                <?php endif; ?>
            </div>

        </div>

        <!-- Image Section -->
        <div class="w-1/2 shadow-2xl">
            <img class="object-cover w-full h-screen hidden md:block" src="./img/background.png" alt="Background">
        </div>

    </div>

</body>
</html>
