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

    $userdata=null;
    if(isset($_SESSION['id'])){
        $userdata = $dao->selectUserById($_SESSION['id']);
    }

    // プロジェクト情報取得
    $project = $dao->selectProjectDetailById($_GET['pid']);
    $project_id = $project['project_id'];

    //プロジェクトを投稿したユーザの情報取得
    $createUserdata = $dao->selectUploadUserById($project['user_id']);

    // サムネイル画像取得
    $thumbnailArray = $dao->selectProjectThumbnailById($project_id);

    // タグ情報取得
    $tag = $dao->selectProjectTagById($project_id);

    // 内容情報取得
    $intro = $dao->selectProjectIntroById($project_id);

    //コース情報取得
    $course = $dao->selectProjectCourseById($project_id);

?>
<!-- ここまで -->
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $project['project_name'] ?></title>

    <!-- cssの導入 -->
    <link rel="stylesheet" href="css/header.css">
    <link rel="stylesheet" href="css/p_syousai.css">
    
    <!-- javascriptの導入 -->
    <script src="./script/p_syousai.js"></script>
    <script src="script/toggleLike.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

    <!-- bootstrapのCSSの導入 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

</head>
<body class="background">
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

    <!-- タイトルとハッシュタグ機能 -->
    <div class="a">
        <section class="project-name">
            <h1><?php echo $project['project_name'] ?></h1>
            <p><?php
                foreach ($tag as $tagPiece) {
                    echo "#".$tagPiece['tag_name']." ";
                }
            ?></p>
        </section>

            <!-- メイン -->


        <div class= "container">
            <div class="row">
                <div class="col-xs-12 col-lg-8">
                    <div class="pp">
                        <div class='photo'>
                            <div class="selected-image-container">
                                <img class='selected-image' src='<?php echo $thumbnailArray[0]['project_thumbnail_image'] ?>' alt='Selected Image'>
                            </div>
                        </div>
                        <div class="gallery-container">
                            <?php
                            foreach ($thumbnailArray as $index => $thumbnail) {
                                echo "
                                    <div class='thumbnail-container'>
                                        <img class='thumbnail' src='" . $thumbnail['project_thumbnail_image'] . "' alt='Thumbnail " . ($index + 1) . "'>
                                    </div>
                                ";
                            }
                            ?>
                        </div>
                    </div>
                </div>
                <div class="col-xs-12 col-lg-4">
                    <div class="aa">
                        <p class="money">￥ 現在の支援金額</p>
                        <h1><?php echo number_format($project['total_money']) ?>円</h1>
                        <progress value="<?php echo (int)$project['money_ratio'] ?>" max="100"><?php echo (int)$project['money_ratio'] ?>%</progress><br>
                        <p class="m">目標金額<?php echo number_format($project['project_goal_money']) ?>円</p>
                        <div class="sien">
                                <span>  支援者 <?php echo $project['support_count'] ?>人</span>
                        </div><br>
                            <div class="sien">
                                <span>  残　り <?php echo (int)((strtotime($project['project_end']) - time()) / (60 * 60 * 24)) ?>日</span>
                        </div>
                                
                        <!-- コメント関連 -->
                        <!-- <div class="icon">
                            <img src="img/icon/default.png" alt="アイコン">                   
                        </div>
                        <div class="user-name">
                            <p>wawawaw</p>
                        </div>
                        <div class="comment">
                            <p>学生も勉学に励めると思うので応援お願いします！</p>
                        </div> -->
                        
                        
                        <div class="sien_b">
                            <button>支援にすすむ</button>
                        </div>
                        <p class="like" id="likeButton" data-project-id="<?php echo $project_id; ?>" onclick="toggleLike(<?php echo $_SESSION['id'].','.$project_id; ?>)">
                            <?php
                                // サーバから気になっているかの情報を取得
                                $isLiked = $dao->checkIfHeartExists($_SESSION['id'], $project_id);
                                if ($isLiked) {
                                    echo '気になる済み';
                                } else {
                                    echo '気になる';
                                }
                            ?>
                        </p>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 col-lg-8">
                    <div class="goods ms-5">
                        <h1>・プロジェクト紹介</h1>
                        <?php
                        foreach ($intro as $introPiece) {
                            if ($introPiece['project_intro_flag'] == '0') {
                                // テキストの場合
                                echo "<p class='text-intro'>" . $introPiece['project_intro_text'] . "</p>";
                            } elseif ($introPiece['project_intro_flag'] == '1') {
                                // 画像の場合
                                echo "<div class='image-intro'><img src='" . $introPiece['project_intro_image'] . "' alt='Introduction Image'></div>";
                            }
                        }
                        ?>
                    </div>
                </div>
                <div class="col-xs-12 col-lg-4">
                    
                    <!-- 投稿ユーザの情報 -->
                    <div class="plofile" onclick="window.location.href='profile.php?user_id=<?php echo $createUserdata['user_id'] ?>'">
                        <img src="<?php echo $createUserdata['user_icon']; ?>" alt="User Icon">
                        <p><?php echo $createUserdata['user_name']; ?></p>
                        <p>他に<?php echo $createUserdata['totalProjectCount']; ?>件のプロジェクトを掲載しています</p>
                        <?php if ($createUserdata['user_intro'] !== null): ?>
                            <p><?php echo $createUserdata['user_intro']; ?></p>
                        <?php else: ?>
                            <p>紹介文はありません</p>
                        <?php endif; ?>
                    </div><br>

                    <!-- コース情報 -->
                    <?php
                    $courseCounter=0;
                    foreach ($course as $courseInfo) {
                        echo '<div class="plan">';
                        echo '<p id="p_money">' . $courseInfo['project_course_value'] . '円</p>';
                        echo '<p id="stock">残り' . 100-$courseInfo['total_support_users_count'] . '個</p>';
                        echo '<img src="' . $courseInfo['project_course_thumbnail'] . '" alt="" id="aso2_p">';
                        echo '<h2>' . $courseInfo['project_course_name'] . '</h2>';
                        echo '<p>' . $courseInfo['project_course_intro'] . '</p>';
                        echo '<div class="sien"><span>支援者: ' . $courseInfo['total_support_users_count'] . '人</span></div><br>';
                        echo '<a href="projectSupport.php?project_id=' . $project_id . '&project_detail_id=' . $courseCounter . '"><button>支援に進む</button></a>';
                        echo '</div>';
                        $courseCounter++;
                    }
                    ?>


                    
                </div>
            </div>
        </div>
        
        
    </div>
    </div>
    

<script>
    $(document).ready(function () {
        // サムネイルがクリックされたときの処理
        $('.thumbnail').click(function () {
            var imageUrl = $(this).attr('src');
            $('.selected-image').attr('src', imageUrl);
        });
    });
</script>
<!-- bootstrapのjavascriptの導入 -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
</html>