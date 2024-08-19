<?php
session_start();
include('db.php');

if (!isset($_SESSION['user_id'])) {
    exit('未登錄');
}

$user_id = $_SESSION['user_id'];
$start_date = $_GET['start_date'];
$end_date = $_GET['end_date'];

// 獲取進度數據
$stmt = $conn->prepare("SELECT * FROM user_progress WHERE user_id = ? AND date BETWEEN ? AND ? ORDER BY date ASC");
$stmt->bind_param("iss", $user_id, $start_date, $end_date);
$stmt->execute();
$result = $stmt->get_result();
$progress = $result->fetch_all(MYSQLI_ASSOC);

// 處理數據
$dates = array_column($progress, 'date');
$weights = array_column($progress, 'weight');
$expected_weights = array_column($progress, 'expected_weight');
$calories_in = array_column($progress, 'calories_in');
$calories_out = array_column($progress, 'calories_out');
$net_calories = array_map(function($in, $out) { return $in - $out; }, $calories_in, $calories_out);

// 獲取推薦熱量
$stmt = $conn->prepare("SELECT bmr FROM user_analysis WHERE user_id = ? ORDER BY date DESC LIMIT 1");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$bmr = $result->fetch_assoc()['bmr'] ?? 0;
$recommended_calories = array_fill(0, count($progress), $bmr);

// 計算進度百分比
$latest_expected_weight = end($expected_weights);
$current_weight = end($weights);
$initial_weight = $weights[0];
$progress_percentage = ($initial_weight - $current_weight) / ($initial_weight - $latest_expected_weight) * 100;
$progress_percentage = max(0, min(100, $progress_percentage));

$response = [
    'dates' => $dates,
    'weights' => $weights,
    'expected_weights' => $expected_weights,
    'calories_in' => $calories_in,
    'calories_out' => $calories_out,
    'net_calories' => $net_calories,
    'recommended_calories' => $recommended_calories,
    'progress_percentage' => $progress_percentage
];

echo json_encode($response);