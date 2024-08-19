<?php
session_start();
?>

<!DOCTYPE html>
<html lang="zh-TW">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>關於我們 - 大肌肌健身平台</title>
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
                    <li><a href="index.php">首頁</a></li>
                    <li><a href="about.php" class="active">關於我們</a></li>
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

    <section class="about">
        <div class="container">
            <h2>關於大肌肌健身平台</h2>
            
            <div class="about-content">
                <div class="about-text">
                    <h3>創作理念</h3>
                    <p>大肌肌健身平台成立於2024年。我們觀察到，很多人都在健身之路上常常感到迷茫，缺乏目標和持續的動力。因此，我們決定做一個結合AI技術和專業健身知識的平台，為每一位想健身但不知道該如何開始的人提供個性化的健身解決方案。</p>
                </div>
                
                <div class="about-text">
                    <h3>目標</h3>
                    <p>我們的目標是讓健身與飲食的規劃變得輕鬆、方便。只要是想健身的人，都能在大肌肌健身平台找到適合自己的健身計劃。我們致力於幫助每個人實現健康生活，達成健身目標。</p>
                </div>
                
                <div class="about-text">
                    <h3>核心價值</h3>
                    <div class="value-item">
                        <h4>創新</h4>
                        <p>藉由AI技術，為用戶帶來最先進的健身體驗。</p>
                    </div>
                    <div class="value-item">
                        <h4>個性化</h4>
                        <p>依照每個人的個人情況，提供量身定制的健身方案。</p>
                    </div>
                </div>
            </div>
            
            <div class="contact-us">
                <h3>聯絡我們</h3>
                <p>如果您有任何問題或建議，歡迎隨時與我們聯繫：</p>
                <ul>
                    <li>Email: azz150422@gmail.com</li>
                    <li>電話: (04) 2219 5678</li>
                    <li>地址: 台中市北區三民路三段129號</li>
                </ul>
            </div>
        </div>
    </section>

    <footer>
        <div class="container">
            <p>&copy; 2023 大肌肌健身平台. All rights reserved.</p>
        </div>
    </footer>
</body>
</html>