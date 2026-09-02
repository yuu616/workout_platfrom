// 進度追蹤頁。頁面會先以 window.PROGRESS_DATA 傳入圖表資料與最新預期體重。
var progressData = window.PROGRESS_DATA || {};

function confirmReset() {
  return confirm("確定要清除所有進度數據嗎？此操作不可逆。");
}

function confirmDelete(date) {
  return confirm("確定要刪除 " + date + " 的記錄嗎？此操作不可逆。");
}

function toggleExpectedWeight() {
  var checkbox = document.getElementById("update_expected_weight");
  var input = document.getElementById("expected_weight");
  input.disabled = !checkbox.checked;
  if (!checkbox.checked) {
    input.value = progressData.latestExpectedWeight;
  }
}

function openTab(evt, tabName) {
  var i, tabcontent, tablinks;
  tabcontent = document.getElementsByClassName("tabcontent");
  for (i = 0; i < tabcontent.length; i++) {
    tabcontent[i].style.display = "none";
  }
  tablinks = document.getElementsByClassName("tablinks");
  for (i = 0; i < tablinks.length; i++) {
    tablinks[i].className = tablinks[i].className.replace(" active", "");
  }
  document.getElementById(tabName).style.display = "block";
  evt.currentTarget.className += " active";
}

function queryProgress() {
  var startDate = document.getElementById("start_date").value;
  var endDate = document.getElementById("end_date").value;

  var xhr = new XMLHttpRequest();
  xhr.onreadystatechange = function () {
    if (this.readyState == 4 && this.status == 200) {
      updateCharts(JSON.parse(this.responseText));
    }
  };
  xhr.open(
    "GET",
    "get_progress.php?start_date=" + startDate + "&end_date=" + endDate,
    true,
  );
  xhr.send();
}

function updateCharts(data) {
  // 更新體重圖表
  weightChart.data.labels = data.dates;
  weightChart.data.datasets[0].data = data.weights;
  weightChart.data.datasets[1].data = data.expected_weights;
  weightChart.data.datasets[2].data = data.weights; // 趨勢線
  weightChart.update();

  // 更新卡路里圖表
  caloriesChart.data.labels = data.dates;
  caloriesChart.data.datasets[0].data = data.calories_in;
  caloriesChart.data.datasets[1].data = data.calories_out;
  caloriesChart.data.datasets[2].data = data.recommended_calories;
  caloriesChart.data.datasets[3].data = data.net_calories;
  caloriesChart.update();
}

document.getElementById("defaultOpen").click();

var ctx = document.getElementById("weightChart").getContext("2d");
var weightChart = new Chart(ctx, {
  type: "line",
  data: {
    labels: progressData.dates,
    datasets: [
      {
        label: "實際體重 (kg)",
        data: progressData.weights,
        borderColor: "rgb(75, 192, 192)",
        tension: 0.1,
      },
      {
        label: "預期體重 (kg)",
        data: progressData.expectedWeights,
        borderColor: "rgb(255, 99, 132)",
        tension: 0.1,
      },
      {
        label: "體重趨勢",
        data: progressData.weights,
        borderColor: "rgb(54, 162, 235)",
        borderDash: [5, 5],
        fill: false,
        tension: 0.1,
      },
    ],
  },
  options: {
    responsive: true,
    maintainAspectRatio: false,
    scales: {
      y: {
        beginAtZero: false,
      },
    },
  },
});

var ctxCalories = document.getElementById("caloriesChart").getContext("2d");
var caloriesChart = new Chart(ctxCalories, {
  type: "bar",
  data: {
    labels: progressData.dates,
    datasets: [
      {
        label: "攝入熱量",
        data: progressData.caloriesIn,
        backgroundColor: "rgba(75, 192, 192, 0.6)",
      },
      {
        label: "消耗熱量",
        data: progressData.caloriesOut,
        backgroundColor: "rgba(255, 99, 132, 0.6)",
      },
      {
        label: "推薦攝入量",
        data: progressData.recommendedCalories,
        type: "line",
        borderColor: "rgb(54, 162, 235)",
        fill: false,
      },
      {
        label: "淨卡路里",
        data: progressData.netCalories,
        type: "line",
        borderColor: "rgb(255, 159, 64)",
        fill: false,
      },
    ],
  },
  options: {
    responsive: true,
    maintainAspectRatio: false,
    scales: {
      y: {
        beginAtZero: true,
      },
    },
  },
});
