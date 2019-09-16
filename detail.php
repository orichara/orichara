<?php
require_once './function/common.php';
require_once 'kannsuu.php';
require_once './function/DbManager.php';
//ヘッダーを呼び出し
head();
?>
<link rel="stylesheet" type="text/css" href="https://angry-ori-chara.ssl-lolipop.jp/chara_css/chara_data.css">
<link rel="shortcut icon" href="https://angry-ori-chara.ssl-lolipop.jp/sozai/fav/tmfav04905.ico"
	type="image/vnd.microsoft.icon">
<title>キャラクター図鑑</title>
</head>

<body>
	<br>
	<br>
	<?php
containar(); navvar();
require_once 'shogo.php';


$code=$_GET['code'];
$page=$_GET['page'];

$db = getDb();

$sql = 'SELECT * FROM `character` WHERE `code`=?';
$stmt = $db->prepare($sql);
$data[] = $code;
$stmt->execute($data);

$rec = $stmt->fetch(PDO::FETCH_ASSOC);
$db = null;


print <<<STATUS
<div class="col-12" ID="Z">
<br>
<br>
<br>
<div class="row">
<div class="col-6">
<img class="img-thumbnail" src="https://angry-ori-chara.ssl-lolipop.jp/chara_image/$rec[image_url]" widrh="100em" height="100em" id="image">
<br>
<br>
</div>
<br>
<div class="col-5 ml-5 rounded bg-light" id="boxC">
STATUS;

require_once './function/status.php';

print <<<ABOUT
</div>
</div>
ABOUT;
?>



	<?php
require_once './function/DbManager.php';
$db = getDb();
$sql = "SELECT `name1`,`name2`,`rival_code`,`winner`,`date`,`end_turn`,`damage1`,`damage2`,`kaihisuu1`,`kaihisuu2` FROM `result` WHERE `code`=? ORDER BY `number`";
$data1[] = $code;
$stmt = $db->prepare($sql);
$stmt->execute($data1);

while (true) {
    $rec = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($rec==false) {
        break;
    }
    $name2[] = $rec['name2'];
    $winner[] = $rec['winner'];
    $date[] = $rec['date'];
    $end_turn[] = $rec['end_turn'];
    $damage1[] = $rec['damage1'];
    $damage2[] = $rec['damage2'];
    $kaihisuu1[] = $rec['kaihisuu1'];
    $kaihisuu2[] = $rec['kaihisuu2'];
}

$db = null;


//経過ターン
$keika = array_sum($end_turn);

//相手に勝負を挑んだ数
$idomiA = count($winner);

//総合の勝率
$syouritu_total = round($syouri/$taisennsuu*100, 1);

//相手に勝負を挑んだ時の勝率
$syoubuA= array_count_values($winner);
//連想配列を昇順で並び替え
ksort($syoubuA);
//ループ処理でプレーヤーから勝負を挑んだ時の勝利数と敗北数を取り出す
foreach ($syoubuA as $keyZ => $valueZ) {
    if ($keyZ == 1) {
        $syourisuuA = $valueZ;
    }
    if ($keyZ == 2) {
        $syourisuuB = $valueZ;
    }
}
$syourituA = round($syourisuuA/($syourisuuA+$syourisuuB)*100, 1);

//累計与ダメージと被ダメージ
$total_damage1 = array_sum($damage1);
$total_damage2 = array_sum($damage2);

//平均与ダメージと被ダメージ
$average_damage1 = round(array_sum($damage1)/count($damage1), 1);
$average_damage2 = round(array_sum($damage2)/count($damage2), 1);

//最大与ダメージと被ダメージ
$max_damage1 = max($damage1);
$max_damage2 = max($damage2);

//累計回避回数と回避された回数
$total_kaihisuu1 = array_sum($kaihisuu1);
$total_kaihisuu2 = array_sum($kaihisuu2);

//一戦での平均回避回数
$average_kaihi1 = round(array_sum($kaihisuu1)/count($kaihisuu1), 1);
$average_kaihi2 = round(array_sum($kaihisuu2)/count($kaihisuu2), 1);

//一戦での最大回避回数
$max_kaihi1 = max($kaihisuu1);
$max_kaihi2 = max($kaihisuu2);

//キャラごとの対戦数をカウント
$rival_count = array_count_values($name2);
//連想配列を降順で並び替え
arsort($rival_count);
//戦ったオリキャラの数
$kazu = count($rival_count);

//
//ここから表示部分

// 経過ターン：{$keika}ターン<br>
// 相手に勝負を挑んだ数：{$idomiA}試合<br>
// 勝率（総合）{$syouritu_total}%<br>
// 相手に勝負を挑んだ時の勝率：{$syourituA}%<br>
// 累計与ダメージ：{$total_damage1}<br>
// 累計被ダメージ：{$total_damage2}<br>
// 平均与ダメージ：{$average_damage1}<br>
// 平均被ダメージ：{$average_damage2}<br>
// 最大与ダメージ：{$max_damage1}<br>
// 最大被ダメージ：{$max_damage2}<br>
// 累計攻撃回避数：{$total_kaihisuu1}<br>
// 累計攻撃失敗数：{$total_kaihisuu2}<br>
// 一試合での平均攻撃回避数：{$average_kaihi1}<br>
// 一試合での平均攻撃失敗数：{$average_kaihi2}<br>
// 一試合での最大攻撃回避数：{$max_kaihi1}<br>
// 一試合での最大攻撃失敗数：{$max_kaihi2}<br>
// 対戦したことのあるオリキャラの数：{$kazu}種類<br><br>
print <<< DETAIL
<br>
<table class="col-10 mx-auto table table-bordered table-dark">
  </thead>
    <tr>
      <td>経過ターン</td>
      <td>{$keika}ターン</td>
    </tr>
    <tr>
      <td>相手に勝負を挑んだ数</td>
      <td>{$idomiA}試合</td>
	</tr>
	<tr>
		<td>勝率（総合）</td>
		<td>{$syouritu_total}%</td>
	</tr>
	<tr>
		<td>相手に勝負を挑んだ時の勝率</td>
		<td>{$syourituA}%</td>
	</tr>
	<tr>
		<td>累計与ダメージ</td>
		<td>{$total_damage1}</td>
	</tr>
	<tr>
		<td>累計被ダメージ</td>
		<td>{$total_damage2}</td>
	</tr>
	<tr>
		<td>平均与ダメージ</td>
		<td>{$average_damage1}</td>
	</tr>
	<tr>
		<td>平均被ダメージ</td>
		<td>{$average_damage2}</td>
	</tr>
	<tr>
		<td>最大与ダメージ</td>
		<td>{$max_damage1}</td>
	</tr>
	<tr>
		<td>最大被ダメージ</td>
		<td>{$max_damage2}</td>
	</tr>
	<tr>
		<td>累計攻撃回避数</td>
		<td>{$total_kaihisuu1}</td>
	</tr>
	<tr>
		<td>累計攻撃失敗数</td>
		<td>{$total_kaihisuu2}</td>
	</tr>
	<tr>
		<td>一試合での平均攻撃回避数</td>
		<td>{$average_kaihi1}</td>
	</tr>
	<tr>
		<td>一試合での平均攻撃失敗数</td>
		<td>{$average_kaihi2}</td>
	</tr>
	<tr>
		<td>一試合での最大攻撃回避数</td>
		<td>{$max_kaihi1}</td>
	</tr>
	<tr>
		<td>一試合での最大攻撃失敗数</td>
		<td>{$max_kaihi2}</td>
	</tr>
	<tr>
		<td>対戦したことのあるオリキャラの数</td>
		<td>{$kazu}種類</td>
	</tr>
</table>
<br>
DETAIL;
print <<< TAISENNSUU
対戦数の多い相手best10：
<br>
<table class="col-10 mx-auto table table-bordered table-dark">
TAISENNSUU;
$count =0;
foreach ($rival_count as $key => $value) {
    if ($count < 10) {
        print "<tr><td>対戦数：{$value}</td><td>相手：{$key}</td></tr>";
    }
    $count +=1;
}
print '</table>';
?>

	<br>
	<div class="col-3 list-group">
		<a href="chara_zukan<?php print "?code=$code&page=$page";?>"
			class="list-group-item list-group-item-action list-group-item-secondary">図鑑に戻る</a>
	</div>
	<br>

	</div><!-- container_end -->
</body>

</html>