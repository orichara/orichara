<?php
require_once './function/common.php';
//ヘッダーを呼び出し
head();
?>
<link rel="stylesheet" type="text/css" href="main.css">
<title>ログイン</title>
</head>

<body>
    <?php containar(); navvar(); ?>

    <div class="col-12 boxC">
        <br>
        <br>
        <br>
        <br>
        <h1>ログイン</h1>

        <br>
        <form method="post" action="chara_page_check.php">
            <br>
            <div class="form-group col-12 col-sm-8 col-md-6 col-xl-3">
                <label class="control-label">キャラクター名</label>
                <input class="form-control" type="text" name="name" value="" size="15">
            </div>
            <div class="form-group col-12 col-sm-8 col-md-6 col-xl-3">
                <label class="control-label">パスワード</label>
                <input class="form-control" type="password" name="pass" size="15">
            </div>
            <br>
            <br>
            <br>
            ※ログイン後はBGMが鳴ります。音量にご注意ください。
            <br>
            <br>
            <br>
            <input class="btn" type="submit" value="ログイン" />
        </form>
        <br>
    </div>
</body>

</html>