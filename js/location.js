function location(){

var lat,lon,time;

if (navigator.geolocation) {
    // 現在の位置情報取得を実施
    navigator.geolocation.getCurrentPosition(
    // 位置情報取得成功時
    function loc(pos) {
      time = pos.timestamp;
      lat = pos.coords.latitude;
      lon = pos.coords.longitude;
      console.log("loc p:"+time+" "+lat+" "+lon);
      document.getElementById("loc_lt").value = lat;
      document.getElementById("loc_ln").value = lon;

    },
    // 位置情報取得失敗時
    function (error) {
      var message = "";
      switch (error.code) {
      // 位置情報取得できない場合
      case error.POSITION_UNAVAILABLE:
        message = "位置情報の取得ができませんでした。";
        break;
      // Geolocation使用許可されない場合
      case error.PERMISSION_DENIED:
        message = "位置情報取得の使用許可がされませんでした。";
        break;
      // タイムアウトした場合
      case error.PERMISSION_DENIED_TIMEOUT:
        message = "位置情報取得中にタイムアウトしました。";
        break;
    }
    window.alert(message);
  });

} else {
  window.alert("本ブラウザではGeolocationが使えません");
}

}
