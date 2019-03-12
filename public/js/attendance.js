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
/******/ 	return __webpack_require__(__webpack_require__.s = 1);
/******/ })
/************************************************************************/
/******/ ({

/***/ "./resources/js/attendance.js":
/*!************************************!*\
  !*** ./resources/js/attendance.js ***!
  \************************************/
/*! no static exports found */
/***/ (function(module, exports) {

$(function () {
  //jqueryのクリック処理（出退勤ボタンをクリックイベントとする。）
  var btn = $('.js_attendance_btn');
  btn.on('click', function () {
    var attendance = $(this).attr("id"); // if (confirmAttendance(attendance)) {
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

    return confirmAttendance(attendance); // }
  });

  function add(attendance) {
    var japaneseAttendance = checkWchichAttendance(attendance);
    $('.attendance_complete').prepend('<div class="row">\n' + '    <div class="col-md-12">\n' + '        <div class="form-group">\n' + '            <div class="alert alert-success">' + japaneseAttendance + '処理が完了しました。</div>\n' + '        </div>\n' + '    </div>\n' + '</div>');
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
}); //ここをjqueryのクリック処理を加えた後、そのままajaxで勤怠処理を行う。
//

/***/ }),

/***/ 1:
/*!******************************************!*\
  !*** multi ./resources/js/attendance.js ***!
  \******************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(/*! /home/vagrant/kintai/resources/js/attendance.js */"./resources/js/attendance.js");


/***/ })

/******/ });