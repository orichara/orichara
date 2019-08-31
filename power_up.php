<?php
session_start();
if (isset($_SESSION['login'])==false){
	print 'ログインされていません。<br />';
	print '<a href="chara_page.php">ログイン画面へ</a>';
	exit();
}else {
}
?>

<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link rel="stylesheet" type="text/css" href="chara_css/power_up.css">
<link rel="stylesheet" type="text/css" href="https://angry-ori-chara.ssl-lolipop.jp/chara_css/common2.css">
<title>キャラクター強化</title>
</head>
<body>
<div ID="container">
<div id="wrapper">
<div id="boxB">
<?php
require_once 'kannsuu.php';

$name=$_SESSION['name'];
$pass=$_SESSION['pass'];

require_once './function/DbManager.php';
$db = getDb();

if (isset($_POST['up'])){
	$select = $_POST['up'];
	switch ($select){
		case 'hp_up':
			//能力を上げるために必要な教科ポイントが足りるか計算
			if ($_SESSION['kyouka'] < $_SESSION['hitsuyou_hp']) {
				print '<span id="kyouka">必要な強化ポイントが足りません</span><br>';
			}else{
				$_SESSION['hp_up'] += 1;
				$_SESSION['kyouka'] -= $_SESSION['hitsuyou_hp'];
				$sql = 'UPDATE `character` SET `hp`=?,`kyouka`=? WHERE `code` =?';
				$stmt = $db->prepare($sql);
				$data1[] = $_SESSION['hp_up'];
				$data1[] = $_SESSION['kyouka'];
				$data1[] = $_SESSION['code_up'];
				$stmt->execute($data1);
			}
			break;

		case 'attack_up':
			//能力を上げるために必要な教科ポイントが足りるか計算
			if ($_SESSION['kyouka'] < $_SESSION['hitsuyou_attack']) {
				print '<span id="kyouka">必要な強化ポイントが足りません</span><br>';
			}else{
				$_SESSION['attack_up'] += 1;
				$_SESSION['kyouka'] -= $_SESSION['hitsuyou_attack'];
				$sql = 'UPDATE `character` SET `attack`=?,`kyouka`=? WHERE `code` =?';
				$stmt = $db->prepare($sql);
				$data1[] = $_SESSION['attack_up'];
				$data1[] = $_SESSION['kyouka'];
				$data1[] = $_SESSION['code_up'];
				$stmt->execute($data1);
			}
			break;

		case 'defense_up':
			//能力を上げるために必要な教科ポイントが足りるか計算
			if ($_SESSION['kyouka'] < $_SESSION['hitsuyou_defense']) {
				print '<span id="kyouka">必要な強化ポイントが足りません</span><br>';
			}else{
				$_SESSION['defense_up'] += 1;
				$_SESSION['kyouka'] -= $_SESSION['hitsuyou_defense'];
				$sql = 'UPDATE `character` SET `defense`=?,`kyouka`=? WHERE `code` =?';
				$stmt = $db->prepare($sql);
				$data1[] = $_SESSION['defense_up'];
				$data1[] = $_SESSION['kyouka'];
				$data1[] = $_SESSION['code_up'];
				$stmt->execute($data1);
			}
			break;

		case 'speed_up':
			//能力を上げるために必要な教科ポイントが足りるか計算
			if ($_SESSION['kyouka'] < $_SESSION['$hitsuyou_speed']) {
				print '<span id="kyouka">必要な強化ポイントが足りません</span><br>';
			}else{
				$_SESSION['speed_up'] += 1;
				$_SESSION['kyouka'] -= $_SESSION['$hitsuyou_speed'];
				$sql = 'UPDATE `character` SET `speed`=?,`kyouka`=? WHERE `code` =?';
				$stmt = $db->prepare($sql);
				$data1[] = $_SESSION['speed_up'];
				$data1[] = $_SESSION['kyouka'];
				$data1[] = $_SESSION['code_up'];
				$stmt->execute($data1);
			}
			break;

		case '2001':
			//能力を上げるために必要な教科ポイントが足りるか計算
			if ($_SESSION['kyouka'] < 100) {
				print '<span id="kyouka">必要な強化ポイントが足りません</span><br>';
			}else{
				$_SESSION['kyouka'] -= 100;
				$sql = 'UPDATE `character` SET `tokusyu1`=?,`kyouka`=? WHERE `code` =?';
				$stmt = $db->prepare($sql);
				$data1[] = "2001";
				$data1[] = $_SESSION['kyouka'];
				$data1[] = $_SESSION['code_up'];
				$stmt->execute($data1);
			}
			break;

		case '2002':
			//能力を上げるために必要な教科ポイントが足りるか計算
			if ($_SESSION['kyouka'] < 120) {
				print '<span id="kyouka">必要な強化ポイントが足りません</span><br>';
			}else{
				$_SESSION['kyouka'] -= 120;
				$sql = 'UPDATE `character` SET `tokusyu1`=?,`kyouka`=? WHERE `code` =?';
				$stmt = $db->prepare($sql);
				$data1[] = "2002";
				$data1[] = $_SESSION['kyouka'];
				$data1[] = $_SESSION['code_up'];
				$stmt->execute($data1);
			}
			break;

		case '2003':
		//能力を上げるために必要な教科ポイントが足りるか計算
			if ($_SESSION['kyouka'] < 250) {
				print '<span id="kyouka">必要な強化ポイントが足りません</span><br>';
			}else{
				$_SESSION['kyouka'] -= 250;
				$sql = 'UPDATE `character` SET `tokusyu1`=?,`kyouka`=? WHERE `code` =?';
				$stmt = $db->prepare($sql);
				$data1[] = "2003";
				$data1[] = $_SESSION['kyouka'];
				$data1[] = $_SESSION['code_up'];
				$stmt->execute($data1);
			}
		break;
	}
}

//必殺技名が入力されたらデータベースに登録
if (isset($_POST['hissatsu1'])){
	$set_hissatsu1 = $_POST['hissatsu1'];
	//必殺技をデータベースに登録
	$sql = 'UPDATE `character` SET `hissatsu1`=? WHERE `code` =?';
	$stmt = $db->prepare($sql);
	$data1[] = $set_hissatsu1;
	$data1[] = $_SESSION['code_up'];
	$stmt->execute($data1);
}

//超必殺技名が入力されたらデータベースに登録
if (isset($_POST['hissatsu2'])){
	$set_hissatsu2 = $_POST['hissatsu2'];
	//必殺技をデータベースに登録
	$sql = 'UPDATE `character` SET `hissatsu2`=? WHERE `code` =?';
	$stmt = $db->prepare($sql);
	$data1[] = $set_hissatsu2;
	$data1[] = $_SESSION['code_up'];
	$stmt->execute($data1);
}

//特殊能力名が入力されたらデータベースに登録
if (isset($_POST['tokusyu1'])){
	$set_tokusyu1 = $_POST['tokusyu1'];
	//必殺技をデータベースに登録
	$sql = 'UPDATE `character` SET `tokusyu1`=? WHERE `code` =?';
	$stmt = $db->prepare($sql);
	$data1[] = $set_tokusyu1;
	$data1[] = $_SESSION['code_up'];
	$stmt->execute($data1);
}


$sql = 'SELECT * FROM `character` WHERE `name`=? AND `password`=?';
$stmt = $db->prepare($sql);
$data[] = $name;
$data[] = $pass;
$stmt->execute($data);

$rec = $stmt->fetch(PDO::FETCH_ASSOC);

$code = $rec['code'];
$hp = $rec['hp'];
$attack = $rec['attack'];
$defense = $rec['defense'];
$speed = $rec['speed'];
$kyouka = $rec['kyouka'];
$level = $rec['level'];
$hissatsu1 = $rec['hissatsu1'];
$hissatsu2 = $rec['hissatsu2'];
$tokusyu1 = $rec['tokusyu1'];

$_SESSION['kyouka'] = $kyouka;
$_SESSION['code_up'] = $code;
$_SESSION['hp_up'] = $hp;
$_SESSION['attack_up'] = $attack;
$_SESSION['defense_up'] = $defense;
$_SESSION['speed_up'] = $speed;
$_SESSION['tokusyu1'] = $tokusyu1;

$db = null;

//経験値アップに必要なポイントをセット
$_SESSION['hitsuyou_hp'] = hp($hp,$tokusyu1);
$_SESSION['hitsuyou_attack'] = attack($attack,$tokusyu1);
$_SESSION['hitsuyou_defense'] = defense($defense,$tokusyu1);
$_SESSION['$hitsuyou_speed'] = speed($speed,$tokusyu1);

print <<< KYOUKA
<span id="kyouka">所持強化ポイント：$kyouka</span>
<br>
<br>
KYOUKA;
print '<div ID="table">';
//1列目
print <<< LINE1
<table border="1" width="90%" style="font-size : 20px; text-align: center; font-family:arial;">
<tr>
<th bgcolor="#3399FF" width="300"><font color="#FFFFFF"></font></th>
<th bgcolor="#3399FF" width="200"><font color="#FFFFFF">HP</font></th>
<th bgcolor="#3399FF" width="200"><font color="#FFFFFF">攻撃力</font></th>
<th bgcolor="#3399FF" width="200"><font color="#FFFFFF">防御力</font></th>
<th bgcolor="#3399FF" width="200"><font color="#FFFFFF">素早さ</font></th>
</tr>
LINE1;

//2列目
print <<< LINE2
<tr>
<td bgcolor="#CCFFFF">
現在の能力
</td>
<td bgcolor="#CCFFFF">
$hp
</td>
<td bgcolor="#CCFFFF">
$attack
</td>
<td bgcolor="#CCFFFF">
$defense
</td>
<td bgcolor="#CCFFFF">
$speed
</td>
</tr>
LINE2;

//3列目
//
print <<< LINE3
<tr>
<td bgcolor="#CCFFFF">
必要ポイント
</td>
<td bgcolor="#CCFFFF">
{$_SESSION['hitsuyou_hp']}
</td>
<td bgcolor="#CCFFFF">
{$_SESSION['hitsuyou_attack']}
</td>
<td bgcolor="#CCFFFF">
{$_SESSION['hitsuyou_defense']}
</td>
<td bgcolor="#CCFFFF">
{$_SESSION['$hitsuyou_speed']}
</td>
</tr>
</table>
LINE3;
print '</div>';//tableの終わり

print <<< BUTTON
<br>
<br>
<br>
<form method="post" action="power_up.php">
<input type="hidden" name="up" value="hp_up">
<input class="btn" type="submit" onClick="clicked()" value="HPを強化！">
</form>
<br>
<form method="post" action="power_up.php">
<input type="hidden" name="up" value="attack_up">
<input class="btn" type="submit" onClick="clicked()" value="攻撃力を強化！">
</form>
<br>
<form method="post" action="power_up.php">
<input type="hidden" name="up" value="defense_up">
<input class="btn" type="submit" onClick="clicked()" value="防御力を強化！">
</form>
<br>
<form method="post" action="power_up.php">
<input type="hidden" name="up" value="speed_up">
<input class="btn" type="submit" onClick="clicked()" value="素早さを強化！">
</form>
<br>
<br>
<br>
<br>
特殊能力を覚える（すでにある特殊能力は上書きされます）
<form method="post" action="power_up.php">
<input type="hidden" name="up" value="2001">
<input class="btn" type="submit" onClick="clicked()" value="先手必勝（100ポイント）">
</form>
<form method="post" action="power_up.php">
<input type="hidden" name="up" value="2002">
<input class="btn" type="submit" onClick="clicked()" value="自己再生（120ポイント）">
</form>
<form method="post" action="power_up.php">
<input type="hidden" name="up" value="2003">
<input class="btn" type="submit" onClick="clicked()" value="疾風怒涛（250ポイント）">
</form>
BUTTON;


if ($level >=3 && $hissatsu1 == null) {
print <<< NAME_HISSATSU1
必殺技に名前を付けてください
<br>
<form method="post" action="power_up.php">
<input type="text" name="hissatsu1" size="20">
<input class="" type="submit" value="必殺技を登録！">
</form>
NAME_HISSATSU1;
}

if ($level >=20 && $hissatsu2 == null) {
	print <<< NAME_HISSATSU2
	超必殺技に名前を付けてください
	<br>
	<form method="post" action="power_up.php">
	<input type="text" name="hissatsu2" size="20">
	<input class="" type="submit" value="超必殺技を登録！">
	</form>
NAME_HISSATSU2;
}

if ($level >=5 && $tokusyu1 == "0") {
print <<<TOKUSYU1
特殊能力を選んでください。
<br>
<form method="post" action="power_up.php">
<select name="tokusyu1">
<option value="1001">驚異の生命力※HPを上げるのに必要な経験値が下がります。</option>
<option value="1002">狂戦士※攻撃力を上げるのに必要な経験値が下がります。</option>
<option value="1003">鉄壁※防御力を上げるのに必要な経験値が下がります。</option>
<option value="1004">韋駄天※素早さを上げるのに必要な経験値が下がります。</option>
</select>
<input class="" type="submit" value="特殊能力を登録！">
</form>
TOKUSYU1;

}
?>
<br>
<a href="mypage.php">マイページに戻る</a>
<br />


</div>
<div id="boxC">
</div>
</div>

</div>
<script>
function clicked() {
    //音を鳴らす
    var audio = new Audio("http://ori-chara.angry.jp/se/decision17.mp3");
    audio.play();
}
</script>
</body>
</html>