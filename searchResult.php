<!-- 多分sessionは全ページ必須？なので消さないでください。 -->
<?php
session_start();
?>
<!-- sessionここまで -->

<!-- DAOを使用する場合は残してください。 -->
<?php
    //DAOの呼び出し
    require_once 'DAO.php';
    $dao = new DAO();

    $userdata = null;
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
    <title>検索結果</title>

    <!-- cssの導入 -->
    <link rel="stylesheet" href="css/header.css">
    <link rel="stylesheet" href="css/postContents.css">

    <!-- javascriptの導入 -->


    <!-- bootstrapのCSSの導入 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

</head>
<body>
    <!-- ヘッダーここから -->
    <header class="header">
        <img class="header-logo" src="img/IdecaLogo.png" onclick="window.location.href = 'top.php'">

        <div class="search-bar" onclick="document.getElementById('search-input-id').click()">
            <form id="search" action="searchResult.php" method="get"></form>

            <i class="bi bi-search search-icon"></i>
            <input class="search-input" id="search-input-id" type="text" form="search" name="keyword">

        </div>
            <div class="header-contents-area">
                <a href="createProject.php"><div class="project-link">プロジェクトを始める</div></a>
                <a href="board.php"><div class="project-link">アイデア掲示板</div></a>
            <?php
                if(isset($_SESSION['id'])){
                        echo"
                            <div class='user-content' onclick=\"window.location.href = 'profile.php?user_id=".$_SESSION['id']."'\" >
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
    
    <h1>"<?php echo $_GET['keyword'] ?>"の検索結果</h1>

    <?php
        // 使用例
        $keyword = isset($_GET['search']) ? $_GET['search'] : '';
        $searchResults = $dao->searchProjects($keyword);

        foreach ($searchResults as $result) {
            echo "
                <div class='postArea' onclick=\"window.location.href='projectDetail.php?pid=".$result['project_id']."'\">
                    <img src='".(file_exists($result['project_thumbnail_image']) ? $result['project_thumbnail_image'] : 'img/noImage_'.rand(1,2).'.jpg')."' alt='' class='postImage'>
                    <div class='postTextArea'>
                        <p class='postText'>$result[project_name]</p>
                        <div class='postValuePercent'>
                            <div class='postValue'>".number_format($result['total_money'])."円</div>
                            <div class='postPercent'>".(int)$result['money_ratio']."%</div>
                        </div>
                        <div class='postNumberDay'>
                            <div class='postUnder'><i class='bi bi-people'></i>　".$result['support_count']."人</div>
                            <div class='postUnder'><i class='bi bi-clock'></i>　".(int)((strtotime($result['project_end']) - time()) / (60 * 60 * 24))."日</div>
                        </div>
                    </div>
                </div>
                <!-- 投稿ここまで -->
            ";
        }
    ?>

<!-- bootstrapのjavascriptの導入 -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

</body>
</html>