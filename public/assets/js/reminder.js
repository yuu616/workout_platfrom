// 超過一週沒回來使用時，提醒使用者更新進度。
function checkReminder() {
  var lastUse = localStorage.getItem("lastUse");
  var now = new Date().getTime();

  if (!lastUse || now - lastUse > 7 * 24 * 60 * 60 * 1000) {
    alert("別忘了更新你的進度並使用 AI 菜單！");
  }

  localStorage.setItem("lastUse", now);
}

window.addEventListener("load", checkReminder);
