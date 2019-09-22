<?php
require_once './function/common.php';
require_once 'kannsuu.php';
require_once './function/DbManager.php';
require_once 'shogo.php';
//ヘッダーを呼び出し
head();
containar();
navvar();

$code=$_GET['code'];
$page=$_GET['page'];

$db = getDb();
$sql = 'SELECT * FROM `character` WHERE `code`=?';
$stmt = $db->prepare($sql);
$data[] = $code;
$stmt->execute($data);
$rec = $stmt->fetch(PDO::FETCH_ASSOC);
?>

<link rel="stylesheet" type="text/css" href="chara_css/chara_data.css">
<link rel="shortcut icon" href="https://angry-ori-chara.ssl-lolipop.jp/sozai/fav/tmfav04905.ico"
    type="image/vnd.microsoft.icon">
<title><?php print "$rec[name]";?> キャラクター図鑑 </title>
</head>

<body>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
        integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous">
    </script>
    <br>
    <br>
<div class="col-12" ID="Z">
<br>
<br>
<div class="row">
<div class="col-12 col-sm-12 col-md-5 col-xl-5">
<img class="img-thumbnail" src="https://angry-ori-chara.ssl-lolipop.jp/chara_image/<?php print ''.$rec[image_url]?>" width="100em" height="100em" id="image">
<br>
<br>
</div>
<br>
<div class="col-12 col-sm-12 col-md-5 col-xl-5 rounded bg-light" id="boxC">

<?php
require_once './function/status.php';

$about = htmlspecialchars($rec['about']);
//文字数の長さに応じてサイズを変える
$moji_size = text_resize($about);
//キャラクターの説明文がない場合
if ($about == null) {
    $about = 'このキャラクターの説明文はまだありません';
}
?>
</div>
</div>
    <div class="col-12" id="boxD">
        <?php
print <<<ABOUT
<div class="col-12" id="message$moji_size">
$about
<br>
</div>
製作者URL：<a href="${rec['url']}">${rec['url']}</a>
<br>
作成日：${rec['sakuseibi']}
<br>
<br>
<div>タグ一覧<br></div>
ABOUT;

//タグ一覧
for ($i = 1; $i <= 10; $i++) {
    print "<a href=https://angry-ori-chara.ssl-lolipop.jp/chara_serch.php?word={$rec["tag$i"]}&type=3page=$show_page>{$rec["tag$i"]}  </a>";
}

//称号一覧
shogo($code);
//最近の出来事を表示
recent_event($code);
//詳細項目を表示
detail($code);
?>
        <br>
        <!-- ツイッターボタン -->
        <a href="https://twitter.com/share?ref_src=twsrc%5Etfw" class="twitter-share-button"
            data-text="<?php print "キャラクター名：".$name." レベル：".$level." 攻撃力：".$attack." 防御力：".$defence." 必殺技：".$hissatsu1." 説明：".$about;?>"
            data-show-count="false">Tweet</a>
        <script async src="https://platform.twitter.com/widgets.js" charset="utf-8"></script>
    </div>
    </div>
    </div>
    <br>
</body>
</html>