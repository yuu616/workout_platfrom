<?php
require_once __DIR__ . '/config.php';

$conn = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

if ($conn->connect_error) {
    die('連接失敗: ' . $conn->connect_error);
}

$conn->set_charset('utf8mb4');
