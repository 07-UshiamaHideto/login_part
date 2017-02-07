<!DOCTYPE html>
<?php
session_start();
//クロスサイトリクエストフォージェリ（CSRF）対策
$_SESSION['token'] = base64_encode(openssl_random_pseudo_bytes(32));
$token = $_SESSION['token'];

require_once("functions.php");

header('X-FRAME-OPTIONS: SAMEORIGIN');


$date = isset($_POST['date']) ? $_POST['date'] : NULL;
$time = isset($_POST['time']) ? $_POST['time'] : NULL;
$addwress = isset($_POST['address']) ? $_POST['password'] : NULL;
$sns = isset($_POST['sns']) ? $_POST['sns'] : NULL;
$memo = isset($_POST['memo']) ? $_POST['memo'] : NULL;
$admin = isset($_POST['admin']) ? $_POST['admin'] : NULL;
$flag = 1;

$errors = array();

//アカウント入力判定
//前後にある半角全角スペースを削除
$account = spaceTrim($email);
if ($account == ''):
  $errors['account'] = "E-mailが入力されていません。";
elseif(!preg_match('|^[0-9a-z_./?-]+@([0-9a-z-]+\.)+[0-9a-z-]+$|', $account)):
  $errors['account_word'] = "正しいE-mailアドレスではありません。";
elseif(mb_strlen($account)>128):
  $errors['account_length'] = "E-mailは128文字以内で入力して下さい。";
else:
// 登録アドレスチェック
$sql = "SELECT * FROM member WHERE mail=(:account) AND flag =1";
//アカウントで検索
$pdo = db_con();
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':account', $account, PDO::PARAM_STR);
$stmt->execute();

if($row = $stmt->fetch()){
  $errors['email'] = "すでに登録されているメールアドレスです。";
}

endif;

//パスワード入力判定
if ($pass == ''):
  $errors['password'] = "パスワードが入力されていません。";
elseif(!preg_match('/^[0-9a-zA-Z]{5,30}$/', $_POST["password"])):
  $errors['password_length'] = "パスワードは半角英数字の5文字以上30文字以下で入力して下さい。";
else:
  //前後にある半角全角スペースを削除
  $password = spaceTrim($pass);
  $password_hide = str_repeat('*', strlen($password));
endif;

if(count($errors) === 0){

  //パスワードのハッシュ化
  $pass_hash =  password_hash($pass, PASSWORD_DEFAULT);

  $sql = "INSERT INTO member (id, name, password, mail, sns,  memo, admin, flag, udate, idate) VALUES (NULL, :a1, :a2, :a3, :a4, :a5, :a6, :a7, sysdate(), sysdate())";
  var_dump($sql);
  $pdo = db_con();
  $stmt = $pdo->prepare($sql);
  $stmt->bindValue(':a1', $name, PDO::PARAM_STR);
  $stmt->bindValue(':a2', $pass_hash, PDO::PARAM_STR);
  $stmt->bindValue(':a3', $email, PDO::PARAM_STR);
  $stmt->bindValue(':a4', $sns, PDO::PARAM_STR);
  $stmt->bindValue(':a5', $memo, PDO::PARAM_STR);
  $stmt->bindValue(':a6', $admin, PDO::PARAM_INT);
  $stmt->bindValue(':a7', $flag, PDO::PARAM_INT);
  $result = $stmt->execute();
  var_dump($result);

  if($result==false){
    $error = $stmt->errorInfo();
    exit("QUERY ERROR:".$error[2]);
  }else{
    echo "投入終了";
    header("Location: user_list.php");
    exit;
  }
}

?>
<html>
  <head>
    <meta charset="utf-8">
    <title>登録</title>

  </head>
  <body>

    <?php if(count($errors) > 0): ?>

    <?php
    foreach($errors as $value){
    	echo "<p>".$value."</p>";
    }
    ?>

    <input type="button" value="戻る" onClick="history.back()">

    <?php endif; ?>


  </body>
</html>
