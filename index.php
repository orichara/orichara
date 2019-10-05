<?php
session_start();
require_once './function/common.php';
require_once 'kannsuu.php';
require_once './function/DbManager.php';
//ヘッダーを呼び出し
head();
?>
<meta name="description"
	content="あなたの考えたオリジナルキャラクター（オリキャラ）を戦わせてみませんか？メールアドレス登録は不要ですぐにキャラクターを登録できます。自分だけのオリキャラでランキングトップを目指せ！">
<meta name="keywords" content="オリキャラ,オリジナル,キャラクター,バトル,創作">
<link rel="stylesheet" type="text/css" href="index.css">
<link rel="shortcut icon" href="https://angry-ori-chara.ssl-lolipop.jp/sozai/fav/tmfav04905.ico"
	type="image/vnd.microsoft.icon">
<title>オリキャラバトル　～あなたの考えたキャラクターを戦わせよう！～</title>
</head>

<body style="padding-top:70px">
	<?php

$db = getDb();
$sql = 'SELECT `code`,`name`,`about`,`image_url` FROM `character` WHERE 1 ORDER BY `code` DESC LIMIT 10';
$stmt = $db->prepare($sql);
$stmt->execute();

containar();
//ナビゲーションバーを呼び出し
navvar();

print <<< HEAD_CAROUSEL
<br>
<br>
<br>
<h1 class="col-12 text-light font-size: small;">新人のオリキャラたち</h1>	
HEAD_CAROUSEL;
$hyouji = 0;
for ($i = 1; $i <= 3; $i++) {
    $rec = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($rec==false) {
        break;
    }
    $card_color = 'bg-light';
    card($hyouji, $card_color, $rec['image_url'], $rec['name'], $rec['about'], $rec['code']);
    $hyouji++;
}

print '<h2 class="col-12 text-info font-size: small;">ランダムPICKUP</h2>';
$hyouji2 = 0;
$sql_randomselect = 'SELECT `code`,`name`,`about`,`image_url` FROM `character` WHERE 1 ORDER BY RAND() DESC LIMIT 10';
$stmt2 = $db->prepare($sql_randomselect);
$stmt2->execute();
for ($i = 1; $i <= 3; $i++) {
    $rec = $stmt2->fetch(PDO::FETCH_ASSOC);
    if ($rec==false) {
        break;
    }
    $card_color = 'bg-info';
    card($hyouji, $card_color, $rec['image_url'], $rec['name'], $rec['about'], $rec['code']);
    $hyouji2++;
}

?>
	<div class="box1">
		<h2>Update</h2>
		2019.9.29　コメント機能を追加しました。
		<br>
		2019.9.15　マイページに最近の出来事を追加しました。
		<br>
		2019.9.9　編集ページにタグ機能を追加しました。
		<br>
		2019.8.31　オリキャラ検索を追加しました。
		<br>
		2019.8.3　超必殺技が使用可能になりました。
		<br>
		2019.7.26　特殊能力「疾風怒涛」を追加しました。
		<br>
		2019.7.21　強化ポイントの計算式を見直しました。
		<br>
		2019.3.17　キャラクターページにソーシャルボタンを設置しました。
		<br>
		2019.1.21　ランキングの項目と表示数を追加しました。
		<br>
		2019.1.5　特殊能力を追加しました。
		<br>
		2018.12.31　詳細データを追加しました。
		<br>
		2018.12.28　能力アップに必要な経験値を見直しました。
		<br>
		2018.12.24　レベルアップの条件を変更し、上限を撤廃しました。
		<br>
		2018.12.11　ランキングの項目を追加しました。
		<br>
		2018.11.17　キャラクター図鑑に最近の対戦成績を追加しました。
		<br>
		2018.10.7　相手から仕掛けられた勝負も戦績に反映されるようになりました。
		<br>
		2018.9.28　レベルアップの条件を勝利数に変更しました。
		<br>
	</div>

	<br>

	<div class="box1">
		<h3>遊び方</h3>
		趣旨
		<br>
		あなたの考えたオリジナルキャラクター（オリキャラ）を登録できます。
		<br>
		あなたの考えたオリキャラでランキングトップを目指せ！
		<br>
		<br>
		登録方法
		<br>
		１．キャラクターを「登録する」をクリック
		<br>
		２．キャラクター名とパスワードを入力
		<br>
		３．キャラクター詳細と製作者URLを任意で記入（後から変更可）
		<br>
		４．画像を選択してアップロード
		<br>
		５．確認画面で「OK」ボタンをクリック
		<br>
		６．登録完了！
		<br>
		<br>
		対戦方法
		<br>
		１．キャラクター名とパスワードを入力して「ログイン」ボタンをクリック
		<br>
		２．「対戦相手を探す」ボタンをクリック
		<br>
		３．対戦したいオリキャラを探して「このキャラクターと対戦！」ボタンをクリック
		<br>
		４．対戦開始！
		<br>
	</div>
	<br>

	<div class="box1">
		<h3>利用規約</h3>
		・第三社の著作権を侵害するような画像のアップロードはご遠慮ください。
		<br>
		<br>
		・第三者の財産、プライバシーもしくは肖像権を侵害する行為、又は侵害する恐れのある行為はしないでください。
		<br>
		<br>
		・パスワード、キャラクター名を紛失しても再発行は行っていません。利用者の責任で管理してください。
		<br>
		<br>
		・当サイトの管理人は事前の予告なくして、サイトの内容をいつでも任意の理由で追加、変更、中断、終了することができます。
		<br>
		<br>
		・問題のある画像、書き込みなどの投稿は管理人の判断でいつでも削除できるものとします。
		<br>
		<br>
		・当サイトを利用したことによる損害については製作者は一切責任を負いません。自己責任でご利用ください。
		<br>
	</div>
	<br>

	</div>
	<footer id="footer">
		<p class="copyright"> <small>※当サイトはフリー音楽素材魔王魂とWingless SeraphのBGMを利用しています。 </small> </p>
		<p class="copyright"> <small>copyright &copy; ori-chara.angry.jp All Rights Reserved. </small> </p>
	</footer>
</body>

</html>