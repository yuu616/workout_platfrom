<?php
session_start();

$error   = $_SESSION['error'] ?? '';
$success = $_SESSION['success'] ?? '';
unset($_SESSION['error'], $_SESSION['success']);

$page_title  = '註冊';
$active_page = 'register.php';
require __DIR__ . '/includes/header.php';
?>
    <section class="auth-section">
        <div class="container">
            <div class="auth-form">
                <h2>註冊</h2>
                <?php if ($error): ?>
                    <p class="error"><?= htmlspecialchars($error) ?></p>
                <?php endif; ?>
                <?php if ($success): ?>
                    <p class="success"><?= htmlspecialchars($success) ?></p>
                <?php endif; ?>
                <form action="register_action.php" method="post">
                    <div class="form-group">
                        <label for="username">使用者名稱:</label>
                        <input type="text" id="username" name="username" required>
                    </div>
                    <div class="form-group">
                        <label for="password">密碼:</label>
                        <input type="password" id="password" name="password" required>
                    </div>
                    <div class="form-group">
                        <label for="confirm_password">確認密碼:</label>
                        <input type="password" id="confirm_password" name="confirm_password" required>
                    </div>
                    <button type="submit">註冊</button>
                </form>
            </div>
        </div>
    </section>
<?php require __DIR__ . '/includes/footer.php'; ?>
