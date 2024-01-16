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

    //表示するユーザのデータを入れる変数
    $searchUserId;
    //このユーザページが閲覧しているユーザの物か判別する変数
    $isMine;
    $_SESSION['id'] = 1; 
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $searchUserId = $_POST['user_id'];
    } elseif ($_SERVER['REQUEST_METHOD'] === 'GET') {
        $searchUserId = $_GET['user_id'];
    } else {
        // それ以外の場合はエラー処理などを行う
        // この例では何もしませんが、実際のプロジェクトではエラーページなどにリダイレクトするなどの対応が必要です
        die('Invalid request method');
    }

    $userdata = null;
    if(isset($_SESSION['id'])){
        $userdata = $dao->selectUserById($_SESSION['id']);
    }
    $userProject = $dao->searchProjectsByUserId($searchUserId);

    if($searchUserId == $_SESSION['id']){
        $isMine = true;
        $userAddress = $dao->selectAllAddressById($searchUserId);

    }else{
        $isMine = false;
    }

?>
<!-- ここまで -->
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $userdata['user_name'] ?>さんのプロフィール</title>

    <!-- cssの導入 -->
    <link rel="stylesheet" href="css/header.css?<?php echo date('YmdHis'); ?>">
    <link rel="stylesheet" href="css/profile.css">

    <!-- javascriptの導入 -->
    <script src="script/profile/changeTab.js"></script>

    <!-- bootstrapのCSSの導入 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

</head>
<!-- <body style="background-image: url('hai.svg');"> -->
<body style="background-color: #fff;">
    <!-- ヘッダーここから -->
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
    
    <div class="haikei row">
        <!-- setting画像 -->
        <img src="./img/gear.svg" width="50" height="50" alt="" class="size" onclick="window.location.href = 'setting.php?uid=<?php echo $searchUserId ?>'">
        
        
        <div class="tabs col-2">
            <div class="d1" onclick="changeTab(1)">プロフィール</div>
            <div class="d2" onclick="changeTab(2)">プロジェクト</div>
            <div class="d3" onclick="changeTab(3)">届け先情報</div>
        </div>
        <div class="col-8">
            

            <div id="tab1" class="tab-content active">
                <div class="user-data">
                    <img src="img/icon/default.png" class="icon-img" alt="">
                    <div class="user-name"><?php echo $userdata['user_name'] ?></div>
                    <div class="user-mail"><?php echo $userdata['user_mail'] ?></div>
                </div>
                
                <div class="d6">
                    <?php echo $userdata['user_intro'] ?>
                </div>
            </div>

            <div id="tab2" class="tab-content">
                <div class="d4"><?php echo $userdata['user_name'] ?>さんの作成したプロジェクト</div>
                <div>
                    <?php
                        foreach ($userProject as $result) {
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
                </div>
            </div>

            <div id="tab3" class="tab-content">
                <div class="d4"><?php echo $userdata['user_name'] ?>さんの登録した届け先情報</div>
                <?php
                    if($isMine){
                        foreach ($userAddress as $address) {
                            
                            echo "<label for='".$address['address_detail_id']."'>"
                                        .$address['chi_name']
                                        .$address['kana_name']
                                        .$address['post_code']
                                        .$address['user_address']
                                        .$address['mail_address']
                                ."</label><hr/>";
                        }
                    }else{
                        echo "<p>こちらのユーザの届け先情報は閲覧できません</p>";
                    }

                ?>
            </div>
        </div>
        
        

    </div>
            



<!-- bootstrapのjavascriptの導入 -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
</html>