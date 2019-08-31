<?php
session_start();
if (isset($_SESSION['login'])==false){
	print 'ログインされていません。<br />';
	print '<a href="chara_page.php">ログイン画面へ</a>';
	exit();
}

$code = $_SESSION['code'];
$rival_code = $_GET['rival_code'];


require_once 'kannsuu.php';
require_once './function/DbManager.php';
$db = getDb();

//自分と対戦相手のステータスを取得
$sql = 'SELECT * FROM `character` WHERE `code`=?';
$stmt = $db->prepare($sql);
$data[] = $code;
$stmt->execute($data);

$rec = $stmt->fetch(PDO::FETCH_ASSOC);
//$rec[''];
$name1 = $rec['name'];
$level1 = $rec['level'];
$hp1 = $rec['hp'];
$image1 = $rec['image_url'];
$attack1 = $rec['attack'];
$defense1 = $rec['defense'];
$speed1 = $rec['speed'];
$kyouka1 = $rec['kyouka'];
$taisennsuu1 = $rec['taisennsuu'];
$syouri1 = $rec['syouri'];
$hissatsu1 = $rec['hissatsu1'];
$hissatsu2 = $rec['hissatsu2'];
$tokusyu1 = $rec['tokusyu1'];
$taisennsuu1 += 1;

//1のsessionにデータを放り込む
$max_hp1 = $hp1;
$image_url1 = $image1;

$sql = 'SELECT * FROM `character` WHERE `code`=?';
$stmt = $db->prepare($sql);
$data1[] = $rival_code;
$stmt->execute($data1);

$rec = $stmt->fetch(PDO::FETCH_ASSOC);
$name2 = $rec['name'];
$level2 = $rec['level'];
$hp2 = $rec['hp'];
$image2 = $rec['image_url'];
$attack2 = $rec['attack'];
$defense2 = $rec['defense'];
$speed2 = $rec['speed'];
$kyouka2 = $rec['kyouka'];
$taisennsuu2 = $rec['taisennsuu'];
$syouri2 = $rec['syouri'];
//プレーヤーBの必殺技はA,B,C・・・と続ける
$hissatsuA = $rec['hissatsu1'];
$hissatsuB = $rec['hissatsu2'];
$tokusyuA = $rec['tokusyu1'];
$taisennsuu2 += 1;

//最大HPとは別に現在のHPを設定
$max_hp2 = $hp2;

//戦う相手がいない場合は処理を終える
if ($name2 === null) {
	print '現在は対戦できる相手がいません。<br><a href="https://angry-ori-chara.ssl-lolipop.jp/mypage.php">戻る</a>';
	exit;
}

//ここから戦闘開始
//
//
//

//配列をセット
$kakunou_text = array();
$kakunou_damage1 = array();
$kakunou_damage2 = array();
$kakunou_hp1 = array();
$kakunou_hp2 = array();
$kakunou_kaihi1 = array();
$kakunou_kaihi2 = array();
$kakunou_koukaon = array();

//最初に巡をセット
$jyunn = 0;

//1巡目のテキストを表示
$text = "{$name2}が勝負を仕掛けてきた！";
array_push($kakunou_text,$text);

//両プレーヤーの基礎攻撃力を計算
$attack1 -= $defense2;
$kiso1 = $attack1;
//最低でも基礎攻撃力は1にする
if ($kiso1 <= 1){
	$kiso1 = 1;
}
$attack2 -= $defense1;
$kiso2 = $attack2;
if ($kiso2 <= 1){
	$kiso2 = 1;
}

//先制後攻を決める。この後攻守切り替えがあるためスピードの遅いほうをセットしておく。
$turn = sennseikougeki($speed1,$speed2,$tokusyu1,$tokusyuA);

//戦闘が継続している場合
while ($hp1 > 0 && $hp2 > 0){
	$jyunn +=1;

	//攻守交代
	if ($turn == a) {
		$turn = b;
	}else{
		$turn = a;
	}
	if ($jyunn >= 3) {
		$turn = sippuudotou($turn,$tokusyu1,$tokusyuA);
	}
	jikosaisei($tokusyu1,$tokusyuA);

	if ($turn == a) {
		//必殺技を覚えているか確認して抽選
		$waza = tyuusenn_hissatsu($hissatsu1,$hissatsu2);
		//技を表示するための変数を用意
		switch ($waza){
			case '1':
				$waza_hyoujiA = '攻撃';
				break;
			case '2':
				$waza_hyoujiA = $hissatsu1;
				break;
			case '3':
				$waza_hyoujiA = $hissatsu2;
				break;
		}
		//技が命中するかどうかを求める
		$meityuu = keisann_kaihi($speed2,$speed1);
		if ($meityuu == 1) {
			//通常攻撃や必殺技の威力を求める
			$A = keisann_iryoku($waza,$turn,$kiso1,$kiso2);
			//ダメージを与える
			$hp2 -= $A;
			//画面に表示する部分
			$text = "{$name1}の{$waza_hyoujiA}！{$name2}に{$A}のダメージ！";
			//必殺技か通常攻撃かで効果音変える
			$koukaon = sound_hit($waza);
		}else{
			//外れたらダメージは0
			$A = 0;
			$text = "{$name1}の{$waza_hyoujiA}！しかし攻撃は外れてしまった！";
			array_push($kakunou_kaihi2,1);
			$koukaon = "http://ori-chara.angry.jp/se/cancel2.mp3";
		}
	}else{
		//プレーヤーBのターンの場合
		$waza = tyuusenn_hissatsu($hissatsuA,$hissatsuB);
		//技を表示するための変数を用意
		switch ($waza){
			case '1':
				$waza_hyoujiB = '攻撃';
				break;
			case '2':
				$waza_hyoujiB = $hissatsuA;
				break;
			case '3':
				$waza_hyoujiB = $hissatsuB;
				break;
		}
		$meityuu = keisann_kaihi($speed1,$speed2);
		if ($meityuu == 1) {
			$B = keisann_iryoku($waza,$turn,$kiso1,$kiso2);
			$hp1 -= $B;
			$text = "{$name2}の{$waza_hyoujiB}！{$name1}に{$B}のダメージ！";
			$koukaon = sound_hit($waza);
		}else{
			//外れたらダメージは0
			$B = 0;
			$text = "{$name2}の{$waza_hyoujiB}！しかし攻撃は外れてしまった！";
			array_push($kakunou_kaihi1,1);
			$koukaon = "http://ori-chara.angry.jp/se/cancel2.mp3";
		}
	}

	//HPがマイナスまで行ったら０で表示する
	if ($hp1 <= 0) {
		$hp1 = 0;
	}
	if ($hp2 <= 0) {
		$hp2 = 0;
	}

	//メッセージ用に配列に格納
	array_push($kakunou_damage1,$A);
	array_push($kakunou_damage2,$B);
	array_push($kakunou_hp1,$hp1);
	array_push($kakunou_hp2,$hp2);
	array_push($kakunou_text,$text);
	array_push($kakunou_koukaon,$koukaon);
}

//プレーヤーのHPが尽きた場合
if ($hp2 <= 0) {
	//sql更新用。レベルアップした時のテキスト表示にも使う
	$syouri1 += 1;
	$new_level2 = level($level2,$syouri2);
	$get_experience = cal_experience($level1,$level2);
	$kyouka1 += $get_experience;
	$new_level1 = level($level1,$syouri1);

	$winner = 1;
	$text = "{$name2}は力尽きてしまった！";
	$koukaon = "http://ori-chara.angry.jp/se/decision22.mp3";
	array_push($kakunou_text,$text);
	array_push($kakunou_koukaon,$koukaon);

	$text = "{$name1}は戦闘に勝利した！";
	$koukaon = "http://ori-chara.angry.jp/se/trumpet1.mp3";
	array_push($kakunou_text,$text);
	array_push($kakunou_koukaon,$koukaon);

	$text = "強化ポイントを{$get_experience}ポイント手に入れた！";
	$koukaon = "http://ori-chara.angry.jp/se/trumpet1.mp3";
	array_push($kakunou_text,$text);
	array_push($kakunou_koukaon,$koukaon);

	//レベルアップしたらテキストを表示
	if ($new_level1 != $level1) {
		$text = "{$name1}はレベルが{$new_level1}にあがった！";
		$koukaon = "http://ori-chara.angry.jp/se/trumpet1.mp3";
		array_push($kakunou_text,$text);
		array_push($kakunou_koukaon,$koukaon);
		//レベルが3になったら必殺技を覚える
		if ($new_level1 == 3) {
			$text = "{$name1}は必殺技を使用可能になった！<br>※キャラクター強化画面で必殺技の設定をしてください。";
			$koukaon = "http://ori-chara.angry.jp/se/decision22.mp3";
			array_push($kakunou_text,$text);
			array_push($kakunou_koukaon,$koukaon);
		}
		//レベルが20になったら超必殺技を覚える
		if ($new_level1 == 20) {
			$text = "{$name1}は超必殺技を使用可能になった！<br>※キャラクター強化画面で必殺技の設定をしてください。";
			$koukaon = "http://ori-chara.angry.jp/se/decision22.mp3";
			array_push($kakunou_text,$text);
			array_push($kakunou_koukaon,$koukaon);
		}
		//レベルが5になったら特殊能力を覚える
		if ($new_level1 == 5) {
			$text = "{$name1}は特殊能力を使用可能になった！<br>※キャラクター強化画面で特殊能力の設定をしてください。";
			$koukaon = "http://ori-chara.angry.jp/se/decision22.mp3";
			array_push($kakunou_text,$text);
			array_push($kakunou_koukaon,$koukaon);
		}
	}
}
if ($hp1 <= 0) {
	$winner = 2;
	$text = "{$name1}は力尽きてしまった！";
	$koukaon = "http://ori-chara.angry.jp/se/decision22.mp3";
	array_push($kakunou_text,$text);
	array_push($kakunou_koukaon,$koukaon);
	$text = "{$name1}は戦闘に敗北した．．．";
	$koukaon = "http://ori-chara.angry.jp/se/decision22.mp3";
	array_push($kakunou_text,$text);
	array_push($kakunou_koukaon,$koukaon);

	//sql更新用。
	$syouri2 += 1;
	$new_level2 = level($level2,$syouri2);
	$kyouka2 += cal_experience($level2,$level1);
	$new_level1 = level($level1,$syouri1);
}


//sqlを更新
//対戦結果をプレーヤーのステータスに反映
$sql = 'UPDATE `character` SET `taisennsuu`=?, `kyouka`=?,`syouri`=?,`level`=? WHERE `code` =?';
$stmt = $db->prepare($sql);
$data2[] = $taisennsuu1;
$data2[] = $kyouka1;
$data2[] = $syouri1;
$data2[] = $new_level1;
$data2[] = $code;
$stmt->execute($data2);
//対戦相手のステータスも更新
$sql = 'UPDATE `character` SET `taisennsuu`=?, `kyouka`=?,`syouri`=?,`level`=? WHERE `code` =?';
$stmt = $db->prepare($sql);
$data3[] = $taisennsuu2;
$data3[] = $kyouka2;
$data3[] = $syouri2;
$data3[] = $new_level2;
$data3[] = $rival_code;
$stmt->execute($data3);

//与えた最大ダメージと最小ダメージを格納
$max_damage1 = max($kakunou_damage1);
$max_damage2 = max($kakunou_damage2);
//攻撃を回避した数を格納
$kaihisuu1 = array_sum($kakunou_kaihi1);
$kaihisuu2 = array_sum($kakunou_kaihi2);
//sqlの対戦結果を更新
$sql = 'INSERT INTO `result`( `code`, `name1`, `rival_code`, `name2`, `winner`, `end_turn`, `damage1`, `damage2`, `kaihisuu1`, `kaihisuu2`) VALUES ("'.$code.'","'.$name1.'","'.$rival_code.'","'.$name2.'","'.$winner.'","'.$jyunn.'","'.$max_damage1.'","'.$max_damage2.'","'.$kaihisuu1.'","'.$kaihisuu2.'")';
$stmt = $db->prepare($sql);
$stmt->execute();

$db = null;


//javascriptに配列受け渡し
$java_damage1 = json_encode($kakunou_damage1);
$java_damage2 = json_encode($kakunou_damage2);
$java_hp1 = json_encode($kakunou_hp1);
$java_hp2 = json_encode($kakunou_hp2);
$java_text = json_encode($kakunou_text);
$java_koukaon = json_encode($kakunou_koukaon);
?>

<!DOCTYPE html>
<html>
<head>
<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-136702693-1"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-136702693-1');
</script>

<meta http-equiv="charset=UTF-8">
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
<link rel="stylesheet" type="text/css" href="battle.css">
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js" integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js" integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k" crossorigin="anonymous"></script>
<title>戦闘中</title>
</head>
<body>
<audio src="./music/YU-FULCA-WITH-SAKURABA.mp3"  autoplay loop></audio>
<div ID="container">
<div ID="senntou">

<?php
//キャラクター画像とＨＰを表示
print <<< TAISENGAMEN
	<div id="playerA">
	<span id="name">{$name1}：<span id="hp1">{$max_hp1}</span>/{$max_hp1}</span>
	<br>
	<br>
	<img border="3" src="./chara_image/$image_url1" width="300" height="300">
	</div>

	<div id="playerB">
	<span id="name">{$name2}：<span id="hp2">{$max_hp2}</span>/{$max_hp2}</span>
	<br>
	<br>
	<img border="3" src="./chara_image/$image2" width="300" height="300">
	</div>

	<div id="kaijyo"></div>

	<div class="kaijyo"></div>
	<div id="message">$kakunou_text[0]</div>
	<span class="btn" input type="button" value="Exec" onclick="countUp();"/>次へ</span>
	
TAISENGAMEN;

//print '<span id="Output" style="margin-left: 10px;">0</span>';//ターン確認用
?>

</div>
</div>
<script>

var count = 0;

function countUp() {
	var audio = new Audio(koukaon[count]);
	audio.play();
	delete audio;
	if(hp1[count] >= 0 && hp2[count] >= 0){
	document.getElementById("hp1").innerHTML = hp1[count];
	document.getElementById("hp2").innerHTML = hp2[count];
	}
	document.getElementById("message").innerHTML = text[count+1];
	if (text[count+1] == null){
		location.href = 'https://angry-ori-chara.ssl-lolipop.jp/mypage.php';
	}
    document.getElementById( "Output" ).innerHTML = ++count;
}


var damage1 = JSON.parse('<?php echo $java_damage1; ?>');
var damage2 = JSON.parse('<?php echo $java_damage2; ?>');
var hp1 = JSON.parse('<?php echo $java_hp1; ?>');
var hp2 = JSON.parse('<?php echo $java_hp2; ?>');
var text = JSON.parse('<?php echo $java_text; ?>');
var koukaon = JSON.parse('<?php echo $java_koukaon; ?>');

</script>
</body>
</html>