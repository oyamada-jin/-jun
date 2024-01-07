<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>プロフィール</title>

    <link rel="stylesheet" href="css/header.css?<?php echo date('YmdHis'); ?>">
    <link rel="stylesheet" href="css/profile3.css?<?php echo date('YmdHis'); ?>">

</head>
<body style="background-image: url('hai.svg');">
     <!-- ヘッダーここから -->
   <header class="header">
        <img class="header-logo" src="img/IdecaLogo.png">

        <div class="search-bar">
            <img class="search-icon" src="">
            <input class="search-input" type="text">
        </div>

        <div class="header-contents-area">
            <div class="project-link">プロジェクトを始める</div>
            <div class="project-link">プロジェクト掲載</div>
            <button class="header-button login-button">ログイン</button>
            <button class="header-button signUp-button">新規登録</button>
        </div>
    </header>

    <div class="haikei">
        <div class="d1">プロフィール</div>
        <div class="d2">プロジェクト</div>
        <div class="d3">届け先情報</div>
        <div class="d4">井之頭 権三郎さんの登録した届け先情報</div>

    </div>
</body>
</html>