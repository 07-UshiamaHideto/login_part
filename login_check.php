<?php
session_start();

header("Content-type: text/html; charset=utf-8");

//クロスサイトリクエストフォージェリ（CSRF）対策のトークン判定
if ($_POST['token'] != $_SESSION['token']){
	echo "不正アクセスの可能性あり";
	exit();
}

//クリックジャッキング対策
header('X-FRAME-OPTIONS: SAMEORIGIN');

//データベース接続
require_once("functions.php");

//エラーメッセージの初期化
$errors = array();

if(empty($_POST)) {
	header("Location: login.php");
	exit();
}else{
	//POSTされたデータを各変数に入れる
	$account = isset($_POST['mail']) ? $_POST['mail'] : NULL;
	$password = isset($_POST['password']) ? $_POST['password'] : NULL;

	//前後にある半角全角スペースを削除
	$account = spaceTrim($account);
	$password = spaceTrim($password);

	//アカウント入力判定
	if ($account == ''):
		$errors['account'] = "アカウントが入力されていません。";
	elseif(mb_strlen($account)>128):
		$errors['account_length'] = "アカウントは128文字以内で入力して下さい。";
	endif;

	//パスワード入力判定
	if ($password == ''):
		$errors['password'] = "パスワードが入力されていません。";
	elseif(!preg_match('/^[0-9a-zA-Z]{5,30}$/', $_POST["password"])):
		$errors['password_length'] = "パスワードは半角英数字の5文字以上30文字以下で入力して下さい。";
	else:
		$password_hide = str_repeat('*', strlen($password));
	endif;

}

//エラーが無ければ実行
if(count($errors) === 0){

		//例外処理を投げる（スロー）ようにする
		$sql = "SELECT * FROM member WHERE mail=(:account) AND flag =1";
		//アカウントで検索
		$pdo = db_con();
		$stmt = $pdo->prepare($sql);
		$stmt->bindValue(':account', $account, PDO::PARAM_STR);
		$stmt->execute();
		// $row = $stmt->fetch();
		//svar_dump($row);
		//アカウントが一致
		if($row = $stmt->fetch()){
//			var_dump($row);
			$password_hash = $row[password];
//			echo "p pass:".$password;
//			echo "s Pass:".$password_hash;

			//パスワードが一致
			if (password_verify($password, $password_hash)) {

				//セッションハイジャック対策
				session_regenerate_id(true);

				$_SESSION['account'] = $account;
				$_SESSION['ad'] = $row[admin];
				$_SESSION['id'] = $row[id];

				 header("Location: user_page.php");
				 exit();
			}else{
				$errors['password'] = "パスワードが一致しません。";
			}
		}else{
			$errors['account'] = "アカウントが存在しません。";
		}

		//データベース接続切断
		$pod = null;
}

?>

<!DOCTYPE html>
<html>
<head>
<title>ログイン確認画面</title>
<meta charset="utf-8">
</head>
<body>
<h1>ログイン確認画面</h1>

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
