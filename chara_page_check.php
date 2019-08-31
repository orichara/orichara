<?php
try
{
$name = $_POST['name'];
$pass = $_POST['pass'];

$name = htmlspecialchars($name);
$pass = htmlspecialchars($pass);

$pass = md5($pass);

require_once './function/DbManager.php';
$db = getDb();

$sql = 'SELECT `name` FROM `character` WHERE `name`=? AND `password`=?';
$stmt = $db->prepare($sql);
$data[] = $name;
$data[] = $pass;
$stmt->execute($data);

$db = null;

$rec = $stmt->fetch(PDO::FETCH_ASSOC);

if($rec==false)
{
print <<< BACK
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Frameset//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link rel="stylesheet" type="text/css" href="main.css">
<title>ログイン</title>
</head>
<body>

<div ID="container">
<div ID="boxA"></div>


<div id="boxB">
キャラクター名かパスワードが間違っています。<br>
<a href="chara_page.php">戻る</a>
</div>



<div id="boxD"></div>
<div id="boxE"></div>

</div>
</body>
BACK;
}
else
{
	session_start();
	session_regenerate_id(true);
	$_SESSION['login']=1;
	$_SESSION['name']=$name;
	$_SESSION['pass']=$pass;
	header('Location: mypage.php');
}

}
catch (Exception $e)
{
	print 'ただ今障害によりご迷惑をおかけしています。';
	exit();
}

?>
