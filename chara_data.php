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
$sql_comment = 'SELECT * FROM `character` WHERE `code`=?';
$stmt = $db->prepare($sql_comment);
$data[] = $code;
$stmt->execute($data);
$rec = $stmt->fetch(PDO::FETCH_ASSOC);

$about = htmlspecialchars($rec['about']);
//文字数の長さに応じてサイズを変える
$moji_size = text_resize($about);
//キャラクターの説明文がない場合
if ($about == null) {
    $about = 'このキャラクターの説明文はまだありません';
}

//コメントが入力されたらデータベースに登録
if (isset($_POST['comment'])) {
    $set_comment = $_POST['comment'];
    $name1 = $_SESSION['name'];
    $sender_code = $_SESSION['code'];
    $receiver_code = $_POST['receiver'];
    $name2 = $_POST['name2'];
    //コメントをデータベースに登録
    $sql_comment = 'INSERT INTO `board`( `sender_code`, `name1`, `receiver_code`, `name2`, `comment`)
    VALUES ("'.$sender_code.'","'.$name1.'","'.$receiver_code.'","'.$name2.'","'.$set_comment.'")';
    $stmt = $db->prepare($sql_comment);
    $stmt->execute($data_comment);
}

?>

<link rel="stylesheet" type="text/css" href="chara_css/chara_data.css">
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
                <img class="img-thumbnail"
                    src="https://angry-ori-chara.ssl-lolipop.jp/chara_image/<?php print ''.$rec[image_url]?>"
                    width="100em" height="100em" id="image">
                <br>
                <br>
            </div>
            <br>
            <div class="col-12 col-sm-12 col-md-5 col-xl-5 rounded bg-light" id="boxC">
                <?php require_once './function/status.php'; ?>
            </div>
        </div>
        <div class="col-12" id="boxD">
            <div class="col-12" id="message<?php $moji_size; ?>">
                <?php print ''.$rec[about]?>
                <br>
            </div>
            製作者URL：
            <a href="<?php print ''.$rec[url]?>"><?php print ''.$rec[url]?></a>
            <br>
            作成日：<?php print ''.$rec[sakuseibi]?>
            <br>
            <br>
            <div>タグ一覧</div>
            <br>



            <?php
            for ($i = 1; $i <= 10; $i++) {
                print "<a href=https://angry-ori-chara.ssl-lolipop.jp/chara_serch.php?word={$rec["
                tag$i"]}&type=3page=$show_page>{$rec["tag$i"]} </a>";
            }
            print "<br><br>";

            if (isset($_SESSION['login'])==true) {
                print <<< COMMENT
                <button class="btn btn-primary" type="button" data-toggle="modal" data-target="#modal1">
                    コメントを残す
                </button>
                <br>
                <br>
                <div class="modal fade" id="modal1">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-body">
                                <form method="post" action="chara_data.php?code=$code">
                                    <div class="form-group">
                                        <label for="exampleFormControlTextarea1">コメント：</label>
                                        <textarea class="form-control" name="comment" rows="4"></textarea>
                                        <input type="hidden" name="receiver" value="$code">
                                        <input type="hidden" name="code" value="$code">
                                        <input type="hidden" name="name2" value="{$rec['name']}">
                                    </div>
                                    <button type="submit" class="btn btn-primary">コメントを残す</button>
                                    <button class="btn btn-secondary" data-dismiss="modal">閉じる</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
COMMENT;
            }
                    ?>

        </div>

        <?php display_comment($code); ?>

        <div class="accordion" id="collapse-accordion">
            <button class="btn btn-secondary btn-block text-left active" type="button" data-toggle="collapse"
                data-target="#collapse-accordion-1">
                称号一覧
            </button>
            <div id="collapse-accordion-1" class="collapse" data-parent="#collapse-accordion">
                <?php shogo($code); ?>
            </div>
            <br>
            <button class="btn btn-secondary btn-block text-left active" type="button" data-toggle="collapse"
                data-target="#collapse-accordion-2">
                最近の出来事
            </button>
            <div id="collapse-accordion-2" class="collapse" data-parent="#collapse-accordion">
                <?php recent_event($code); ?>
            </div>
            <br>
            <button class="btn btn-secondary btn-block text-left active" type="button" data-toggle="collapse"
                data-target="#collapse-accordion-2">
                詳細データ
            </button>
            <div id="collapse-accordion-2" class="collapse" data-parent="#collapse-accordion">
                <?php detail($code); ?>
            </div>
        </div>

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