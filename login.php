<?php
session_start();
?>

<!-- ここまで -->
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ログイン</title>

    <!-- cssの導入 -->
    <link rel="stylesheet" href="css/login.css">

    <!-- javascriptの導入 -->
    <script src="./script/script.js"></script>

    <!-- bootstrapのCSSの導入 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

</head>
<body style="background-image: url('hai.svg');">
    <div class="haikei">
    
    <h2>ログイン</h2>

    <form action="loginCheck.php" method="post">

        <p>メールアドレス</p>
        <input type="text" name="user_mail" placeholder="メールアドレス"><br>

        <p>パスワード</p>
        <input type="password" name="user_password" placeholder="パスワード"><br>

        <input type="submit" value="ログイン">

    </form>

    <a href="signUp.php">アカウントをお持ちでない方</a>

    </div>

<!-- bootstrapのjavascriptの導入 -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
</html>