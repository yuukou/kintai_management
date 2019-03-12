$(function () {
  //jqueryのクリック処理（出退勤ボタンをクリックイベントとする。）

  var btn = $('.js_attendance_btn');

  btn.on('click', function () {
    var attendance = $(this).attr("id");
    if (confirmAttendance(attendance)) {
      $.ajax({
        url: "/attendance/" + attendance,
        type: "post",
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        async: true,
        dataType: 'json',
        data: {
          attendance:attendance,
        },
      })

       .done(function (data) {
          console.log(data);
          $('.address1').text();
        })
       .fail(function (jqXHR, textStatus, errorThrown) {
         alert("出退勤処理に失敗しました。");
       });
    }
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


//ここをjqueryのクリック処理を加えた後、そのままajaxで勤怠処理を行う。

//