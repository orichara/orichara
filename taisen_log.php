<?php
require_once './function/common.php';
require_once './function/DbManager.php';
//ヘッダーを呼び出し
head();
?>
<link rel="stylesheet" type="text/css" href="main.css">
<title>オリキャラバトル</title>
</head>

<body>
	<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
		integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous">
	</script>


	<div class="col-12 boxB">
		<?php navvar(); ?>
		<br>
		<br>
		<br>
		<h1>対戦ログ（直近200戦）</h1>
		<?php
$db = getDb();

/* $countRecord = $db->prepare("SELECT COUNT(*) `code` FROM `result`");
$countRecord->execute();
$countRecord = $countRecord->fetchColumn(); */


$sql = "SELECT `code`,`rival_code`,`name1`,`name2`,`winner`,`date`,`end_turn`,`damage1`,`damage2`,`kaihisuu1`,`kaihisuu2` FROM `result` WHERE 1 ORDER BY `number` DESC LIMIT 200";
//$data[] = $start;
$stmt = $db->prepare($sql);
$stmt->execute();

print <<< table
<table class="table-striped" border="1" width="100%" style="table-layout: auto;">
<tr>
<th bgcolor="#b0b0b0"><font color="#FFFFFF">挑戦者</font></th>
<th bgcolor="#b0b0b0"><font color="#FFFFFF">対戦相手</font></th>
<th bgcolor="#b0b0b0"><font color="#FFFFFF">勝者</font></th>
<th bgcolor="#b0b0b0"><font color="#FFFFFF">対戦日時</font></th>
<th bgcolor="#b0b0b0"><font color="#FFFFFF">終了ターン</font></th>
<th bgcolor="#b0b0b0"><font color="#FFFFFF">最大与ダメージ</font></th>
<th bgcolor="#b0b0b0"><font color="#FFFFFF">最大被ダメージ</font></th>
<th bgcolor="#b0b0b0"><font color="#FFFFFF">攻撃をかわした数</font></th>
<th bgcolor="#b0b0b0"><font color="#FFFFFF">攻撃をかわされた数</font></th>
</tr>
table;

while (true) {
    $rec = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($rec==false) {
        break;
    }
    $code1 = $rec['code'];
    $code2 = $rec['rival_code'];
    $name1 = $rec['name1'];
    $name2 = $rec['name2'];
    $winner = $rec['winner'];
    $date = $rec['date'];

    if ($winner == 1) {
        $syousya = $name1 ;
    }
    if ($winner == 2) {
        $syousya = $name2 ;
    }

    //日付を変換
    $date = date('Y年n月j日g時i分', strtotime($date));

    print <<< ETSURAN
	<tr>
	<td><a href="chara_data.php?code={$code1}">$name1</a></td>
	<td><a href="chara_data.php?code={$code2}">$name2</a></td>
	<td>$syousya</td>
	<td>$date</td>
	<td>{$rec['end_turn']}</td>
	<td>{$rec['damage1']}</td>
	<td>{$rec['damage2']}</td>
	<td>{$rec['kaihisuu1']}</td>
	<td>{$rec['kaihisuu2']}</td>
	</tr>
ETSURAN;
}
print '</table>';
$db = null;
?>

	</div>
</body>

</html>