//2点の位置情報（緯度・経度）から距離を求める
(function($) {
    $.fn.getDistance = async function(originalAddressLocation, destinationAddressLocation) {
        var distance = '';
        // DistanceMatrix サービスを生成
        var distanceMatrixService = new google.maps.DistanceMatrixService();
// 出発点
        var originalLocation = await new google.maps.LatLng(parseFloat(originalAddressLocation['latitude']),parseFloat(originalAddressLocation['longitude']));
        var originalAddress = originalAddressLocation['address'];
// 到着点
        var destinationLocation = await new google.maps.LatLng(parseFloat(destinationAddressLocation['latitude']),parseFloat(destinationAddressLocation['longitude']));
        var destinationAddress = destinationAddressLocation['address'];
// DistanceMatrix の実行
        await distanceMatrixService.getDistanceMatrix({
            // origins: origin, // 出発地点
            origins: [originalLocation, originalAddress], // 出発地点
            destinations: [destinationAddress, destinationLocation], // 到着地点
            // destinations: destination, // 到着地点
            travelMode: google.maps.TravelMode.WALKING, // 車モード or 徒歩モード
        }, function(response, status) {
            if (status == google.maps.DistanceMatrixStatus.OK) {

                // console.log(response);
                // // 出発地点と到着地点の住所（配列）を取得
                // var origins = response.originAddresses;
                // var destinations = response.destinationAddresses;
                //
                // // 出発地点でループ
                // for (var i=0; i<origins.length; i++) {
                //     // 出発地点から到着地点への計算結果を取得
                //     var results = response.rows[i].elements;
                //
                //     // 到着地点でループ
                //     for (var j = 0; j<results.length; j++) {
                //         var distance = results[j].distance.value; // 距離
                //         // console.log(distance);
                //     }
                // }

                distance = response.rows[0].elements[0].distance.value; // 距離
                console.log(distance);
            }
        });
        console.log(distance);
        return distance;
    }
})($);