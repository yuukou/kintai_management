$(function () {
  function showClock() {
    var nowTime = new Date();
    var nowHour = toDoubleDigits(nowTime.getHours());
    var nowMin = toDoubleDigits(nowTime.getMinutes());
    var nowSec = toDoubleDigits(nowTime.getSeconds());
    var message = nowHour + ":" + nowMin + ":" + nowSec;
    $('#realTimeClockArea').html(message);
  }

  var toDoubleDigits = function (num) {
    num += "";
    if (num.length === 1) {
      num = "0" + num;
    }
    return num;
  };

  setInterval(showClock, 1000);
});