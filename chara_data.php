<?php
require_once './function/common.php';
require_once 'kannsuu.php';
require_once './function/DbManager.php';
//ヘッダーを呼び出し
head();

require_once 'shogo.php';

$code=$_GET['code'];
$page=$_GET['page'];

$db = getDb();

$sql = 'SELECT * FROM `character` WHERE `code`=?';
$stmt = $db->prepare($sql);
$data[] = $code;
$stmt->execute($data);

$rec = $stmt->fetch(PDO::FETCH_ASSOC);
?>

<link rel="stylesheet" type="text/css" href="chara_css/chara_data.css">
<link rel="shortcut icon" href="http://ori-chara.angry.jp/sozai/fav/tmfav04905.ico" type="image/vnd.microsoft.icon">
<title><?php print "$rec[name]";?> キャラクター図鑑 </title>
</head>
<body>
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>

<br>
<br>
<?php 
containar(); 
navvar();

$url = rec['url'];
print <<<STATUS
<div class="col-12" ID="Z">
<br>
<br>
<div class="row">
<div class="col-6">
<img class="img-thumbnail" src="./chara_image/$rec[image_url]" widrh="100em" height="100em" id="image">
<br>
<br>
</div>
<br>
<div class="col-5 rounded bg-light" id="boxC">
STATUS;

require_once './function/status.php';


print "</div>";

?>


<div class="col-12" id="boxD">
<?php
$about = htmlspecialchars($rec['about']);
//文字数の長さを取得して枠の中に納まるようにする
$mojisuu = mb_strlen ($about,UTF8);
if ($mojisuu >= 150 && $mojisuu <= 199) {
	$moji_size = "1";
}elseif ($mojisuu >= 200 && $mojisuu <= 299){
	$moji_size = "2";
}elseif ($mojisuu >= 300 && $mojisuu <= 600){
	$moji_size = "3";
}else{
	$moji_size = null;
}
print '<div class="col-12" id="message'.$moji_size.'">';
print $about;
//キャラクターの説明文がない場合
if ($about == null){
	print 'このキャラクターの説明文はまだありません';
}

print <<<ABOUT
<br>
</div>
製作者URL：<a href="${rec['url']}">${rec['url']}</a>
<br>
作成日：${rec['sakuseibi']}
<br>
<br>
<div>タグ一覧<br></div>
ABOUT;

//
//タグ一覧
for ($i = 1; $i <= 10; $i++){
	print "<a href=chara_serch.php?word={$rec["tag$i"]}&type=3page=$show_page>{$rec["tag$i"]}  </a>";
}


//称号一覧
print '<div ID="shogo">獲得称号一覧<br>';

//対戦数
$taisennsuu = taisennsuu($rec['taisennsuu']);
$taisennsuu_rank = taisennsuu_rank($rec['taisennsuu']);
if ($taisennsuu != null) {
	print '<div class="'.$taisennsuu_rank.'">'.$taisennsuu.'</div>';
}
//勝利数
$syourisuu = syourisuu($rec['syouri']);
$syourisuu_rank = syourisuu_rank($rec['syouri']);
if ($syourisuu != null) {
	print '<div class="'.$syourisuu_rank.'">'.$syourisuu.'</div>';
}
//攻撃力
$kougekiryoku = kougekiryoku($rec['attack']);
$kougekiryoku_rank = kougekiryoku_rank($rec['attack']);
if ($kougekiryoku != null) {
	print '<div class="'.$kougekiryoku_rank.'">'.$kougekiryoku.'</div>';
}
//防御力
$bougyoryoku = bougyoryoku($rec['defense']);
$bougyoryoku_rank = bougyoryoku_rank($rec['defense']);
if ($bougyoryoku != null) {
	print '<div class="'.$bougyoryoku_rank.'">'.$bougyoryoku.'</div>';
}
//素早さ
$subayasa = subayasa($rec['speed']);
$subayasa_rank = subayasa_rank($rec['speed']);
if ($subayasa != null) {
	print '<div class="'.$subayasa_rank.'">'.$subayasa.'</div>';
}
//勝率
$syouritu = syouritu($rec['taisennsuu'],$rec['syouri']);
$syouritu_rank = syouritu_rank($rec['taisennsuu'],$rec['syouri']);
if ($syouritu != null) {
	print '<div class="'.$syouritu_rank.'">'.$syouritu.'</div>';
}
//バランス
$barannsu = barannsu($rec['attack'],$rec['defense'],$rec['speed']);
$barannsu_rank = barannsu_rank($rec['attack'],$rec['defense'],$rec['speed']);
if ($barannsu != null) {
	print '<div class="'.$barannsu_rank.'">'.$barannsu.'</div>';
}

print '</div>';
?>
<p>最近の対戦成績</p>
相手に勝負を仕掛けた試合
<?php
require_once './function/DbManager.php';
$db = getDb();
$sql = "SELECT `name1`,`rival_code`,`name2`,`winner`,`date`,`end_turn` FROM `result` WHERE `code`=? ORDER BY `number` DESC LIMIT 5";
$data1[] = $code;
$stmt = $db->prepare($sql);
$stmt->execute($data1);

print <<<SEISEKI
<table class="table table-bordered table-dark">
<tr>
<th width="30%">対戦相手</th>
<th width="20%">結果</th>
<th width="30%">対戦日時</th>
<th width="20%">終了ターン</th>
</tr>
SEISEKI;


while(true){
	$rec = $stmt->fetch(PDO::FETCH_ASSOC);
	if($rec==false){
		break;
	}
	$name2 = $rec['name2'];
	$rival_code= $rec['rival_code'];
	$winner = $rec['winner'];
	$date = $rec['date'];
	$end_turn = $rec['end_turn'];

	$taisenn_aite = $rec['name2'];

	if ($winner == 1) {
		$syousya = "勝利";
	}
	if ($winner == 2) {
		$syousya = "敗北";
	}

	//日付を変換
	$date = date('Y年n月j日g時i分', strtotime($date));

	print <<< ETSURAN
	<tr>
	<td><a href="http://ori-chara.angry.jp/chara_data.php?code=$rival_code">$taisenn_aite</a></td>
	<td>$syousya</td>
	<td>$date</td>
	<td>$end_turn</td>
	</tr>
ETSURAN;
}
print '</table><br>相手に勝負を挑まれた試合';

$sql = "SELECT `code`,`name1`,`name2`,`winner`,`date`,`end_turn` FROM `result` WHERE `rival_code`=? ORDER BY `number` DESC LIMIT 5";
$data2[] = $code;
$stmt = $db->prepare($sql);
$stmt->execute($data2);

print <<<SEISEKI
<table class="table table-bordered table-dark">
<tr>
<th width="30%">対戦相手</th>
<th width="20%">結果</th>
<th width="30%">対戦日時</th>
<th width="20%">終了ターン</th>
</tr>
SEISEKI;


while(true){
	$rec = $stmt->fetch(PDO::FETCH_ASSOC);
	if($rec==false){
		break;
	}
	$name2 = $rec['name2'];
	$code2 = $rec['code'];
	$winner = $rec['winner'];
	$date = $rec['date'];
	$end_turn = $rec['end_turn'];
	//相手に勝負を挑んだ場合と異なる。自分が対戦相手。
	$taisenn_aite = $rec['name1'];

	if ($winner == 1) {
		$syousya = "敗北";
	}
	if ($winner == 2) {
		$syousya = "勝利";
	}

	//日付を変換
	$date = date('Y年n月j日g時i分', strtotime($date));

	print <<< ETSURAN
	<tr>
	<td><a href="http://ori-chara.angry.jp/chara_data.php?code=$code2">$taisenn_aite</a></td>
	<td>$syousya</td>
	<td>$date</td>
	<td>$end_turn</td>
	</tr>
ETSURAN;
}
print '</table>';

$db = null;

?>
<br>

  <a href="detail<?php print "?code=$code";?>" class="col-12 list-group-item list-group-item-action list-group-item-secondary">詳細データ</a>

<br>
<a href="https://twitter.com/share?ref_src=twsrc%5Etfw" class="twitter-share-button" data-text="<?php print "キャラクター名：".$name." レベル：".$level." 攻撃力：".$attack." 防御力：".$defence." 必殺技：".$hissatsu1." 説明：".$about;?>" data-show-count="false">Tweet</a><script async src="https://platform.twitter.com/widgets.js" charset="utf-8"></script>
</div>
</div>
<div>
<br>


</div>
</div>
<br>
</body>
</html>