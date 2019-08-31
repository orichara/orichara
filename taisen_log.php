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
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>


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


$sql = "SELECT `name1`,`name2`,`winner`,`date`,`end_turn`,`damage1`,`damage2`,`kaihisuu1`,`kaihisuu2` FROM `result` WHERE 1 ORDER BY `number` DESC LIMIT 200";
//$data[] = $start;
$stmt = $db->prepare($sql);
$stmt->execute();

print '<table class="table-striped" border="1" width="100%" style="table-layout: auto;">';
print '<tr>';
print '<th bgcolor="#b0b0b0"><font color="#FFFFFF">挑戦者</font></th>';
print '<th bgcolor="#b0b0b0"><font color="#FFFFFF">対戦相手</font></th>';
print '<th bgcolor="#b0b0b0"><font color="#FFFFFF">勝者</font></th>';
print '<th bgcolor="#b0b0b0"><font color="#FFFFFF">対戦日時</font></th>';
print '<th bgcolor="#b0b0b0"><font color="#FFFFFF">終了ターン</font></th>';
print '<th bgcolor="#b0b0b0"><font color="#FFFFFF">最大与ダメージ</font></th>';
print '<th bgcolor="#b0b0b0"><font color="#FFFFFF">最大被ダメージ</font></th>';
print '<th bgcolor="#b0b0b0"><font color="#FFFFFF">攻撃をかわした数</font></th>';
print '<th bgcolor="#b0b0b0"><font color="#FFFFFF">攻撃をかわされた数</font></th>';
print '</tr>';

while(true){
	$rec = $stmt->fetch(PDO::FETCH_ASSOC);
	if($rec==false){
		break;
	}
	$name1 = $rec['name1'];
	$name2 = $rec['name2'];
	$winner = $rec['winner'];
	$date = $rec['date'];
	$end_turn = $rec['end_turn'];
	$max_damage1 = $rec['damage1'];
	$max_damage2 = $rec['damage2'];
	$kaihisuu1 = $rec['kaihisuu1'];
	$kaihisuu2 = $rec['kaihisuu2'];


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
	<td>$name1</td>
	<td>$name2</td>
	<td>$syousya</td>
	<td>$date</td>
	<td>$end_turn</td>
	<td>$max_damage1</td>
	<td>$max_damage2</td>
	<td>$kaihisuu1</td>
	<td>$kaihisuu2</td>
	</tr>
ETSURAN;
}
print '</table>';
$db = null;
?>

</div>


</body>
</html>