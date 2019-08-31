<?php
require_once './function/common.php';
//ヘッダーを呼び出し
head();
?>
<link rel="stylesheet" type="text/css" href="main.css">
<title>ログイン</title>
</head>
<body>
<?php navvar(); ?>

<div class="col-12 boxB">
<br>
<br>
<br>
<br>
<h1>ログイン</h1>

<!--
メインのボックス
-->
<form method="post" action="chara_page_check.php">

キャラ名：
<br>
<input type="text" name="name" value="" size="15">
<br>
<br>
パスワード：
<br>
<input type="password" name="pass" size="15">
<br>
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