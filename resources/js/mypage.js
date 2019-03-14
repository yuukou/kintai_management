$(function () {

    $('.js_set_up_btn').click(function (e) {
        let workspaceType = $(this).parent().attr('id');
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

            console.log(latitude);
            console.log(longitude);

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

                    if (confirm(address + 'で位置情報を登録します。\n本当によろしいでしょうか？')) {
                        //ajaxでデータ送信
                        $.ajax({
                            url: "/terminal-location",
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
                                //勤務先種別（0or1）
                                workspace_type:workspaceType,
                            },
                        })
                            .done(function (data) {
                                console.log(data);
                                console.log(data['address']);
                                let addressType = $('#' + data['workspace_type']);
                                console.log(addressType);
                                addressType.text(data['address']);
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
});