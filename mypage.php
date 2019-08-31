<?php
session_start();
if (isset($_SESSION['login'])==false){
	print 'ログインされていません。<br />';
	print '<a href="chara_page.php">ログイン画面へ</a>';
	exit();
}else {
}
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Frameset//EN">
<html>
<head>
<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-136702693-1"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-136702693-1');
</script>

<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link rel="stylesheet" type="text/css" href="https://angry-ori-chara.ssl-lolipop.jp/chara_css/mypage.css">
<link rel="stylesheet" type="text/css" href="https://angry-ori-chara.ssl-lolipop.jp/chara_css/common2.css">
<link rel="shortcut icon" href="https://angry-ori-chara.ssl-lolipop.jp/sozai/fav/tmfav04905.ico" type="image/vnd.microsoft.icon">
<title>マイページ</title>
</head>
<body>
<audio src="./music/bgm_maoudamashii_acoustic52.mp3"  autoplay loop></audio>
<div ID="Z">

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

$db = null;

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
require_once 'kannsuu.php';
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
$mojisuu = mb_strlen ($about,UTF8);
if ($mojisuu >= 150 && $mojisuu <= 199) {
	$moji_size = "1";
}elseif ($mojisuu >= 200){
	$moji_size = "2";
}else{
	$moji_size = null;
}
print '<div id="message'.$moji_size.'">';
print $about;
print '</div>';


$_SESSION['code'] = $rec['code'];
$_SESSION['level'] = $rec['level'];

print <<< MENU
<br>
<form method="post" action="edit.php">
<input class="btn" type="submit" onClick="clicked()" value="キャラクターを編集する">
</form>
<form method="post" action="select_rival.php">
<input class="btn" type="submit" onClick="clicked()" value="対戦相手を探す">
</form>
<form method="post" action="power_up.php">
<input class="btn" type="submit" onClick="clicked()" value="キャラクターを強化する">
</form>
<form method="post" action="logout.php">
<input class="btn" type="submit" onClick="clicked()" value="ログアウト">
</form>
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