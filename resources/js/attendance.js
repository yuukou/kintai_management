$(function () {
  //jqueryのクリック処理（出退勤ボタンをクリックイベントとする。）

  var btn = $('.js_attendance_btn');

  btn.on('click', function () {
    var attendance = $(this).attr("id");
    // if (confirmAttendance(attendance)) {
      // $.ajax({
      //   url: "/attendance/" + attendance,
      //   type: "post",
      //   headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
      //   async: true,
      //   dataType: 'json',
      //   data: {
      //     attendance:attendance,
      //   },
      // })
      //
      //  .done(function (data) {
      //     console.log(data);
      //    $('.attendance_complete').fadeIn('slow', function () {
      //      add(data['attendance']);
      //      $(this).delay(5000).fadeOut('slow');
      //    });
      //   })
      //  .fail(function (jqXHR, textStatus, errorThrown) {
      //    alert("出退勤処理に失敗しました。");
      //  });

      return confirmAttendance(attendance);
    // }
  });

  function add(attendance) {
    var japaneseAttendance = checkWchichAttendance(attendance);
    $('.attendance_complete').prepend('<div class="row">\n' +
        '    <div class="col-md-12">\n' +
        '        <div class="form-group">\n' +
        '            <div class="alert alert-success">' + japaneseAttendance + '処理が完了しました。</div>\n' +
        '        </div>\n' +
        '    </div>\n' +
        '</div>');
  }

  function confirmAttendance(attendance) {
    var japaneseAttendance = checkWchichAttendance(attendance);
    return confirm(japaneseAttendance + 'を記録します。本当によろしいですか？');
  }

  function checkWchichAttendance(attendance) {
    if (attendance == 'arrive') {
      return '出社';
    }
    if (attendance == 'leave') {
      return '退社';
    }
  }
});


//ここをjqueryのクリック処理を加えた後、そのままajaxで勤怠処理を行う。

//