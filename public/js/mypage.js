!function(e){var o={};function t(n){if(o[n])return o[n].exports;var r=o[n]={i:n,l:!1,exports:{}};return e[n].call(r.exports,r,r.exports,t),r.l=!0,r.exports}t.m=e,t.c=o,t.d=function(e,o,n){t.o(e,o)||Object.defineProperty(e,o,{enumerable:!0,get:n})},t.r=function(e){"undefined"!=typeof Symbol&&Symbol.toStringTag&&Object.defineProperty(e,Symbol.toStringTag,{value:"Module"}),Object.defineProperty(e,"__esModule",{value:!0})},t.t=function(e,o){if(1&o&&(e=t(e)),8&o)return e;if(4&o&&"object"==typeof e&&e&&e.__esModule)return e;var n=Object.create(null);if(t.r(n),Object.defineProperty(n,"default",{enumerable:!0,value:e}),2&o&&"string"!=typeof e)for(var r in e)t.d(n,r,function(o){return e[o]}.bind(null,r));return n},t.n=function(e){var o=e&&e.__esModule?function(){return e.default}:function(){return e};return t.d(o,"a",o),o},t.o=function(e,o){return Object.prototype.hasOwnProperty.call(e,o)},t.p="/",t(t.s=3)}({3:function(e,o,t){e.exports=t("tSG3")},tSG3:function(e,o){$(function(){$(".js_set_up_btn").click(function(e){var o=$(this).parent().attr("id"),t=UAParser().browser.name;e.preventDefault(),navigator.geolocation.getCurrentPosition(function(e){var n="",r="",a=$("#search_here");n=a.data("lat")?a.data("lat"):e.coords.latitude;r=a.data("lon")?a.data("lon"):e.coords.longitude;console.log(n),console.log(r),(new google.maps.Geocoder).geocode({location:new google.maps.LatLng(n,r)},function(e,a){var l="";if("OK"===a)for(i=e[2].address_components.length-1;i>=0;i--)e[2].address_components[i].long_name.match(/日本/)||(e[2].address_components[i].long_name.match(/^\d{3}-\d{4}$/)?e[2].address_components[i].long_name:l+=e[2].address_components[i].long_name);else console.log("位置情報取得は成功しましたが、住所情報の取得に失敗しました。"),$("div.hereArea p.errorMsg").text("位置情報が取得出来ませんでした。");return confirm(l+"で位置情報を登録します。\n本当によろしいでしょうか？")&&$.ajax({url:"/terminal-location",type:"post",headers:{"X-CSRF-TOKEN":$('meta[name="csrf-token"]').attr("content")},async:!0,dataType:"json",data:{longitude:r,latitude:n,address:l,terminal:t,workspace_type:o}}).done(function(e){console.log(e),console.log(e.address);var o=$("#"+e.workspace_type);console.log(o),o.text(e.address)}).fail(function(e,o,t){alert("位置情報の登録に失敗しました。")}),!1})},function(e){$("div.hereArea p.errorMsg").text("位置情報が取得出来ませんでした。"),console.log("Error code:"+e.code+" msg:"+e.message)})})})}});