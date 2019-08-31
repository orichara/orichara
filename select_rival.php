<?php
session_start();
if (isset($_SESSION['login'])==false){
	print 'ログインされていません。<br />';
	print '<a href="chara_page.php">ログイン画面へ</a>';
	exit();
}
?>

<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link rel="stylesheet" type="text/css" href="select_rival.css">
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js" integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js" integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k" crossorigin="anonymous"></script>
<title>対戦相手を選択してください</title>
</head>
<body>
<audio src="./music/vow-wow.mp3"  autoplay loop></audio>
<div ID="container">
<div id="boxB">
<?php
//テストしたらすぐ消す
$level = $_SESSION['level'];
$code = $_SESSION['code'];


$max_level = $level;
$max_level += 10;
$min_level = $level;
$min_level -= 10;


require_once './function/DbManager.php';
$db = getDb();

$sql = 'SELECT `code`,`name`,`image_url`,`level` FROM `character` WHERE `level`>=? AND `level`<=? AND `code`!=? ORDER BY `code` DESC LIMIT 20';
$stmt = $db->prepare($sql);
$data[] = $min_level;
$data[] = $max_level;
$data[] = $code;
$stmt->execute($data);

$db = null;


print <<< SELECT
<p class="select">STOPボタンを押してください。</p>
<br>
SELECT;

//ここからテーブル
$count_rival = 0;
$chara_code = array();
$chara_name = array();
$chara_level = array();
$chara_image_url = array();

print '<div class="waku"><p id="isChara"></p></div><br><br>';
while(true){
	$rec = $stmt->fetch(PDO::FETCH_ASSOC);
	if($rec==false){
		break;
	}
	$rec['image_url'] = htmlspecialchars($rec['image_url']);
	$rec['name'] = htmlspecialchars($rec['name']);


	$current_image = '<img class="border border-primary" border="4" src="./chara_image/'.$rec['image_url'].'" width="100" height="100">';

	print $current_image;

	array_push($chara_code,$rec['code']);
	array_push($chara_name,$rec['name']);
	array_push($chara_level,$rec['level']);
	array_push($chara_image_url,$current_image);
	$count_rival ++;
}



//javascriptに配列受け渡し
$java_code = json_encode($chara_code);
$java_name = json_encode($chara_name);
?>

<div class="buttons">
<br>
<br>
<br>
<button id="stop" onClick="clickedStop()">STOP</button>
</div>

<br>
<br>
<br>

</div>
</div>
<script>
//変数宣言
var chara = '';
var intervalID = -1;
var rival_code = [];
var rival_name = [];

var rival_code = JSON.parse('<?php echo $java_code; ?>');
var rival_name = JSON.parse('<?php echo $java_name; ?>');

//ルーレットスタート
'use strict';
intervalID = setInterval(function() {
		select = Math.floor( Math.random() * rival_name.length )
        chara = rival_name[select];
		code = rival_code[select];
        document.getElementById("isChara").innerHTML = chara;
}, 100);

// ストップボタンを押した時の処理
function clickedStop() {
    'use strict';
    clearTimeout(intervalID);
    //音を鳴らす
    var audio = new Audio("http://ori-chara.angry.jp/se/decision26.mp3");
	audio.play();
// 結果を画面に表示
    document.getElementById("isChara").innerHTML = chara;
    document.getElementById("stop").innerHTML = code;
    var destination = '/battle.php?rival_code=' + code;
    window.location.href = destination;
}
</script>
</body>
</html>
