<?php
session_start();
session_regenerate_id(true);
if (isset($_SESSION['login'])==false){
	print 'ログインされていません。<br />';
	print '<a href="chara_page.php">ログイン画面へ</a>';
	exit();
}
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Frameset//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link rel="stylesheet" type="text/css" href="main.css">
<link rel="stylesheet" type="text/css" href="https://angry-ori-chara.ssl-lolipop.jp/chara_css/common2.css">
<title>編集画面</title>
</head>
<body>
<audio src="./music/bgm_maoudamashii_acoustic52.mp3"  autoplay loop></audio>
<div ID="container">
<div ID="boxA"></div>
<div id="wrapper">
<div id="boxB">
<?php
$name=$_SESSION['name'];
$pass=$_SESSION['pass'];

$dsn = 'mysql:dbname=LAA0352957-eibunnpou;host=mysql015.phy.lolipop.lan';
$user = 'LAA0352957';
$password = 'uke092mdv';
$dbh = new PDO($dsn,$user,$password);
$dbh->query('SET NAMES utf8');

$sql = 'SELECT * FROM `character` WHERE `name`=? AND `password`=?';
$stmt = $dbh->prepare($sql);
$data[] = $name;
$data[] = $pass;
$stmt->execute($data);

$dbh = null;

$rec = $stmt->fetch(PDO::FETCH_ASSOC);



$url = $rec['url'];
$about = $rec['about'];
htmlspecialchars($url);
htmlspecialchars($about);

print <<< EDIT
<form method="post" action="edit_done.php">
URL：
<br>
<input type="text" name="url" value="$url" size="15">
<br>
<br>
キャラクターの説明：
<br>
<textarea name="setsumei" cols="80" rows="10">
$about
</textarea>
<br>
<br>
<input class="btn" type="submit" value="編集を反映させる">
</form>
<br>
<br>
<br>
<br>
<br>
<a href="mypage.php" class="btn">マイページに戻る</a>
<br>
EDIT;


?>





</div>
<div id="boxC">
</div>
</div>

<div id="boxD"></div>
<div id="boxE"></div>

</div>
</body>
</html>