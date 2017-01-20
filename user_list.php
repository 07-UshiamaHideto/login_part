<!DOCTYPE html>
<?php
session_start();
//クロスサイトリクエストフォージェリ（CSRF）対策
$_SESSION['token'] = base64_encode(openssl_random_pseudo_bytes(32));
$token = $_SESSION['token'];

// ログイン状態のチェック
if (!isset($_SESSION["account"])) {
	header("Location: Login.php");
	exit();
}

require_once("functions.php");

header('X-FRAME-OPTIONS: SAMEORIGIN');


$sql = "SELECT * FROM member WHERE flag='1' ";
//var_dump($sql);
$pdo = db_con();
$stmt = $pdo->prepare($sql);
$stmt->execute();
$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
//var_dump($results);

$view = '';
$view .= '<div class="user_table">';
$view .=  '<ol class="table_h"><li>ID</li><li>name</li><li>mail</li><li>sns</li><li>メモ</li><li>権限</li><li> </li><li>update</li><li>create</li></ol>';

foreach($results as $row) {
	$btn_c = '<li>'.'<a href="user_edit.php?id='.$row["id"].'">詳細変更</a>'.'<a href="password_change.php?id='.$row["id"].'">パスワード変更</a>'.'</li>';
	if($row["admin"]=="1") {
		$admin = "管理者";
	} else {
		$admin = "ユーザー";
	}
	$view .= "<ol><li>".$row["id"]." </li><li>".$row["name"]."</li><li>".$row["mail"]."</li><li>".$row["sns"]."</li><li>".$row["memo"]."</li><li>".$admin." </li>".$btn_c."<li>".$row["udate"]." </li><li>".$row["idate"]."</li></ol>";
}
$view .= '</div>';
// table閉じタグで終了

$pdo = null;

?>
<html>
  <head>
    <meta charset="utf-8">
    <title>登録ユーザーリスト</title>
    <script src="js/login.js"></script>
    <link rel="stylesheet" href="css/reset.css">
    <link rel="stylesheet" href="css/main.css">
  </head>
  <body>
    <?php include("header.php"); ?>
    <div class="main">
      <?php echo $view; ?>
    </div>
    <?php include("footer.php"); ?>
  </body>
</html>
