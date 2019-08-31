<?php

//バランス
function barannsu($kougeki,$bougyo,$subayasa){
	$total = $kougeki + $bougyo + $subayasa;
	if (($kougeki / $total) * 100 >= 50) {
		$message_barannsu = "攻撃型";
		return ($message_barannsu);
	}elseif (($bougyo / $total) * 100 >= 50){
		$message_barannsu = "防御型";
		return ($message_barannsu);
	}elseif (($speed / $total) * 100 >= 50){
		$message_barannsu = "スピード型";
		return ($message_barannsu);
	}else {
		$message_barannsu = "バランス型";
		return ($message_barannsu);
	}
}
function barannsu_rank($barannsu){
	if (($kougeki / $total) * 100 >= 50) {
		$message_barannsu = "rank1";
		return ($message_barannsu);
	}elseif (($bougyo / $total) * 100 >= 50){
		$message_barannsu = "rank1";
		return ($message_barannsu);
	}elseif (($speed / $total) * 100 >= 50){
		$message_barannsu = "rank1";
		return ($message_barannsu);
	}else {
		$message_barannsu = "rank1";
		return ($message_barannsu);
	}
}

//対戦数
function taisennsuu($taisennsuu){
	if ($taisennsuu >= 3000) {
		$message_taisennsuu = "対戦数3000";
		return ($message_taisennsuu);
	}elseif ($taisennsuu >= 1000){
		$message_taisennsuu = "対戦数1000";
		return ($message_taisennsuu);
	}elseif ($taisennsuu >= 500){
		$message_taisennsuu = "対戦数500";
		return ($message_taisennsuu);
	}elseif ($taisennsuu >= 100){
		$message_taisennsuu = "対戦数100";
		return ($message_taisennsuu);
	}else {
		$message_taisennsuu = null;
		return ($message_taisennsuu);
	}
}
function taisennsuu_rank($taisennsuu){
	if ($taisennsuu >= 3000) {
		$message_taisennsuu = "rank4";
		return ($message_taisennsuu);
	}elseif ($taisennsuu >= 1000){
		$message_taisennsuu = "rank3";
		return ($message_taisennsuu);
	}elseif ($taisennsuu >= 500){
		$message_taisennsuu = "rank2";
		return ($message_taisennsuu);
	}elseif ($taisennsuu >= 100){
		$message_taisennsuu = "rank1";
		return ($message_taisennsuu);
	}else {
		$message_taisennsuu = null;
		return ($message_taisennsuu);
	}
}

//勝利数
function syourisuu($syourisuu){
	if ($syourisuu >= 3000) {
		$message_syourisuu = "勝利数3000";
		return ($message_syourisuu);
	}elseif ($syourisuu >= 1000){
		$message_syourisuu = "勝利数1000";
		return ($message_syourisuu);
	}elseif ($syourisuu >= 500){
		$message_syourisuu = "勝利数500";
		return ($message_syourisuu);
	}elseif ($syourisuu >= 100){
		$message_syourisuu = "勝利数100";
		return ($message_syourisuu);
	}else {
		$message_syourisuu = null;
		return ($message_syourisuu);
	}
}
function syourisuu_rank($syourisuu){
	if ($syourisuu >= 3000) {
		$message_syourisuu = "rank4";
		return ($message_syourisuu);
	}elseif ($syourisuu >= 1000){
		$message_syourisuu = "rank3";
		return ($message_syourisuu);
	}elseif ($syourisuu >= 500){
		$message_syourisuu = "rank2";
		return ($message_syourisuu);
	}elseif ($syourisuu >= 100){
		$message_syourisuu = "rank1";
		return ($message_syourisuu);
	}else {
		$message_syourisuu = null;
		return ($message_syourisuu);
	}
}

//攻撃力
function kougekiryoku($kougekiryoku){
	if ($kougekiryoku >= 1000) {
		$message_kougekiryoku = "攻撃力1000";
		return ($message_kougekiryoku);
	}elseif ($kougekiryoku >= 500){
		$message_kougekiryoku = "攻撃力500";
		return ($message_kougekiryoku);
	}elseif ($kougekiryoku >= 100){
		$message_kougekiryoku = "攻撃力100";
		return ($message_kougekiryoku);
	}elseif ($kougekiryoku >= 50){
		$message_kougekiryoku = "攻撃力50";
		return ($message_kougekiryoku);
	}else {
		$message_kougekiryoku = null;
		return ($message_kougekiryoku);
	}
}
function kougekiryoku_rank($kougekiryoku){
	if ($kougekiryoku >= 1000) {
		$message_kougekiryoku = "rank4";
		return ($message_kougekiryoku);
	}elseif ($kougekiryoku >= 500){
		$message_kougekiryoku = "rank3";
		return ($message_kougekiryoku);
	}elseif ($kougekiryoku >= 100){
		$message_kougekiryoku = "rank2";
		return ($message_kougekiryoku);
	}elseif ($kougekiryoku >= 50){
		$message_kougekiryoku = "rank1";
		return ($message_kougekiryoku);
	}else {
		$message_kougekiryoku = null;
		return ($message_kougekiryoku);
	}
}

//防御力
function bougyoryoku($bougyoryoku){
	if ($bougyoryoku >= 1000) {
		$message_bougyoryoku = "防御力1000";
		return ($message_bougyoryoku);
	}elseif ($bougyoryoku >= 500){
		$message_bougyoryoku = "防御力500";
		return ($message_bougyoryoku);
	}elseif ($bougyoryoku >= 100){
		$message_bougyoryoku = "防御力100";
		return ($message_bougyoryoku);
	}elseif ($bougyoryoku >= 50){
		$message_bougyoryoku = "防御力50";
		return ($message_bougyoryoku);
	}else {
		$message_bougyoryoku = null;
		return ($message_bougyoryoku);
	}
}
function bougyoryoku_rank($bougyoryoku){
	if ($bougyoryoku >= 1000) {
		$message_bougyoryoku = "rank4";
		return ($message_bougyoryoku);
	}elseif ($bougyoryoku >= 500){
		$message_bougyoryoku = "rank3";
		return ($message_bougyoryoku);
	}elseif ($bougyoryoku >= 100){
		$message_bougyoryoku = "rank2";
		return ($message_bougyoryoku);
	}elseif ($bougyoryoku >= 50){
		$message_bougyoryoku = "rank1";
		return ($message_bougyoryoku);
	}else {
		$message_bougyoryoku = null;
		return ($message_bougyoryoku);
	}
}

//素早さ
function subayasa($subayasa){
	if ($subayasa >= 1000) {
		$message_subayasa = "素早さ1000";
		return ($message_subayasa);
	}elseif ($subayasa >= 500){
		$message_subayasa = "素早さ500";
		return ($message_subayasa);
	}elseif ($subayasa >= 100){
		$message_subayasa = "素早さ100";
		return ($message_subayasa);
	}elseif ($subayasa >= 50){
		$message_subayasa = "素早さ50";
		return ($message_subayasa);
	}else {
		$message_subayasa = null;
		return ($message_subayasa);
	}
}
function subayasa_rank($subayasa){
	if ($subayasa >= 1000) {
		$message_subayasa = "rank4";
		return ($message_subayasa);
	}elseif ($subayasa >= 500){
		$message_subayasa = "rank3";
		return ($message_subayasa);
	}elseif ($subayasa >= 100){
		$message_subayasa = "rank2";
		return ($message_subayasa);
	}elseif ($subayasa >= 50){
		$message_subayasa = "rank1";
		return ($message_subayasa);
	}else {
		$message_subayasa = null;
		return ($message_subayasa);
	}
}

//勝率
function syouritu($taisennsuu,$syouri){
	$syouritu = round(100 * $syouri/$taisennsuu);
	if ($syouritu >= 95) {
		$message_syouritu = "勝率95％超";
		return ($message_syouritu);
	}elseif ($syouritu >= 90){
		$message_syouritu = "勝率90％超";
		return ($message_syouritu);
	}elseif ($syouritu >= 80){
		$message_syouritu = "勝率80％超";
		return ($message_syouritu);
	}elseif ($syouritu >= 70){
		$message_syouritu = "勝率70％超";
		return ($message_syouritu);
	}else {
		$message_syouritu = null;
		return ($message_syouritu);
	}
}
function syouritu_rank($taisennsuu,$syouri){
	$syouritu_rank = round(100 * $syouri/$taisennsuu);
	if ($syouritu_rank >= 95) {
		$message_syouritu_rank = "rank4";
		return ($message_syouritu_rank);
	}elseif ($syouritu_rank >= 90){
		$message_syouritu_rank = "rank3";
		return ($message_syouritu_rank);
	}elseif ($syouritu_rank >= 80){
		$message_syouritu_rank = "rank2";
		return ($message_syouritu_rank);
	}elseif ($syouritu_rank >= 70){
		$message_syouritu_rank = "rank1";
		return ($message_syouritu_rank);
	}else {
		$message_syouritu_rank = null;
		return ($message_syouritu_rank);
	}
}

?>