<?php
session_start();

//クロスサイトリクエストフォージェリ（CSRF）対策
$_SESSION['token'] = base64_encode(openssl_random_pseudo_bytes(32));
$token = $_SESSION['token'];

?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>ログイン</title>
    <script src="js/login.js"></script>
    <link rel="stylesheet" href="css/reset.css">
    <link rel="stylesheet" href="css/main.css">
  </head>
  <body>
  <?php include("header.php"); ?>
  <div class="main">
    <h2>ログイン</h2>
    <form class="u_login" action="login_check.php" method="post">
      <ul>
        <li><span>Mailadress:</span>
          <input type="text" name="mail" value="" placeholder="メールアドレス">
          <input type="hidden" name="token" value="<?=$token?>">
        </li>
        <li><span>Password:</span>
          <input type="password" name="password" value="" placeholder="パスワード"></li>
        <li><input type="submit" value="送信"></li>
      </ul>
    </form>
  </div>
  <?php include("footer.php"); ?>
  </body>
</html>
