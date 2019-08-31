<?php
session_start();
?>

<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link rel="stylesheet" type="text/css" href="kakomonn.css">
<title>確認画面</title>
</head>
<body>
<div ID="container">
<div ID="boxA"></div>
<div id="wrapper">
<div id="boxB">

<h1>確認画面</h1>

<!-- 
メインのボックス
-->
<?php 
$_SESSION['name'] = $_POST['name'];
$_SESSION['pass'] = $_POST['pass'];
$_SESSION['url'] = $_POST['url'];
$_SESSION['setsumei'] = $_POST['setsumei'];
$_SESSION['image']['name'] = $_FILES["image"]["name"];
$_FILES["image"]["name"];


if (is_uploaded_file($_FILES["image"]["tmp_name"])) {
	if (move_uploaded_file($_FILES["image"]["tmp_name"], "image/" . $_FILES["image"]["name"])) {
		chmod("image/" . $_FILES["image"]["name"], 777);
		echo $_FILES["image"]["name"] . "をアップロードしました。";
	} else {
		echo "ファイルをアップロードできません。";
	}
} else {
	echo "ファイルが選択されていません。";
}


$name = $_SESSION['name'];
$pass = $_SESSION['pass'];
$url = $_SESSION['url'];
$setsumei = $_SESSION['setsumei'];

print 'キャラ名：'.$name;
print '<br>';
print 'パスワード：'.$pass;
print '<br>';
print 'URL：'.$url;
print '<br>';
print 'キャラクターの説明：'.$setsumei;
print '<br>';
print ''.$_FILES["image"]["name"];
print '<br>';
print '<br>';
print '以上で登録してよろしいですか？';



print '<form method="POST" action="kanryou.php">';
print '<input type="submit" value="登録">';
print '</form>';

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