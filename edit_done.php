<?php 
session_start();
session_regenerate_id(true);
if (isset($_SESSION['login'])==false){
	print 'ログインされていません。<br />';
	print '<a href="chara_page.php">ログイン画面へ</a>';
	exit();
}else {
	print $_SESSION['name'];
	print'さんログイン中<br />';
	print'<br />';
}
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Frameset//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link rel="stylesheet" type="text/css" href="kakomonn.css">
<title>編集完了</title>
</head>
<body>
<div ID="container">
<div ID="boxA"></div>
<div id="wrapper">
<div id="boxB">
<?php 
$name=$_SESSION['name'];
$pass=$_SESSION['pass'];

$url = $_POST['url'];
$about = $_POST['setsumei'];

$dsn = 'mysql:dbname=LAA0352957-eibunnpou;host=mysql015.phy.lolipop.lan';
$user = 'LAA0352957';
$password = 'uke092mdv';
$dbh = new PDO($dsn,$user,$password);
$dbh->query('SET NAMES utf8');

$sql = 'UPDATE `character` SET `url`=?,`about`=? WHERE `name`=? AND `password`=?';
$stmt = $dbh->prepare($sql);
$data[] = $url;
$data[] = $about;
$data[] = $name;
$data[] = $pass;
$stmt->execute($data);

$dbh = null;



htmlspecialchars($url);
htmlspecialchars($about);

print <<< EDIT
編集を完了しました。
<br>
<br>
<a href="mypage.php">マイページに戻る</a>
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