<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link rel="stylesheet" type="text/css" href="main.css">
<title>キャラクター登録</title>
</head>
<body>
<div ID="container">
<div ID="boxA"></div>
<div id="wrapper">
<div id="boxB">

<h1>キャラクター登録</h1>

<!-- 
メインのボックス
-->
<?php 
$name = $_POST['name'];
$pass = $_POST['pass'];
$pass2 = $_POST['pass2'];
$setsumei = $_POST['setsumei'];
$url = $_POST['url'];
$image = $_FILES['image'];
$oldimage = $image['name'];

$name = htmlspecialchars($name);
$pass = htmlspecialchars($pass);
$pass2 = htmlspecialchars($pass2);
$setsumei = htmlspecialchars($setsumei);
$url = htmlspecialchars($url);


require_once './function/DbManager.php';
$db = getDb();

$sql = 'SELECT `name` FROM `character` WHERE `name`=?';
$stmt = $db->prepare($sql);
$data[] = $name;
$stmt->execute($data);

$rec = $stmt->fetch(PDO::FETCH_ASSOC);
$check_tyouhuku = $rec['name'];




//入力チェックしてエラーメッセージを表示
if ($name=='') {
	print 'キャラクター名が入力されていません<br>';
}

if ($pass=='') {
	print 'パスワードが入力されていません<br>';
}

if ($pass != $pass2) {
	print 'パスワードが一致しません。<br>';
}

if ($image['size'] > 0) {
	if ($image['size'] > 1000000) {
		print '画像が大きすぎます';
	}
}
if ($image['size'] == '') {
	print '画像が選択されていません<br>';
}

if ($check_tyouhuku != '') {
	print 'そのキャラクター名は既に使われています<br>';
}

//ここから拡張子チェック
$filename = $image['name'];
$kakutyoushi = substr(strrchr($filename, '.'), 1);
$kakutyoushi = strtolower($kakutyoushi);


if ($kakutyoushi != jpg && $kakutyoushi != jpeg && $kakutyoushi != png){
	print '拡張子はjpg,jpeg,pngのいずれかにしてください。';
	$kakutyoushicheck = 1;
}

//ここからフラグ制御
$okflg=true;

if ($name=='') {
	$okflg=false;
}

if ($pass=='') {
	$okflg=false;
}

if ($pass2=='') {
	$okflg=false;
}

if ($pass!=$pass2) {
	$okflg=false;
}

if ($image['size'] == '') {
	$okflg=false;
}

if ($image['size'] > 1000000) {
	$okflg=false;
}

if ($kakutyoushicheck == 1) {
	$okflg=false;
}

if ($check_tyouhuku != ''){
	$okflg=false;
}

if ($okflg==true) {
	$pass = md5($pass);
	move_uploaded_file($image['tmp_name'],'./image/'.$image['name']);
	print 'キャラクター名：'.$name;
	print '<br>';
	print '<img border="1" src="./image/'.$image['name'].'" width="300" height="300">';
	print '<br>';

	print '以上で登録してよろしいですか？';
	//次のページへデータの受け渡し	
	print '<form method="post" action="chara-add-done.php" enctype="multipart/form-data">';
	print '<input type="hidden" name="name" value="'.$name.'">';
	print '<input type="hidden" name="pass" value="'.$pass.'">';
	print '<input type="hidden" name="setsumei" value="'.$setsumei.'">';
	print '<input type="hidden" name="url" value="'.$url.'">';
	print '<input type="hidden" name="oldimage" value="'.$oldimage.'">';
	print '<input type="hidden" name="kakutyoushi" value="'.$kakutyoushi.'">';
	print '<br>';
	print '<input class="btn" type="button" onclick="history.back()" value="戻る">';
	print '<input class="btn" type="submit" value="OK">';
	print '</form>';
	
}else{
	print '<br>';
	print '<br>';
	print '<form>';
	print '<input class="btn" type="button" onclick="history.back()" value="戻る">';
	print '</form>';
}


?>
</div>

</div>

</div>
</body>
</html>