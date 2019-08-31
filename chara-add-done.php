<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Frameset//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link rel="stylesheet" type="text/css" href="main.css">
<title>登録完了</title>
</head>
<body>
<div ID="container">
<div ID="boxA"></div>
<div id="wrapper">
<div id="boxB">

<h1>登録完了</h1>

<!-- 
メインのボックス
-->
<?php 

try {
	$name = $_POST['name'];
	$pass = $_POST['pass'];
	$setsumei = $_POST['setsumei'];
	$url = $_POST['url'];
	$oldimage = $_POST['oldimage'];
	$kakutyoushi = $_POST['kakutyoushi'];
	
	$name = htmlspecialchars($name);
	$pass = htmlspecialchars($pass);
	$setsumei = htmlspecialchars($setsumei);
	$url = htmlspecialchars($url);
	
	print $name;
	
	
	$dsn = 'mysql:dbname=LAA0352957-eibunnpou;host=mysql015.phy.lolipop.lan';
	$user = 'LAA0352957';
	$password = 'uke092mdv';
	$dbh = new PDO($dsn,$user,$password);
	$dbh->query('SET NAMES utf8');
	
	//最後に挿入したdodeを得るSQL文
	$sql = 'SELECT `code` FROM `character` ORDER BY `code` DESC LIMIT 1;';
	$stmt = $dbh->prepare($sql);
	$stmt->execute();
	
	$rec = $stmt->fetch(PDO::FETCH_ASSOC);
	$rec['code'] +=1;
	$lastcode = $rec['code'];
	
	//画像をリネーム
	$lastcode .= ".";
	$lastcode .= $kakutyoushi;
	$image_url = $lastcode;
	rename('./image/'.$oldimage, './chara_image/'.$lastcode);
	

	$sql = 'INSERT INTO `character`(`name`, `password`, `about`, `url`, `image_url`) VALUES ("'.$name.'","'.$pass.'","'.$setsumei.'","'.$url.'","'.$image_url.'")';
	$stmt = $dbh->prepare($sql);
	$stmt->execute();

	$dbh = null;
	
	print '<br>';
	print 'を追加しました。<br />';

	
	
}
catch (Exception $e)
{
	print 'ただ今障害によりご迷惑をおかけしています';
	exit();
}

print '<a href="http://ori-chara.angry.jp/index.php">オリキャラバトル　TOP</a>';

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