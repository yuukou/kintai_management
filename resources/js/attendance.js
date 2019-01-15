$(function () {
  var form = $('#postId');
  var btn = $('.btn');
  var japanese = '';

  btn.on('click', function () {
    var attendance = $(this).attr("id");
    return check(attendance);
  });

  function check(attendance) {
    if (attendance == 'arrive') {
      japanese = '出社';
    }
    if (attendance == 'leave') {
      japanese = '退社';
    }
    makeInput(attendance);
    return confirmAttendance(attendance, japanese);
  }

  function confirmAttendance(attendance, japanese) {
    return confirm(japanese + 'を記録します。本当によろしいですか？');
  }

  function makeInput(attendance) {
    $('<input>').attr({
      type: 'hidden',
      id: 'attendance',
      name: 'attendance',
      value: attendance
    }).appendTo(form);
  }
});