<?php
session_start();
include('db.php');

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$user_id = $_SESSION['user_id'];

// 獲取用戶資料
$stmt = $conn->prepare("SELECT * FROM user_profiles WHERE user_id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$profile = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="zh-TW">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AI菜單 - 大肌肌健身平台</title>
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
        <form id="qaForm" >
            <label for="question">提出你的問題：</label>
            <input type="text" id="question" name="question" placeholder="輸入你的問題"style="width: 100%; padding: 15px; margin-bottom: 5px; border: 1px solid #ccc; border-radius: 4px; font-size: 18px;">
            <button type="submit" style="width: auto; padding: 8px 12px; font-size: 14px; background-color: #007bff; color: white; border: none; border-radius: 4px; cursor: pointer; display: inline-block;">發問</button>
        </form>
        <div id="answer"></div>
    </div>
    <script>
    function formatAIResponse(response) {
        response = response.replace(/[\*\#\-]/g, '');
        var paragraphs = response.split('\n\n');
        var formattedResponse = '';
        paragraphs.forEach(function(paragraph) {
            if (paragraph.includes('|')) {
                formattedResponse += formatTable(paragraph);
            } else {
                formattedResponse += '<p>' + paragraph.trim() + '</p>';
            }
        });
        return formattedResponse;
    }

    function formatTable(tableString) {
        var rows = tableString.trim().split('\n');
        var html = '<table border="1"><thead><tr>';
        var headers = rows[0].split('|');
        headers.forEach(function(header) {
            html += '<th>' + header.trim() + '</th>';
        });
        html += '</tr></thead><tbody>';
        for (var i = 1; i < rows.length; i++) {
            html += '<tr>';
            var cells = rows[i].split('|');
            cells.forEach(function(cell) {
                html += '<td>' + cell.trim() + '</td>';
            });
            html += '</tr>';
        }
        html += '</tbody></table>';
        return html;
    }

    document.getElementById('qaForm').addEventListener('submit', function(event) {
        event.preventDefault();
        var question = document.getElementById('question').value;
        var height = '<?= $profile['height'] ?>';
        var weight = '<?= $profile['weight'] ?>';
        var dislikes = '<?= $profile['dislikes'] ?>';
        var goal = '<?= $profile['goal'] ?>';
        var userId = '<?= $_SESSION['user_id'] ?>';

        var askButton = document.querySelector('button[type="submit"]');
        var buttonDisplayStyle = askButton.style.display;

        askButton.style.display = 'none';
        document.getElementById('answer').innerHTML = '載入中...';

        fetch('http://localhost:5000/chat', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({
                user_input: question,
                height: height,
                weight: weight,
                dislikes: dislikes,
                goal: goal,
                user_id: userId
            })
        })
        .then(response => response.json())
        .then(data => {
            document.getElementById('answer').innerHTML = formatAIResponse(data.response);
            
            return fetch('/save_response.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    user_input: question,
                    height: height,
                    weight: weight,
                    dislikes: dislikes,
                    goal: goal,
                    response: data.response,
                    user_id: userId
                })
            });
        })
        .then(saveResponse => saveResponse.json())
        .then(saveData => {
            if (saveData.status === 'success') {
                console.log('資料已成功存儲');
            } else {
                console.error('資料存儲失敗: ' + saveData.message);
            }
            askButton.style.display = buttonDisplayStyle;
        })
        .catch(error => {
            console.error('錯誤:', error);
            askButton.style.display = buttonDisplayStyle;
        });
    });
    </script>
</body>
</html>