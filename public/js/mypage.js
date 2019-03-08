/******/ (function(modules) { // webpackBootstrap
/******/ 	// The module cache
/******/ 	var installedModules = {};
/******/
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/
/******/ 		// Check if module is in cache
/******/ 		if(installedModules[moduleId]) {
/******/ 			return installedModules[moduleId].exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = installedModules[moduleId] = {
/******/ 			i: moduleId,
/******/ 			l: false,
/******/ 			exports: {}
/******/ 		};
/******/
/******/ 		// Execute the module function
/******/ 		modules[moduleId].call(module.exports, module, module.exports, __webpack_require__);
/******/
/******/ 		// Flag the module as loaded
/******/ 		module.l = true;
/******/
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/
/******/
/******/ 	// expose the modules object (__webpack_modules__)
/******/ 	__webpack_require__.m = modules;
/******/
/******/ 	// expose the module cache
/******/ 	__webpack_require__.c = installedModules;
/******/
/******/ 	// define getter function for harmony exports
/******/ 	__webpack_require__.d = function(exports, name, getter) {
/******/ 		if(!__webpack_require__.o(exports, name)) {
/******/ 			Object.defineProperty(exports, name, { enumerable: true, get: getter });
/******/ 		}
/******/ 	};
/******/
/******/ 	// define __esModule on exports
/******/ 	__webpack_require__.r = function(exports) {
/******/ 		if(typeof Symbol !== 'undefined' && Symbol.toStringTag) {
/******/ 			Object.defineProperty(exports, Symbol.toStringTag, { value: 'Module' });
/******/ 		}
/******/ 		Object.defineProperty(exports, '__esModule', { value: true });
/******/ 	};
/******/
/******/ 	// create a fake namespace object
/******/ 	// mode & 1: value is a module id, require it
/******/ 	// mode & 2: merge all properties of value into the ns
/******/ 	// mode & 4: return value when already ns object
/******/ 	// mode & 8|1: behave like require
/******/ 	__webpack_require__.t = function(value, mode) {
/******/ 		if(mode & 1) value = __webpack_require__(value);
/******/ 		if(mode & 8) return value;
/******/ 		if((mode & 4) && typeof value === 'object' && value && value.__esModule) return value;
/******/ 		var ns = Object.create(null);
/******/ 		__webpack_require__.r(ns);
/******/ 		Object.defineProperty(ns, 'default', { enumerable: true, value: value });
/******/ 		if(mode & 2 && typeof value != 'string') for(var key in value) __webpack_require__.d(ns, key, function(key) { return value[key]; }.bind(null, key));
/******/ 		return ns;
/******/ 	};
/******/
/******/ 	// getDefaultExport function for compatibility with non-harmony modules
/******/ 	__webpack_require__.n = function(module) {
/******/ 		var getter = module && module.__esModule ?
/******/ 			function getDefault() { return module['default']; } :
/******/ 			function getModuleExports() { return module; };
/******/ 		__webpack_require__.d(getter, 'a', getter);
/******/ 		return getter;
/******/ 	};
/******/
/******/ 	// Object.prototype.hasOwnProperty.call
/******/ 	__webpack_require__.o = function(object, property) { return Object.prototype.hasOwnProperty.call(object, property); };
/******/
/******/ 	// __webpack_public_path__
/******/ 	__webpack_require__.p = "/";
/******/
/******/
/******/ 	// Load entry module and return exports
/******/ 	return __webpack_require__(__webpack_require__.s = 5);
/******/ })
/************************************************************************/
/******/ ({

/***/ "./resources/js/mypage.js":
/*!********************************!*\
  !*** ./resources/js/mypage.js ***!
  \********************************/
/*! no static exports found */
/***/ (function(module, exports) {

$(function () {
  $('.js_set_up_btn').click(function (e) {
    //Userエージェント情報を取得する処理
    var browser = UAParser().browser;
    e.preventDefault(); // $('div.hereArea p.errorMsg').text('');

    navigator.geolocation.getCurrentPosition(here_success_callback, here_error_call);

    function here_error_call(error) {
      $('div.hereArea p.errorMsg').text('位置情報が取得出来ませんでした。');
      console.log('Error code:' + error.code + ' msg:' + error.message);
    }

    function here_success_callback(position) {
      // 経度・緯度を取得
      var latitude = '';
      var longitude = '';
      var $search_here = $('#search_here');

      if ($search_here.data('lat')) {
        latitude = $search_here.data('lat');
      } else {
        latitude = position.coords.latitude;
      }

      if ($search_here.data('lon')) {
        longitude = $search_here.data('lon');
      } else {
        longitude = position.coords.longitude;
      }

      console.log(latitude);
      console.log(longitude); // Google Geocoding API

      var geocoder = new google.maps.Geocoder();
      geocoder.geocode({
        location: new google.maps.LatLng(latitude, longitude)
      }, function (result, response) {
        var tmp_zip_code = "";
        var address = "";

        if (response === "OK") {
          for (i = result[2].address_components.length - 1; i >= 0; i--) {
            if (result[2].address_components[i].long_name.match(/日本/)) {
              continue;
            } else if (result[2].address_components[i].long_name.match(/^\d{3}-\d{4}$/)) {
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
            url: "/entry",
            type: "post",
            headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            async: true,
            dataType: 'json',
            data: {
              //位置情報（緯度・経度）
              longitude: longitude,
              latitude: latitude,
              // 住所
              address: address,
              //端末情報としてブラウザ情報を使用する
              terminal: browser
            }
          }).done(function (data) {
            console.log(data);
            $('.address1').text(data['address']);
          }).fail(function (jqXHR, textStatus, errorThrown) {
            alert("位置情報の登録に失敗しました。");
          });
        }

        return false;
      });
    }
  });
});

/***/ }),

/***/ 5:
/*!**************************************!*\
  !*** multi ./resources/js/mypage.js ***!
  \**************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(/*! /home/vagrant/kintai/resources/js/mypage.js */"./resources/js/mypage.js");


/***/ })

/******/ });