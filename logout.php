<?php

session_start();

header("Content-type: text/html; charset=utf-8");

// ログイン状態のチェック
if (!isset($_SESSION["account"])) {
	header("Location: login_form.php");
	exit();
}

//セッション変数を全て解除
$_SESSION = array();

//セッションを破棄する
session_destroy();

?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>ログインアウト</title>
    <script src="js/login.js"></script>
    <link rel="stylesheet" href="css/reset.css">
    <link rel="stylesheet" href="css/main.css">
  </head>
  <body>
  <?php include("header.php"); ?>
  <div class="main">
    <h2>ログインアウトしました。</h2>
  </div>
  <?php include("footer.php"); ?>
  </body>
</html>
