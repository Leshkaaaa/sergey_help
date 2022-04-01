<?php
$arResult = array();
$arPagination = array();

require_once('databases.php');

header('Content-Type: text/html; charset=utf-8');



if(!isset($_GET['page'])) $page = 1; else $page = htmlspecialchars($_GET['page']);
if (ctype_digit($page) === false) $page = 1;
$news = "page_less";
$count_query = $connection -> query("SELECT COUNT(*) FROM `news`");
$count_array = $count_query->fetch_array(MYSQLI_NUM);
$count = $count_array[0];
$limit = 5;
$start = ($page*$limit)-$limit;
$length = ceil($count/$limit);

if ((int)$page > $length) $start = 0;
$query = mysqli_query($connection,"SELECT * FROM `news` ORDER BY idate DESC LIMIT $start, $limit");


function Pagination($length, $page){
    foreach (range(1, $length) as $p) echo '<a href="news.php?page='.$p.'"> '.$p.' </a>';
    /*        if($length < 5) foreach (range(1, $length) as $p) echo  '<a href="index.php?page='.$p.'"> '.$p.' </a>';
            if($length > 4 && $page < 5) foreach (range(1, 5) as $p) echo  '<a href="index.php?page='.$p.'"> '.$p.' </a>';
            if($length-5 < 5 && $page > 5) foreach (range($length-4, $length) as $p) echo  '<a href="index.php?page='.$p.'"> '.$p.' </a>';
            if($length > 4 && $length-5 < 5 && $page == 5) foreach (range($page-2, $length) as $p) echo  '<a href="index.php?page='.$p.'"> '.$p.' </a>';
            if($length > 4 && $length-5 > 5 && $page >= 5 && $page <= $length-4) foreach (range($page-2, $page+2) as $p) echo  '<a href="index.php?page='.$p.'"> '.$p.' </a>';
            if($length > 4 && $length-5 > 5 && $page > $length-4) foreach (range($length-4, $length) as $p) echo  '<a href="index.php?page='.$p.'"> '.$p.' </a>';*/
}

while ($article = mysqli_fetch_assoc($query)){
    $arResult[] = array(
        'idate' => date('d.m.Y ', $article['idate']),
        'title' => $article['title'],
        'id' => $article['id'],
        'announce' => $article['announce'],
    );
}



?>

<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
<h1>Новости</h1>

<?php foreach ($arResult as $item){?>
    <div class="titles">
        <div class="newDate"><?=$item['idate'] ?></div>
        <div class="title"><a href="view.php?id=<?=$item['id'] ?>"><?=$item['title'] ?></a></div>
    </div>
    <div class="announce"><?=$item['announce'] ?></div>
<?}?>
<?Pagination($length, $page);?>
<style>
    .titles {
        display: flex;
        border-radius: 2px;
    }
    .newDate{
        padding: 2px;
        background-color: red;

    }
</style>
<? foreach ($arPagination as $item){?>




<? }?>
</body>
</html>
