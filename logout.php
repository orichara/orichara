<?php 
$_SESSION=array();
if (isset($_COOKIE[session_name()])==true) {
	setcookie(session_name(),'',time()-42000,'/');
}
@session_destroy();
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Frameset//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link rel="stylesheet" type="text/css" href="main.css">
<title>ログイン</title>
</head>
<body>
<div ID="container">
<div id="wrapper">
<div id="boxB">

<h1>ログアウト</h1>
ログアウトしました。
<br>
<br>
<a href="http://ori-chara.angry.jp/index.php">オリキャラバトル　TOP</a>
<?php
header( "Location: https://angry-ori-chara.ssl-lolipop.jp/chara_serch.php" ) ;
exit ;
?>

</div>
</div>


</div>
<script>
window.location.href = 'https://angry-ori-chara.ssl-lolipop.jp/index.php';
</script>
</body>
</html>