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


    <!-- javascriptの導入 -->


    <!-- bootstrapのCSSの導入 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

</head>
<body>
    
    <h1>"<?php echo $_GET['keyword'] ?>"の検索結果</h1>

    <?php
        // 使用例
        $keyword = isset($_GET['search']) ? $_GET['search'] : '';
        $searchResults = $dao->searchProjects($keyword);

        // 結果の表示
        foreach ($searchResults as $result) {
            echo "<div onclick=\"window.location.href = 'projectDetail.php?pid=".$result['project_id']."';\">";
            echo "Project ID: " . $result['project_id'] . '<br>';
            echo "Project Name: " . $result['project_name'] . '<br>';
            echo "Support Count: " . $result['support_count'] . '人<br>';
            echo "Total Money: " . $result['total_money'] . '円<br>';
            echo "Money Ratio: " . (int)$result['money_ratio'] . '%<br>';
            echo "Remaining Days: " . (int)((strtotime($result['project_end']) - time()) / (60 * 60 * 24)) . '日<br>';
            echo "Thumbnail Image: " . $result['project_thumbnail_image'] . '<br>';
            echo "</div>";
            echo "<hr>";
        }
    ?>

<!-- bootstrapのjavascriptの導入 -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

</body>
</html>