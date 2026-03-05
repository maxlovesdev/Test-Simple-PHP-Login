<?php
$conn = mysqli_connect("localhost", "root", "", "test_login") or die(mysqli_connect_error());

// Auth check
if (!isset($_COOKIE['ID_your_site'])) {
    header("Location: login.php");
    exit();
}

$currentUser = mysqli_real_escape_string($conn, $_COOKIE['ID_your_site']);
$pass = $_COOKIE['Key_your_site'];
$authCheck = mysqli_query($conn, "SELECT * FROM users WHERE username = '$currentUser'") or die(mysqli_error($conn));
$authInfo = mysqli_fetch_array($authCheck);

if (!$authInfo || $pass != $authInfo['password']) {
    setcookie('ID_your_site', '', time() - 3600);
    setcookie('Key_your_site', '', time() - 3600);
    header("Location: login.php");
    exit();
}

// Get target user by ID
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header("Location: members.php");
    exit();
}

$targetId = (int)$_GET['id'];
$userQuery = mysqli_query($conn, "SELECT * FROM users WHERE ID = $targetId") or die(mysqli_error($conn));
$targetUser = mysqli_fetch_array($userQuery);

if (!$targetUser) {
    header("Location: members.php");
    exit();
}

$error = '';
$success = false;

if (isset($_POST['submit'])) {
    $newPass  = $_POST['new_pass'] ?? '';
    $confPass = $_POST['confirm_pass'] ?? '';

    if (!$newPass || !$confPass) {
        $error = 'Please fill in both password fields.';
    } elseif ($newPass !== $confPass) {
        $error = 'Passwords do not match.';
    } else {
        $hashed = md5($newPass);
        mysqli_query($conn, "UPDATE users SET password = '$hashed' WHERE ID = $targetId") or die(mysqli_error($conn));

        // If the modified user is the current user, update their cookie too
        if ($targetUser['username'] === $_COOKIE['ID_your_site']) {
            $hour = time() + 3600;
            setcookie('Key_your_site', $hashed, $hour);
        }

        $success = true;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modify User</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.css" rel="stylesheet">
    <style>
        @import url('https://fonts.googleapis.com/css?family=Karla:400,700&display=swap');
        .font-family-karla { font-family: karla; }
    </style>
</head>
<body class="bg-gray-100 font-family-karla min-h-screen">

    <!-- Navbar -->
    <nav class="bg-black text-white px-8 py-4 flex justify-between items-center">
        <a href="#" class="font-bold text-xl">MyApp</a>
        <div class="flex items-center space-x-4">
            <span class="text-gray-300">Logged in as <strong><?php echo htmlspecialchars($_COOKIE['ID_your_site']); ?></strong></span>
            <a href="logout.php" class="bg-white text-black font-semibold px-4 py-2 hover:bg-gray-200">Logout</a>
        </div>
    </nav>

    <div class="max-w-md mx-auto mt-10 px-4">
        <div class="bg-white shadow rounded p-8">
            <h1 class="text-2xl font-bold mb-2">Modify User</h1>
            <p class="text-gray-500 mb-6">
                Changing password for <strong><?php echo htmlspecialchars($targetUser['username']); ?></strong>
                <?php if ($targetUser['username'] === $_COOKIE['ID_your_site']): ?>
                    <span class="text-indigo-600">(you)</span>
                <?php endif; ?>
            </p>

            <?php if ($success): ?>
                <div class="bg-green-100 text-green-700 px-4 py-3 rounded mb-4">
                    Password updated successfully.
                </div>
                <a href="members.php" class="block text-center bg-black text-white font-bold py-2 hover:bg-gray-700">
                    Back to Users
                </a>
            <?php else: ?>

                <?php if ($error): ?>
                    <p class="text-red-500 mb-4"><?php echo htmlspecialchars($error); ?></p>
                <?php endif; ?>

                <form action="modify.php?id=<?php echo $targetId; ?>" method="post" class="flex flex-col space-y-4">
                    <div class="flex flex-col">
                        <label for="new_pass" class="text-lg mb-1">New Password</label>
                        <input type="password" id="new_pass" name="new_pass" placeholder="New password"
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                    </div>
                    <div class="flex flex-col">
                        <label for="confirm_pass" class="text-lg mb-1">Confirm Password</label>
                        <input type="password" id="confirm_pass" name="confirm_pass" placeholder="Confirm new password"
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                    </div>
                    <div class="flex space-x-3 pt-2">
                        <input type="submit" name="submit" value="Save Changes"
                            class="flex-1 bg-black text-white font-bold text-lg hover:bg-gray-700 p-2 cursor-pointer">
                        <a href="members.php"
                            class="flex-1 text-center border border-gray-300 text-gray-700 font-bold text-lg hover:bg-gray-100 p-2">
                            Cancel
                        </a>
                    </div>
                </form>

            <?php endif; ?>
        </div>
    </div>

</body>
</html>
