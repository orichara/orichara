<?php
require_once './function/common.php';
require_once './function/DbManager.php';
//ヘッダーを呼び出し
head();
?>
<link rel="stylesheet" type="text/css" href="chara_css/chara_zukan.css">
<link rel="shortcut icon" href="http://ori-chara.angry.jp/sozai/fav/tmfav04905.ico" type="image/vnd.microsoft.icon">
<title>オリキャラ検索</title>
</head>

<body>


	<?php containar(); navvar(); ?>
	<br>
	<br>
	<br>
	<br>
	<h1 class="title">オリキャラ検索</h1>

	<form method="GET" action="chara_serch.php">
		<div class="form-group">
			<input class="form-control" placeholder="検索するオリキャラの名前を入力してください" name="word" value="<?php if (!empty($_GET['word'])) {
    echo $_GET['word'];
} ?>">
			<input type="radio" name="type" value="1" checked>キャラクター名で検索
			<input type="radio" name="type" value="2">説明文で検索
			<input type="radio" name="type" value="3">タグで検索
			<small id="emailHelp" class="form-text text-muted">入力し、検索ボタンを押してください。部分一致も可。</small>
		</div>
		<button type="submit" class="btn btn-primary">検索</button>
	</form>
	<br>

	<?php
$word = $_GET["word"];
print "検索ワード：".$word;

if (
isset($_GET["page"]) &&$_GET["page"] > 0) {
    $page = (int)$_GET["page"];
} else {
    $page = 1;
}
// スタートのポジションを計算する
if ($page > 1) {
    $start = ($page * 10) -10;
} else {
    $start = 0;
}


$db = getDb();
$countRecord = $db->prepare("SELECT `code`,`name`,`about`,`image_url` FROM `character` WHERE name LIKE '%$word%'");
$countRecord->execute();
$countRecord = $countRecord->fetchColumn();

// 検索ウィンドウに入力されたデータを基にデータベースから検索
if (!empty($word)) {
    $countRecord = $db->prepare("SELECT `code`,`name`,`about`,`image_url` FROM `character` WHERE `$serch_mode` LIKE '%$word%'");
    $countRecord->execute();
    $countRecord = $countRecord->fetchColumn();

    if ($_GET['type']  == 1) {
        $sql = "SELECT `code`,`name`,`about`,`image_url` FROM `character` WHERE `name` LIKE '%$word%' ORDER BY `code` DESC LIMIT {$start},10";
    }
    if ($_GET['type']  == 2) {
        $sql = "SELECT `code`,`name`,`about`,`image_url` FROM `character` WHERE `about` LIKE '%$word%' ORDER BY `code` DESC LIMIT {$start},10";
    }
    if ($_GET['type']  == 3) {
        $sql = "SELECT `code`,`name`,`about`,`image_url` FROM `character` WHERE concat(tag1,'|',tag2,'|',tag3,'|',tag4,'|',tag5,'|',tag6,'|',tag7,'|',tag8,'|',tag9,'|',tag10) LIKE '%$word%' OR tag2 LIKE '%$word%' OR tag3 LIKE '%$word%' ORDER BY `code` DESC LIMIT {$start},10";
    }
    $stmt = $db->prepare($sql);
    $stmt->execute();
}

print '<div>';

//ここからページネーション
$totalPage = ceil($countRecord/10);
function pagenation($page, $totalPage)
{
    print '<div class="col-12 pagination"><ul class="pagination">';
    if ($page <= 6) {
        for ($nowPage = 1;$nowPage <= 8;$nowPage++) {
            if ($nowPage == $page) {
                print "<li><a style=\"background-color: teal;\" href=?page=$nowPage>$nowPage</a></li>";
            } else {
                print "<li><a href=?page=$nowPage>$nowPage</a></li>";
            }
        }
        print "<li><a href=?page=$page>・・</a></li>";
        print "<li><a href=?page=$totalPage>$totalPage</a></li>";
    } elseif ($page >= $totalPage -6) {
        print "<li><a href=?page=1>1</a></li>";
        print "<li><a href=?page=$page>・・</a></li>";
        //最後の3ページを表示
        $show_page = $totalPage -8;
        for ($i = 1;$i <=8;$i++) {
            $show_page +=1;
            if ($show_page == $page) {
                print "<li><a style=\"background-color: teal;\" href=?page=$show_page>$show_page</a></li>";
            } else {
                print "<li><a href=?page=$show_page>$show_page</a></li>";
            }
        }
    } else {
        print "<li><a href=?page=1>1</a></li>";
        print "<li><a href=?page=$page>・・</a></li>";
        $show_page += $page -4;
        for ($nowPage = 1;$nowPage <= 7;$nowPage++) {
            $show_page += 1;
            if ($show_page == $page) {
                print "<li><a style=\"background-color: teal;\" href=?page=$show_page>$show_page</a></li>";
            } else {
                print "<li></li>";
            }
        }
        print "<li><a href=?page=$page>・・</a></li>";
        print "<li><a href=?page=$totalPage>$totalPage</a></li>";
    }
    print '</ul></div>';
    print '<br>';
}
print '</div>';


// pagenation($page,$totalPage);

while (true) {
    $rec = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($rec==false) {
        break;
    }
    $rec['name'] = htmlspecialchars($rec['name']);
    $rec['about'] = htmlspecialchars($rec['about']);
    $link = $rec['code'];
    $name = $rec['name'];
    $about = $rec['about'];
    $image = $rec['image_url'];

    //文字を丸める

    $about = mb_strimwidth($about, 0, 250, "...", 'UTF-8');
    print <<< ETSURAN
<a class="col-8" href="chara_data.php?code=$link" style="text-decoration:none; color:black;">
<div class="card mb-3 mx-auto">
  <div class="row no-gutters" id="waku">
    <div class="col-md-3">
      <class="bd-placeholder-img" width="100%" height="0"><title></title><img class="rounded" src="./chara_image/{$image}" alt="キャラクターの画像" title="$name" width="170" height="170"></text>
    </div>
    <div class="col-md-8">
      <div class="card-body">
        <h5 class="card-title">$name</h5>
        <p class="card-text">$about</p>
      </div>
    </div>
  </div>
</div>
</a>
ETSURAN;
}


// pagenation($page,$totalPage);

$db = null;
?>


	</div>
</body>

</html>