<?
//クロスサイトリクエストフォージェリ（CSRF）対策
$_SESSION['token'] = base64_encode(openssl_random_pseudo_bytes(32));
$token = $_SESSION['token'];

header('X-FRAME-OPTIONS: SAMEORIGIN');

// ログイン状態のチェック
if (!isset($_SESSION["account"])) {
	header("Location: login.php");
	exit();
}

?>

<div class="admin_part">
  <form class="u_regi" action="regist_act.php" method="post">
    <ul>
      <li><span>Name:</span>
        <input type="text" name="name"></li>
      <li><span>Password:</span>
        <input type="password" name="password"><br></li>
      <li><span>E-mail:</span>
        <input type="text" name="email"></li>
      <li><span>SNS:</span>
        <input type="text" name="sns"></li>
      <li><span>管理権限:</span>
        <select name="admin">
          <option value="0">ユーザー</option>
          <option value="1">管理者</option>
        </select>
      </li>
      <li><span>Memo:</span>
        <textarea name="memo"></textarea></li>
      <li><input type="submit" value="登録"></li>
    </ul>
  </form>
</div>
