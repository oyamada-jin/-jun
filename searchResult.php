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
    <title>検索結果</title>

    <!-- cssの導入 -->
    <link rel="stylesheet" href="css/style.css?v=2">

    <!-- javascriptの導入 -->
    <script src="./script/script.js"></script>

    <!-- bootstrapのCSSの導入 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

</head>
<body>
    
    <h1>"<?php echo $_GET['keyword'] ?>"の検索結果</h1>

    <?php
        $keyword = isset($_GET['keyword']) ? $_GET['keyword'] : '';
        $searchResults = $dao->searchProjects($keyword);

        foreach ($searchResults as $result) {
            echo "Project ID: " . $result['project_id'] . '<br>';
            echo "Project Name: " . $result['project_name'] . '<br>';
            echo "Support Count: " . $result['support_count'] . '<br>';
            echo "Total Money: " . $result['total_money'] . '<br>';
            echo "Money Ratio: " . $result['money_ratio'] . '%<br>';
            echo "Remaining Days: " . (strtotime($result['project_start']) - time()) / (60 * 60 * 24) . '<br>';
            echo "Thumbnail Image: " . $result['project_thumbnail_image'] . '<br>';  // 追加
            echo "<hr>";
        }
    ?>

<!-- bootstrapのjavascriptの導入 -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
</html>