$(function () {
  var btn = $('.btn');

  btn.on('click', function () {
    var attendance = $(this).attr("id");
    return confirmAttendance(attendance);
  });

  function confirmAttendance(attendance) {
    var japanese = '';
    if (attendance == 'arrive') {
      japanese = '出社';
    }
    if (attendance == 'leave') {
      japanese = '退社';
    }
    return confirm(japanese + 'を記録します。本当によろしいですか？');
  }
});