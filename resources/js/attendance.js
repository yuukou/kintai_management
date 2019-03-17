$(async function () {
    //jqueryのクリック処理（出退勤ボタンをクリックイベントとする。）
  // let geolocationData = [];
  //   await geolocationData = $('.js_attendance_btn').getGeolocation();
  //   await console.log(geolocationData);
  //     // if (confirm('現在地情報は' + geolocationData.address + 'でよろしいでしょうか？')) {
  //     if (await confirm('現在地情報は' + geolocationData.terminal + 'でよろしいでしょうか？')) {
  //       //ajaxでデータ送信
  //       await $.ajax({
  //         url: 'attendance/check-terminal-location',
  //         type: "post",
  //         headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
  //         async: true,
  //         dataType: 'json',
  //         data: {
  //           //緯度
  //           longitude:geolocationData.longitude,
  //           //経度
  //           latitude:geolocationData.latitude,
  //           // 住所
  //           address: geolocationData.address,
  //           //端末情報としてブラウザ情報を使用する
  //           terminal: geolocationData.browser,
  //         },
  //       })
  //           .done(function (data) {
  //             // console.log(data);
  //             // console.log(data['address']);
  //             let addressType = $('#' + data['workspace_type']);
  //             // console.log(addressType);
  //             addressType.text(data['address']);
  //           })
  //           .fail(function (jqXHR, textStatus, errorThrown) {
  //             alert("位置情報の登録に失敗しました。");
  //           });
  //     }

  $('.js_attendance_btn').click(function (e) {
    //Userエージェント情報を取得する処理
    let browser = UAParser().browser.name;

    e.preventDefault();
    // $('div.hereArea p.errorMsg').text('');
    navigator.geolocation.getCurrentPosition(here_success_callback, here_error_call);

    function here_error_call(error) {
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
      //
      // console.log(latitude);
      // console.log(longitude);

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
              console.log("位置情報取得は成功しましたが、住所情報の取得に失敗しました。");
              $('div.hereArea p.errorMsg').text('位置情報が取得出来ませんでした。');
            }

            if (confirm('現在地は' + address + 'でよろしいでしょうか？')) {
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
                      let distance = await $(this)  .getDistance(originalAddressLocation, data.destinationAddressLocation);
                      // if (await distance <= 1000) {
                      //   console.log('勤怠処理が可能です。');
                      // } else {
                      //   console.log('勤怠処理を行えません。');
                      // }
                    });
                  })
                  .fail(function (jqXHR, textStatus, errorThrown) {
                    alert("位置情報の登録に失敗しました。");
                  });
            }

            return false;
          }
      );
    }
  });

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