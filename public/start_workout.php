<?php
require __DIR__ . '/includes/auth.php';
require __DIR__ . '/includes/db.php';

// 處理表單提交
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $date = date('Y-m-d H:i:s');
    $type = $_POST['type'];
    $duration = $_POST['duration'];
    $actions = $_POST['actions'];

    $sql = "INSERT INTO exercises (user_id, date, type, duration, actions) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("issis", $user_id, $date, $type, $duration, $actions);
    $stmt->execute();
    $stmt->close();
}

// 獲取運動記錄
$sql = "SELECT * FROM exercises WHERE user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$exercises = [];
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $exercises[] = $row;
    }
}
$stmt->close();
$conn->close();

$page_title   = '運動計時器';
$active_page  = 'start_workout.php';
$page_styles  = ['assets/css/start-workout.css'];
$page_scripts = ['assets/js/start-workout.js'];
$page_head_extra = <<<'HTML'
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@5.10.2/main.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.10.2/main.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
HTML;
require __DIR__ . '/includes/header.php';
?>
    <h1>進階運動計時器</h1>
    
    <div class="setup">
        <h2>運動設置</h2>
        <div id="actionList">
            <!-- 動作列表將在這裡動態生成 -->
        </div>
        <button onclick="addAction()">添加動作</button>
        <br><br>
        <label for="sets">總組數:</label>
        <input type="number" id="sets" value="2"><br>
        
        <button onclick="startTimer()">開始運動</button>
    </div>
    
    <div class="timer">
        <h2>計時器</h2>
        <div id="timer">00:00</div>
        <div id="phase">準備開始</div>
        <div id="action">動作: </div>
        <div id="cycle">循環: 0 / 0</div>
        <div id="set">組數: 0 / 0</div>
        <div class="control-buttons">
            <button onclick="pauseTimer()">暫停</button>
            <button onclick="resumeTimer()">繼續</button>
            <button onclick="resetTimer()">重置</button>
        </div>
    </div>
    
    <div class="calendar">
        <h2>運動日曆</h2>
        <div id="calendar"></div>
    </div>
    
    <div class="stats">
        <h2>數據統計</h2>
        <div class="chart-container">
            <canvas id="weeklyChart"></canvas>
        </div>
        <div class="chart-container">
            <canvas id="monthlyChart"></canvas>
        </div>
        <div class="chart-container">
            <canvas id="typeChart"></canvas>
        </div>
    </div>
    <script>
        window.WORKOUT_DATA = <?= json_encode(['exercises' => $exercises], JSON_UNESCAPED_UNICODE) ?>;
    </script>
<?php require __DIR__ . '/includes/footer.php'; ?>
