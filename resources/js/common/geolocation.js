(function ($) {
    // クリックイベントによって端末位置情報を取得するプログラムが走る
    $.fn.getGeolocation = function()
    {
        this.click(async function (e) {
            e.preventDefault();
            //位置情報取得機能として取得する情報を配列で返す
            let geolocationResult = [];
            //Userエージェント情報により端末情報（ブラウザ）を取得する処理
            geolocationResult.terminal = UAParser().browser.name;

            // $('div.hereArea p.errorMsg').text('');
            await navigator.geolocation.getCurrentPosition(here_success_callback, here_error_call);

            function here_error_call(error) {
                $('div.hereArea p.errorMsg').text('位置情報が取得出来ませんでした。');
                console.log('Error code:' + error.code + ' msg:' + error.message);
            }

            async function here_success_callback(position) {
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

                geolocationResult.latitude = await latitude;
                geolocationResult.longitude = await longitude;

                return await getGeocoder(latitude, longitude, geolocationResult);
            }
            return geolocationResult;
        });
    };

    function getGeocoder(latitude, longitude, geolocationResult) {
        let geocoder = new google.maps.Geocoder();

        // Google Geocoding API
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
                    geolocationResult.address = address;
                    return geolocationResult;
                } else {
                    console.log("位置情報取得は成功しましたが、住所情報の取得に失敗しました。");
                    $('div.hereArea p.errorMsg').text('位置情報が取得出来ませんでした。');
                }
            }
        );
    }
})($);