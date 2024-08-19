<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "fitplatform";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("連接失敗: " . $conn->connect_error);
}

// 檢查用戶是否已登錄
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

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
?>

<!DOCTYPE html>
<html lang="zh-TW">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <h1 style="visibility: hidden;">.......</h1>
    <title>進階運動計時器</title>
    <link href='https://cdn.jsdelivr.net/npm/fullcalendar@5.10.2/main.min.css' rel='stylesheet' />
    <link rel="stylesheet" href="style.css">
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@5.10.2/main.min.js'></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        .action-input {
            margin-bottom: 10px;
        }
        #actionList {
            margin-bottom: 20px;
        }
        .control-buttons {
            text-align: center;
            margin-bottom: 20px;
        }
        .control-buttons button {
            margin: 0 10px;
        }
        .chart-container {
            width: 300px;
            height: 200px;
            margin: 20px auto;
        }
        .calendar, .chart-container {
    width: 80%;
    max-width: 600px;
    margin: 20px auto;
}
body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
            background-color: #f4f4f4;
        }
        h1, h2 {
            color: #2c3e50;
        }
        .container {
            background-color: #fff;
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 20px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        .action-input {
            margin-bottom: 15px;
        }
        #actionList {
            margin-bottom: 20px;
        }
        .control-buttons {
            text-align: center;
            margin-bottom: 20px;
        }
        .control-buttons button {
            margin: 0 10px;
            padding: 10px 20px;
            font-size: 16px;
            background-color: #3498db;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        .control-buttons button:hover {
            background-color: #2980b9;
        }
        .chart-container {
            width: 100%;
            max-width: 600px;
            height: 300px;
            margin: 20px auto;
        }
        .calendar {
            width: 100%;
            max-width: 800px;
            margin: 20px auto;
        }
        #timer {
            font-size: 48px;
            font-weight: bold;
            text-align: center;
            margin: 20px 0;
        }
        #phase, #action, #cycle, #set {
            font-size: 18px;
            margin: 10px 0;
        }
        .yellow { color: #f39c12; }
        .green { color: #2ecc71; }
        .blue { color: #3498db; }
    </style>
</head>
<body>
<header>
        <div class="container">
            <div class="logo">
                <h1>大肌肌<span>健身平台</span></h1>
            </div>
            <nav>
                <ul>
                    <li><a href="index.php">首頁</a></li>
                    <li><a href="about.php">關於我們</a></li>
                    <?php if (isset($_SESSION['loggedin']) && $_SESSION['loggedin']): ?>
                        <li><a href="qa.php">AI菜單</a></li>
                        <li><a href="profile.php">個人資料</a></li>
                        <li><a href="progress.php">進度追蹤</a></li>
                        <li><a href="analysis.php">數據計算</a></li>
                        <li><a href="view_responses.php">健身菜單紀錄</a></li>
                        <li><a href="start_workout.php">運動計時器</a></li>
                        <li><a href="logout.php">登出</a></li>
                        <li>歡迎, <?= htmlspecialchars($_SESSION['username']) ?></li>
                    <?php else: ?>
                        <li><a href="login.php">登入</a></li>
                        <li><a href="register.php">註冊</a></li>
                    <?php endif; ?>
                </ul>
            </nav>
        </div>
    </header>
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
        let timer;
        let isPaused = false;
        let currentPhase = 'prep';
        let currentTime = 0;
        let currentAction = 0;
        let currentCycle = 0;
        let currentSet = 0;
        let totalSets = 0;
        let actions = [];

        function addAction() {
            const actionList = document.getElementById('actionList');
            const actionIndex = actions.length;
            const actionHtml = `
                <div class="action-input">
                    <label for="type${actionIndex}">運動類型:</label>
                    <select id="type${actionIndex}">
                        <option value="aerobic">有氧</option>
                        <option value="anaerobic">無氧</option>
                    </select>
                    <label for="name${actionIndex}">動作名稱:</label>
                    <input type="text" id="name${actionIndex}" placeholder="例如：深蹲">
                    <label for="prepTime${actionIndex}">預備時間 (秒):</label>
                    <input type="number" id="prepTime${actionIndex}" value="10">
                    <label for="exerciseTime${actionIndex}">運動時間 (秒):</label>
                    <input type="number" id="exerciseTime${actionIndex}" value="30">
                    <label for="restTime${actionIndex}">休息時間 (秒):</label>
                    <input type="number" id="restTime${actionIndex}" value="10">
                    <label for="cycles${actionIndex}">循環次數:</label>
                    <input type="number" id="cycles${actionIndex}" value="3">
                </div>
            `;
            actionList.insertAdjacentHTML('beforeend', actionHtml);
            actions.push({});
        }

        function startTimer() {
            clearInterval(timer);
            isPaused = false;
            actions = [];
            const actionInputs = document.querySelectorAll('.action-input');
            actionInputs.forEach((actionInput, index) => {
                actions.push({
                    type: document.getElementById(`type${index}`).value,
                    name: document.getElementById(`name${index}`).value,
                    prepTime: parseInt(document.getElementById(`prepTime${index}`).value),
                    exerciseTime: parseInt(document.getElementById(`exerciseTime${index}`).value),
                    restTime: parseInt(document.getElementById(`restTime${index}`).value),
                    cycles: parseInt(document.getElementById(`cycles${index}`).value)
                });
            });
            currentPhase = 'prep';
            currentAction = 0;
            currentTime = actions[0].prepTime;
            currentCycle = 1;
            currentSet = 1;
            totalSets = parseInt(document.getElementById('sets').value);
            updateDisplay();
            timer = setInterval(updateTimer, 1000);
        }

        function pauseTimer() {
            isPaused = true;
            clearInterval(timer);
        }

        function resumeTimer() {
            if (isPaused) {
                isPaused = false;
                timer = setInterval(updateTimer, 1000);
            }
        }

        function resetTimer() {
            clearInterval(timer);
            currentPhase = 'prep';
            currentTime = 0;
            currentAction = 0;
            currentCycle = 0;
            currentSet = 0;
            updateDisplay();
        }

        function updateTimer() {
            if (isPaused) return;
            currentTime--;
            if (currentTime <= 0) {
                switchPhase();
            }
            updateDisplay();
        }

        function switchPhase() {
            const currentActionData = actions[currentAction];
            if (currentPhase === 'prep') {
                currentPhase = 'exercise';
                currentTime = currentActionData.exerciseTime;
            } else if (currentPhase === 'exercise') {
                if (currentCycle < currentActionData.cycles) {
                    currentPhase = 'rest';
                    currentTime = currentActionData.restTime;
                    currentCycle++;
                } else {
                    currentAction++;
                    if (currentAction < actions.length) {
                        currentPhase = 'prep';
                        currentTime = actions[currentAction].prepTime;
                        currentCycle = 1;
                    } else if (currentSet < totalSets) {
                        currentAction = 0;
                        currentPhase = 'prep';
                        currentTime = actions[0].prepTime;
                        currentSet++;
                        currentCycle = 1;
                    } else {
                        clearInterval(timer);
                        alert('運動完成!');
                        recordExercise();
                        return;
                    }
                }
            } else if (currentPhase === 'rest') {
                currentPhase = 'exercise';
                currentTime = currentActionData.exerciseTime;
            }
        }

        function updateDisplay() {
            document.getElementById('timer').textContent = formatTime(currentTime);
            document.getElementById('phase').textContent = getPhaseText();
            document.getElementById('action').textContent = `動作: ${actions[currentAction].name}`;
            document.getElementById('cycle').textContent = `循環: ${currentCycle} / ${actions[currentAction].cycles}`;
            document.getElementById('set').textContent = `組數: ${currentSet} / ${totalSets}`;
            
            document.getElementById('timer').className = 
                currentPhase === 'prep' ? 'yellow' : 
                currentPhase === 'exercise' ? 'green' : 'blue';
        }

        function formatTime(seconds) {
            const mins = Math.floor(seconds / 60);
            const secs = seconds % 60;
            return `${mins.toString().padStart(2, '0')}:${secs.toString().padStart(2, '0')}`;
        }

        function getPhaseText() {
            switch(currentPhase) {
                case 'prep': return '預備';
                case 'exercise': return '運動';
                case 'rest': return '休息';
            }
        }

        function recordExercise() {
            const totalDuration = actions.reduce((sum, action) => 
                sum + (action.prepTime + action.exerciseTime + action.restTime) * action.cycles, 0) * totalSets;
            
            const form = document.createElement('form');
            form.method = 'post';
            form.style.display = 'none';

            const typeInput = document.createElement('input');
            typeInput.name = 'type';
            typeInput.value = actions.map(a => a.type).join(', ');
            form.appendChild(typeInput);

            const durationInput = document.createElement('input');
            durationInput.name = 'duration';
            durationInput.value = totalDuration;
            form.appendChild(durationInput);

            const actionsInput = document.createElement('input');
            actionsInput.name = 'actions';
            actionsInput.value = JSON.stringify(actions);
            form.appendChild(actionsInput);

            document.body.appendChild(form);
            form.submit();
        }

        document.addEventListener('DOMContentLoaded', function() {
            initializeCalendar();
            updateCharts();
            addAction(); // 添加第一個動作輸入
        });

        function initializeCalendar() {
            var calendarEl = document.getElementById('calendar');
            var calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                events: getCalendarEvents(),
                dateClick: function(info) {
                    alert('點擊的日期: ' + info.dateStr);
                    // 這裡可以添加顯示當天運動詳情的邏輯
                }
            });
            calendar.render();
        }

        function getCalendarEvents() {
    const exercises = <?php echo json_encode($exercises); ?>;
    return exercises.map(exercise => ({
        title: getChineseType(exercise.type),
        start: exercise.date,
        allDay: true
    }));

    function getChineseType(type) {
    const types = type.split(', ');
    return types.map(t => t === 'aerobic' ? '有氧' : t === 'anaerobic' ? '無氧' : t).join('、');
}

}

        function updateCharts() {
            const exercises = <?php echo json_encode($exercises); ?>;
            updateWeeklyChart(exercises);
            updateMonthlyChart(exercises);
            updateTypeChart(exercises);
        }

        function updateWeeklyChart(exercises) {
            const weekDays = ['週日', '週一', '週二', '週三', '週四', '週五', '週六'];
            const weeklyCounts = new Array(7).fill(0);

            exercises.forEach(exercise => {
                const day = new Date(exercise.date).getDay();
                weeklyCounts[day]++;
            });

            const ctx = document.getElementById('weeklyChart').getContext('2d');
            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: weekDays,
                    datasets: [{
                        label: '每週運動次數',
                        data: weeklyCounts,
                        backgroundColor: 'rgba(75, 192, 192, 0.6)'
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                stepSize: 1
                            }
                        }
                    }
                }
            });
        }

        function updateMonthlyChart(exercises) {
            const monthNames = ['一月', '二月', '三月', '四月', '五月', '六月', '七月', '八月', '九月', '十月', '十一月', '十二月'];
            const monthlyDurations = new Array(12).fill(0);

            exercises.forEach(exercise => {
                const month = new Date(exercise.date).getMonth();
                monthlyDurations[month] += exercise.duration / 60; // 轉換為分鐘
            });

            const ctx = document.getElementById('monthlyChart').getContext('2d');
            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: monthNames,
                    datasets: [{
                        label: '每月運動時長 (分鐘)',
                        data: monthlyDurations,
                        borderColor: 'rgb(75, 192, 192)',
                        tension: 0.1
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        }

function updateTypeChart(exercises) {
    const typeCounts = {
        '有氧': 0,
        '無氧': 0
    };

    exercises.forEach(exercise => {
        const types = exercise.type.split(', ');
        types.forEach(type => {
            if (type === 'aerobic') typeCounts['有氧']++;
            if (type === 'anaerobic') typeCounts['無氧']++;
        });
    });

    const ctx = document.getElementById('typeChart').getContext('2d');
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ['有氧', '無氧'],
            datasets: [{
                label: '運動類型次數',
                data: [typeCounts['有氧'], typeCounts['無氧']],
                backgroundColor: [
                    'rgba(255, 99, 132, 0.6)',
                    'rgba(54, 162, 235, 0.6)'
                ]
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1
                    }
                }
            }
        }
    });
}

    </script>
</body>
</html>