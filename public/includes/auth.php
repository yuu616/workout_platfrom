<?php
/**
 * 需要登入的頁面在最上方 require 這個檔案，未登入者會被導回登入頁。
 */
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$user_id = $_SESSION['user_id'];
