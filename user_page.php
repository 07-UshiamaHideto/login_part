<!DOCTYPE html>
<?php
session_start();

// ログイン状態のチェック
if (!isset($_SESSION["account"])):
	header("Location: Login.php");
	exit();
else:
  $name_h2 = 'Name: '.$_SESSION["account"];
endif;

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
$view .=  '<ol><li>ID</li><li>name</li><li>mail</li><li>sns</li><li>meno</li><li>admin</li><li>update</li><li>create</li></ol>';

foreach($results as $row) {
	$view .= "<ol><li>".$row["id"]." </li><li>".$row["name"]."</li><li>".$row["mail"]."</li><li>".$row["sns"]."</li><li>".$row["memo"]."</li><li>".$row["admin"]." </li><li>".$row["udate"]." </li><li>".$row["idate"]."</li></ol>";
}
$view .= '</div>';
// table閉じタグで終了

$pdo = null;

?>
<html>
  <head>
    <meta charset="utf-8">
    <title></title>
    <script src="js/login.js"></script>
    <link rel="stylesheet" href="css/reset.css">
    <link rel="stylesheet" href="css/main.css">
  </head>
  <body>
    <?php include("header.php"); ?>
    <div class="main">
			<h2><?php echo $name_h2; ?></h2>
      <?php echo $view; ?>
    </div>
    <?php include("footer.php"); ?>
  </body>
</html>
