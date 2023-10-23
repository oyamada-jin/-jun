<!-- 多分sessionは全ページ必須？なので消さないでください。 -->
<?php
session_start();
?>
<!-- sessionここまで -->

<!-- ログイン必須ページだけここのコードを残してください。 -->

<?php
//if(isset($_SESSION['id']) == false){
   //header('Location: login.php');
   //exit();
//}
?>

<!-- ログイン必須用はここまで -->

<!-- DAOを使用する場合は残してください。 -->
<?php
    //DAOの呼び出し
    require_once 'DAO.php';
    $dao = new DAO();

?>
<!-- ここまで -->
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>掲示板トップ画面</title>

    <!-- cssの導入 -->
    <link rel="stylesheet" href="css/style.css?v=2">

    <!-- javascriptの導入 -->
    <script src="./script/script.js"></script>

    <!-- bootstrapのCSSの導入 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

</head>
<body>
<button type=“button” onclick="location.href='top.php'">ホーム画面に遷移する！</button>
<h1>このアイデアが注目されています</h1>
<?php
    $searchArray = $dao->board_get_randam();
    shuffle($searchArray);
    $firstThree = array_slice($searchArray, 0, 3);

// データを表示
foreach ($firstThree as $row) {
    // "Comment ID: " . $row['comment_id'] . "<br>";
    echo '<img src="' . $row['user_icon'] . '" class="user_icon_ft">';
    echo  $row['user_name'];
    echo  $row['comment_time'] . "<br>";
    echo  $row['comment_content'] . "<br>";
    
}
?>
<h1>みんなのアイデア</h1>
<?php

if(isset($_SESSION[0]['user_name']) && $_SESSION[0]['user_name'] !== null) {
    $searchUser = $dao->get_username_icon();
    echo '<h2><img src="' . $searchUser[0]['user_icon'] . '" class="user_icon_ft">' . $searchUser[0]['user_name'] . 'として投稿</h2>';
    echo '<form method="post" action="">
    <label for="comment">コメント：</label>
    <textarea name="comment" id="comment" required></textarea>
    <input type="submit" name="submit" value="投稿">
</form>;';
}
?>



<?php
// フォームが送信されたときの処理
if (isset($_POST['submit'])) {
    $post_comment = $_POST['comment'];
    $post_comments = $dao->post_bord_comment($post_comment);
}
?>


<?php
//コメント全件取得
$searchArray = $dao->board_get_all();
//コメント新しい順取得
$searchTimeASC = $dao->get_time_comment();
//コメントいいね順取得
$searchHeartDesc = $dao->get_heart_comment();
?>
<div>
    <button id="sortByNewest">新しい順に表示</button>
    <button id="sortByLikes">いいねが多い順に表示</button>
</div>
<div id="comments">

</div>
<script>
    const searchTimeASC = <?php echo json_encode($searchTimeASC); ?>;
    const searchHeartDesc = <?php echo json_encode($searchHeartDesc); ?>;
</script>
<!-- bootstrapのjavascriptの導入 -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
</html>