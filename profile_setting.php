<?php
session_start();

require_once 'DAO.php';
    $dao = new DAO();
    $userdata = null;
    if(isset($_SESSION['id'])){
        $userdata = $dao->selectUserById($_SESSION['id']);
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>プロフィール</title>

    <link rel="stylesheet" href="css/header.css?<?php echo date('YmdHis'); ?>">
    <link rel="stylesheet" href="css/profile_setting.css?<?php echo date('YmdHis'); ?>">

</head>
<body style="background-image: url('hai.svg');">
    <!-- ヘッダーここから  -->
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

    <div class="haikei">
    <img src="./img/gear.svg" width="50" height="50" alt="" class="size">
        <div class="d1">プロフィール</div>
        <div class="d2">プロジェクト</div>
        <div class="d3">届け先情報</div>
        <div class="d4">井之頭 権三郎</div>
        <div class="d5">gonzapzap@outlook.jp</div>
        <div class="d6">私は井之頭 権三郎と申します。
            リンゴ味のマーガリンや、バニラ味のアイスなど、
            様々なものを開発しました。
            どうぞ応援よろしくお願いします。
        </div>

        <button>新規登録</button>

    </div>
</body>
</html>