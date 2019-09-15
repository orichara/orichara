<?php
session_start();
if (isset($_SESSION['login'])==false) {
    print 'ログインされていません。<br />';
    print '<a href="chara_page.php">ログイン画面へ</a>';
    exit();
} else {
}
?>
<?php
require_once './function/common.php';
require_once 'kannsuu.php';
require_once './function/DbManager.php';
//ヘッダーを呼び出し
head();
?>
<link rel="stylesheet" type="text/css" href="https://angry-ori-chara.ssl-lolipop.jp/chara_css/mypage.css">
<link rel="shortcut icon" href="https://angry-ori-chara.ssl-lolipop.jp/sozai/fav/tmfav04905.ico"
  type="image/vnd.microsoft.icon">
<title>マイページ</title>
</head>

<body>
  <audio src="./music/bgm_maoudamashii_acoustic52.mp3" autoplay loop></audio>
  <div ID="container">

    <div ID="boxA"></div>

    <div id="boxB">
      <?php
$name=$_SESSION['name'];
$pass=$_SESSION['pass'];

require_once './function/DbManager.php';
$db = getDb();

$sql = 'SELECT * FROM `character` WHERE `name`=? AND `password`=?';
$stmt = $db->prepare($sql);
$data[] = $name;
$data[] = $pass;
$stmt->execute($data);

$rec = $stmt->fetch(PDO::FETCH_ASSOC);
?>


      <?php
print '<img border="1" src="https://angry-ori-chara.ssl-lolipop.jp/chara_image/'.$rec['image_url'].'" width="400" height="400">';

?>
      <br>
      <br>

    </div>

    <div id="boxC">
      <?php
require_once './function/status.php';
?>
    </div>

    <div class="kaijyo"></div>

    <div ID="about">
      <?php

print <<< STATUS2
作成日：${rec['sakuseibi']}
<br>
製作者URL：${rec['url']}
<br>
STATUS2;
?>
    </div>

    <div id="boxD">
      <?php
$about = htmlspecialchars($rec['about']);
//文字数の長さを取得して枠の中に納まるようにする
$mojisuu = mb_strlen($about, UTF8);
if ($mojisuu >= 150 && $mojisuu <= 199) {
    $moji_size = "1";
} elseif ($mojisuu >= 200) {
    $moji_size = "2";
} else {
    $moji_size = null;
}

print "<div id=\"message\".$moji_size>$about</div>";

$code = $rec['code'];
//できごと
$sql_event = "SELECT `code`,`rival_code`,`name1`,`name2`,`winner`,`date`,`end_turn`,`damage1`,`damage2`,`kaihisuu1`,`kaihisuu2` FROM `result` WHERE `code` = $code OR `rival_code` = $code ORDER BY `date` DESC LIMIT 200";
$stmt_event = $db->prepare($sql_event);
$data[] = $rec['code'];
$stmt_event->execute($data);

print "<h1>最近のできごと</h1>";
print "<div class=\"event\">";
foreach ($stmt_event as $row) {
  echo date('Y年m月d日H時i分',  strtotime($row['date'])).'　　　';
  if ($code == $row['code']){
    $row['winner'] == '1' ? $syouhai = "<span class=\"win\">勝利</span>" : $syouhai = "<span class=\"lose\">敗北</span>";
    print "<a href=\"chara_data.php?code=${row['rival_code']}\">${row['name2']}</a>に勝負を挑み{$syouhai}した";
  }
  if ($rec['code'] != $row['code']){
    $row['winner'] == '2' ? $syouhai = "<span class=\"win\">勝利</span>" : $syouhai = "<span class=\"lose\">敗北</span>";
    print "<a href=\"chara_data.php?code=${row['code']}\">${row['name1']}</a>に勝負を挑まれ{$syouhai}した";
  }
  echo '<br>';
}
print "</div>";

$_SESSION['code'] = $rec['code'];
$_SESSION['level'] = $rec['level'];

print <<< MENU
<br>
<form method="post" action="edit.php">
<input class="btn2" type="submit" onClick="clicked()" value="キャラクターを編集">
</form>
<form method="post" action="select_rival.php">
<input class="btn2" type="submit" onClick="clicked()" value="対戦相手を探す">
</form>
<form method="post" action="power_up.php">
<input class="btn2" type="submit" onClick="clicked()" value="キャラクターを強化">
</form>
<form method="post" action="logout.php">
<input class="btn2" type="submit" onClick="clicked()" value="ログアウト">
</form>
<br>
<br>
MENU;
?>

    </div>

  </div>
  <script>
    function clicked() {
      //音を鳴らす
      var audio = new Audio("http://ori-chara.angry.jp/se/decision22.mp3");
      audio.play();
    }
  </script>
</body>

</html>