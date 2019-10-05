<?php
require_once './function/common.php';
require_once 'kannsuu.php';
require_once './function/DbManager.php';
//ヘッダーを呼び出し
head();
?>
<link rel="stylesheet" type="text/css" href="https://angry-ori-chara.ssl-lolipop.jp/chara_css/ranking.css">
<link rel="shortcut icon" href="https://angry-ori-chara.ssl-lolipop.jp/sozai/fav/tmfav04905.ico"
    type="image/vnd.microsoft.icon">
<?php
if (isset($_GET['rank']) == false) {
    $_GET['rank'] = 1;
}
switch ($_GET['rank']) {
    case '1':
        $ranking = 'level';
        break;
    case '2':
        $ranking = 'attack';
        break;
    case '3':
        $ranking = 'defense';
        break;
    case '4':
        $ranking = 'speed';
        break;
    case '5':
        $ranking = 'hp';
        break;
    case '6':
        $ranking = 'taisennsuu';
        break;
    case '7':
        $ranking = 'damage1';
        break;
    case '8':
        $ranking = 'kaihisuu1';
        break;
    case '9':
        $ranking = 'end_turn';
        break;
}

switch ($_GET['rank']) {
    case '1':
        $title = 'レベル';
        break;
    case '2':
        $title = '攻撃力';
        break;
    case '3':
        $title = '防御力';
        break;
    case '4':
        $title = '素早さ';
        break;
    case '5':
        $title = 'HP';
        break;
    case '6':
        $title = '対戦数';
        break;
    case '7':
        $title = '最大ダメージ';
        break;
    case '8':
        $title = '回避数';
        break;
    case '9':
        $title = '最大ターン';
        break;
}
?>

<title><?php print "$title"; ?>ランキング</title>
</head>

<body>
    <div class="container col-12" id="container">
        <?php containar(); navvar(); ?>
        <br>
        <br>
        <br>
        <div class="text-center">
            <h1 class="title"><?php print "$title"; ?>ランキング</h1>
        </div>
        <div class="dropdown">
            <button class="btn btn-info dropdown-toggle btn-lg" type="button" id="dropdownMenuButton"
                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                ランキングを選択
            </button>
            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                <a class="dropdown-item" href="http://ori-chara.angry.jp/ranking.php?rank=1">レベル</a>
                <a class="dropdown-item" href="http://ori-chara.angry.jp/ranking.php?rank=2">攻撃力</a>
                <a class="dropdown-item" href="http://ori-chara.angry.jp/ranking.php?rank=3">防御力</a>
                <a class="dropdown-item" href="http://ori-chara.angry.jp/ranking.php?rank=4">素早さ</a>
                <a class="dropdown-item" href="http://ori-chara.angry.jp/ranking.php?rank=5">HP</a>
                <a class="dropdown-item" href="http://ori-chara.angry.jp/ranking.php?rank=6">対戦数</a>
                <a class="dropdown-item" href="http://ori-chara.angry.jp/ranking.php?rank=7">最大ダメージ</a>
                <a class="dropdown-item" href="http://ori-chara.angry.jp/ranking.php?rank=8">回避数</a>
                <a class="dropdown-item" href="http://ori-chara.angry.jp/ranking.php?rank=9">長期戦</a>
            </div>
        </div>
        <?php
require_once './function/DbManager.php';
$db = getDb();

print '<br>';

if ($_GET['rank'] >=1 && $_GET['rank'] <= 6) {
    $sql = "SELECT `code`,`name`,`about`,`image_url`,`$ranking` FROM `character` WHERE 1 ORDER BY `$ranking` DESC LIMIT 30";
    $stmt = $db->prepare($sql);
    $stmt->execute();
}

if ($_GET['rank'] >=7 && $_GET['rank'] <= 10) {
    $sql = "SELECT result.`code`,`name1`,$ranking,character.image_url,name,about FROM `result`,`character` WHERE result.code = character.code ORDER BY $ranking DESC LIMIT 30";
    $stmt = $db->prepare($sql);
    $stmt->execute($data1);
}

while (true) {
    $rec = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($rec==false) {
        break;
    }
    if (isset($jyunni)) {
        $jyunni += 1;
    } else {
        $jyunni = 1;
    }

    $power = $rec["$ranking"];
    $image = $rec['image_url'];

    card_ranking($hyouji, $card_color, $rec['image_url'], $rec['name'], $rec['about'], $rec['code'], $jyunni);
}
?>
        <br>
    </div>
    </div>
</body>

</html>