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

    //View表示
    $viewArray = $dao->selectAllProjectView();

    //ランキング表示
    $rankingArray = $dao->selectAllProjectRanking();

    // 新着表示
    $newArray = $dao->selectAllProjectNew();

    // おすすめ表示
    $likeArray = $dao->selectAllProjectLike();

    // もうすぐ始まる表示
    $readyArray = $dao->selectAllProjectReady();

    // 達成済み表示
    $compArray = $dao->selectAllProjectComplete();

    $userdata=null;
    if(isset($_SESSION['id'])){
        $userdata = $dao->selectUserById($_SESSION['id']);
    }

?>
<!-- ここまで -->
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ホーム画面</title>

    <!-- cssの導入 -->
    
    <link rel="stylesheet" href="css/header.css">
    <link rel="stylesheet" href="css/footer.css">
    <link rel="stylesheet" href="css/top.css">
    <link rel="stylesheet" href="css/postContents.css">

    <!-- javascriptの導入 -->
    <script src="./script/script.js"></script>

    <!-- bootstrapのCSSの導入 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

</head>
<body class="background">
    <!-- ヘッダーここから -->
    <header class="header">
        <img class="header-logo" src="img/IdecaLogo.png" onclick="window.location.href = 'top.php'">

        <div class="search-bar">
            <form id="search" action="searchResult.php" method="get"></form>

            <i class="bi bi-search search-icon" onclick="document.getElementById('search-input-id').click()"></i>
            <input class="search-input" id="search-input-id" type="text" form="search" name="keyword">

        </div>
            <div class="header-contents-area">
                <a href="createProject.php"><div class="project-link">プロジェクトを始める</div></a>
                <a href="createProject.php"><div class="project-link">プロジェクト掲載</div></a>
            <?php
                if(isset($_SESSION['id'])){
                        echo"
                            <div class='user-content'>
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

    <!-- メインビュー -->
    <div class="mainView">
        <div>
            <!-- ここでビューの表示 -->
            <?php
                foreach ($viewArray as $view) {
                    echo   "<img src='".$view['project_thumbnail_image']."' alt='メインビュー' class='mainView-image'>
                            <div class='mainview-overlapContents'>
                                <div class='mainView-title'>".$view['project_name']."</div>
                                <div class='mainView-contents'>
                                    <ul class='mainView-contents-list'>
                                        <li class='mainView-contents-money mainView-contents-lists'>現在の支援金額　<b>".$view['total_money']."円</b></li>
                                        <li class='mainView-contents-achievement mainView-contents-lists'>達成率　<b>".(int)$view['money_ratio']."'%</b></li>
                                        <li class='mainView-contents-supporter mainView-contents-lists'>支援者　<b>".$view['support_count']."人</b></li>
                                        <li class='mainView-contents-dayLeft mainView-contents-lists'>残り　<b>".(int)((strtotime($view['project_end']) - time()) / (60 * 60 * 24))."日</b></li>
                                    </ul>
                                    <a href='projectDetail.php?pid=".$view['project_id']."' style='text-decoration: none;'><div class='button mainView-contents-button'>VIEW</div></a>
                                </div>
                            </div>";
                }
                

            ?>
            <!-- <img src="img/Sauna.jpg" alt="メインビュー" class="mainView-image">
            <div class="mainview-overlapContents">
                <div class="mainView-title">麻生情報ビジネス専門学校を建て替える！</div>
                <div class="mainView-contents">
                    <ul class="mainView-contents-list">
                        <li class="mainView-contents-money mainView-contents-lists">現在の支援金額　<b>1,200,000円</b></li>
                        <li class="mainView-contents-achievement mainView-contents-lists">達成率　<b>150%</b></li>
                        <li class="mainView-contents-supporter mainView-contents-lists">支援者　<b>150人</b></li>
                        <li class="mainView-contents-dayLeft mainView-contents-lists">残り　<b>3日</b></li>
                    </ul>
                    <a href="" style="text-decoration: none;"><div class="button mainView-contents-button">VIEW</div></a>
                </div>
            </div> -->
        </div>
        
    </div>

    <!-- ピックアッププロジェクト -->
    <div class="project-pickUp">
        <div class="project-pickUp-title">PICK UP　プロジェクト</div>

        <ul class="project-pickUp-list">
            <li class="project-pickUp-lists">
                <img src="img/project-pickUp-contents.png" alt="ピックアップコンテンツ" class="project-pickUp-contentsImage">
            </li>

            <li class="project-pickUp-lists">
                <img src="img/project-pickUp-contents.png" alt="ピックアップコンテンツ" class="project-pickUp-contentsImage">
            </li>
                
            <li class="project-pickUp-lists">
                 <img src="img/project-pickUp-contents.png" alt="ピックアップコンテンツ" class="project-pickUp-contentsImage">
            </li>

            <li class="project-pickUp-lists">
                <img src="img/project-pickUp-contents.png" alt="ピックアップコンテンツ" class="project-pickUp-contentsImage">
            </li>
        </ul>
    </div>


    <!-- 各プロジェクト -->
    <div class="projects">

        <!-- ランキング -->
        <div class="project-ranking project-margin-bottom container-fluid">
            <div class="project-title">ランキング</div>
            <a href="" class="more-link"><div class="more">すべて見る ></div></a>
            <ul class="project-contents-list row justify-content-start">

                <!-- <li class="project-contents-lists col-md-3">
                    <div class="rank" style="color: #d70026;">1</div>
                    <img src="img/contentsImage.png" alt="コンテンツ" class="project-contents-lists-img">
                </li> -->

                <?php

                if(!empty($rankingArray)){
                    foreach ($rankingArray as $result) {
                        echo "<li class='project-contents-lists col-md-3' onclick=\"window.location.href = 'projectDetail.php?pid=".$result['project_id']."';\">";
                        echo "Project ID: " . $result['project_id'] . '<br>';
                        echo "Project Name: " . $result['project_name'] . '<br>';
                        echo "Support Count: " . $result['support_count'] . '人<br>';
                        echo "Total Money: " . $result['total_money'] . '円<br>';
                        echo "Money Ratio: " . (int)$result['money_ratio'] . '%<br>';
                        echo "Remaining Days: " . (int)((strtotime($result['project_end']) - time()) / (60 * 60 * 24)) . '日<br>';
                        echo "Thumbnail Image: <img src='" . $result['project_thumbnail_image'] . "'><br>";
                        echo "</li>";
                    }
                }else{
                    echo "<p>このトピックに当てはまるプロジェクトはありませんでした。</p>";
                }

                ?>

                <li class="project-contents-lists col-md-3">
                    <div class="rank" style="color: #edb83d; font-weight: 600;">1</div>
                    <!-- 投稿ここから -->
                    <div class="postArea">
                        <img src="img/postImage.png" alt="" class="postImage">
                        <div class="postTextArea">
                            <p class="postText">次世代の食洗器VERUSH「水だけ」なのに驚きの洗浄力！1回0.5円で農薬・殺菌除去！【1台で野菜、果物から哺乳瓶もまとめて洗浄】</p>
                            <div class="postValuePercent">
                                <div class="postValue">15,396,200円</div>
                                <div class="postPercent">5132%</div>
                            </div>
                            <div class="postNumberDay">
                                <div class="postUnder"><i class="bi bi-people"></i>　364人</div>
                                <div class="postUnder"><i class="bi bi-clock"></i>　5日</div>
                            </div>
                        </div>
                    </div>
                    <!-- 投稿ここまで -->
                </li>

                <li class="project-contents-lists col-md-3">
                    <div class="rank">2</div>
                    <!-- 投稿ここから -->
                    <div class="postArea">
                        <img src="img/postImage.png" alt="" class="postImage">
                        <div class="postTextArea">
                            <p class="postText">次世代の食洗器VERUSH「水だけ」なのに驚きの洗浄力！1回0.5円で農薬・殺菌除去！【1台で野菜、果物から哺乳瓶もまとめて洗浄】</p>
                            <div class="postValuePercent">
                                <div class="postValue">15,396,200円</div>
                                <div class="postPercent">5132%</div>
                            </div>
                            <div class="postNumberDay">
                                <div class="postUnder"><i class="bi bi-people"></i>　364人</div>
                                <div class="postUnder"><i class="bi bi-clock"></i>　5日</div>
                            </div>
                        </div>
                    </div>
                    <!-- 投稿ここまで -->
                </li>

                <li class="project-contents-lists col-md-3"> 
                    <div class="rank">3</div>
                    <!-- 投稿ここから -->
                    <div class="postArea">
                        <img src="img/postImage.png" alt="" class="postImage">
                        <div class="postTextArea">
                            <p class="postText">次世代の食洗器VERUSH「水だけ」なのに驚きの洗浄力！1回0.5円で農薬・殺菌除去！【1台で野菜、果物から哺乳瓶もまとめて洗浄】</p>
                            <div class="postValuePercent">
                                <div class="postValue">15,396,200円</div>
                                <div class="postPercent">5132%</div>
                            </div>
                            <div class="postNumberDay">
                                <div class="postUnder"><i class="bi bi-people"></i>　364人</div>
                                <div class="postUnder"><i class="bi bi-clock"></i>　5日</div>
                            </div>
                        </div>
                    </div>
                    <!-- 投稿ここまで -->
                </li>

                <li class="project-contents-lists col-md-3">
                    <div class="rank">4</div>
                    <!-- 投稿ここから -->
                    <div class="postArea">
                        <img src="img/postImage.png" alt="" class="postImage">
                        <div class="postTextArea">
                            <p class="postText">次世代の食洗器VERUSH「水だけ」なのに驚きの洗浄力！1回0.5円で農薬・殺菌除去！【1台で野菜、果物から哺乳瓶もまとめて洗浄】</p>
                            <div class="postValuePercent">
                                <div class="postValue">15,396,200円</div>
                                <div class="postPercent">5132%</div>
                            </div>
                            <div class="postNumberDay">
                                <div class="postUnder"><i class="bi bi-people"></i>　364人</div>
                                <div class="postUnder"><i class="bi bi-clock"></i>　5日</div>
                            </div>
                        </div>
                    </div>
                    <!-- 投稿ここまで -->
                </li>

            </ul>
        </div>

        <!-- 新着プロジェクト -->
        <div class="project-newProject project-margin-bottom container-fluid">
            <div class="project-title">新着プロジェクト</div>
            <a href="" class="more-link"><div class="more">すべて見る ></div></a>
                <ul class="project-contents-list row justify-content-start">

                    <!-- <li class="project-contents-lists col-md-3">
                        <img src="img/contentsImage.png" alt="コンテンツ" class="project-contents-lists-img">
                    </li> -->

                    <?php

                    if(!empty($newArray)){
                        foreach ($newArray as $result) {
                            echo "<li class='project-contents-lists col-md-3' onclick=\"window.location.href = 'projectDetail.php?pid=".$result['project_id']."';\">";
                            echo "Project ID: " . $result['project_id'] . '<br>';
                            echo "Project Name: " . $result['project_name'] . '<br>';
                            echo "Support Count: " . $result['support_count'] . '人<br>';
                            echo "Total Money: " . $result['total_money'] . '円<br>';
                            echo "Money Ratio: " . (int)$result['money_ratio'] . '%<br>';
                            echo "Remaining Days: " . (int)((strtotime($result['project_end']) - time()) / (60 * 60 * 24)) . '日<br>';
                            echo "Thumbnail Image: " . $result['project_thumbnail_image'] . '<br>';
                            echo "</li>";
                        }
                    }else{
                        echo "<p>このトピックに当てはまるプロジェクトはありませんでした。</p>";
                    }

                    ?>

                    <li class="project-contents-lists col-md-3">
                        <!-- 投稿ここから -->
                        <div class="postArea">
                            <img src="img/postImage.png" alt="" class="postImage">
                            <div class="postTextArea">
                                <p class="postText">次世代の食洗器VERUSH「水だけ」なのに驚きの洗浄力！1回0.5円で農薬・殺菌除去！【1台で野菜、果物から哺乳瓶もまとめて洗浄】</p>
                                <div class="postValuePercent">
                                    <div class="postValue">15,396,200円</div>
                                    <div class="postPercent">5132%</div>
                                </div>
                                <div class="postNumberDay">
                                    <div class="postUnder"><i class="bi bi-people"></i>　364人</div>
                                    <div class="postUnder"><i class="bi bi-clock"></i>　5日</div>
                                </div>
                            </div>
                        </div>
                        <!-- 投稿ここまで -->
                    </li>

                    <li class="project-contents-lists col-md-3">
                        <!-- 投稿ここから -->
                        <div class="postArea">
                            <img src="img/postImage.png" alt="" class="postImage">
                            <div class="postTextArea">
                                <p class="postText">次世代の食洗器VERUSH「水だけ」なのに驚きの洗浄力！1回0.5円で農薬・殺菌除去！【1台で野菜、果物から哺乳瓶もまとめて洗浄】</p>
                                <div class="postValuePercent">
                                    <div class="postValue">15,396,200円</div>
                                    <div class="postPercent">5132%</div>
                                </div>
                                <div class="postNumberDay">
                                    <div class="postUnder"><i class="bi bi-people"></i>　364人</div>
                                    <div class="postUnder"><i class="bi bi-clock"></i>　5日</div>
                                </div>
                            </div>
                        </div>
                        <!-- 投稿ここまで -->
                    </li>

                    <li class="project-contents-lists col-md-3">
                        <!-- 投稿ここから -->
                        <div class="postArea">
                            <img src="img/postImage.png" alt="" class="postImage">
                            <div class="postTextArea">
                                <p class="postText">次世代の食洗器VERUSH「水だけ」なのに驚きの洗浄力！1回0.5円で農薬・殺菌除去！【1台で野菜、果物から哺乳瓶もまとめて洗浄】</p>
                                <div class="postValuePercent">
                                    <div class="postValue">15,396,200円</div>
                                    <div class="postPercent">5132%</div>
                                </div>
                                <div class="postNumberDay">
                                    <div class="postUnder"><i class="bi bi-people"></i>　364人</div>
                                    <div class="postUnder"><i class="bi bi-clock"></i>　5日</div>
                                </div>
                            </div>
                        </div>
                        <!-- 投稿ここまで -->
                    </li>

                    <li class="project-contents-lists col-md-3">
                        <!-- 投稿ここから -->
                        <div class="postArea">
                            <img src="img/postImage.png" alt="" class="postImage">
                            <div class="postTextArea">
                                <p class="postText">次世代の食洗器VERUSH「水だけ」なのに驚きの洗浄力！1回0.5円で農薬・殺菌除去！【1台で野菜、果物から哺乳瓶もまとめて洗浄】</p>
                                <div class="postValuePercent">
                                    <div class="postValue">15,396,200円</div>
                                    <div class="postPercent">5132%</div>
                                </div>
                                <div class="postNumberDay">
                                    <div class="postUnder"><i class="bi bi-people"></i>　364人</div>
                                    <div class="postUnder"><i class="bi bi-clock"></i>　5日</div>
                                </div>
                            </div>
                        </div>
                        <!-- 投稿ここまで -->
                    </li>

                    <li class="project-contents-lists col-md-3">
                        <!-- 投稿ここから -->
                        <div class="postArea">
                            <img src="img/postImage.png" alt="" class="postImage">
                            <div class="postTextArea">
                                <p class="postText">次世代の食洗器VERUSH「水だけ」なのに驚きの洗浄力！1回0.5円で農薬・殺菌除去！【1台で野菜、果物から哺乳瓶もまとめて洗浄】</p>
                                <div class="postValuePercent">
                                    <div class="postValue">15,396,200円</div>
                                    <div class="postPercent">5132%</div>
                                </div>
                                <div class="postNumberDay">
                                    <div class="postUnder"><i class="bi bi-people"></i>　364人</div>
                                    <div class="postUnder"><i class="bi bi-clock"></i>　5日</div>
                                </div>
                            </div>
                        </div>
                        <!-- 投稿ここまで -->
                    </li>

                </ul>
        </div>

        <!-- もうすぐ始まるプロジェクト -->
        <div class="project-soon project-margin-bottom container-fluid">
            <div class="project-title">もうすぐ始まるプロジェクト</div>
            <a href="" class="more-link"><div class="more">すべて見る ></div></a>
                <ul class="project-contents-list row justify-content-start">

                    <!-- <li class="project-contents-lists col-md-3">
                        <img src="img/contentsImage.png" alt="コンテンツ" class="project-contents-lists-img">
                    </li> -->

                    <?php

                    if(!empty($readyArray)){
                        foreach ($readyArray as $result) {
                            echo "<li class='project-contents-lists col-md-3' onclick=\"window.location.href = 'projectDetail.php?pid=".$result['project_id']."';\">";
                            echo "Project ID: " . $result['project_id'] . '<br>';
                            echo "Project Name: " . $result['project_name'] . '<br>';
                            echo "Support Count: " . $result['support_count'] . '人<br>';
                            echo "Total Money: " . $result['total_money'] . '円<br>';
                            echo "Money Ratio: " . (int)$result['money_ratio'] . '%<br>';
                            echo "Remaining Days: " . (int)((strtotime($result['project_end']) - time()) / (60 * 60 * 24)) . '日<br>';
                            echo "Thumbnail Image: " . $result['project_thumbnail_image'] . '<br>';
                            echo "</li>";
                        }
                    }else{
                        echo "<p>このトピックに当てはまるプロジェクトはありませんでした。</p>";
                    }

                    ?>

                    <li class="project-contents-lists col-md-3">
                        <!-- 投稿ここから -->
                        <div class="postArea">
                            <img src="img/postImage.png" alt="" class="postImage">
                            <div class="postTextArea">
                                <p class="postText">次世代の食洗器VERUSH「水だけ」なのに驚きの洗浄力！1回0.5円で農薬・殺菌除去！【1台で野菜、果物から哺乳瓶もまとめて洗浄】</p>
                                <div class="postValuePercent">
                                    <div class="postValue">15,396,200円</div>
                                    <div class="postPercent">5132%</div>
                                </div>
                                <div class="postNumberDay">
                                    <div class="postUnder"><i class="bi bi-people"></i>　364人</div>
                                    <div class="postUnder"><i class="bi bi-clock"></i>　5日</div>
                                </div>
                            </div>
                        </div>
                        <!-- 投稿ここまで -->
                    </li>

                    <li class="project-contents-lists col-md-3">
                        <!-- 投稿ここから -->
                        <div class="postArea">
                            <img src="img/postImage.png" alt="" class="postImage">
                            <div class="postTextArea">
                                <p class="postText">次世代の食洗器VERUSH「水だけ」なのに驚きの洗浄力！1回0.5円で農薬・殺菌除去！【1台で野菜、果物から哺乳瓶もまとめて洗浄】</p>
                                <div class="postValuePercent">
                                    <div class="postValue">15,396,200円</div>
                                    <div class="postPercent">5132%</div>
                                </div>
                                <div class="postNumberDay">
                                    <div class="postUnder"><i class="bi bi-people"></i>　364人</div>
                                    <div class="postUnder"><i class="bi bi-clock"></i>　5日</div>
                                </div>
                            </div>
                        </div>
                        <!-- 投稿ここまで -->
                    </li>

                    <li class="project-contents-lists col-md-3">
                        <!-- 投稿ここから -->
                        <div class="postArea">
                            <img src="img/postImage.png" alt="" class="postImage">
                            <div class="postTextArea">
                                <p class="postText">次世代の食洗器VERUSH「水だけ」なのに驚きの洗浄力！1回0.5円で農薬・殺菌除去！【1台で野菜、果物から哺乳瓶もまとめて洗浄】</p>
                                <div class="postValuePercent">
                                    <div class="postValue">15,396,200円</div>
                                    <div class="postPercent">5132%</div>
                                </div>
                                <div class="postNumberDay">
                                    <div class="postUnder"><i class="bi bi-people"></i>　364人</div>
                                    <div class="postUnder"><i class="bi bi-clock"></i>　5日</div>
                                </div>
                            </div>
                        </div>
                        <!-- 投稿ここまで -->
                    </li>

                    <li class="project-contents-lists col-md-3">
                        <!-- 投稿ここから -->
                        <div class="postArea">
                            <img src="img/postImage.png" alt="" class="postImage">
                            <div class="postTextArea">
                                <p class="postText">次世代の食洗器VERUSH「水だけ」なのに驚きの洗浄力！1回0.5円で農薬・殺菌除去！【1台で野菜、果物から哺乳瓶もまとめて洗浄】</p>
                                <div class="postValuePercent">
                                    <div class="postValue">15,396,200円</div>
                                    <div class="postPercent">5132%</div>
                                </div>
                                <div class="postNumberDay">
                                    <div class="postUnder"><i class="bi bi-people"></i>　364人</div>
                                    <div class="postUnder"><i class="bi bi-clock"></i>　5日</div>
                                </div>
                            </div>
                        </div>
                        <!-- 投稿ここまで -->
                    </li>

                </ul>
        </div>

        <!-- おすすめプロジェクト -->
        <div class="project-recommendationProject project-margin-bottom container-fluid">
            <div class="project-title">おすすめプロジェクト</div>
            <a href="" class="more-link"><div class="more">すべて見る ></div></a>
                <ul class="project-contents-list row justify-content-start">

                    <!-- <li class="project-contents-lists col-md-3">
                        <img src="img/contentsImage.png" alt="コンテンツ" class="project-contents-lists-img">
                    </li> -->

                    <?php

                    if(!empty($likeArray)){
                        foreach ($likeArray as $result) {
                            echo "<li class='project-contents-lists col-md-3' onclick=\"window.location.href = 'projectDetail.php?pid=".$result['project_id']."';\">";
                            echo "Project ID: " . $result['project_id'] . '<br>';
                            echo "Project Name: " . $result['project_name'] . '<br>';
                            echo "Support Count: " . $result['support_count'] . '人<br>';
                            echo "Total Money: " . $result['total_money'] . '円<br>';
                            echo "Money Ratio: " . (int)$result['money_ratio'] . '%<br>';
                            echo "Remaining Days: " . (int)((strtotime($result['project_end']) - time()) / (60 * 60 * 24)) . '日<br>';
                            echo "Thumbnail Image: " . $result['project_thumbnail_image'] . '<br>';
                            echo "</li>";
                        }
                    }else{
                        echo "<p>このトピックに当てはまるプロジェクトはありませんでした。</p>";
                    }

                    ?>

                <li class="project-contents-lists col-md-3">
                        <!-- 投稿ここから -->
                        <div class="postArea">
                            <img src="img/postImage.png" alt="" class="postImage">
                            <div class="postTextArea">
                                <p class="postText">次世代の食洗器VERUSH「水だけ」なのに驚きの洗浄力！1回0.5円で農薬・殺菌除去！【1台で野菜、果物から哺乳瓶もまとめて洗浄】</p>
                                <div class="postValuePercent">
                                    <div class="postValue">15,396,200円</div>
                                    <div class="postPercent">5132%</div>
                                </div>
                                <div class="postNumberDay">
                                    <div class="postUnder"><i class="bi bi-people"></i>　364人</div>
                                    <div class="postUnder"><i class="bi bi-clock"></i>　5日</div>
                                </div>
                            </div>
                        </div>
                        <!-- 投稿ここまで -->
                    </li>

                    <li class="project-contents-lists col-md-3">
                        <!-- 投稿ここから -->
                        <div class="postArea">
                            <img src="img/postImage.png" alt="" class="postImage">
                            <div class="postTextArea">
                                <p class="postText">次世代の食洗器VERUSH「水だけ」なのに驚きの洗浄力！1回0.5円で農薬・殺菌除去！【1台で野菜、果物から哺乳瓶もまとめて洗浄】</p>
                                <div class="postValuePercent">
                                    <div class="postValue">15,396,200円</div>
                                    <div class="postPercent">5132%</div>
                                </div>
                                <div class="postNumberDay">
                                    <div class="postUnder"><i class="bi bi-people"></i>　364人</div>
                                    <div class="postUnder"><i class="bi bi-clock"></i>　5日</div>
                                </div>
                            </div>
                        </div>
                        <!-- 投稿ここまで -->
                    </li>

                    <li class="project-contents-lists col-md-3">
                        <!-- 投稿ここから -->
                        <div class="postArea">
                            <img src="img/postImage.png" alt="" class="postImage">
                            <div class="postTextArea">
                                <p class="postText">次世代の食洗器VERUSH「水だけ」なのに驚きの洗浄力！1回0.5円で農薬・殺菌除去！【1台で野菜、果物から哺乳瓶もまとめて洗浄】</p>
                                <div class="postValuePercent">
                                    <div class="postValue">15,396,200円</div>
                                    <div class="postPercent">5132%</div>
                                </div>
                                <div class="postNumberDay">
                                    <div class="postUnder"><i class="bi bi-people"></i>　364人</div>
                                    <div class="postUnder"><i class="bi bi-clock"></i>　5日</div>
                                </div>
                            </div>
                        </div>
                        <!-- 投稿ここまで -->
                    </li>

                    <li class="project-contents-lists col-md-3">
                        <!-- 投稿ここから -->
                        <div class="postArea">
                            <img src="img/postImage.png" alt="" class="postImage">
                            <div class="postTextArea">
                                <p class="postText">次世代の食洗器VERUSH「水だけ」なのに驚きの洗浄力！1回0.5円で農薬・殺菌除去！【1台で野菜、果物から哺乳瓶もまとめて洗浄】</p>
                                <div class="postValuePercent">
                                    <div class="postValue">15,396,200円</div>
                                    <div class="postPercent">5132%</div>
                                </div>
                                <div class="postNumberDay">
                                    <div class="postUnder"><i class="bi bi-people"></i>　364人</div>
                                    <div class="postUnder"><i class="bi bi-clock"></i>　5日</div>
                                </div>
                            </div>
                        </div>
                        <!-- 投稿ここまで -->
                    </li>

                </ul>
        </div>

        <!-- 達成したプロジェクト -->
        <div class="project-achievedProject project-margin-bottom container-fluid">
            <div class="project-title">達成したプロジェクト</div>
            <a href="" class="more-link"><div class="more">すべて見る ></div></a>
                <ul class="project-contents-list row justify-content-start">

                    <!-- <li class="project-contents-lists col-md-3">
                        <img src="img/contentsImage.png" alt="コンテンツ" class="project-contents-lists-img">
                    </li> -->

                    <?php

                    if(!empty($compArray)){
                        foreach ($compArray as $result) {
                            echo "<li class='project-contents-lists col-md-3' onclick=\"window.location.href = 'projectDetail.php?pid=".$result['project_id']."';\">";
                            echo "Project ID: " . $result['project_id'] . '<br>';
                            echo "Project Name: " . $result['project_name'] . '<br>';
                            echo "Support Count: " . $result['support_count'] . '人<br>';
                            echo "Total Money: " . $result['total_money'] . '円<br>';
                            echo "Money Ratio: " . (int)$result['money_ratio'] . '%<br>';
                            echo "Remaining Days: " . (int)((strtotime($result['project_end']) - time()) / (60 * 60 * 24)) . '日<br>';
                            echo "Thumbnail Image: " . $result['project_thumbnail_image'] . '<br>';
                            echo "</li>";
                        }
                    }else{
                        echo "<p>このトピックに当てはまるプロジェクトはありませんでした。</p>";
                    }

                    ?>

                <li class="project-contents-lists col-md-3">
                        <!-- 投稿ここから -->
                        <div class="postArea">
                            <img src="img/postImage.png" alt="" class="postImage">
                            <div class="postTextArea">
                                <p class="postText">次世代の食洗器VERUSH「水だけ」なのに驚きの洗浄力！1回0.5円で農薬・殺菌除去！【1台で野菜、果物から哺乳瓶もまとめて洗浄】</p>
                                <div class="postValuePercent">
                                    <div class="postValue">15,396,200円</div>
                                    <div class="postPercent">5132%</div>
                                </div>
                                <div class="postNumberDay">
                                    <div class="postUnder"><i class="bi bi-people"></i>　364人</div>
                                    <div class="postUnder"><i class="bi bi-clock"></i>　5日</div>
                                </div>
                            </div>
                        </div>
                        <!-- 投稿ここまで -->
                    </li>

                    <li class="project-contents-lists col-md-3">
                        <!-- 投稿ここから -->
                        <div class="postArea">
                            <img src="img/postImage.png" alt="" class="postImage">
                            <div class="postTextArea">
                                <p class="postText">次世代の食洗器VERUSH「水だけ」なのに驚きの洗浄力！1回0.5円で農薬・殺菌除去！【1台で野菜、果物から哺乳瓶もまとめて洗浄】</p>
                                <div class="postValuePercent">
                                    <div class="postValue">15,396,200円</div>
                                    <div class="postPercent">5132%</div>
                                </div>
                                <div class="postNumberDay">
                                    <div class="postUnder"><i class="bi bi-people"></i>　364人</div>
                                    <div class="postUnder"><i class="bi bi-clock"></i>　5日</div>
                                </div>
                            </div>
                        </div>
                        <!-- 投稿ここまで -->
                    </li>

                    <li class="project-contents-lists col-md-3">
                        <!-- 投稿ここから -->
                        <div class="postArea">
                            <img src="img/postImage.png" alt="" class="postImage">
                            <div class="postTextArea">
                                <p class="postText">次世代の食洗器VERUSH「水だけ」なのに驚きの洗浄力！1回0.5円で農薬・殺菌除去！【1台で野菜、果物から哺乳瓶もまとめて洗浄】</p>
                                <div class="postValuePercent">
                                    <div class="postValue">15,396,200円</div>
                                    <div class="postPercent">5132%</div>
                                </div>
                                <div class="postNumberDay">
                                    <div class="postUnder"><i class="bi bi-people"></i>　364人</div>
                                    <div class="postUnder"><i class="bi bi-clock"></i>　5日</div>
                                </div>
                            </div>
                        </div>
                        <!-- 投稿ここまで -->
                    </li>

                    <li class="project-contents-lists col-md-3">
                        <!-- 投稿ここから -->
                        <div class="postArea">
                            <img src="img/postImage.png" alt="" class="postImage">
                            <div class="postTextArea">
                                <p class="postText">次世代の食洗器VERUSH「水だけ」なのに驚きの洗浄力！1回0.5円で農薬・殺菌除去！【1台で野菜、果物から哺乳瓶もまとめて洗浄】</p>
                                <div class="postValuePercent">
                                    <div class="postValue">15,396,200円</div>
                                    <div class="postPercent">5132%</div>
                                </div>
                                <div class="postNumberDay">
                                    <div class="postUnder"><i class="bi bi-people"></i>　364人</div>
                                    <div class="postUnder"><i class="bi bi-clock"></i>　5日</div>
                                </div>
                            </div>
                        </div>
                        <!-- 投稿ここまで -->
                    </li>

                </ul>
        </div>
    </div>

    <div class="category-background">
        <div class="category">
            <div class="categorys container-fluid">
                <div class="category-title">カテゴリ</div>
                <ul class="category-list row justify-content-start">
                    <li class="category-lists col-md-3">ガジェット</li>
                    <li class="category-lists col-md-3">テクノロジー</li>
                    <li class="category-lists col-md-3">雑貨</li>
                    <li class="category-lists col-md-3">オーディオ</li>
                    <li class="category-lists col-md-3">アウトドア</li>
                    <li class="category-lists col-md-3">車/バイク</li>
                    <li class="category-lists col-md-3">ファッション</li>
                    <li class="category-lists col-md-3">スポーツ</li>
                    <li class="category-lists col-md-3">社会貢献</li>
                    <li class="category-lists col-md-3">アート</li>
                    <li class="category-lists col-md-3">出版</li>
                    <li class="category-lists col-md-3">地域活性化</li>
                    <li class="category-lists col-md-3">エンタメ</li>
                    <li class="category-lists col-md-3">音楽</li>
                    <li class="category-lists col-md-3">フード</li>
                    <li class="category-lists col-md-3">映像/映画</li>

                </ul>
            </div>
        </div>
    </div>

    <!-- フッター -->
    <footer class="footer container-fluid">
        <div class="row">
            <!-- カテゴリ -->
            <div class="footer-category col-md-5 container-fluid">
                <div class="footer-category-title">カテゴリ</div>
                <ul class="footer-category-list">
                    <li class="footer-category-lists">テクノロジー・ガジェット</li>
                    <li class="footer-category-lists">まちづくり・地域活性化</li>
                    <li class="footer-category-lists">プロダクト</li>
                    <li class="footer-category-lists">音楽</li>
                    <li class="footer-category-lists">フード・飲食店</li>
                    <li class="footer-category-lists">チャレンジ</li>
                    <li class="footer-category-lists">アニメ・映画</li>
                    <li class="footer-category-lists">スポーツ</li>
                    <li class="footer-category-lists">ファッション</li>
                    <li class="footer-category-lists">映像・映画</li>
                    <li class="footer-category-lists">ゲーム・サービス開発</li>
                    <li class="footer-category-lists">書籍・雑誌出版</li>
                    <li class="footer-category-lists">ビジネス・企業</li>
                    <li class="footer-category-lists">ビューティー・ヘルスケア</li>
                    <li class="footer-category-lists">アート・写真</li>
                    <li class="footer-category-lists">舞台・パフォーマンス</li>
                    <li class="footer-category-lists">ソーシャルグッド</li>
                </ul>
            </div>

                <!-- プロジェクト -->
                <div class="footer-project col-md-3">
                    <div class="border-height">
                        <div class="footer-project-title">プロジェクト</div>
                            <ul class="footer-project-list">
                                <li class="footer-project-lists">すべてのプロジェクト</li>
                                <li class="footer-project-lists">プロジェクト掲示板</li>
                                <li class="footer-project-lists">ランキング</li>
                                <li class="footer-project-lists">新着プロジェクト</li>
                                <li class="footer-project-lists">もうすぐ始まるプロジェクト</li>
                                <li class="footer-project-lists">おすすめプロジェクト</li>
                                <li class="footer-project-lists">達成したプロジェクト</li>
                                <li class="footer-project-lists">ピックアッププロジェクト</li>
                            </ul>
                    </div>
                </div>

            <!-- IDECAについて -->
            <div class="footer-about col-md-4">
                <div class="footer-about-title">IDECAについて</div>
                <ul class="footer-about-list">
                    <li class="footer-about-lists">IDECAとは</li>
                    <li class="footer-about-lists">ヘルプ</li>
                    <li class="footer-about-lists">お問い合わせ</li><br>
                    <li class="footer-about-lists">各種設定・利用規約</li>
                    <li class="footer-about-lists">プライバシーポリシー</li>
                </ul>
            </div>            
        </div>

        <div class="copyrightArea">
            <p class="copyright-text">Copyright @ IDECA, Inc. All Rights Reserved.</p>
        </div>
    </footer>
    
    



    <!-- bootstrapのjavascriptの導入 -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
</html>