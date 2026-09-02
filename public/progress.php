<?php
require __DIR__ . '/includes/auth.php';
require __DIR__ . '/includes/db.php';

// 獲取用戶的最新基礎代謝率
$stmt = $conn->prepare("SELECT bmr FROM user_analysis WHERE user_id = ? ORDER BY date DESC LIMIT 1");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$bmr = $result->fetch_assoc()['bmr'] ?? 0;
$bmr = floatval($bmr);

// 獲取用戶的最新預期體重
$stmt = $conn->prepare("SELECT expected_weight FROM user_progress WHERE user_id = ? ORDER BY date DESC LIMIT 1");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$latest_expected_weight = $result->fetch_assoc()['expected_weight'] ?? 0;
$latest_expected_weight = floatval($latest_expected_weight);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['reset'])) {
        // 還原功能
        $stmt = $conn->prepare("DELETE FROM user_progress WHERE user_id = ?");
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $reset_message = "所有進度數據已被清除。";
    } elseif (isset($_POST['record'])) {
        // 記錄功能
        $weight = floatval($_POST['weight']);
        $date = $_POST['date'];
        $expected_weight = floatval($_POST['expected_weight']);
        $calories_in = intval($_POST['calories_in']);
        $calories_out = intval($_POST['calories_out']);

        // 如果沒有輸入新的預期體重,使用最新的預期體重
        if ($expected_weight == 0) {
            $expected_weight = $latest_expected_weight;
        }

        $stmt = $conn->prepare("INSERT INTO user_progress (user_id, weight, date, expected_weight, calories_in, calories_out) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("idsdii", $user_id, $weight, $date, $expected_weight, $calories_in, $calories_out);
        $stmt->execute();
        
        // 添加跳轉
        echo "<script>
            alert('數據已成功記錄！');
            window.location.href = 'progress.php#View';
        </script>";
        exit;
    } elseif (isset($_POST['delete'])) {
        // 刪除特定記錄
        $date_to_delete = $_POST['delete_date'];
        $stmt = $conn->prepare("DELETE FROM user_progress WHERE user_id = ? AND date = ?");
        $stmt->bind_param("is", $user_id, $date_to_delete);
        $stmt->execute();
        $delete_message = "已刪除 $date_to_delete 的記錄。";
    }
}

// 設置默認日期範圍為過去一周
$start_date = isset($_GET['start_date']) ? $_GET['start_date'] : date('Y-m-d', strtotime('-1 week'));
$end_date = isset($_GET['end_date']) ? $_GET['end_date'] : date('Y-m-d');

// 獲取指定日期範圍的進度數據
$stmt = $conn->prepare("SELECT * FROM user_progress WHERE user_id = ? AND date BETWEEN ? AND ? ORDER BY date ASC");
$stmt->bind_param("iss", $user_id, $start_date, $end_date);
$stmt->execute();
$result = $stmt->get_result();
$progress = $result->fetch_all(MYSQLI_ASSOC);

// 如果沒有數據，獲取最近的一周數據
if (empty($progress)) {
    $stmt = $conn->prepare("SELECT * FROM user_progress WHERE user_id = ? ORDER BY date DESC LIMIT 7");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $progress = array_reverse($result->fetch_all(MYSQLI_ASSOC));
}

// 計算每日推薦熱量
$recommended_calories = $bmr;

// 獲取最新的體重記錄
$stmt = $conn->prepare("SELECT weight FROM user_progress WHERE user_id = ? ORDER BY date DESC LIMIT 1");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$current_weight = $result->fetch_assoc()['weight'] ?? 0;
$current_weight = floatval($current_weight);

// 計算距離目標體重的差距
$weight_difference = $current_weight - $latest_expected_weight;

// 計算本週平均卡路里攝入量
$stmt = $conn->prepare("SELECT AVG(calories_in) as avg_calories FROM user_progress WHERE user_id = ? AND date >= DATE_SUB(CURDATE(), INTERVAL 7 DAY)");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$avg_calories = $result->fetch_assoc()['avg_calories'];
$avg_calories = $avg_calories ? round($avg_calories) : 0; // 如果是 NULL，設為 0

// 計算體重變化趨勢
$weight_trend = "維持";
if (count($progress) > 1) {
    $first_weight = $progress[0]['weight'];
    $last_weight = end($progress)['weight'];
    if ($last_weight < $first_weight) {
        $weight_trend = "下降";
    } elseif ($last_weight > $first_weight) {
        $weight_trend = "上升";
    }
}

// 計算平均每日卡路里盈餘/赤字
$total_net_calories = 0;
foreach ($progress as $entry) {
    $total_net_calories += $entry['calories_in'] - $entry['calories_out'];
}
$avg_net_calories = count($progress) > 0 ? round($total_net_calories / count($progress)) : 0;

// 計算進度百分比

$page_title   = '進度追蹤';
$active_page  = 'progress.php';
$page_styles  = ['assets/css/progress.css'];
$page_scripts = ['assets/js/progress.js'];
$page_head_extra = <<<'HTML'
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
HTML;
require __DIR__ . '/includes/header.php';
?>
    <main>
    <h1 style="color: White;">.......</h1>
    <h1 style="color: black;">進度追蹤</h1>
        
        <div class="tab">
            <button class="tablinks" onclick="openTab(event, 'Record')" id="defaultOpen">記錄進度</button>
            <button class="tablinks" onclick="openTab(event, 'View')">查看進度</button>
        </div>

        <div id="Record" class="tabcontent">
            <h2>記錄新的進度</h2>
            <div class="progress-form"><form method="post">
                    <label for="weight">體重 (kg):</label>
                    <input type="number" step="0.1" id="weight" name="weight" required>

                    <label for="update_expected_weight">更新預期體重?</label>
                    <input type="checkbox" id="update_expected_weight" onchange="toggleExpectedWeight()">

                    <label for="expected_weight">預期體重 (kg):</label>
                    <input type="number" step="0.1" id="expected_weight" name="expected_weight" value="<?php echo htmlspecialchars($latest_expected_weight); ?>" disabled>

                    <label for="calories_in">攝入熱量 (卡路里):</label>
                    <input type="number" id="calories_in" name="calories_in" required>

                    <label for="calories_out">消耗熱量 (卡路里):</label>
                    <input type="number" id="calories_out" name="calories_out" required>

                    <label for="date">日期:</label>
                    <input type="date" id="date" name="date" required value="<?php echo date('Y-m-d'); ?>">

                    <div class="buttons">
                        <button type="submit" style="width: auto; padding: 8px 12px; font-size: 14px; background-color: #007bff; color: white; border: none; border-radius: 4px; cursor: pointer; display: inline-block;" name="record">記錄</button>
                    </div>
                </form>

                <?php if (isset($success_message)): ?>
                    <p class="success-message"><?php echo $success_message; ?></p>
                <?php endif; ?>

                <?php if (isset($reset_message)): ?>
                    <p class="reset-message"><?php echo $reset_message; ?></p>
                <?php endif; ?>

                <?php if (isset($delete_message)): ?>
                    <p class="delete-message"><?php echo $delete_message; ?></p>
                <?php endif; ?>
            </div>
        </div>

        <div id="View" class="tabcontent">
            <h2>查看進度</h2>
            <div class="overview">
                <div class="overview-item">
                    <h3>當前體重</h3>
                    <p><?php echo number_format($current_weight,1); ?> kg</p>
                </div>
                <div class="overview-item">
                    <h3>距離目標體重</h3>
                    <p><?php echo number_format($weight_difference, 1); ?> kg</p>
                </div>
                <div class="overview-item">
                    <h3>本週平均卡路里攝入</h3>
                    <p><?php echo $avg_calories; ?> 卡路里</p>
                </div>
                <div class="overview-item">
                    <h3>體重變化趨勢</h3>
                    <p class="trend-<?php echo strtolower($weight_trend); ?>"><?php echo $weight_trend; ?></p>
                </div>
                <div class="overview-item">
                    <h3>平均每日卡路里盈餘/赤字</h3>
                    <p><?php echo $avg_net_calories; ?> 卡路里</p>
                </div>
            </div>

            <div class="date-range-form">
                <form onsubmit="event.preventDefault(); queryProgress();">
                    <label for="start_date">開始日期:</label>
                    <input type="date" id="start_date" name="start_date" value="<?php echo $start_date; ?>">

                    <label for="end_date">結束日期:</label>
                    <input type="date" id="end_date" name="end_date" value="<?php echo $end_date; ?>">

                    <button type="submit" style="width: auto; padding: 8px 12px; font-size: 14px; background-color: #007bff; color: white; border: none; border-radius: 4px; cursor: pointer; display: inline-block;">查詢</button>
                </form>
            </div>

            <div class="progress-charts">
                <div class="chart-container">
                    <canvas id="weightChart"></canvas>
                </div>
                <div class="chart-container">
                    <canvas id="caloriesChart"></canvas>
                </div>

            </div>

            <table class="progress-table">
                <thead>
                    <tr>
                        <th>日期</th>
                        <th>實際體重 (kg)</th>
                        <th>預期體重 (kg)</th>
                        <th>攝入熱量 (卡路里)</th>
                        <th>消耗熱量 (卡路里)</th>
                        <th>淨熱量 (卡路里)</th>
                        <th>與推薦攝入量差異</th>
                        <th>操作</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($progress as $entry): 
                        $net_calories = $entry['calories_in'] - $entry['calories_out'];
                        $calorie_difference = $entry['calories_in'] - $recommended_calories;
                    ?>
                    <tr>
                        <td><?php echo $entry['date']; ?></td>
                        <td><?php echo $entry['weight']; ?></td>
                        <td><?php echo $entry['expected_weight']; ?></td>
                        <td><?php echo $entry['calories_in']; ?></td>
                        <td><?php echo $entry['calories_out']; ?></td>
                        <td><?php echo $net_calories; ?></td>
                        <td><?php echo $calorie_difference; ?></td>
                        <td>
                            <form method="post" class="delete-form" onsubmit="return confirmDelete('<?php echo $entry['date']; ?>')">
                                <input type="hidden" name="delete_date" value="<?php echo $entry['date']; ?>">
                                <button type="submit" name="delete" class="delete-button">刪除</button>
                            </form>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <form method="post" onsubmit="return confirmReset()">
            <button type="submit" name="reset" class="reset-button">還原所有數據</button>
        </form>

    </main>
    <script>
        window.PROGRESS_DATA = <?= json_encode([
            'dates'                => array_column($progress, 'date'),
            'weights'              => array_column($progress, 'weight'),
            'expectedWeights'      => array_column($progress, 'expected_weight'),
            'caloriesIn'           => array_column($progress, 'calories_in'),
            'caloriesOut'          => array_column($progress, 'calories_out'),
            'recommendedCalories'  => array_fill(0, count($progress), $recommended_calories),
            'netCalories'          => array_map(
                fn($entry) => $entry['calories_in'] - $entry['calories_out'],
                $progress
            ),
            'latestExpectedWeight' => $latest_expected_weight,
        ], JSON_UNESCAPED_UNICODE) ?>;
    </script>
<?php require __DIR__ . '/includes/footer.php'; ?>
