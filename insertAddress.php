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
    
    <div>
        <form action="insertAddressCheck.php" method="post">
            <p>お名前【全角文字】</p>
            <input type="text" name="chi_name">
            <p>お名前カナ【全角カタカナ】</p>
            <input type="text" name="kana_name">
            <p>電話番号【半角数字】</p>
            <input type="text" name="phone_number">
            <p>郵便番号【半角数字】</p>
            <input type="text" name="post_code">
            <p>ご自宅住所【全角文字】</p>
            <input type="text" name="user_address">
            <p>お名前【全角英数字】</p>
            <input type="text" name="mail_address">

            <input type="submit" value="登録する">
        </form>
    </div>


<!-- bootstrapのjavascriptの導入 -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
</html>