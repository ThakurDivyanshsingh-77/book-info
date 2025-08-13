<?php
$host = "localhost";
$user = "root"; // change if you have a different MySQL username
$pass = "";     // your MySQL password
$dbname = "booksdb";

$conn = new mysqli($host, $user, $pass, $dbname);

if ($conn->connect_error) {
    die("Database Connection Failed: " . $conn->connect_error);
}
?>
