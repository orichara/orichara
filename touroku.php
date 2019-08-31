<?php
require_once './function/common.php';
//ヘッダーを呼び出し
head();
?>

<link rel="stylesheet" type="text/css" href="main.css">
<title>キャラクター登録</title>
</head>
<body>
<div ID="container">
<div id="wrapper">
<?php containar(); navvar(); ?>
<br>
<br>
<div id="boxB">
<br>
<h1>キャラクター登録</h1>
キャラクターを登録します。
<br>
※のついた項目はすべて記入してください。
<br>
<br>
<br>
<!--
メインのボックス
-->
<form method="post" action="chara-check.php" enctype="multipart/form-data">

※キャラ名：
<br>
キャラクター名とパスワードはログインする際に必要となります。
<br>
<input type="text" name="name" value="" size="15">
<br>
<br>
※パスワード
<br>
パスワードの再発行は行っていません。利用者の責任で管理してください。
<br>
<input type="password" name="pass" size="15">
<br>
<br>
※パスワードをもう一度入力してください。
<br>
<input type="password" name="pass2" size="15">
<br>
<br>
製作者ホームページ（後から変更可）：
<br>
<input type="text" name="url" value="" size="15">
<br>
<br>
キャラクターの説明（後から変更可）：
<br>
<textarea name="setsumei" cols="25" rows="4">
</textarea>
<br>
<br>
※キャラクターの画像：
<br>
（ファイルの拡張子はjpg,jpeg,pngのいずれかにしてください）
<br>
<input type="file" name="image" size="30">
<br>
<br>
<br>
<br>
<input class="btn" type="button" onclick="history.back()" value="戻る">
<input class="btn" type="submit" value="確認画面へ" />
</form>

</div>
</div>


</div>
</body>
</html>