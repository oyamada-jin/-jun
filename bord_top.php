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
    $userdata=null;
    if(isset($_SESSION['id'])){
        $userdata = $dao->selectUserById($_SESSION['id']);
    }
?>
<!-- ここまで -->
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>掲示板画面</title>

    <!-- cssの導入 -->
    <link rel="stylesheet" href="css/header.css">

    <!-- javascriptの導入 -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="./script/script.js"></script>


    <!-- bootstrapのCSSの導入 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

</head>
<body>
    <!-- ヘッダーここから -->
    <!-- ヘッダーここから -->
    <header class="header">
        <img class="header-logo" src="img/IdecaLogo.png" onclick="window.location.href = 'top.php'">

        <div class="search-bar">
            <form id="search" action="searchResult.php" method="get"></form>
            <img class="search-icon" src="" onclick="document.getElementById('search-input-id').click()">
            <input class="search-input" id="search-input-id" type="text" form="search" name="keyword">
        </div>
            <div class="header-contents-area">
                <a href="createProject.php"><div class="project-link">プロジェクトを始める</div></a>
                <a href="createProject.php"><div class="project-link">プロジェクト掲載</div></a>
            <?php
                if(isset($_SESSION['id'])){
                        echo"
                            <div class='user-content'>
                                <img src='".$userdata['user_icon']."' class='user-icon'>
                                <p class='user-name'>".$userdata['user_name']."</p>
                            </div>        
                        ";
                }else{
                        echo"
                            <button class='header-button login-button' onclick=\'window.location.href='Login.php'\'>ログイン</button>
                            <button class='header-button signUp-button' onclick=\'window.location.href='signUp.php'\'>新規登録</button>
                            
                        ";
                }

            ?>
        </div>
    </header>
    <!-- ヘッダーここまで -->
<button type=“button” onclick="location.href='top.php'">ホーム画面に遷移する！</button>
<h1>このアイデアが注目されています</h1>
<?php
$searchArray = $dao->board_get_randam();
shuffle($searchArray);
$firstThree = array_slice($searchArray, 0, 3);
?>

<?php foreach ($firstThree as $row) : ?>
    <div>
        <img src="<?php echo $row['user_icon']; ?>" class="user_icon_ft">
        <?php echo $row['user_name']; ?>
        <?php echo $row['comment_time']; ?><br>
        <?php echo $row['comment_content']; ?>

        <!-- フォームを追加 -->
        <form action="insert_bord_good.php" method="post">
            <input type="hidden" name="comment_id" value="<?php echo $row['comment_id']; ?>">
            <button type="submit">
                <img src="img/button/good_button.png">
            </button>
        </form>
        <br>
    </div>
<?php endforeach; ?>




<h1>みんなのアイデア</h1>
<?php


    $searchUser = $dao->get_username_icon();
    echo '<h2><img src="' . $searchUser[0]['user_icon'] . '" class="user_icon_ft">' . $searchUser[0]['user_name'] . 'として投稿</h2>';
    echo '<form method="post" action="">
    <label for="comment">コメント：</label>
    <textarea name="comment" id="comment" required></textarea>
    <input type="submit" name="submit" value="投稿">
    </form>;';
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