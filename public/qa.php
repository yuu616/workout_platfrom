<?php
require __DIR__ . '/includes/auth.php';
require __DIR__ . '/includes/db.php';

// 獲取用戶資料
$stmt = $conn->prepare("SELECT * FROM user_profiles WHERE user_id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$profile = $result->fetch_assoc();

$page_title   = 'AI菜單';
$active_page  = 'qa.php';
$page_styles  = ['assets/css/qa.css'];
$page_scripts = ['assets/js/qa.js'];
require __DIR__ . '/includes/header.php';
?>
    <div class="container">
        <h2>AI菜單</h2>
        <div id="userProfile">
            <h3>個人資料</h3>
            <p>身高: <?= htmlspecialchars($profile['height']) ?> cm</p>
            <p>體重: <?= htmlspecialchars($profile['weight']) ?> kg</p>
            <p>飲食偏好: <?= htmlspecialchars($profile['dietary_preferences']) ?></p>
            <p>不喜歡的食物: <?= htmlspecialchars($profile['dislikes']) ?></p>
            <p>目標: <?= htmlspecialchars($profile['goal']) ?></p>
        </div>
        <form id="qaForm">
            <label for="question">提出你的問題：</label>
            <input type="text" id="question" name="question" placeholder="輸入你的問題">
            <button type="submit">發問</button>
        </form>
        <div id="answer"></div>
    </div>
    <script>
        window.QA_CONFIG = <?= json_encode([
            'aiServiceUrl' => AI_SERVICE_URL,
            'height'       => $profile['height'] ?? '',
            'weight'       => $profile['weight'] ?? '',
            'dislikes'     => $profile['dislikes'] ?? '',
            'goal'         => $profile['goal'] ?? '',
            'userId'       => $user_id,
        ], JSON_UNESCAPED_UNICODE) ?>;
    </script>
<?php require __DIR__ . '/includes/footer.php'; ?>
