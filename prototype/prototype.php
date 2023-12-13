<!-- 多分sessionは全ページ必須？なので消さないでください。 -->
<?php
session_start();
?>
<!-- sessionここまで -->

<!-- ログイン必須ページだけここのコードを残してください。 -->
<?php
if(isset($_SESSION['id']) == false){
   header('Location: login.php');
   exit();
}
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
    <title>ここに論理ページ名を入力</title>

    <!-- cssの導入 -->


    <!-- javascriptの導入 -->


    <!-- bootstrapのCSSの導入 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

</head>
<body>
    <!-- ヘッダーここから -->
    <header class="header">
        <img class="header-logo" src="img/IdecaLogo.png" onclick="window.location.href = 'top.php'">

        <div class="search-bar">
            <form id="search" action="searchResult.php" method="get"></form>
            <img class="search-icon" src="" onclick="document.getElementById('search-input-id').click()">
            <input class="search-input" id="search-input-id" type="text" form="search" name="keyword">
        </div>

        <div class="header-contents-area">
            <a href="IdeaPost.php"><div class="project-link" onclick="window.location.href='createProject.php'">プロジェクトを始める</div></a>
            <a href=""><div class="project-link" onclick="window.location.href='createProject.php'">プロジェクト掲載</div></a>
            <button class="header-button login-button" onclick="window.location.href='Login.php'">ログイン</button>
            <button class="header-button signUp-button" onclick="window.location.href='signUp.php'">新規登録</button>
        </div>
    </header>
    <!-- ヘッダーここまで -->
    



<!-- bootstrapのjavascriptの導入 -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
</html>