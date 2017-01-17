<?php
// ログイン状態のチェック
if (!isset($_SESSION["account"])):
  $log = '<a href="login.php">Login</a>';
else:
  $log = '<a href="logout.php">Logout</a>';
endif;
?>
<header>
  <h1>勤怠アプリ(Attendance app)</h1>
  <div class="head_list">
    <ul>
      <li><?=$log ?></li>
      <li>Help</li>
    </ul>
  </div>
</header>
