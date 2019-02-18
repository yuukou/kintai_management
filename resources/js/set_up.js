$(function () {
  $('.js_set_up_btn').click(function (e) {

      //Userエージェント情報を取得する処理
      let ua = navigator.userAgent;
      console.log(ua);
      console.log(chkBrowser());

      function chkDevice() {
          let device = false;
          if(ua.indexOf('iphone') !== -1 || ua.indexOf('ipod') !== -1){
              device = 'iphone';
          } else if (ua.indexOf('ipad')    !== -1){
              device =  'ipad';
          } else if (ua.indexOf('android') !== -1){
              device =  'android';
          } else if (ua.indexOf('windows') !== -1 && ua.indexOf('phone') !== -1){
              device =  'windows_phone';
          }
          else return '';
          return device;
      }

      function chkBrowser()
      {
          if (ua.indexOf('edge')){
              brw = 'edge';
          } else if (ua.indexOf('chrome')  !== -1 && ua.indexOf('edge') === -1){
              // Chrome
              return 'chrome';
          } else if (ua.indexOf('safari')  !== -1 && ua.indexOf('chrome') === -1){
              // Safari
              return 'safari';
          } else if (ua.indexOf('firefox') !== -1){
              // FIrefox
              return 'firefox';
          }
          else {
              return 'unknown_browser';
          }
      }

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

        // Google Geocoding API
        let geocoder = new google.maps.Geocoder();
        geocoder.geocode({location: new google.maps.LatLng(latitude, longitude)},
            function(result, response) {
                let tmp_zip_code = "";
                let address = "";
                if(response === "OK") {
                    for (i = (result[2].address_components.length - 1); i >= 0; i--) {
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

                //ajaxでデータ送信
                $.ajax({
                    url: "/entry",
                    type: "post",
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    async: true,
                    dataType: 'json',
                    data: {
                        //郵便番号
                        // zipcode: tmp_zip_code.split('-'),
                        // 住所
                        address: address,
                    },
                })
                    .done(function (data) {
                        console.log(data);
                    });
                return false;
            }
        );
    }
  });
});