<?php
require __DIR__ . '/includes/auth.php';
require __DIR__ . '/includes/db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $height = $_POST['height'];
    $weight = $_POST['weight'];
    $age = $_POST['age'];
    $gender = $_POST['gender'];
    $waist = $_POST['waist'];
    $neck = $_POST['neck'];
    $hip = ($gender == 'female') ? $_POST['hip'] : null;
    $dietary_preferences = $_POST['dietary_preferences'];
    $dislikes = $_POST['dislikes'];
    $goal = $_POST['goal'];

    $stmt = $conn->prepare("INSERT INTO user_profiles 
        (user_id, height, weight, age, gender, waist, neck, hip, dietary_preferences, dislikes, goal) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?) 
        ON DUPLICATE KEY UPDATE 
        height = VALUES(height), 
        weight = VALUES(weight),
        age = VALUES(age),
        gender = VALUES(gender),
        waist = VALUES(waist),
        neck = VALUES(neck),
        hip = VALUES(hip),
        dietary_preferences = VALUES(dietary_preferences),
        dislikes = VALUES(dislikes),
        goal = VALUES(goal)");
    $stmt->bind_param("iiiisddssss", $user_id, $height, $weight, $age, $gender, $waist, $neck, $hip, $dietary_preferences, $dislikes, $goal);
    $stmt->execute();
}

$stmt = $conn->prepare("SELECT * FROM user_profiles WHERE user_id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$profile = $result->fetch_assoc();

$page_title  = '個人資料';
$active_page = 'profile.php';
$page_styles = ['assets/css/profile.css'];
$page_scripts = ['assets/js/profile.js'];
$page_head_extra = <<<'HTML'
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;700&display=swap" rel="stylesheet">
HTML;
require __DIR__ . '/includes/header.php';
?>
    <main>
    <div class="profile-container">
    <h1>個人資料</h1>
    <form method="post">
        <div class="form-grid">
            <div class="form-group">
                <label for="height">身高 (cm)</label>
                <input type="number" id="height" name="height" value="<?php echo htmlspecialchars($profile['height'] ?? ''); ?>" required>
            </div>
            <div class="form-group">
                <label for="weight">體重 (kg)</label>
                <input type="number" id="weight" name="weight" value="<?php echo htmlspecialchars($profile['weight'] ?? ''); ?>" required>
            </div>
            <div class="form-group">
                <label for="age">年齡</label>
                <input type="number" id="age" name="age" value="<?php echo htmlspecialchars($profile['age'] ?? ''); ?>" required>
            </div>
            <div class="form-group">
                <label for="gender">性別</label>
                <select id="gender" name="gender" required>
                    <option value="male" <?php echo ($profile['gender'] == 'male') ? 'selected' : ''; ?>>男性</option>
                    <option value="female" <?php echo ($profile['gender'] == 'female') ? 'selected' : ''; ?>>女性</option>
                </select>
            </div>
            <div class="form-group">
                <label for="waist">腰圍 (cm)</label>
                <input type="number" step="0.1" id="waist" name="waist" value="<?php echo htmlspecialchars($profile['waist'] ?? ''); ?>" required>
            </div>
            <div class="form-group">
                <label for="neck">脖圍 (cm)</label>
                <input type="number" step="0.1" id="neck" name="neck" value="<?php echo htmlspecialchars($profile['neck'] ?? ''); ?>" required>
            </div>
            <div class="form-group" id="hip_group" style="display:none;">
                <label for="hip">臀圍 (cm)</label>
                <input type="number" step="0.1" id="hip" name="hip" value="<?php echo htmlspecialchars($profile['hip'] ?? ''); ?>">
            </div>
            <div class="form-group full-width">
                <label for="dietary_preferences">飲食偏好</label>
                <textarea id="dietary_preferences" name="dietary_preferences"><?php echo htmlspecialchars($profile['dietary_preferences'] ?? ''); ?></textarea>
            </div>
            <div class="form-group full-width">
                <label for="dislikes">不喜歡的食物</label>
                <input type="text" id="dislikes" name="dislikes" value="<?php echo htmlspecialchars($profile['dislikes'] ?? ''); ?>">
            </div>
            <div class="form-group full-width">
                <label for="goal">目標</label>
                <select id="goal" name="goal">
                    <option value="減重" <?php echo ($profile['goal'] == '減重') ? 'selected' : ''; ?>>減重</option>
                    <option value="增肌" <?php echo ($profile['goal'] == '增肌') ? 'selected' : ''; ?>>增肌</option>
                </select>
            </div>
        </div>
        <button type="submit" class="submit-btn">保存資料</button>
    </form>
</div>
    </main>
<?php require __DIR__ . '/includes/footer.php'; ?>
