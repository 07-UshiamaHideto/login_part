if (!navigator.geolocation){
  alert("navigator.geolocation の対応しているブラウザを使用してください。");
}else{
  /* 位置情報取得オプション option object */
  var option = {
    enableHighAccuracy: true, // より高精度な位置を求める
    maximumAge: 1,         // 最後の現在地情報取得が [maximuAge][ms]以内であればその情報を再利用する設定
    timeout: 10000          // timeout[ms]以内に現在地情報を取得できなければ、処理を終了
  };
  /* CurrentPosition */
  var current = 'current-position';
  navigator.geolocation.getCurrentPosition(
    function(position){ success(current, position); },
    function(error){ err(current, error); },
    option
  );
  /* watchPosition */
  var watch = 'watch-position';
  navigator.geolocation.watchPosition(
    function(position){
      success(watch, position);
    },
    function(error){ err(watch, error); },
    option
  );
}
// 位置情報の取得に成功した時の処理
function success(id, position) {
  var time = position.timestamp;                 //タイムスタンプ
  var lat = position.coords.latitude;            //緯度
  var lon = position.coords.longitude;           //経度
  var alt = position.coords.altitude;            //高度
  var acc = position.coords.accuracy;            //正確性
  var alt_acc = position.coords.altitudeAccuracy;//高度の正確性
  var heading = position.coords.heading;         //方位
  var speed = position.coords.speed;             //速
/*  $('#'+id + " .status").html("緯度・経度: 取得完了！");
  $('#'+id + " .time").html("Timestamp: " + time);
  $('#'+id + " .lat").html("緯度[deg]: " + lat);
  $('#'+id + " .lon").html("経度[deg]: " + lon);
  $('#'+id + " .alt").html("高度[m]: " + alt);
  $('#'+id + " .acc").html("正確性[m]: " + acc);
  $('#'+id + " .alt-acc").html("高度の正確性[m]: " + alt_acc);
  $('#'+id + " .heading").html("方位[deg]: " + heading);
  $('#'+id + " .speed").html("速度[m/s]: " + speed);
*/
 console.log("loc t:"+ time + "  l:" + lat + "  " + lon);
 return [time,lat,lon,alt,acc,alt_acc,heading,speed];
}
// 位置情報の取得に失敗した場合の処理
function err(id, error){
  var e = "";
  if (error.code == 1) { //1＝位置情報取得が許可されてない（ブラウザの設定）
    e = "位置情報が許可されてません";
  }
  if (error.code == 2) { //2＝現在地を特定できない
    e = "現在位置を特定できません";
  }
  if (error.code == 3) { //3＝位置情報を取得する前にタイムアウトになった場合
    e = "位置情報を取得する前にタイムアウトになりました";
  }
  $('#'+id + " .status").html("エラー：" + e);
}
