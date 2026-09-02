document.getElementById("gender").addEventListener("change", function () {
  var hipField = document.getElementById("hip");
  var hipLabel = document.getElementById("hip_label");
  if (this.value === "female") {
    hipField.style.display = "block";
    hipLabel.style.display = "block";
  } else {
    hipField.style.display = "none";
    hipLabel.style.display = "none";
  }
});

// 頁面加載時檢查性別
window.onload = function () {
  var gender = document.getElementById("gender").value;
  var hipField = document.getElementById("hip");
  var hipLabel = document.getElementById("hip_label");
  if (gender === "female") {
    hipField.style.display = "block";
    hipLabel.style.display = "block";
  } else {
    hipField.style.display = "none";
    hipLabel.style.display = "none";
  }
};
