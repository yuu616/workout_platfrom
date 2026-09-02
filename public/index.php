<?php
$page_title   = '';
$active_page  = 'index.php';
$page_scripts = ['assets/js/reminder.js'];
require __DIR__ . '/includes/header.php';
?>
    <section class="hero">
        <div class="container">
            <div class="hero-content">
                <div class="hero-text">
                    <h2>歡迎來到大肌肌健身平台</h2>
                    <p>這裡是您的個人健康助手，幫助您達成健身目標。</p>
                </div>
                <div class="hero-image">
                    <img src="assets/img/hero.jpg" alt="健身圖片">
                </div>
            </div>
        </div>
    </section>

    <section class="features">
        <div class="container">
            <h2>網站特色</h2>
            <div class="feature-list">
                <div class="feature-item">
                    <img src="assets/img/feature-ai.jpg" alt="AI 圖標">
                    <h3>AI 智能健身飲食計畫</h3>
                    <p>根據您的個人情況，提供量身定制的飲食計劃。</p>
                </div>
                <div class="feature-item">
                    <img src="assets/img/feature-progress.jpg" alt="進度圖標">
                    <h3>進度追蹤</h3>
                    <p>實時記錄您的健身歷程，視覺化呈現進步軌跡。</p>
                </div>
                <div class="feature-item">
                    <img src="assets/img/feature-analysis.jpg" alt="追蹤圖標">
                    <h3>身體分析</h3>
                    <p>分析身體指數讓您更了解自己的身體!</p>
                </div>
            </div>
        </div>
    </section>

<?php require __DIR__ . '/includes/footer.php'; ?>
