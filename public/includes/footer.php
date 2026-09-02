<?php
/**
 * 全站共用的頁尾。
 *
 * 頁面在 include 之前可設定：
 *   $page_scripts  array  要在 </body> 前載入的 JS 檔路徑（相對於 public/）
 */
$page_scripts = $page_scripts ?? [];
?>
    <footer>
        <div class="container">
            <p>&copy; 2023 <?= SITE_NAME ?>. All rights reserved.</p>
        </div>
    </footer>
<?php foreach ($page_scripts as $script): ?>
    <script src="<?= htmlspecialchars($script) ?>"></script>
<?php endforeach; ?>
</body>
</html>
