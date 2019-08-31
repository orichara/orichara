<?php
session_start();

//攻守切り替え
function change_turn($turn){
	if ($turn == a) {
		$turn = b;
	}else{
		$turn = a;
	}
	return($turn);
}

//メッセージや効果音等を格納する
function kakunou(){
	//グローバル変数はPHPではデフォルトでは関数外でのみ使用される変数となっており、関数内で使うためにはグローバルで使う変数を宣言しなくてはなりません。これは忘れやすいのでよく覚えておきましょう。
	include './function/global.php';
	array_push($kakunou_text,$text);
	array_push($kakunou_koukaon,$koukaon);
	array_push($kakunou_hp1,$hp1);
	array_push($kakunou_hp2,$hp2);
}


//勝利数によってレベルアップしたかどうか判定
function level($level,$syourisuu){
	$hosei = 3;
	$total = 0;
	for ($i = 1; $i <= $level; $i++){
		$hosei = 3 + ceil($i/3) - 1;
		$total += $hosei;
		/* デバッグ用
		print $i;
		print "    ";
		print $hosei;
		print "    ";
		print $total;
		print "<br>"; */
	}
	if ($syourisuu > $total) {
		$level = $level +=1;
	}
	return($level);
}

//HPのアップに必要な強化ポイントを返す
function hp($now_hp,$tokusyu1){
	if ($tokusyu1 == 1001) {
		$now_hp = $now_hp/2;
	}
	$hp_point = ceil($now_hp/10);
	return($hp_point);
}

//攻撃力のアップに必要な強化ポイントを返す
function attack($now_attack,$tokusyu1){
	if ($tokusyu1 == 1002) {
		$now_attack = $now_attack/2;
	}
	$attack_point = ceil($now_attack/7);
	return($attack_point);
}

//防御力のアップに必要な強化ポイントを返す
function defense($now_defense,$tokusyu1){
	if ($tokusyu1 == 1003) {
		$now_defense = $now_defense/2;
	}
	$defense_point = ceil($now_defense/5);
	return($defense_point);
}

//素早さのアップに必要な強化ポイントを返す
function speed($now_speed,$tokusyu1){
	if ($tokusyu1 == 1004) {
		$now_speed = $now_speed/2;
	}
	$speed_point = ceil($now_speed/8);
	return($speed_point);
}

//通常攻撃の威力を計算。通常の攻撃力×（0.8～1.2）
function tuujyou1($kougeki){
	$a = mt_rand(0,4);
	$kougeki = $kougeki * (0.8 + 0.1 * $a);
	$kougeki = ceil($kougeki);
	return ($kougeki);
}

//必殺技の威力を計算
function hissatsu1($hissatsu){
	$a = mt_rand(0,4);
	$hissatsu = $hissatsu * (2.8 + 0.1 * $a);
	$hissatsu = ceil($hissatsu);
	return ($hissatsu);
}

//必殺技２の威力を計算
function hissatsu2($hissatsu){
	$a = mt_rand(0,10);
	$hissatsu = $hissatsu * (4.0 + 0.1 * $a);
	$hissatsu = ceil($hissatsu);
	return ($hissatsu);
}

//通常技と必殺技を抽選
function tyuusenn_hissatsu($hissatsu1,$hissatsu2){
	if ($hissatsu1 == null) {
		$waza = 1;
	}elseif ($hissatsu2 == null) {
		$tyuusenn = mt_rand(1, 100);
		if($tyuusenn <= 60){
			$waza = 1;
		}else{
			$waza = 2;
		}
	}else{
		$tyuusenn = mt_rand(1, 100);
		if($tyuusenn <= 60){
			$waza = 1;
		}elseif ($tyuusenn <= 80){
			$waza = 2;			
		}else{
			$waza = 3;
		}
	}
	return ($waza);
}

//通常攻撃や必殺技の威力を求める
function keisann_iryoku($waza,$turn,$kiso1,$kiso2){
	if ($turn == a) {
		switch ($waza){
			case '1':
				$A = tuujyou1($kiso1);
				$hp2 -= $A;
				break;
			case '2':
				$A = hissatsu1($kiso1);
				$hp2 -= $A;
				break;
			case '3':
				$A = hissatsu2($kiso1);
				$hp2 -= $A;
				break;
		}
		return ($A);
	}

	if ($turn == b) {
		switch ($waza){
			case '1':
				$B = tuujyou1($kiso2);
				$hp1 -= $B;
				break;
			case '2':
				$B = hissatsu1($kiso2);
				$hp1 -= $B;
				break;
			case '3':
				$B = hissatsu2($kiso2);
				$hp1 -= $B;
				break;
		}
		return ($B);
	}
}

//攻撃を回避する確率を求めた後、回避したかどうかを判定
function keisann_kaihi($speed1,$speed2){
	$speed1 -= $speed2;
	$hantei = $speed1;
	if ($hantei <= -50) {
		$kaihi = 0;
	}else if($hantei >= -49 && $hantei <= -40){
		$kaihi = 8;
	}else if($hantei >= -39 && $hantei <= -30){
		$kaihi = 16;
	}else if($hantei >= -29 && $hantei <= -20){
		$kaihi = 24;
	}else if($hantei >= -19 && $hantei <= -10){
		$kaihi = 32;
	}else if($hantei >= -9 && $hantei <= 0){
		$kaihi = 40;
	}else if($hantei >= 1 && $hantei <= 10){
		$kaihi = 48;
	}else if($hantei >= 11 && $hantei <= 20){
		$kaihi = 56;
	}else if($hantei >= 21 && $hantei <= 30){
		$kaihi = 64;
	}else if($hantei >= 31 && $hantei <= 40){
		$kaihi = 72;
	}else if($hantei >= 41 && $hantei <= 50){
		$kaihi = 100;
	}else {
		$kaihi = 100;
	}
	$rannsuu = mt_rand(1,100);
	if ($rannsuu > $kaihi) {
		$meityuu = 1;
	}else {
		$meityuu = 0;
	}
	return ($meityuu);
}

//攻撃が当たった時の効果音
function sound_hit($waza){
	if ($waza == 1){
		$koukaon = "http://ori-chara.angry.jp/se/punch-high1.mp3";
	}
	if ($waza == 2){
		$koukaon = "http://ori-chara.angry.jp/se/punch-high2.mp3";
	}
	if ($waza == 3){
		$koukaon = "http://ori-chara.angry.jp/se/super-arts-hit1.mp3";
	}
	return($koukaon);
}

//手に入れた経験値を求める
function cal_experience($level1,$level2){
	if ($level1 >= $level2 + 3){
		$experience = 2;
	}elseif ($level1 <= $level2 - 3){
		$experience = 4;
	}else{
		$experience = 3;
	}
	return($experience);
}

//特殊能力の表示に使う
function hyouji_tokusyu($tokusyu1){
	switch($tokusyu1){
		case 1001:
			$tokusyu1 =  "驚異の生命力";
			break;
		case 1002:
			$tokusyu1 =  "狂戦士";
			break;
		case 1003:
			$tokusyu1 =  "鉄壁";
			break;
		case 1004:
			$tokusyu1 =  "韋駄天";
			break;
		case 2001:
			$tokusyu1 =  "先手必勝";
			break;
		case 2002:
			$tokusyu1 =  "自己再生";
			break;
		case 2003:
			$tokusyu1 =  "疾風怒涛";
			break;
		default:
			$tokusyu1 =  "-";
	}
	return ($tokusyu1);
}

function sennseikougeki($speed1,$speed2,$tokusyu1,$tokusyuA){
	if ($speed1 >= $speed2) {
		$turn = a;
	}else {
		$turn = b;
	}
	include './function/global.php';

	//先手必勝の特殊能力判定
	if ($tokusyuA == 2001) {
		$turn = b;
		$text = "{$name2}の特殊能力「先手必勝」発動！";
		$koukaon = "http://ori-chara.angry.jp/se/flash2.mp3";
		kakunou();
	}
	//先手必勝の能力を持ったキャラ同士が戦った場合プレーヤーを優先するためこの位置から動かさない
	if ($tokusyu1 == 2001) {
		$turn = a;
		$text = "{$name1}の特殊能力「先手必勝」発動！";
		$koukaon = "http://ori-chara.angry.jp/se/flash2.mp3";
		kakunou();
	}
	//この後攻守切り替えがあるため先攻後攻を逆にセットしておく
	if ($turn == a) {
		$turn = b;
	}else{
		$turn = a;
	}
	return ($turn);
}

function jikosaisei($tokusyu1,$tokusyuA){
	include './function/global.php';
	//先手必勝の特殊能力判定
	$tyuusenn_kaihuku1 = mt_rand(1, 2);
	if ($tokusyu1 == 2002 && $max_hp1 * 0.5 >= $hp1 && $tyuusenn_kaihuku1 == 1) {
		$kaihuku = ceil($max_hp1 * 0.2);
		$hp1 = $hp1 + $kaihuku;
		$text = "{$name1}の特殊能力「自己再生」発動！<br>{$name1}の体力が{$kaihuku}回復した！";
		$koukaon = "http://ori-chara.angry.jp/se/magic-status-cure2.mp3";
		kakunou();
	}
	$tyuusenn_kaihuku2 = mt_rand(1, 2);
	if ($tokusyuA == 2002 && $max_hp2 * 0.5 >= $hp2 && $tyuusenn_kaihuku2 == 1) {
		$kaihuku = ceil($max_hp2 * 0.2);
		$hp2 = $hp2 + $kaihuku;
		$text = "{$name2}の特殊能力「自己再生」発動！<br>{$name2}の体力が{$kaihuku}回復した！";
		$koukaon = "http://ori-chara.angry.jp/se/magic-status-cure2.mp3";
		kakunou();
	}
}

function sippuudotou($turn,$tokusyu1,$tokusyuA){
	include './function/global.php';
	//疾風怒涛の特殊能力判定
	$tyuusenn_sippuu = mt_rand(1, 4);
	//もしプレーヤー2のターンだったらプレーヤー1のターンに変える
	if ($tokusyu1 == 2003 && $turn == b && $tyuusenn_sippuu == 1){
		$text = "{$name1}の特殊能力「疾風怒涛」発動！<br>再び{$name1}のターン！";
		$koukaon = "http://ori-chara.angry.jp/se/shakin2.mp3";
		kakunou();
		$turn = change_turn($turn);	
	}
	$tyuusenn_sippuu = mt_rand(1, 4);
	if ($tokusyuA == 2003 && $turn == a && $tyuusenn_sippuu == 1){
		$text = "{$name2}の特殊能力「疾風怒涛」発動！<br>再び{$name2}のターン！";
		$koukaon = "http://ori-chara.angry.jp/se/shakin2.mp3";
		kakunou();
		$turn = change_turn($turn);	
	}
	return ($turn);
}

?>