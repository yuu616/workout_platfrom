-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- 主機： 127.0.0.1
-- 產生時間： 2024-08-15 17:52:58
-- 伺服器版本： 10.4.32-MariaDB
-- PHP 版本： 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- 資料庫： `fitplatform`
--

-- --------------------------------------------------------

--
-- 資料表結構 `ai_responses`
--

CREATE TABLE `ai_responses` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `user_input` text DEFAULT NULL,
  `height` int(11) DEFAULT NULL,
  `weight` int(11) DEFAULT NULL,
  `dislikes` text DEFAULT NULL,
  `goal` enum('減重','增肌') DEFAULT NULL,
  `response` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- 傾印資料表的資料 `ai_responses`
--

INSERT INTO `ai_responses` (`id`, `user_id`, `user_input`, `height`, `weight`, `dislikes`, `goal`, `response`, `created_at`) VALUES
(17, 2, '我想減少10公斤', 181, 82, '羊肉', '減重', '##  您的個人減重計畫  (目標: 10公斤)\n\n**基本信息:**\n\n* 身高: 181 公分\n* 體重: 82 公斤\n* 目標: 減重 10 公斤\n* 不喜歡食物: 羊肉\n\n**重要提示:**  本計畫僅供參考，開始任何飲食或運動計畫前，請諮詢專業醫生或營養師。\n\n---\n\n### 一周飲食菜單\n\n**原則:**\n\n* 每日攝取熱量控制在 **1800 大卡** 左右 (根據您的活動量和基礎代謝率可能有所調整)。\n* 均衡攝取六大類食物：全穀根莖類、豆魚蛋肉類、乳品類、蔬菜類、水果類、油脂與堅果種子類。\n* 減少高油、高糖、高鹽食物攝取。\n* 多喝水，每日至少 2000 毫升。\n\n**每日熱量分配範例:**\n\n* 早餐 (30%): 540 大卡\n* 午餐 (40%): 720 大卡\n* 晚餐 (25%): 450 大卡\n* 點心 (5%): 90 大卡\n\n**菜單範例:** (每項餐點皆可替換，確保營養均衡和熱量控制)\n\n| 星期 | 早餐 (約540大卡)                                    | 午餐 (約720大卡)                             | 晚餐 (約450大卡)                             | 點心 (約90大卡)          |\n|------|-------------------------------------------------------|------------------------------------------------|------------------------------------------------|-----------------------------|\n| 一    | 全麥吐司夾蛋 (2片全麥吐司+1顆蛋+生菜) + 無糖豆漿     | 糙米飯 + 清蒸魚 + 炒青菜 + 豆腐湯             | 雞胸肉蔬菜沙拉 (雞胸肉+生菜+番茄+堅果)       | 無糖優格一杯                |\n| 二    | 燕麥粥 (燕麥+牛奶+水果)                               | 雞肉蔬菜捲餅 (全麥餅皮+雞胸肉+生菜+番茄)    | 鮭魚豆腐味噌湯 (鮭魚+豆腐+味噌+蔬菜)        | 蘋果一顆                  |\n| 三    | 地瓜牛奶 (地瓜+牛奶)                                  | 蕎麥麵 + 滷牛肉 + 燙青菜                     | 海鮮蔬菜咖哩 (海鮮+蔬菜+咖哩)               | 水煮蛋一顆                |\n| 四    | 全麥三明治 (全麥麵包+雞胸肉+生菜+番茄) + 低脂牛奶 | 糙米飯 + 烤雞腿 + 炒時蔬                     | 冬瓜蛤蜊湯 (冬瓜+蛤蜊+薑絲)                | 奇異果一顆                  |\n| 五    | 玉米片 (玉米片+牛奶+水果)                           | 義大利麵 (全麥義大利麵+番茄肉醬+蔬菜)         | 清蒸鱈魚 + 燙青菜                          | 無糖豆漿一杯                |\n| 六    | 法式吐司 (全麥吐司+雞蛋+牛奶) + 水果              | 壽司 (壽司米+海苔+小黃瓜+鮪魚)                | 紫菜蛋花湯 (紫菜+雞蛋+蔥花)                | 香蕉一根                  |\n| 日    | 飯糰 (糙米飯+鮭魚鬆+海苔)                          | 雞肉蔬菜湯 (雞胸肉+蔬菜+高湯)                | 什錦炒麵 (雞蛋+蔬菜+麵條)                  | 低卡果凍                   |\n\n**備註:** 以上僅為參考範例，您可以根據自己的喜好和實際情況進行調整，但請務必注意每餐的營養搭配和熱量控制。\n\n---\n\n### 一周健身菜單\n\n**原則:**\n\n* 每周至少運動 3-5 天，每次 30-60 分鐘。\n* 結合有氧運動和重量訓練，有效燃脂和增肌。\n* 選擇自己喜歡的運動方式，更容易持之以恆。\n* 運動強度循序漸進，避免運動傷害。\n\n**運動計劃範例:**\n\n| 星期 | 運動內容                                       | 時間   | 消耗熱量 (約) |\n|------|---------------------------------------------|--------|------------|\n| 一    | 慢跑 (或快走)                             | 40 分鐘  | 350 大卡      |\n| 二    | 重量訓練 (胸、背)                       | 40 分鐘  | 250 大卡      |\n| 三    | 游泳                                       | 30 分鐘  | 300 大卡      |\n| 四    | 休息                                        |        |             |\n| 五    | 重量訓練 (腿、肩)                       | 40 分鐘  | 250 大卡      |\n| 六    | 戶外健行 (或騎自行車)                  | 60 分鐘  | 400 大卡      |\n| 日    | 瑜伽或伸展                                    | 30 分鐘  | 150 大卡      |\n\n**備註:**\n\n* 以上熱量消耗僅供參考，實際消耗量會因人而異，建議佩戴運動手環或使用相關應用程式追蹤。\n* 重量訓練可以根據自身情況選擇器械或徒手進行，循序漸進增加重量和組數。\n* 運動前後做好暖身和拉伸，避免運動傷害。\n\n---\n\n### 其他建議\n\n*  **記錄飲食和運動:** 使用手機應用程式或筆記本記錄每日飲食和運動狀況，方便追蹤進度和調整計畫。\n*  **尋求專業協助:** 如果您需要更個人化的減重計畫，建議諮詢專業營養師或健身教練，他們會根據您的身體狀況和目標制定更適合您的方案。\n*  **保持耐心和毅力:** 減肥是一個需要時間和耐心的過程，不要期待快速看到結果，堅持下去才能獲得最終的勝利。\n\n希望以上資訊對您有所幫助，祝您早日達成減重目標！', '2024-08-06 01:49:32'),
(20, 1, '我只能在家運動', 180, 80, '羊肉', '減重', '## 個人居家減重計畫\n\n**基本資料**\n\n* 身高：180 公分\n* 體重：80 公斤\n* 不喜歡食物：羊肉\n* 目標：減重\n\n**本週目標**\n\n* 每日攝取熱量： **2000 大卡**(此數據僅供參考，實際需求根據個人活動量有所調整) \n* 運動目標： **每週至少運動 3-5 次，每次 30-60 分鐘。**\n\n**一週飲食菜單**\n\n| **星期** | **早餐 (約 400 大卡)** | **午餐 (約 500 大卡)** | **晚餐 (約 400 大卡)** | **點心 (約 200 大卡)** | **每日總計** |\n|---|---|---|---|---|---|\n| 星期一 | 全麥吐司香蕉蛋餅 (一片全麥吐司，一根香蕉，一個雞蛋) |  雞胸肉蔬菜沙拉 (100g 雞胸肉，生菜沙拉，適量橄欖油) | 鮭魚豆腐湯 (100g 鮭魚，豆腐，蔬菜) |  蘋果一片，堅果一把 | **約 1500 大卡** |\n| 星期二 | 希臘優格水果燕麥碗 (100g 希臘優格，適量水果，30g 燕麥) |  番茄雞蛋麵 (雞蛋，番茄，一小份麵條) |  蝦仁蔬菜豆腐煲 (100g 蝦仁，豆腐，蔬菜) |  低脂牛奶一杯，香蕉半根 | **約 1600 大卡** |\n| 星期三 | 水煮蛋兩個，全麥麵包一片，生菜番茄 |  金槍魚沙拉三明治 (全麥麵包，金槍魚罐頭，生菜，番茄) |  炒青菜香菇 (適量青菜，香菇) |  無糖豆漿一杯，蘋果一個 | **約 1400 大卡** |\n| 星期四 | 牛奶燕麥粥 (30g 燕麥，250ml 牛奶，適量堅果和水果) |  雞肉蔬菜捲餅 (雞胸肉，蔬菜，捲餅) |  清蒸魚佐蔬菜 (100g 魚肉，清蒸蔬菜) |  堅果一小把，香蕉半根 | **約 1500 大卡** |\n| 星期五 | 全麥饅頭夾蛋 (一個全麥饅頭，一個雞蛋，生菜) |  牛肉蔬菜湯 (牛肉，蔬菜) |  番茄豆腐湯麵 (一小份麵條，番茄，豆腐) |  低脂牛奶一杯，蘋果一片 | **約 1600 大卡** |\n| 星期六 |  雞蛋蔬菜餅 (雞蛋，蔬菜) |  雞肉蔬菜沙拉 (雞胸肉，生菜，黃瓜，番茄) |  海鮮湯 (魚肉，蝦仁，蛤蜊，蔬菜) |  堅果一小把，香蕉半根 | **約 1500 大卡** |\n| 星期日 | 全麥吐司花生醬 (一片全麥吐司，花生醬) |  雞胸肉蔬菜義大利麵 (雞胸肉，蔬菜，一小份義大利麵) |  蔬菜豆腐湯 (豆腐，蔬菜) |  無糖豆漿一杯 | **約 1400 大卡** |\n\n\n**備註：**\n\n* 以上菜單僅供參考，請根據自身狀況和口味調整。\n*  確保每日攝取足夠的蛋白質（約 1.2-1.6g/kg 體重）。\n*  選擇健康的碳水化合物來源，如糙米、全麥麵包、水果等。\n*  多攝取蔬菜和水果，補充維生素和纖維。\n\n**一週居家健身菜單**\n\n| **星期** | **訓練內容** | **動作** | **組數** | **次數** | **休息時間** | **預估消耗熱量** |\n|---|---|---|---|---|---|---|\n| 星期一 | **全身循環訓練** | 開合跳 | 3 | 20 秒 | 10 秒 | |\n|  |  | 深蹲 | 3 | 15 | 30 秒 | |\n|  |  |  伏地挺身 (可做跪姿) | 3 | 力竭 | 30 秒 | **約 300 大卡** |\n|  |  |  平板支撐 | 3 | 30 秒 | 30 秒 | |\n|  |  |  波比跳 | 3 | 10 | 60 秒 | |\n| 星期二 | **休息** |  |  |  |  |  |\n| 星期三 | **有氧運動** |  跑步 (可慢跑或快走) | 30-45 分鐘 |  |  | **約 350-500 大卡** |\n| 星期四 | **休息** |  |  |  |  |  |\n| 星期五 | **全身循環訓練** |  開合跳 | 3 | 20 秒 | 10 秒 | |\n|  |  | 弓箭步 | 3 | 每邊 12 下 | 30 秒 | |\n|  |  |  上斜伏地挺身 | 3 | 力竭 | 30 秒 | **約 300 大卡** |\n|  |  |  平板支撐交替觸肩 | 3 | 30 秒 | 30 秒 | |\n|  |  |  登山者式 | 3 | 20 秒 | 60 秒 | |\n| 星期六 | **休息** |  |  |  |  |  |\n| 星期日 | **居家瑜伽** |  根據自身情況選擇合適的瑜伽影片 | 30-45 分鐘 |  |  | **約 200-300 大卡** |\n\n**備註：**\n\n* 以上菜單僅供參考，請根據自身狀況和運動水平調整。\n*  運動時請注意安全，並根據需要使用輔助器材。\n*  運動前後請做好熱身和拉伸運動。\n*  確保每週至少休息1-2天，讓身體得到充分休息和恢復。\n\n**注意事項**\n\n* 以上飲食和運動計劃僅供參考，具體熱量攝入和消耗會因個人體質、活動量、食物種類等因素而有所差異。\n*  建議諮詢專業的營養師和健身教練，制定更適合自己的個人計劃。 \n*  減重需要長期坚持，保持良好的飲食和運動習慣才能達到理想效果。 \n', '2024-08-09 08:26:42'),
(23, 1, '', 180, 80, '羊肉', '減重', '## 個性化減重計畫\n\n**基本信息:**\n\n* 身高: 180 公分\n* 體重: 80 公斤\n* 不喜歡食物: 羊肉\n* 目標: 減重\n\n**本周目標:**\n\n* **建立健康飲食習慣:**  著重於攝取均衡營養，包含蛋白質、碳水化合物和健康脂肪，同時控制總卡路里攝取。\n* **開始規律運動:**  結合有氧運動和力量訓練，提升新陳代謝，燃燒更多卡路里。\n\n**飲食計畫 (每日約1600大卡):**\n\n| **日期** | **早餐 (約400大卡)** | **午餐 (約500大卡)** | **晚餐 (約500大卡)** | **點心 (約200大卡)** |\n|---|---|---|---|---|\n| 星期一 | 全麥吐司夾蛋餅(2顆蛋+番茄+菠菜)+無糖豆漿 |  烤雞胸肉沙拉(雞胸肉100g+生菜+番茄+黃瓜+油醋醬) | 清蒸魚(100g)+炒青菜+糙米飯 | 蘋果+無糖優格 | \n| 星期二 | 燕麥粥(40g)+牛奶(240ml)+香蕉 | 鮭魚便當(烤鮭魚+花椰菜+紅蘿蔔+地瓜) | 什錦蔬菜豆腐湯(豆腐100g+各種蔬菜)+糙米飯 |  綜合堅果一小把 |\n| 星期三 | 水煮蛋2顆+全麥麵包+低脂牛奶 |  雞肉蔬菜捲餅(雞胸肉+生菜+番茄+黃瓜+全麥餅皮) |  番茄牛肉湯(牛肉80g+番茄+洋蔥)+糙米飯 |  香蕉一根 |\n| 星期四 | 希臘優格(150g)+水果麥片+ berries |   Tuna 沙拉三明治(全麥麵包+鮪魚罐頭+生菜+番茄+低脂美乃滋) |  香煎雞排(雞胸肉+迷迭香)+烤蔬菜(花椰菜+紅椒+櫛瓜) |  低脂牛奶一杯 |\n| 星期五 |  香蕉堅果奶昔(香蕉+牛奶+花生醬+燕麥) |  雞肉蔬菜咖哩(雞肉+馬鈴薯+紅蘿蔔+花椰菜+咖哩粉) |  海鮮豆腐鍋(豆腐+蝦仁+蛤蜊+蔬菜) |  蘋果+花生醬 |\n| 星期六 | 全麥鬆餅(2片)+蜂蜜+水果 | 義大利麵沙拉(雞肉+全麥螺旋麵+彩椒+小番茄+油醋醬) | 烤蔬菜(花椰菜+紅椒+櫛瓜)+烤鮭魚 |  綜合堅果一小把 |\n| 星期日 |  法式吐司(全麥麵包+雞蛋+牛奶)+水果 |  雞肉蔬菜湯麵(雞丝+麵條+白菜+紅蘿蔔) | 清蒸鱸魚+蒜蓉炒菠菜+糙米飯 |  低脂牛奶一杯 |\n\n\n**健身計畫:**\n\n| **日期** | **活動** | **時間** | **消耗卡路里 (估計)** |\n|---|---|---|---|\n| 星期一 |  休息 |  |  |\n| 星期二 |  慢跑 |  30分鐘  | 350 |\n| 星期三 |  重量訓練 (全身) | 45分鐘  | 400 |\n| 星期四 |  游泳 |  30分鐘 | 300 |\n| 星期五 |  休息 |  |  |\n| 星期六 |  登山/戶外健走 |  60分鐘  | 450 |\n| 星期日 |  瑜珈/伸展 |  30分鐘  | 150 |\n\n**總消耗卡路里:** 1650 大卡\n\n**注意事項:**\n\n* 以上只是一份參考菜單和健身計畫，您可以根據自身情況和喜好進行調整。\n* 請確保您攝取足夠的水分，每日至少飲用 2000 毫升。\n* 運動前請做好熱身，運動後請進行適當的拉伸。\n* 建議諮詢專業醫生或營養師，制定更適合您的減重方案。\n\n\n**希望您能堅持執行，早日達成減重目標！** \n', '2024-08-12 03:47:28'),
(24, 1, '我想減少10公斤還有增肌', 180, 80, '羊肉', '增肌', '## 一周減脂增肌計畫 (目標: 減少 10 公斤並增肌)\n\n**個人資料:**\n\n* 身高: 180 公分\n* 體重: 80 公斤\n* 不喜歡食物: 羊肉\n\n**目標:** 增肌減脂\n\n**本周重點:**  高蛋白質攝取，搭配中高強度阻力訓練\n\n**每日熱量需求:** 约 2200 大卡 (此數據僅供參考，請根據自身情況和活動量調整)\n\n---\n\n**一週飲食菜單:**  (每餐包含約 400-500 大卡)\n\n| **星期** | **早餐 (約 400 大卡)** | **午餐 (約 500 大卡)** | **晚餐 (約 500 大卡)** | **點心 (約 200 大卡)** | **備註** |\n|---|---|---|---|---|---|\n| **星期一** | 希臘優格 (150g) + 綜合莓果 (100g) + 燕麥片 (50g) + 堅果 (20g) | 雞胸肉沙拉 (雞胸肉 150g + 生菜 100g + 堅果 20g + 油醋醬) | 鮭魚 (150g) + 糙米飯 (100g) + 蘆筍 (100g) | 水煮蛋 2 個 |  |\n| **星期二** | 全麥吐司 (2 片) + 水煮蛋 (2 個) + 酪梨 (1/4 個) | 糙米飯 (100g) + 牛肉 (100g) + 花椰菜 (100g) | 蝦仁豆腐煲 (蝦仁 100g + 豆腐 100g + 青菜 100g) | 無糖豆漿 (400ml) | |\n| **星期三** | 燕麥粥 (50g) + 牛奶 (250ml) + 香蕉 (1 根) | 雞肉捲餅 (雞胸肉 100g + 生菜 + 全麥餅皮) | 烤雞腿 (1 支) + 烤地瓜 (100g) + 燙青菜 (100g) | 蘋果 (1 個) | |\n| **星期四** | 全麥麵包 (2 片) + 花生醬 (2 湯匙) + 香蕉 (1 根) | 義大利麵 (80g) + 雞肉丸子 (100g) + 番茄醬 | 清蒸魚 (150g) +  quinoa (100g) + 菠菜 (100g) | 希臘優格 (150g) + 蜂蜜 (1 湯匙) | |\n| **星期五** | 雞蛋餅 (雞蛋 2 個 + 青椒 + 洋蔥) | 雞肉蔬菜湯 (雞胸肉 100g + 各式蔬菜) | 鮭魚炒飯 (鮭魚 100g + 糙米飯 100g + 蔬菜) | 水煮毛豆 (100g) | |\n| **星期六** | 法式吐司 (全麥吐司 2 片 + 雞蛋 1 個 + 牛奶 50ml) | 雞肉凱薩沙拉 (雞胸肉 100g + 生菜 + 凱薩醬) | 牛排 (150g) + 烤馬鈴薯 (100g) + 蘆筍 (100g) | 香蕉牛奶 (香蕉 1 根 + 牛奶 250ml) |  |\n| **星期日** | 蛋白質鬆餅 (蛋白粉 30g + 燕麥粉 30g + 牛奶 100ml + 香蕉 1/2 根) | 雞肉三明治 (雞胸肉 100g + 全麥吐司 + 生菜) | 海鮮湯 (各式海鮮 150g + 蔬菜) | 綜合堅果 (30g) | |\n\n**備註**: 以上菜單僅供參考，請根據自身狀況和喜好調整，並注意食物的份量控制。\n\n---\n\n**一週健身菜單:**\n\n**(每個動作 3 組，每組 8-12 下，組間休息 60 秒)**\n\n| **星期** | **訓練部位** | **動作** | **消耗熱量 (約)** | **備註** |\n|---|---|---|---|---|\n| **星期一** | **胸部 & 三頭肌** | 臥推、上斜啞鈴臥推、雙槓臂屈伸、窄距臥推 | 400 大卡 |  |\n| **星期二** | **背部 & 二頭肌** | 引體向上、槓鈴划船、單臂啞鈴划船、槓鈴彎舉、啞鈴錘式彎舉 | 450 大卡 | |\n| **星期三** | **休息日** |  快走 30 分鐘  | 200 大卡 |  |\n| **星期四** | **腿部 & 肩部** | 深蹲、腿推、腿彎舉、過頭推舉、側平舉、前平舉 | 500 大卡 |  |\n| **星期五** | **核心訓練 & 高強度間歇訓練 (HIIT)** | 棒式、捲腹、登山者、波比跳、開合跳 | 350 大卡 |  |\n| **星期六** | **休息日** |  游泳 30 分鐘  | 300 大卡 |  |\n| **星期日** | **自由訓練** |  選擇你喜歡的運動  |  依運動強度而定  |  |\n\n**備註**: \n\n* 以上健身菜單僅供參考，請根據自身狀況和體能調整訓練強度和休息時間。\n* 運動前請務必做好暖身，運動後進行適當的拉伸。\n* 每週安排 1-2 天的休息日，讓身體得到充分的休息和恢復。\n\n---\n\n**成功秘訣:**\n\n* **堅持:** 減脂增肌是一個需要時間和耐心的過程，堅持執行飲食計畫和運動計畫才能看到成果。\n* **記錄:** 記錄每日的飲食和運動狀況，可以幫助你更好地了解自己的 progress 並做出調整。\n* **專業指導:** 如有任何疑問，請諮詢專業的營養師或健身教練。\n\n**祝您早日達成目標!** \n', '2024-08-14 17:26:52');

-- --------------------------------------------------------

--
-- 資料表結構 `exercises`
--

CREATE TABLE `exercises` (
  `id` int(11) NOT NULL,
  `date` datetime DEFAULT NULL,
  `type` varchar(255) DEFAULT NULL,
  `duration` int(11) DEFAULT NULL,
  `actions` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- 傾印資料表的資料 `exercises`
--

INSERT INTO `exercises` (`id`, `date`, `type`, `duration`, `actions`) VALUES
(1, '2024-08-15 12:29:24', 'anaerobic, anaerobic', 24, '[{\"type\":\"anaerobic\",\"name\":\"深蹲\",\"prepTime\":2,\"exerciseTime\":2,\"restTime\":2,\"cycles\":2},{\"type\":\"anaerobic\",\"name\":\"跳\",\"prepTime\":2,\"exerciseTime\":2,\"restTime\":2,\"cycles\":2}]'),
(2, '2024-08-15 12:36:07', 'anaerobic, anaerobic', 24, '[{\"type\":\"anaerobic\",\"name\":\"深蹲\",\"prepTime\":2,\"exerciseTime\":2,\"restTime\":2,\"cycles\":2},{\"type\":\"anaerobic\",\"name\":\"跳\",\"prepTime\":2,\"exerciseTime\":2,\"restTime\":2,\"cycles\":2}]'),
(3, '2024-08-15 12:37:36', 'anaerobic, anaerobic', 24, '[{\"type\":\"anaerobic\",\"name\":\"深蹲\",\"prepTime\":2,\"exerciseTime\":2,\"restTime\":2,\"cycles\":2},{\"type\":\"anaerobic\",\"name\":\"跳\",\"prepTime\":2,\"exerciseTime\":2,\"restTime\":2,\"cycles\":2}]'),
(4, '2024-08-15 12:38:11', 'aerobic', 3, '[{\"type\":\"aerobic\",\"name\":\"跑步\",\"prepTime\":1,\"exerciseTime\":1,\"restTime\":1,\"cycles\":1}]');

-- --------------------------------------------------------

--
-- 資料表結構 `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- 傾印資料表的資料 `users`
--

INSERT INTO `users` (`id`, `username`, `password`) VALUES
(1, '1234', '$2y$10$wXBZdkZFBhN.c6UiZTCtOeL.e9a7O0EL7L5z5nvh7w6/Vz0PVGxpG'),
(2, '4321', '$2y$10$lZDgVjY6q0MkxEwNY6sC7uX0hU37Ei1T2BdNq6U5FNqhewHawFWCu');

-- --------------------------------------------------------

--
-- 資料表結構 `user_analysis`
--

CREATE TABLE `user_analysis` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `weight` decimal(5,2) DEFAULT NULL,
  `height` decimal(5,2) DEFAULT NULL,
  `age` int(11) DEFAULT NULL,
  `gender` varchar(10) DEFAULT NULL,
  `waist` decimal(5,2) DEFAULT NULL,
  `neck` decimal(5,2) DEFAULT NULL,
  `hip` decimal(5,2) DEFAULT NULL,
  `bmi` decimal(5,2) DEFAULT NULL,
  `body_fat` decimal(5,2) DEFAULT NULL,
  `bmr` decimal(7,2) DEFAULT NULL,
  `date` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- 傾印資料表的資料 `user_analysis`
--

INSERT INTO `user_analysis` (`id`, `user_id`, `weight`, `height`, `age`, `gender`, `waist`, `neck`, `hip`, `bmi`, `body_fat`, `bmr`, `date`) VALUES
(10, 1, 80.00, 180.00, 25, 'male', 85.00, 35.00, NULL, 24.69, 18.37, 1640.20, '2024-08-05 14:46:35'),
(11, 1, 80.00, 180.00, 25, 'male', 85.00, 35.00, NULL, 24.69, 18.37, 1806.20, '2024-08-05 14:47:45'),
(12, 1, 80.00, 180.00, 25, 'male', 85.00, 35.00, NULL, 24.69, 18.37, 1806.20, '2024-08-05 14:49:03'),
(13, 1, 50.00, 170.00, 25, 'male', 76.00, 3.00, NULL, 17.30, 34.50, 1444.00, '2024-08-06 09:44:14'),
(14, 1, 50.00, 170.00, 25, 'male', 74.00, 36.00, NULL, 17.30, 10.14, 1444.00, '2024-08-06 09:44:31'),
(15, 1, 50.00, 170.00, 25, 'male', 80.00, 40.00, NULL, 17.30, 11.96, 1444.00, '2024-08-06 09:44:56'),
(16, 2, 82.00, 181.00, 24, 'male', 88.00, 37.00, NULL, 25.03, 18.93, 1837.35, '2024-08-06 09:47:01'),
(17, 1, 80.00, 180.00, 25, 'male', 88.00, 43.00, NULL, 24.69, 14.53, 1806.20, '2024-08-09 16:24:11'),
(18, 1, 80.00, 180.00, 25, 'male', 88.00, 43.00, NULL, 24.69, 14.53, 1806.20, '2024-08-09 16:24:13'),
(19, 1, 80.00, 180.00, 25, 'male', 88.00, 43.00, NULL, 24.69, 14.53, 1806.20, '2024-08-09 16:24:20'),
(20, 1, 80.00, 180.00, 25, 'male', 88.00, 43.00, NULL, 24.69, 14.53, 1806.20, '2024-08-15 11:58:23');

-- --------------------------------------------------------

--
-- 資料表結構 `user_profiles`
--

CREATE TABLE `user_profiles` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `height` int(11) DEFAULT NULL,
  `weight` int(11) DEFAULT NULL,
  `dietary_preferences` text DEFAULT NULL,
  `dislikes` text DEFAULT NULL,
  `goal` enum('減重','增肌') DEFAULT NULL,
  `age` int(11) DEFAULT NULL,
  `gender` enum('male','female') DEFAULT NULL,
  `waist` decimal(5,2) DEFAULT NULL,
  `neck` decimal(5,2) DEFAULT NULL,
  `hip` decimal(5,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- 傾印資料表的資料 `user_profiles`
--

INSERT INTO `user_profiles` (`id`, `user_id`, `height`, `weight`, `dietary_preferences`, `dislikes`, `goal`, `age`, `gender`, `waist`, `neck`, `hip`) VALUES
(1, 1, 180, 80, '', '羊肉', '增肌', 25, 'male', 88.00, 43.00, NULL),
(11, 2, 181, 82, '', '羊肉', '減重', 23, 'male', 87.00, 43.00, NULL);

-- --------------------------------------------------------

--
-- 資料表結構 `user_progress`
--

CREATE TABLE `user_progress` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `weight` int(11) DEFAULT NULL,
  `expected_weight` decimal(5,2) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `calories_in` int(11) DEFAULT 0,
  `calories_out` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- 傾印資料表的資料 `user_progress`
--

INSERT INTO `user_progress` (`id`, `user_id`, `weight`, `expected_weight`, `date`, `calories_in`, `calories_out`) VALUES
(26, 2, 82, 72.00, '2024-08-06', 1957, 231),
(27, 2, 82, 72.00, '2024-08-06', 1957, 231),
(28, 2, 80, 72.00, '2024-08-07', 1865, 132),
(49, 1, 80, 70.00, '2024-08-09', 1877, 255),
(50, 1, 75, 70.00, '2024-08-10', 2105, 141),
(51, 1, 73, 70.00, '2024-08-11', 2488, 523),
(52, 1, 72, 70.00, '2024-08-13', 1588, 210),
(53, 1, 74, 70.00, '2024-08-15', 2351, 122),
(56, 1, 76, 70.00, '2024-08-15', 2455, 300);

--
-- 已傾印資料表的索引
--

--
-- 資料表索引 `ai_responses`
--
ALTER TABLE `ai_responses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- 資料表索引 `exercises`
--
ALTER TABLE `exercises`
  ADD PRIMARY KEY (`id`);

--
-- 資料表索引 `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- 資料表索引 `user_analysis`
--
ALTER TABLE `user_analysis`
  ADD PRIMARY KEY (`id`);

--
-- 資料表索引 `user_profiles`
--
ALTER TABLE `user_profiles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_id` (`user_id`);

--
-- 資料表索引 `user_progress`
--
ALTER TABLE `user_progress`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- 在傾印的資料表使用自動遞增(AUTO_INCREMENT)
--

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `ai_responses`
--
ALTER TABLE `ai_responses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `exercises`
--
ALTER TABLE `exercises`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `user_analysis`
--
ALTER TABLE `user_analysis`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `user_profiles`
--
ALTER TABLE `user_profiles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `user_progress`
--
ALTER TABLE `user_progress`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=59;

--
-- 已傾印資料表的限制式
--

--
-- 資料表的限制式 `ai_responses`
--
ALTER TABLE `ai_responses`
  ADD CONSTRAINT `ai_responses_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- 資料表的限制式 `user_profiles`
--
ALTER TABLE `user_profiles`
  ADD CONSTRAINT `user_profiles_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- 資料表的限制式 `user_progress`
--
ALTER TABLE `user_progress`
  ADD CONSTRAINT `user_progress_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
