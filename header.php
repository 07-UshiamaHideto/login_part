<?php
// ログイン状態のチェック
if (!isset($_SESSION["account"])):
  $name_h = "";
  $btn_h = '<a href="login.php">Login</a>';
else:
  $name_h = '<li class="name_h">Name: '.$_SESSION["account"].'</li>';
  $btn_h = '　<a href="logout.php">Logout</a>';
endif;
?>
<header>
  <h1>勤怠アプリ<span>(Attendance app)</span></h1>
  <div class="head_list">
    <ul>
      <?=$name_h ?>
      <li><?=$btn_h ?></li>
      <li><a href="logout.php">Help</a></li>
    </ul>
  </div>
</header>
