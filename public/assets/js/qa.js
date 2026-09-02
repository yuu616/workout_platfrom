// AI 菜單問答。頁面會先以 window.QA_CONFIG 傳入 AI 服務位址與使用者資料。

// 把 AI 回傳的 Markdown 風格文字整理成 HTML。
function formatAIResponse(response) {
  response = response.replace(/[\*\#\-]/g, "");
  var paragraphs = response.split("\n\n");
  var formattedResponse = "";
  paragraphs.forEach(function (paragraph) {
    if (paragraph.includes("|")) {
      formattedResponse += formatTable(paragraph);
    } else {
      formattedResponse += "<p>" + paragraph.trim() + "</p>";
    }
  });
  return formattedResponse;
}

// 把以 | 分隔的表格文字轉成 <table>。
function formatTable(tableString) {
  var rows = tableString.trim().split("\n");
  var html = '<table border="1"><thead><tr>';
  var headers = rows[0].split("|");
  headers.forEach(function (header) {
    html += "<th>" + header.trim() + "</th>";
  });
  html += "</tr></thead><tbody>";
  for (var i = 1; i < rows.length; i++) {
    html += "<tr>";
    var cells = rows[i].split("|");
    cells.forEach(function (cell) {
      html += "<td>" + cell.trim() + "</td>";
    });
    html += "</tr>";
  }
  html += "</tbody></table>";
  return html;
}

document.getElementById("qaForm").addEventListener("submit", function (event) {
  event.preventDefault();

  var config = window.QA_CONFIG || {};
  var question = document.getElementById("question").value;
  var payload = {
    user_input: question,
    height: config.height,
    weight: config.weight,
    dislikes: config.dislikes,
    goal: config.goal,
    user_id: config.userId,
  };

  var askButton = document.querySelector('button[type="submit"]');
  var buttonDisplayStyle = askButton.style.display;

  askButton.style.display = "none";
  document.getElementById("answer").innerHTML = "載入中...";

  fetch(config.aiServiceUrl + "/chat", {
    method: "POST",
    headers: { "Content-Type": "application/json" },
    body: JSON.stringify(payload),
  })
    .then(function (response) {
      return response.json();
    })
    .then(function (data) {
      document.getElementById("answer").innerHTML = formatAIResponse(
        data.response,
      );

      return fetch("save_response.php", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify(
          Object.assign({}, payload, { response: data.response }),
        ),
      });
    })
    .then(function (saveResponse) {
      return saveResponse.json();
    })
    .then(function (saveData) {
      if (saveData.status === "success") {
        console.log("資料已成功存儲");
      } else {
        console.error("資料存儲失敗: " + saveData.message);
      }
      askButton.style.display = buttonDisplayStyle;
    })
    .catch(function (error) {
      console.error("錯誤:", error);
      askButton.style.display = buttonDisplayStyle;
    });
});
