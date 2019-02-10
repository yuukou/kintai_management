$(function () {
  $('.js_set_up_btn').click(function (e) {
    e.preventDefault();
    $('div.hereArea p.errorMsg').text('');
    navigator.geolocation.getCurrentPosition(here_success_callback, here_error_call);

    function here_error_call(error) {
      $('div.hereArea p.errorMsg').text('位置情報が取得出来ませんでした。');
      console.log('Error code:' + error.code + ' msg:' + error.message);
    }

    function here_success_callback() {

    }
  });
});