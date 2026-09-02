<?php
/**
 * 全站共用的頁首（<head> + 導覽列）。
 *
 * 頁面在 include 之前可設定下列變數：
 *   $page_title       string  瀏覽器標題，會自動接上網站名稱
 *   $active_page      string  目前頁面的檔名，用來標示導覽列的 active 項目
 *   $page_styles      array   額外的 CSS 檔路徑（相對於 public/）
 *   $page_head_extra  string  要插進 <head> 的原始 HTML（例如 CDN 的 script/link）
 */
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once __DIR__ . '/config.php';

$page_title      = $page_title ?? '';
$active_page     = $active_page ?? '';
$page_styles     = $page_styles ?? [];
$page_head_extra = $page_head_extra ?? '';

$document_title = $page_title === '' ? SITE_NAME : $page_title . ' - ' . SITE_NAME;

// 導覽列項目：檔名 => 顯示文字
$public_nav = [
    'index.php' => '首頁',
    'about.php' => '關於我們',
];
$member_nav = [
    'qa.php'             => 'AI菜單',
    'profile.php'        => '個人資料',
    'progress.php'       => '進度追蹤',
    'analysis.php'       => '數據計算',
    'view_responses.php' => '健身菜單紀錄',
    'start_workout.php'  => '運動計時器',
    'logout.php'         => '登出',
];
$guest_nav = [
    'login.php'    => '登入',
    'register.php' => '註冊',
];

$is_logged_in = !empty($_SESSION['loggedin']);
$nav_items = $public_nav + ($is_logged_in ? $member_nav : $guest_nav);
?>
<!DOCTYPE html>
<html lang="zh-TW">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($document_title) ?></title>
    <link rel="stylesheet" href="assets/css/style.css">
<?php foreach ($page_styles as $style): ?>
    <link rel="stylesheet" href="<?= htmlspecialchars($style) ?>">
<?php endforeach; ?>
<?= $page_head_extra ?>
</head>
<body>
    <header>
        <div class="container">
            <div class="logo">
                <h1>大肌肌<span>健身平台</span></h1>
            </div>
            <nav>
                <ul>
<?php foreach ($nav_items as $file => $label): ?>
                    <li><a href="<?= $file ?>"<?= $file === $active_page ? ' class="active"' : '' ?>><?= $label ?></a></li>
<?php endforeach; ?>
<?php if ($is_logged_in): ?>
                    <li class="welcome">歡迎, <?= htmlspecialchars($_SESSION['username']) ?></li>
<?php endif; ?>
                </ul>
            </nav>
        </div>
    </header>
