<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "fitplatform";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("連接失敗: " . $conn->connect_error);
}
?>
