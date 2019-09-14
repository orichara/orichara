<?php
session_start();
session_regenerate_id(true);
if (isset($_SESSION['login'])==false) {
    print 'ログインされていません。<br />';
    print '<a href="chara_page.php">ログイン画面へ</a>';
    exit();
}
?>
<?php
require_once './function/common.php';
require_once 'kannsuu.php';
require_once './function/DbManager.php';
//ヘッダーを呼び出し
head();
$db = getDb();

$name=$_SESSION['name'];
$pass=$_SESSION['pass'];
?>
<?php
//キャラクターの説明文と製作者URLを更新
if (isset($_POST['url'])) {
    $set_url = $_POST['url'];
    $set_about = $_POST['about'];
    $sql = 'UPDATE `character` SET `url`=?,`about`=?  WHERE `name` =?';
    $stmt = $db->prepare($sql);
    $data2 = array($set_url, $set_about, $name);
    $stmt->execute($data2);
}
//タグを登録・更新
if (isset($_POST['tag1'])) {
    for ($i = 1; $i <= 10; $i++) {
        ${"set_tag" . $i} = $_POST["tag$i"];
    }
    $sql2 = 'UPDATE `character` SET `tag1`=?,`tag2`=?,`tag3`=?,`tag4`=?,`tag5`=?,`tag6`=?,`tag7`=?,`tag8`=?,`tag9`=?,`tag10`=? WHERE `name` =?';
    $stmt2 = $db->prepare($sql2);
    $tags = array($set_tag1,$set_tag2,$set_tag3,$set_tag4,$set_tag5,$set_tag6,$set_tag7,$set_tag8,$set_tag9,$set_tag10,$name);
    $stmt2->execute($tags);
}

?>


<link rel="stylesheet" type="text/css" href="https://angry-ori-chara.ssl-lolipop.jp/chara_css/mypage.css">
<title>編集画面</title>
</head>

<body>
    <audio src="./music/bgm_maoudamashii_acoustic52.mp3" autoplay loop></audio>
    <div ID="container">
        <div id="wrapper">
            <div id="boxD">
                <?php
$sql = 'SELECT * FROM `character` WHERE `name`=? AND `password`=?';
$stmt = $db->prepare($sql);
$data[] = $name;
$data[] = $pass;
$stmt->execute($data);
$db = null;

$rec = $stmt->fetch(PDO::FETCH_ASSOC);

$url = $rec['url'];
$about = $rec['about'];
$tag = array($rec['tag1'],$rec['tag2'],$rec['tag3'],$rec['tag4'],$rec['tag5'],$rec['tag6'],$rec['tag7'],$rec['tag8'],$rec['tag9'],$rec['tag10']);
htmlspecialchars($url, $about, $tag);

print <<< EDIT
<form method="post" action="edit.php">
URL：
<br>
<input type="text" name="url" value="$url" size="15">
<br>
<br>
キャラクターの説明：
<br>
<textarea name="about" cols="80" rows="10">
$about
</textarea>
<br>
<br>
<input class="btn2" type="submit" value="編集を反映させる">
</form>
<br>
EDIT;
//レベルを10で割ったものに2を足した数がつけられるタグの数
$number_tags = ceil($rec['level']/10) + 2;
//タグの数は最大10個までにする
if ($number_tags >= 10){
    $number_tags = 10;
}
$ii = 0;
//データベースに値を渡すため、登録できるタグの数にかかわらずひとまず10回ループさせる
for ($i = 1; $i <= 10; $i++){
    $ii = $i - 1;
    //登録できるタグの数を超えたら非表示にする
    if ($number_tags >= $i){
        $from_type ="text";
        $current_tag = "タグ".$i."<br>";
    }else{
        $from_type ="hidden";
        $current_tag = "";
    }
    print <<< TAG
<form method="post" action="edit.php">
$current_tag
<input type="$from_type" name="tag$i" value="$tag[$ii]" size="20">
<br>
TAG;
}

?>
<br>
<input class="btn2" type="submit" value="タグを登録・変更する">
</form>
<a href="mypage.php" style="text-decoration:none;"><button type="button" class="btn2">マイページに戻る</button></a>
<br>
            </div>
        </div>
    </div>
</body>

</html>