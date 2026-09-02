<?php
session_start();

$error = $_SESSION['error'] ?? '';
unset($_SESSION['error']);

$page_title  = '登入';
$active_page = 'login.php';
require __DIR__ . '/includes/header.php';
?>
    <section class="auth-section">
        <div class="container">
            <div class="auth-form">
                <h2>登入</h2>
                <?php if ($error): ?>
                    <p class="error"><?= htmlspecialchars($error) ?></p>
                <?php endif; ?>
                <form action="authenticate.php" method="post">
                    <div class="form-group">
                        <label for="username">使用者名稱:</label>
                        <input type="text" id="username" name="username" required>
                    </div>
                    <div class="form-group">
                        <label for="password">密碼:</label>
                        <input type="password" id="password" name="password" required>
                    </div>
                    <button type="submit">登入</button>
                </form>
            </div>
        </div>
    </section>
<?php require __DIR__ . '/includes/footer.php'; ?>
