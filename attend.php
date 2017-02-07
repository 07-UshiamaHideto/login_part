<!DOCTYPE html>
<?
session_start();
//クロスサイトリクエストフォージェリ（CSRF）対策
$_SESSION['token'] = base64_encode(openssl_random_pseudo_bytes(32));
$token = $_SESSION['token'];

header('X-FRAME-OPTIONS: SAMEORIGIN');

// ログイン状態のチェック
//if (!isset($_SESSION["account"])) {
//	header("Location: login.php");
//	exit();
//}

$date = date("Y/m/d");
$time = date("H:i");

?>
<html>
  <head>
    <meta charset="utf-8">
    <title>登録</title>
    <script src="http://code.jquery.com/jquery-1.10.2.min.js"></script>
    <script src="js/login.js"></script>
		<script src="js/location.js"></script>
		<!-- script src="js/time.js"></script -->
		<script type="text/javascript">
			var loc = location();

      //日付データ
      $(function(){
      var a_date=new Date();
      //日時を取得する
      var year = a_date.getFullYear();
      var month = a_date.getMonth()+1;
      var week = a_date.getDay();
      var day = a_date.getDate();

      var hour = a_date.getHours();
      var min = a_date.getMinutes();
      var second = a_date.getSeconds();

      var dates = 　""+year+month+day;
      console.log("d:"+dates);
      var week_m = new Array("日","月","火","水","木","金","土");

      var times = ""+hour+min;
      console.log("d:"+times);
        $("#times").val(times);
        $("#dates").val(dates);
      });
//      document.getElementById("times").value = times;
//      document.getElementById("dates").value = dates;
		</script>
    <link rel="stylesheet" href="css/reset.css">
    <link rel="stylesheet" href="css/main.css">
  </head>
  <body>
    <?php include("header.php"); ?>
    <div class="main">
      <form class="f_atted" action="attend_act.php" method="post">
        <ul>
          <li><span>月日:</span>
            <input type="text" name="date" id="dates"></li>
					<li><span>時間:</span>
	          <input type="text" name="time" id="times"></li>
          <li><span>場所:</span>
            <input type="text" name="address"><br>
						<span>位置:</span>
						<input type="text" name="lat" id="loc_lt"><input type="text" name="lon" id="loc_ln">
						<a href="http://maps.google.com/maps?q=" target="_blank">地図表示</a>
					</li>
          <li><span>管理権限:</span>
            <select name="type">
              <option value="0">出勤</option>
              <option value="1">退勤</option>
              <option value="2">休憩</option>
              <option value="3">管理者</option>
            </select>
          </li>
          <li><span>Memo:</span>
            <textarea name="memo"></textarea></li>
          <li><input type="submit" value="登録"></li>
        </ul>
      </form>
    </div>
    <?php include("footer.php"); ?>
  </body>
</html>
