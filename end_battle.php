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
<link rel="stylesheet" type="text/css" href="battle.css">
<title>戦闘終了</title>
</head>
<body>
<div ID="container">
<div ID="boxA"></div>
<div id="senntou">
<?php
if (isset($_SESSION['message']) == false) {
	$_SESSION['message'] = 1;
}

//キャラクター画像とＨＰを表示
if ($_SESSION['winner'] == 1) {
	$name01 = $_SESSION['name1'];
	$hp01 = $_SESSION['hp1'];
	$max_hp01 = $_SESSION['max_hp1'];
	$image01 = $_SESSION['image_url1'];
	print <<< PLAYERA
	<div id="playerA">
	<span id="name">{$name01}：{$hp01}/{$max_hp01}</span>
	<br>
	<br>
	<img border="3" src="./chara_image/$image01" width="300" height="300">
	</div>
PLAYERA;
}

if ($_SESSION['winner'] == 2) {
	$name02 = $_SESSION['name2'];
	$hp02 = $_SESSION['hp2'];
	$max_hp02 = $_SESSION['max_hp2'];
	$image02 = $_SESSION['image_url2'];
	print <<< PLAYERB
	<div id="playerB">
	<span id="name">{$name02}：{$hp02}/{$max_hp02}</span>
	<br>
	<br>
	<img border="3" src="./chara_image/$image02" width="300" height="300">
	</div>
PLAYERB;
}

print'<div class="kaijyo"></div>';

//戦闘に勝利した場合
if ($_SESSION['winner'] == 1) {
	if ($_SESSION['message'] == 1) {
		$code = $_SESSION['code'];
		$level1 = $_SESSION['level1'];
		$syouri1 = $_SESSION['syouri1'];
		$kyouka1 = $_SESSION['kyouka1'];
		$taisennsuu =$_SESSION['taisennsuu1'];
		$code += 0;
		$syouri1 += 1;
		$kyouka1 += 3;
		//いずれ絶対パスに書き換える
		require_once 'kannsuu.php';
		$new_level = level($taisennsuu);
		$_SESSION['new_level'] = $new_level;

	$dsn = 'mysql:dbname=LAA0352957-eibunnpou;host=mysql015.phy.lolipop.lan';
	$user = 'LAA0352957';
	$password = 'uke092mdv';
	$dbh = new PDO($dsn,$user,$password);
	$dbh->query('SET NAMES utf8');

	$sql = 'UPDATE `character` SET `kyouka`=?,`syouri`=?,`level`=? WHERE `code` =?';
	$stmt = $dbh->prepare($sql);
	$data[] = $kyouka1;
	$data[] = $syouri1;
	$data[] = $new_level;
	$data[] = $code;
	$stmt->execute($data);

	$dbh = null;
	}






	if ($_SESSION['message'] == 1){
		print <<< WIN
		<div id="message">
		{$_SESSION['name1']}
		は戦闘に勝利した！
		<br>
		</div>
		<form method="post" action="end_battle.php">
		<input class="btn" type="submit" value="次へ">
		</form>
WIN;
	}

	//レベルアップしたかどうかで処理を分岐
	if ($_SESSION['message'] == 2){
		if ($_SESSION['level1'] != $_SESSION['new_level']) {
			print <<< LEVEL_UP
			<div id="message">
			{$_SESSION['name1']}
			はレベルが
			{$_SESSION['new_level']}
			にあがった！
			</div>
			<form method="post" action="end_battle.php">
			<input class="btn" type="submit" value="次へ">
			</form>
LEVEL_UP;
		}else{
			$_SESSION['message'] += 1;
		}
	}

	//
	//必殺技追加テスト
	if ($_SESSION['message'] == 3){
		//初めてレベル3になったとき
		if ($_SESSION['new_level'] == 3 && $_SESSION['level1'] != $_SESSION['new_level']) {
			print <<< LEVEL_UP
			<div id="message">
			{$_SESSION['name1']}
			は必殺技を使用可能になった！
			</div>
			<form method="post" action="end_battle.php">
			<input class="btn" type="submit" value="次へ">
			</form>
LEVEL_UP;
		}else{
			$_SESSION['message'] += 1;
		}
	}
	//必殺技追加テスト
	//

	if ($_SESSION['message'] == 4){
		print <<< GET_KYOUKA
		<div id="message">
		強化ポイントを３ポイント手に入れた。
		</div>
		<form method="post" action="mypage.php">
		<input class="btn" type="submit" value="次へ">
		</form>
GET_KYOUKA;
		//$_SESSION[''],
//		unset($_SESSION['code'],$_SESSION['level'],$_SESSION['name1'],$_SESSION['hp1'],$_SESSION['max_hp1'],$_SESSION['level1'],$_SESSION['attack1'],$_SESSION['defense1'],$_SESSION['speed1'],$_SESSION['kyouka1']);
//		unset($_SESSION['taisennsuu1'],$_SESSION['syouri1'],$_SESSION['name2'],$_SESSION['hp2'],$_SESSION['max_hp2'],$_SESSION['level2'],$_SESSION[''],$_SESSION['attack2'],$_SESSION['defense2'],$_SESSION['speed2']);
//		unset($_SESSION['jyunn'],$_SESSION['kiso1'],$_SESSION['kiso2'],$_SESSION['turn'],$_SESSION['winner'],$_SESSION['message'],$_SESSION['new_level']);
	}
}



//戦闘に敗北した場合
if ($_SESSION['winner'] == 2) {
	if ($_SESSION['message'] == 1){
		print <<< LOSE
		<div id="message">
		{$_SESSION['name1']}
		は戦闘に敗北した…
		</div>
		<form method="post" action="mypage.php">
		<input class="btn" type="submit" value="次へ">
		</form>
LOSE;
		//$_SESSION[''],
		unset($_SESSION['code'],$_SESSION['level'],$_SESSION['name1'],$_SESSION['hp1'],$_SESSION['max_hp1'],$_SESSION['level1'],$_SESSION['attack1'],$_SESSION['defense1'],$_SESSION['speed1'],$_SESSION['kyouka1']);
		unset($_SESSION['taisennsuu1'],$_SESSION['syouri1'],$_SESSION['name2'],$_SESSION['hp2'],$_SESSION['max_hp2'],$_SESSION['level2'],$_SESSION[''],$_SESSION['attack2'],$_SESSION['defense2'],$_SESSION['speed2']);
		unset($_SESSION['jyunn'],$_SESSION['kiso1'],$_SESSION['kiso2'],$_SESSION['turn'],$_SESSION['winner'],$_SESSION['message']);
	}
}



$_SESSION['message'] += 1;
?>


</div>

</div>
</body>
</html>
