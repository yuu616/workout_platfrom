<?php session_start(); ?>
<!DOCTYPE html>
<html lang="zh-TW">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>大肌肌健身平台</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
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

    <section class="hero">
        <div class="container">
            <div class="hero-content">
                <div class="hero-text">
                    <h2>歡迎來到大肌肌健身平台</h2>
                    <p>這裡是您的個人健康助手，幫助您達成健身目標。</p>
                </div>
                <div class="hero-image">
                    <img src="1.jpg" alt="健身圖片">
                </div>
            </div>
        </div>
    </section>

    <section class="features">
        <div class="container">
            <h2>網站特色</h2>
            <div class="feature-list">
                <div class="feature-item">
                    <img src="2.jpg" alt="AI 圖標">
                    <h3>AI 智能健身飲食計畫</h3>
                    <p>根據您的個人情況，提供量身定制的飲食計劃。</p>
                </div>
                <div class="feature-item">
                    <img src="4.jpg" alt="進度圖標">
                    <h3>進度追蹤</h3>
                    <p>實時記錄您的健身歷程，視覺化呈現進步軌跡。</p>
                </div>
                <div class="feature-item">
                    <img src="3.jpg" alt="追蹤圖標">
                    <h3>身體分析</h3>
                    <p>分析身體指數讓您更了解自己的身體!</p>
                </div>
            </div>
        </div>
    </section>

    <footer>
        <div class="container">
            <p>&copy; 2023 大肌肌健身平台. All rights reserved.</p>
        </div>
    </footer>

    <script>
    function checkReminder() {
        var lastUse = localStorage.getItem('lastUse');
        var now = new Date().getTime();
        
        if (!lastUse || now - lastUse > 7 * 24 * 60 * 60 * 1000) {
            alert('別忘了更新你的進度並使用 AI 菜單！');
        }
        
        localStorage.setItem('lastUse', now);
    }

    window.onload = checkReminder;
    </script>
</body>
</html>