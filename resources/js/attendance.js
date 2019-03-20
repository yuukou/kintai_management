$(async function () {
    var clickFlg = false;

    $(document).on('click', '.js_attendance_btn', function (e) {
      if (clickFlg) {
          return false;
      }
      clickFlg = true;

      let browser = UAParser().browser.name;

      e.preventDefault();
      // $('div.hereArea p.errorMsg').text('');
      navigator.geolocation.getCurrentPosition(here_success_callback, here_error_call);

      function here_error_call(error) {
          clickFlg = false;
          $('div.hereArea p.errorMsg').text('位置情報が取得出来ませんでした。');
          console.log('Error code:' + error.code + ' msg:' + error.message);
      }

      function here_success_callback(position) {
          // 経度・緯度を取得

          let latitude = '';
          let longitude = '';
          let $search_here = $('#search_here');
          if ($search_here.data('lat')) {
              latitude = $search_here.data('lat');
          } else {
              latitude = position.coords.latitude;
          }

          if ($search_here.data('lon')) {
              longitude = $search_here.data('lon')
          } else {
              longitude = position.coords.longitude;
          }

      // Google Geocoding API
          let geocoder = new google.maps.Geocoder();
          geocoder.geocode({location: new google.maps.LatLng(latitude, longitude)},
              function(result, response) {
              let tmp_zip_code = "";
              let address = "";
              if(response === "OK") {
                  for (let i = (result[2].address_components.length - 1); i >= 0; i--) {
                      if(result[2].address_components[i].long_name.match(/日本/)) {
                          continue;
                      } else if (result[2].address_components[i].long_name.match(/^\d{3}-\d{4}$/)){
                          tmp_zip_code = result[2].address_components[i].long_name;
                      } else {
                          address += result[2].address_components[i].long_name;
                      }
                  }
              } else {
                  clickFlg = false;
                  console.log("位置情報取得は成功しましたが、住所情報の取得に失敗しました。");
                  $('div.hereArea p.errorMsg').text('位置情報が取得出来ませんでした。');
              }

              if (confirm('現在地は' + address + 'でよろしいでしょうか？')) {
                  //ここでローディングモーダルを表示させる
                  $('#loader-bg').css('display', 'block');
                  //ajaxでデータ送信
                  $.ajax({
                      url: "/attendance/post-location",
                      type: "post",
                      headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                      async: true,
                      dataType: 'json',
                      data: {
                          //緯度
                          longitude:longitude,
                          //経度
                          latitude:latitude,
                          // 住所
                          address: address,
                          //端末情報としてブラウザ情報を使用する
                          terminal: browser,
                      },
                  })
                      .done(function (data) {
                          // console.log(data);
                          $.each(data.originalAddressLocations, async function (key, originalAddressLocation) {
                              let distance = await $(this).getDistance(originalAddressLocation, data.destinationAddressLocation);
                              console.log(distance);
                              // distance = 900;
                              await postAjax(distance);
                          });
                      })
                      .fail(function (jqXHR, textStatus, errorThrown) {
                          clickFlg = false;
                          alert("位置情報の登録に失敗しました。");
                      });
              }
              clickFlg = false;
              return false;
          });
      }
    });

    function postAjax(distance) {
        if (distance <= 1000) {
            let attendance = $('button').attr('id');
            $.ajax({
                url: "/attendance/" + attendance,
                type: "post",
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                async: true,
                dataType: 'json',
                data: {
                    //出退勤の情報
                    attendance: attendance
                },
            })
                .done(function (data) {
                    //ローディングモーダルを非表示にする。
                    $('#loader-bg').css('display', 'none');
                    if (attendance === 'arrive') {
                        clickFlg = false;
                        $('.attendance_result_message_wrapper').css('display', 'block');;
                        $('.alert-success').text('出社処理が完了しました。');

                        $('.btn_wrapper').html(
                            "<button class=\"btn on_btn js_attendance_btn\" id=\"leave\" type=\"button\">🌚</button>" +
                            // "{{ Form::button(\\'🌚\\', [\\'class\\' => \"btn on_btn js_attendance_btn\", \\'id\\' => \\'leave\\']) }}" +
                            "<p class=\"arrive_description\">退社</p>"
                        );
                    }
                    else if (attendance === 'leave') {
                        clickFlg = false;
                        $('.attendance_result_message_wrapper').css('display', 'block');;
                        $('.alert-success').text('退社処理が完了しました。');

                        $('.btn_wrapper').html(
                            "<p class=\"good_bye_description\">本日も一日お疲れ様でした👼👼👼</p>"
                        );
                    } else {
                        clickFlg = false;
                        $('.btn_wrapper').html(
                            "<div>エラーです。運営にお問い合わせください。</div>"
                        );
                    }
                })
                .fail(function () {
                    clickFlg = false;
                })
        } else {
            clickFlg = false;
            console.log('勤怠処理を行えません。');
        }
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