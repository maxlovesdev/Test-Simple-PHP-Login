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

// Fetch all users
$users = mysqli_query($conn, "SELECT ID, username FROM users ORDER BY username ASC") or die(mysqli_error($conn));
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Members Area</title>
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

    <div class="max-w-4xl mx-auto mt-10 px-4">
        <h1 class="text-3xl font-bold mb-6">User Management</h1>

        <div class="bg-white shadow rounded overflow-hidden">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Username</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <?php while ($user = mysqli_fetch_array($users)): ?>
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 text-sm text-gray-500"><?php echo $user['ID']; ?></td>
                        <td class="px-6 py-4 text-sm font-medium text-gray-900">
                            <?php echo htmlspecialchars($user['username']); ?>
                            <?php if ($user['username'] === $_COOKIE['ID_your_site']): ?>
                                <span class="ml-2 text-xs text-indigo-600 font-semibold">(you)</span>
                            <?php endif; ?>
                        </td>
                        <td class="px-6 py-4 text-sm space-x-2">
                            <!-- Modify button always available -->
                            <a href="modify.php?id=<?php echo $user['ID']; ?>"
                               class="inline-block bg-indigo-600 text-white text-xs font-semibold px-3 py-1 rounded hover:bg-indigo-700">
                                Modify
                            </a>
                            <!-- Delete blocked for current user -->
                            <?php if ($user['username'] !== $_COOKIE['ID_your_site']): ?>
                                <a href="delete.php?id=<?php echo $user['ID']; ?>"
                                   onclick="return confirm('Delete user <?php echo htmlspecialchars($user['username'], ENT_QUOTES); ?>?')"
                                   class="inline-block bg-red-600 text-white text-xs font-semibold px-3 py-1 rounded hover:bg-red-700">
                                    Delete
                                </a>
                            <?php else: ?>
                                <span class="inline-block text-xs text-gray-400 px-3 py-1 border border-gray-200 rounded cursor-not-allowed">
                                    Delete
                                </span>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>

</body>
</html>
