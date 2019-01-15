$(function () {
  var completeMessage = '.complete_message';
  var alreadyAttendance = '.already_attendance';

  checkClass(completeMessage);
  checkClass(alreadyAttendance);

  function checkClass(className) {
    if ($(className).length) {
      if (className == completeMessage) {
        AttendanceSetTimeout(5000);
      }
      if (className == alreadyAttendance) {
        AttendanceSetTimeout(3000);
      }
    }
  }

  function AttendanceSetTimeout(second) {
    setTimeout(function () {
      location.href = '/';
    }, second);
  }
});