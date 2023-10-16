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
    <title>プロジェクト作成</title>

    <!-- cssの導入 -->
    <link rel="stylesheet" href="css/style.css?v=2">
    <link rel="stylesheet" href="css/createProject.css?v=2">

    <!-- bootstrapのCSSの導入 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

</head>
<body>
    


    <a href="top.php">HOMEへ戻る</a>

    <form action="createProjectConfirm.php" method="post" enctype="multipart/form-data">

        <p>プロジェクト名</p>
        <input type="text" name="project_name">

        <p>サムネイル画像</p>
        <p>画像の入力欄を追加する</p>
        <span class="row mb-5">

            
            <!-- 追加された画像を表示する箇所 -->
            <div id="preview"></div>

            <!-- 画像追加のinputタグ -->
            <div>
                <input class="noneDisplay" type="file" name="project_thumbnail" id="project_thumbnail" ><br>
                <input type="button" onclick="document.getElementById('project_thumbnail').click()" value="アップロード">
                <p onclick="deleteThumbnail()" >この入力欄を削除する</p>
            </div>
            
            
        </span>

        <p>画像の入力欄を追加する</p>
        

        <p>目標金額</p>

        <p>プロジェクト期間</p>


        <!-- ここは一旦プロジェクトコースの入力欄にしておきました -->
        <p>プロジェクトリターン内容</p>

        <p>プロジェクト内容</p>

        <p>タグ</p>



    </form>

















    <!-- javascriptの導入 -->
    <script src="./script/script.js"></script>
    <script src="./script./createProject/addProjectThumbnail.js"></script>

    <!-- bootstrapのjavascriptの導入 -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
</html>