<?php
session_start();
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
    <title>新規登録</title>

    <!-- cssの導入 -->
    <link rel="stylesheet" href="css/SignUp.css">

    <!-- javascriptの導入 -->
    <script src="./script/script.js"></script>

    <!-- bootstrapのCSSの導入 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

</head>
<body>
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
    <!-- ヘッダーここまで -->
    <div class="null"></div>
    <div class="container">
        <div class="form-container">
            <h2 class="form-title">サインイン</h2>
            <form action="signUpCheck.php" method="post">
                <div class="form-group">
                        <p>メールアドレス</p>
                        <input type="text" name="user_mail" class="form-Input" placeholder="メールアドレス" required><br>

                        <p>パスワード</p>
                        <input type="password" name="user_password"class="form-Input" placeholder="パスワード" required><br>

                        <p>ユーザー名</p>
                        <input type="text" name="user_name" class="form-Input" placeholder="ユーザ名" required><br>

                    <input type="submit" class="form-submit" value="サインイン">

                </div>
                <a href="login.php">既にサインイン済みの方</a>

            </form>
        </div>
    </div>

<!-- bootstrapのjavascriptの導入 -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
</html>