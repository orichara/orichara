<?php
require_once './function/common.php';
//ヘッダーを呼び出し
head();
?>

<link rel="stylesheet" type="text/css" href="main.css">
<title>キャラクター登録</title>
</head>

<body>

    <?php containar(); navvar(); ?>
    <br>
    <br>
    <div class="col-12 boxC">
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

            <div class="form-group col-12 col-sm-8 col-md-6 col-xl-3">
                <label class="control-label">※キャラクター名</label>
                <input class="form-control" type="text" name="name" value="" size="15">
            </div>
            <div class="form-group col-12 col-sm-8 col-md-6 col-xl-3">
                <label class="control-label">※パスワード（パスワードの再発行は行っていません。利用者の責任で管理してください。）</label>
                <input class="form-control" type="password" name="pass" size="15">
            </div>
            <div class="form-group col-12 col-sm-8 col-md-6 col-xl-3">
                <label class="control-label"> ※パスワードをもう一度入力してください。</label>
                <input class="form-control" type="password" name="pass2" size="15">
            </div>
            <div class="form-group col-12 col-sm-10 col-md-8 col-xl-6">
                <label class="control-label">製作者ホームページ（後から変更可）</label>
                <input class="form-control" name="url" size="45">
            </div>
            <div class="form-group col-12 col-sm-10 col-md-8 col-xl-6">
                <label for="exampleFormControlTextarea1">キャラクターの説明（後から変更可）</label>
                <textarea class="form-control" name="setsumei" rows="4"></textarea>
            </div>
            <div class="form-group">
            <label for="exampleFormControlFile1">※キャラクターの画像：<br>（ファイルの拡張子はjpg,jpeg,pngのいずれかにしてください）</label>
            <input type="file" class="form-control-file" name="image" size="30">
            </div>

            <br>
            <input class="btn" type="submit" value="確認画面へ" />
            <br>
        </form>
    </div>
    </div>
</body>

</html>