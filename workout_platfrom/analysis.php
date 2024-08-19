<?php
session_start();
include('db.php');

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$user_id = $_SESSION['user_id'];

function calculateBMI($weight, $height) {
    return $weight / (($height / 100) ** 2);
}

function calculateBodyFat($gender, $waist, $neck, $height, $hip = null) {
    if ($gender == 'male') {
        return 495 / (1.0324 - 0.19077 * log10($waist - $neck) + 0.15456 * log10($height)) - 450;
    } else {
        return 495 / (1.29579 - 0.35004 * log10($waist + $hip - $neck) + 0.22100 * log10($height)) - 450;
    }
}

function calculateBMR($weight, $height, $age, $gender) {
    if ($gender == 'male') {
        return 9.99 * $weight + 6.25 * $height - 4.92 * $age + (166 * 1 - 161);
    } else {
        return 9.99 * $weight + 6.25 * $height - 4.92 * $age + (166 * 0 - 161);
    }
}

function getBMIStatus($bmi) {
    if ($bmi < 18.5) return '過輕';
    if ($bmi < 24) return '正常';
    if ($bmi < 27) return '過重';
    if ($bmi < 30) return '輕度肥胖';
    if ($bmi < 35) return '中度肥胖';
    return '重度肥胖';
}

function getBodyFatStatus($bodyFat, $gender) {
    if ($gender == 'male') {
        if ($bodyFat < 6) return '過低';
        if ($bodyFat < 14) return '運動員';
        if ($bodyFat < 18) return '健康';
        if ($bodyFat < 25) return '可接受';
        return '過高';
    } else {
        if ($bodyFat < 14) return '過低';
        if ($bodyFat < 21) return '運動員';
        if ($bodyFat < 25) return '健康';
        if ($bodyFat < 32) return '可接受';
        return '過高';
    }
}

$bmi = $bodyFat = $bmr = null;

// 獲取用戶個人資料
$stmt = $conn->prepare("SELECT * FROM user_profiles WHERE user_id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$userProfile = $result->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['clear_data'])) {
        $stmt = $conn->prepare("DELETE FROM user_analysis WHERE user_id = ?");
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $clear_message = "所有數據分析記錄已成功清除。";
    } else {
        $weight = $_POST['weight'];
        $height = $_POST['height'];
        $age = $_POST['age'];
        $gender = $_POST['gender'];
        $waist = $_POST['waist'];
        $neck = $_POST['neck'];
        $hip = ($gender == 'female') ? $_POST['hip'] : null;

        $bmi = calculateBMI($weight, $height);
        $bodyFat = calculateBodyFat($gender, $waist, $neck, $height, $hip);
        $bmr = calculateBMR($weight, $height, $age, $gender);

        if ($gender == 'female') {
            $sql = "INSERT INTO user_analysis (user_id, weight, height, age, gender, waist, neck, hip, bmi, body_fat, bmr, date) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW())";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("iddisdddddds", $user_id, $weight, $height, $age, $gender, $waist, $neck, $hip, $bmi, $bodyFat, $bmr);
        } else {
            $sql = "INSERT INTO user_analysis (user_id, weight, height, age, gender, waist, neck, bmi, body_fat, bmr, date) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW())";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("iddisddddd", $user_id, $weight, $height, $age, $gender, $waist, $neck, $bmi, $bodyFat, $bmr);
        }

        $stmt->execute();
    }
}

$stmt = $conn->prepare("SELECT * FROM user_analysis WHERE user_id = ? ORDER BY date DESC LIMIT 1");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$latestAnalysis = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="zh-TW">
<head>
    <meta charset="UTF-8">
    <title>數據分析 - 大肌肌健身平台</title>
    <link rel="stylesheet" href="style.css">
    <style>
        .status-normal { color: green; }
        .status-warning { color: orange; }
        .status-danger { color: red; }
        .clear-btn {
            background-color: #ff4d4d;
            color: white;
            border: none;
            padding: 10px 20px;
            cursor: pointer;
            border-radius: 5px;
            margin-top: 20px;
        }
        .clear-btn:hover {
            background-color: #ff3333;
        }
    </style>
</head>
<body>
    <header>
        <!-- 省略 header 部分，保持不變 -->
        <div class="container">
            <div class="logo">
                <h1>大肌肌<span>健身平台</span></h1>
            </div>
            <nav>
                <ul>
                    <li><a href="index.php" class="active">首頁</a></li>
                    <li><a href="about.php">關於我們</a></li>
                    <?php if (isset($_SESSION['loggedin']) && $_SESSION['loggedin']): ?>
                        <li><a href="qa.php">AI菜單</a></li>
                        <li><a href="profile.php">個人資料</a></li>
                        <li><a href="progress.php">進度追蹤</a></li>
                        <li><a href="analysis.php">數據計算</a></li>
                        <li><a href="view_responses.php">健身菜單紀錄</a></li>
                        <li><a href="start_workout.php">運動計時器</a></li>
                        <li><a href="logout.php">登出</a></li>
                        <li class="welcome">歡迎, <?= htmlspecialchars($_SESSION['username']) ?></li>
                    <?php else: ?>
                        <li><a href="login.php">登入</a></li>
                        <li><a href="register.php">註冊</a></li>
                    <?php endif; ?>
                </ul>
            </nav>
        </div>
    </header>
    <main>
        <div class="profile-container">
        <h1 style="color: White;">.......</h1>
            <h1 style="color: black;">數據分析</h1>
            <?php if (isset($clear_message)): ?>
                <p style="color: green;"><?php echo $clear_message; ?></p><?php endif; ?>
            <form method="post">
                <label for="height">身高 (cm):</label>
                <input type="number" step="0.1" id="height" name="height" value="<?php echo $userProfile['height'] ?? ''; ?>" required>

                <label for="weight">體重 (kg):</label>
                <input type="number" step="0.1" id="weight" name="weight" value="<?php echo $userProfile['weight'] ?? ''; ?>" required>

                <label for="age">年齡:</label>
                <input type="number" id="age" name="age" value="<?php echo $userProfile['age'] ?? ''; ?>" required>

                <label for="gender">性別:</label>
                <select id="gender" name="gender" required>
                    <option value="male" <?php echo ($userProfile['gender'] == 'male') ? 'selected' : ''; ?>>男性</option>
                    <option value="female" <?php echo ($userProfile['gender'] == 'female') ? 'selected' : ''; ?>>女性</option>
                </select>

                <label for="waist">腰圍 (cm):</label>
                <input type="number" step="0.1" id="waist" name="waist" value="<?php echo $userProfile['waist'] ?? ''; ?>" required>

                <label for="neck">脖圍 (cm):</label>
                <input type="number" step="0.1" id="neck" name="neck" value="<?php echo $userProfile['neck'] ?? ''; ?>" required>

                <label for="hip" id="hip_label" style="display:none;">臀圍 (cm):</label>
                <input type="number" step="0.1" id="hip" name="hip" value="<?php echo $userProfile['hip'] ?? ''; ?>" style="display:none;">

                <button type="submit" class="submit-btn" style="width: auto; padding: 8px 12px; font-size: 14px; background-color: #007bff; color: white; border: none; border-radius: 4px; cursor: pointer; display: inline-block;">計算</button>
            </form>

            <!-- 添加清除數據按鈕 -->
            <form method="post" onsubmit="return confirm('確定要清除所有數據分析記錄嗎？這個操作無法撤銷。');">
                <button type="submit" name="clear_data" class="clear-btn">清除所有數據</button>
            </form>

            <?php if ($latestAnalysis): ?>
                <h2>最新分析結果 (<?php echo $latestAnalysis['date']; ?>)</h2>
                <?php
                    $bmiStatus = getBMIStatus($latestAnalysis['bmi']);
                    $bodyFatStatus = getBodyFatStatus($latestAnalysis['body_fat'], $latestAnalysis['gender']);
                    
                    $bmiClass = ($bmiStatus == '正常') ? 'status-normal' : (($bmiStatus == '過重' || $bmiStatus == '過輕') ? 'status-warning' : 'status-danger');
                    $bodyFatClass = ($bodyFatStatus == '健康') ? 'status-normal' : (($bodyFatStatus == '可接受' || $bodyFatStatus == '運動員') ? 'status-warning' : 'status-danger');
                ?>
                <p>BMI: <?php echo number_format($latestAnalysis['bmi'], 2); ?> 
                   <span class="<?php echo $bmiClass; ?>">(<?php echo $bmiStatus; ?>)</span>
                </p>
                <p>體脂率: <?php echo number_format($latestAnalysis['body_fat'], 2); ?>% 
                   <span class="<?php echo $bodyFatClass; ?>">(<?php echo $bodyFatStatus; ?>)</span>
                </p>
                <p>基礎代謝率: <?php echo number_format($latestAnalysis['bmr'], 2); ?> 卡路里/天</p>
                <p>體重: <?php echo $latestAnalysis['weight']; ?> kg</p>
                <p>身高: <?php echo $latestAnalysis['height']; ?> cm</p>
                <p>腰圍: <?php echo $latestAnalysis['waist']; ?> cm</p>
                <p>脖圍: <?php echo $latestAnalysis['neck']; ?> cm</p>
                <?php if ($latestAnalysis['gender'] == 'female'): ?>
                    <p>臀圍: <?php echo $latestAnalysis['hip']; ?> cm</p>
                <?php endif; ?>
            <?php endif; ?>
        </div>
    </main>

    <script>
    document.getElementById('gender').addEventListener('change', function() {
        var hipField = document.getElementById('hip');
        var hipLabel = document.getElementById('hip_label');
        if (this.value === 'female') {
            hipField.style.display = 'block';
            hipLabel.style.display = 'block';
        } else {
            hipField.style.display = 'none';
            hipLabel.style.display = 'none';
        }
    });

    // 頁面加載時檢查性別
    window.onload = function() {
        var gender = document.getElementById('gender').value;
        var hipField = document.getElementById('hip');
        var hipLabel = document.getElementById('hip_label');
        if (gender === 'female') {
            hipField.style.display = 'block';
            hipLabel.style.display = 'block';
        } else {
            hipField.style.display = 'none';
            hipLabel.style.display = 'none';
        }
    };
    </script>
</body>
</html>