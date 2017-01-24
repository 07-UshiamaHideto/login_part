<?php
// ログイン状態のチェック
if (!isset($_SESSION["account"])):
  $name_h = "";
  $btn_h = '<a href="login.php">Login</a>';
else:
  $name_h = '<li class="name_h">Name: '.$_SESSION["account"].'</li>';
  $btn_h = '　<a href="logout.php">Logout</a>';
endif;

//データベース接続
require_once("functions.php");


//$day = '2016-09';
try {
  if (!isset($_GET['m']) || !preg_match('/\A\d{4}-\d{2}\z/', $_GET['m'])) {
    throw new Exception();
  }
  $thisMonth = new DateTime($_GET['m']);
} catch (Exception $e) {
  $thisMonth = new DateTime('first day of this month');
}

$dt = clone $thisMonth;
$prev = $dt->modify('-1 month')->format('Y-m');
$dt = clone $thisMonth;
$next = $dt->modify('+1 month')->format('Y-m');

// $thisMonth = new DateTime($day); // 2015-08-01
$yearMonth = $thisMonth->format('F Y');

$cal_d = '';
$period = new DatePeriod(
  new DateTime('first day of ' . $yearMonth),
  new DateInterval('P1D'),
  new DateTime('first day of ' . $yearMonth . ' +1 month')
);
$day_t = '';
$today = new DateTime('today');
foreach ($period as $day) {
  if ($day->format('w') % 7 === 0) { $cal_d .= '</tr><tr>'; }
  $todayClass = ($day->format('Y-m-d') === $today->format('Y-m-d')) ? 'today' : '';
  $cal_d .= sprintf('<td class="%s">%d</td>', $todayClass, $day->format('d'));
}

$cal_bd = '';
$lastDayOfPrevMonth = new DateTime('last day of ' . $yearMonth . ' -1 month');
while ($lastDayOfPrevMonth->format('w') < 6) {
  $cal_bd = sprintf('<td class="mo_day">%d</td>', $lastDayOfPrevMonth->format('d')) . $cal_bd;
  $lastDayOfPrevMonth->sub(new DateInterval('P1D'));
}

$cal_ad = '';
$firstDayOfNextMonth = new DateTime('first day of ' . $yearMonth . ' +1 month');
while ($firstDayOfNextMonth->format('w') > 0) {
  $cal_ad .= sprintf('<td class="mo_day">%d</td>', $firstDayOfNextMonth->format('d'));
  $firstDayOfNextMonth->add(new DateInterval('P1D'));
}

$cal_part = $cal_bd . $cal_d . $cal_ad;

?>
<!DOCTYPE html>
<html lang="ja">
  <head>
    <meta charset="utf-8">
    <title></title>
    <script src="js/login.js"></script>
    <link rel="stylesheet" href="css/reset.css">
    <link rel="stylesheet" href="css/main.css">
  </head>
  <body>
    <table class="calender">
      <tr>
        <th colspan="2"><a href="./calender.php?m=<?php echo h($prev); ?>">&laquo;</a></td>
        <th colspan="3"><?=$yearMonth; ?></td>
        <th colspan="2"><a href="./calender.php?m=<?php echo h($next); ?>">&raquo;</a></td>
      </tr>
      <tr class="week">
        <td>Sun</td>
        <td>Mon</td>
        <td>Tue</td>
        <td>Wed</td>
        <td>Thu</td>
        <td>Fri</td>
        <td>Sat</td>
      </tr>
      <tr>
        <?=$cal_part ?>
      </tr>
      <tr>
        <th colspan="7" class="btn_today"><a href="./calender.php">Today</a></td>
      </tr>
    </table>

  </body>
</html>
