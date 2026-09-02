<?php
/**
 * 全站設定。
 *
 * 所有值都優先讀取環境變數，讀不到才使用預設值（對應本機 XAMPP 的預設安裝）。
 * 正式環境請設定環境變數，不要直接改這個檔案。
 */

/** 讀取環境變數，沒設定時回傳預設值。 */
function env(string $key, string $default = ''): string
{
    $value = getenv($key);
    return ($value === false || $value === '') ? $default : $value;
}

// 資料庫連線
define('DB_HOST', env('DB_HOST', 'localhost'));
define('DB_USER', env('DB_USER', 'root'));
define('DB_PASSWORD', env('DB_PASSWORD', ''));
define('DB_NAME', env('DB_NAME', 'fitplatform'));

// Flask AI 服務（ai-service/app.py）的位址
define('AI_SERVICE_URL', env('AI_SERVICE_URL', 'http://localhost:5000'));

// 網站名稱，供頁面標題與頁尾使用
define('SITE_NAME', '大肌肌健身平台');
