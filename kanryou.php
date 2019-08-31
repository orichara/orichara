<?php
session_start();
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Frameset//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link rel="stylesheet" type="text/css" href="kakomonn.css">
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
	$dsn = 'mysql:dbname=LAA0352957-eibunnpou;host=mysql015.phy.lolipop.lan';
	$user = 'LAA0352957';
	$password = 'uke092mdv';
	$dbh = new PDO($dsn,$user,$password);
	$dbh->query('SET NAMES utf8');

	
	$url = $_SESSION['url'];
	$setsumei = $_SESSION['setsumei'];
	$image = $_SESSION['image']['name'];
	print 'アップされた画像：'.$_SESSION['image']['name']; 
	print '<br>';	
	//取得する画像のリンク
	$img_url = 'http://jidoushitadoushi.pya.jp/ori-chara/image/'.$_SESSION['image']['name'];
	print 'URL：'.$img_url;
	
//	 画像の取得
//	$img_file = file_get_contents($img_url);
	
	//画像取得が成功した場合
//	if($img_file){
	
		//画像をバイナリに変換
//		$img_binary = mysqli_real_escape_string($dbh,$img_file);
	
		//画像を保存するSQL文の実行
//		$result = mysqli_query( $db_link, 'INSERT INTO img_table (img_col) VALUES ( "'.$img_binary.'" )');
	
//	}

	if (isset($_SESSION['name'])) {
		$name = htmlspecialchars($_SESSION['name'],ENT_QUOTES);
		$pass = htmlspecialchars($_SESSION['pass'],ENT_QUOTES);
		//----------------------
		//SHA-2
		//----------------------
		$password = hash("sha256",$pass);
		$passw = "任意の文字列".$password."任意の文字列";
		$passd = hash("sha256",$passw);
		//----------------------
		//空ならエラー
		//----------------------
		if ($name == "" ) { $error = '<p class="error">名前が入っていません</p>'; }
		if ($pass == "" ) { $error = '<p class="error">パスワードが入っていません</p>'; }
		//----------------------
		//文字数確認
		//----------------------
		$sid = strlen($name);
		$spass = strlen($pass);
		if ($sid < 4 ){ $error = '<p class="error">名前は４文字以上で設定してください</p>'; }
		if ($spass < 4 ){ $error = '<p class="error">パスワードは４文字以上で設定してください</p>'; }
		//----------------------
		//プレグマッチ
		//----------------------
		if (preg_match("/^[a-zA-Z0-9]+$/", $pass)) { $pass = $pass; }else{
			$error = '<p class="error">パスワードは半角英数で登録してください。</p>'; }
			if (preg_match("/^[a-zA-Z0-9]+$/", $name)) { $name = $name; }else{
				$error = '<p class="error">IDは半角英数で登録してください。</p>'; }
				//---------------------
				//重複チェック
				//---------------------
				$stmt = $pdo -> query("SELECT * FROM character");
				while($item = $stmt->fetch()) {
					if($item['name'] == $name){
						$error = '<p class="error">ご希望の名前は既に使用されています。</p>';
					}else{
						$name = $name;
					}
				}
	}
				
print 'キャラ名：'.$name;
print '<br>';
print 'パスワード'.$pass;
print '<br>';
print 'URL：'.$url;
print '<br>';
print 'キャラクターの説明：'.$setsumei;
print '<br>';
print ''.$_SESSION['image']['name'];

//-------------------
//DBに登録
//-------------------
if ($error == "" ) {
	$sql = 'INSERT INTO `character` (`name`, `url`, `about`, `image_url`, `password`) VALUES ("'.$name.'","'.$url.'","'.$setsumei.'","'.$img_url.'","'.$pass.'")';
	$stmt = $dbh->prepare($sql);

	$stmt -> bindParam(':name', $name, PDO::PARAM_STR);
	$stmt -> bindParam(':pass', $passd, PDO::PARAM_STR);

	$stmt->execute();

	$dbh = null;
	
	}
}
catch (Exception $e)
{
	print 'ただ今障害によりご迷惑をおかけしています';
	print '<br>';
	print '<br>';
	print '<a href="index.php">オリキャラバトル　TOP</a>';
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
</html>
