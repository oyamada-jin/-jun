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

?>
<!-- ここまで -->
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>応援プロジェクトID入力</title>

    <!-- cssの導入 -->


    <!-- javascriptの導入 -->


    <!-- bootstrapのCSSの導入 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

</head>
<body>
    <h1>応援するプロジェクトのproject_idを入力してください。</h1>
    <form action="projectSupport.php" method="post">
        コースID<input type="number" name="project_id">
        コース明細ID<input type="number" name="project_detail_id">
        <input type="submit" value="プロジェクトを応援する">
    </form>
    


<!-- bootstrapのjavascriptの導入 -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
</html>