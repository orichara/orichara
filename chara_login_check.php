<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Frameset//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link rel="stylesheet" type="text/css" href="kakomonn.css">
<title>ログイン</title>
</head>
<body>
<div ID="container">
<div ID="boxA"></div>
<div id="wrapper">
<div id="boxB">

<h1>ログイン</h1>

<!-- 
メインのボックス
-->
<?php 
try
{

$name = $_POST['name'];
$pass = $_POST['pass'];

$name = htmlspecialchars($name);
$pass = htmlspecialchars($pass);

$pass = md5($pass);

$dsn = 'mysql:dbname=LAA0352957-eibunnpou;host=mysql015.phy.lolipop.lan';
$user = 'LAA0352957';
$password = 'uke092mdv';
$dbh = new PDO($dsn,$user,$password);
$dbh->query('SET NAMES utf8');


$sql = 'SELECT name FROM characterWHERE code=? AND password=?';
$stmt = $dbh->prepare($sql);
$data[] = $name;
$data[] = $pass;
$stmt->execute($data);

$dbh = null;

$rec = $stmt->fetch(PDO::FETCH_ASSOC);

if($rec==false)
{
	print 'キャラクター名かパスワードが間違っています。<br />';
	print '<a href="chara_page.php">戻る</a>';
}
else
{
	header('Locathion:index.php');
}

}
catch (Exception $e)
{
	print 'ただ今障害によりご迷惑をおかけしています。';
	exit();
}

?>
</div>
<div id="boxC">
</div>
</div>

<div id="boxD"></div>
<div id="boxE"></div>

</div>
</body>