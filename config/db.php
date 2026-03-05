<?php
function getDB() {
    static $conn = null;
    if ($conn === null) {
        $conn = mysqli_connect("localhost", "root", "", "test_login");
        if (!$conn) die("DB connection failed: " . mysqli_connect_error());
    }
    return $conn;
}