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

// Validate ID
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

// Prevent self-deletion
if ($targetUser['username'] === $_COOKIE['ID_your_site']) {
    header("Location: members.php");
    exit();
}

// Perform deletion
mysqli_query($conn, "DELETE FROM users WHERE ID = $targetId") or die(mysqli_error($conn));

header("Location: members.php");
exit();
