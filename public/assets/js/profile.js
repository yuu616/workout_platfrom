document.getElementById("gender").addEventListener("change", function () {
  var hipGroup = document.getElementById("hip_group");
  if (this.value === "female") {
    hipGroup.style.display = "block";
  } else {
    hipGroup.style.display = "none";
  }
});

// 頁面加載時檢查性別
window.onload = function () {
  var gender = document.getElementById("gender").value;
  var hipGroup = document.getElementById("hip_group");
  if (gender === "female") {
    hipGroup.style.display = "block";
  } else {
    hipGroup.style.display = "none";
  }
};

document.querySelector("form").addEventListener("submit", function (e) {
  var height = document.getElementById("height").value;
  var weight = document.getElementById("weight").value;

  if (height <= 0 || weight <= 0) {
    e.preventDefault();
    alert("身高和體重必須大於0");
  }
});
