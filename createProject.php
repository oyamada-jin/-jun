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
    <title>プロジェクト作成</title>

    <!-- cssの導入 -->

    <link rel="stylesheet" href="css/createProject.css?v=2">
    <link rel="stylesheet" href="css/header.css">
    <link rel="stylesheet" href="css/footer.css">


    <!-- bootstrapのCSSの導入 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

</head>
<body class="background">

    <!-- ヘッダーここから -->
    <header class="header">
        <img class="header-logo" src="img/IdecaLogo.png" onclick="window.location.href = 'top.php'">

        <div class="search-bar">
            <form id="search" action="searchResult.php" method="get"></form>
            <img class="search-icon" src="" onclick="document.getElementById('search-input-id').click()">
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


    <div class="createProject-area">
        <a href="top.php" class="backHome">＜ HOMEへ戻る</a>

        <form action="createProjectConfirm.php" method="post" enctype="multipart/form-data">

            <span>

                <p style="font-size: 24px;">プロジェクト名</p>
                <input type="text" name="project_name" required class="inputProject">
            
            </span><hr>
        
            <span class="row mb-5">

                <!-- 画像追加のinputタグ -->
                <div class="project_Thumbnail">

                    <p style="font-size: 24px;">サムネイル画像</p>
                    <input type="hidden" name="project_thumbnail_piece" id="project_thumbnail_piece" value=1>
                    <p onclick="addThumbnail()" style="color: #d70026;">入力欄を追加する</p>
                    
                    <div id="project_thumbnail_1">
                
                        <input class="noneDisplay" type="file" name="project_thumbnail[]" id="project_thumbnail_input_1" onchange="handleFileSelectThumbnail('project_thumbnail_input_1','project_thumbnail_img_1')" required><br>
                        <img src="img/project_thumbnail/default.png" class="ThumbnailImg" id="project_thumbnail_img_1" alt="Image" onclick="document.getElementById('project_thumbnail_input_1').click()" style="margin-bottom: 40px;">

                    </div>
                    
                    
                
                </div>
                
                
            </span><hr>
            

            <span>

                <p style="font-size: 24px;">目標金額</p>
                <input type="num" name="project_goal_money" required style="width: 350px; border: 1px solid rgba(0, 0, 0, 0.36);background: #FFF;border-radius: 4px;">　円

            </span><hr>

            <span>
                <p style="font-size: 24px;">プロジェクト期間</p>

                <input type="date" name="project_start" required>
                <input type="date" name="project_end" required>

            </span><hr>

            <!-- ここは一旦プロジェクトコースの入力欄にしておきました -->
            <span>
        
                <p style="font-size: 24px;">プロジェクトリターン内容</p>
                <input type="hidden" name="project_course_piece" id="project_course_piece" value=1>
                <p onclick="addCourse()" style="color: #d70026;">コースの入力欄を増やす</p>
            
                <div class="project_course">

                    <div id="project_course_1">
                        
                        <input class="noneDisplay" type="file" name="project_course_file[]" id="project_course_file_1" onchange="handleFileSelectCourse('project_course_file_1','project_course_img_1')" required>
                        <img src="img/project_Course/default.png" class="CourseImg" id="project_course_img_1" alt="Image" onclick="document.getElementById('project_course_file_1').click()"><br>
                        <input type="text" name="project_course_name[]" class="project_course_name" id="project_course_name_1" required style="margin-bottom: 5px; width: 350px;"><br>
                        <input type="text" name="project_course_intro[]" class="project_course_intro" id="project_course_intro_1" required style="margin-bottom: 5px; width: 350px;"><br>
                        <input type="number" name="project_course_value[]" class="project_course_value" id="project_course_value_1" required style="width: 350px;">

                    </div>
                
                </div>
        
            </span><hr>
            
            
            
            <span>

                

                <div class="project_intro">

                    <p style="font-size: 24px;">プロジェクト内容</p>
                    <input type="hidden" name="project_intro_piece" id="project_intro_piece" value=0>
                    <p onclick="addIntro(0)" style="color: #d70026;">テキストを追加する</p><p onclick="addIntro(1)" style="color: #d70026;">画像を追加する</p>
                
                </div>


            </span><hr>
            


            <span>
                <div class="project_tag">
                
                    <p style="font-size: 24px;">タグ</p>
                    <input type="hidden" name="project_tag_piece" id="project_tag_piece" value=0>
                    <p onclick="addTag()" style="color: #d70026;">タグを追加する</p>
                    

                </div>
                
            </span>
            
            <input type="submit" value="投稿する" class="createProject-post">

        </form>
    </div>


    <!-- フッターここから -->
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
    <!-- フッターここまで -->



    <!-- javascriptの導入 -->
    <script src="./script/script.js"></script>
    <script src="./script./createProject/newCourseAppend.js"></script>
    <script src="./script./createProject/newThumbnailAppend.js"></script>
    <script src="./script./createProject/newIntroAppend.js"></script>
    <script src="./script./createProject/newTagAppend.js"></script>

    <!-- bootstrapのjavascriptの導入 -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
</html>