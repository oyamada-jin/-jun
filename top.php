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
    <title>ホーム画面</title>

    <!-- cssの導入 -->
    <link rel="stylesheet" href="css/style.css?v=2">
    <link rel="stylesheet" href="css/header.css">
    <link rel="stylesheet" href="css/footer.css">
    <link rel="stylesheet" href="css/top.css">

    <!-- javascriptの導入 -->
    <script src="./script/script.js"></script>

    <!-- bootstrapのCSSの導入 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

</head>
<body class="background">
    <!-- ヘッダーここから -->
    <header class="header">
        <img class="header-logo" src="img/IdecaLogo.png">

        <div class="search-bar">
            <img class="search-icon" src="">
            <input class="search-input" type="text">
        </div>

        <div class="header-contents-area">
            <a href="IdeaPost.php"><div class="project-link">プロジェクトを始める</div></a>
            <a href=""><div class="project-link">プロジェクト掲載</div></a>
            <button class="header-button login-button">ログイン</button>
            <button class="header-button signUp-button">新規登録</button>
        </div>
    </header>
    <!-- ヘッダーここまで -->

    <!-- メインビュー -->
    <div class="mainView">
        <img src="img/Sauna.jpg" alt="メインビュー" class="mainView-image">
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
                <li class="project-contents-lists col-md-3">
                    <div class="rank" style="color: #d70026;">1</div>
                    <img src="img/contentsImage.png" alt="コンテンツ" class="project-contents-lists-img">
                </li>

                <li class="project-contents-lists col-md-3">
                    <div class="rank">2</div>
                    <img src="img/contentsImage.png" alt="コンテンツ" class="project-contents-lists-img">
                </li>

                <li class="project-contents-lists col-md-3"> 
                    <div class="rank">3</div>
                    <img src="img/contentsImage.png" alt="コンテンツ" class="project-contents-lists-img">
                </li>

                <li class="project-contents-lists col-md-3">
                    <div class="rank">4</div>
                    <img src="img/contentsImage.png" alt="コンテンツ" class="project-contents-lists-img">
                </li>
            </ul>
        </div>

        <!-- 新着プロジェクト -->
        <div class="project-newProject project-margin-bottom container-fluid">
            <div class="project-title">新着プロジェクト</div>
            <a href="" class="more-link"><div class="more">すべて見る ></div></a>
                <ul class="project-contents-list row justify-content-start">
                    <li class="project-contents-lists col-md-3">
                        <img src="img/contentsImage.png" alt="コンテンツ" class="project-contents-lists-img">
                    </li>

                    <li class="project-contents-lists col-md-3">
                        <img src="img/contentsImage.png" alt="コンテンツ" class="project-contents-lists-img">
                    </li>

                    <li class="project-contents-lists col-md-3">
                        <img src="img/contentsImage.png" alt="コンテンツ" class="project-contents-lists-img">
                    </li>

                    <li class="project-contents-lists col-md-3">
                        <img src="img/contentsImage.png" alt="コンテンツ" class="project-contents-lists-img">
                    </li>

                    <li class="project-contents-lists col-md-3">
                        <img src="img/contentsImage.png" alt="コンテンツ" class="project-contents-lists-img">
                    </li>
                </ul>
        </div>

        <!-- もうすぐ始まるプロジェクト -->
        <div class="project-soon project-margin-bottom container-fluid">
            <div class="project-title">もうすぐ始まるプロジェクト</div>
            <a href="" class="more-link"><div class="more">すべて見る ></div></a>
                <ul class="project-contents-list row justify-content-start">
                    <li class="project-contents-lists col-md-3">
                        <img src="img/contentsImage.png" alt="コンテンツ" class="project-contents-lists-img">
                    </li>

                    <li class="project-contents-lists col-md-3">
                        <img src="img/contentsImage.png" alt="コンテンツ" class="project-contents-lists-img">
                    </li>

                    <li class="project-contents-lists col-md-3">
                        <img src="img/contentsImage.png" alt="コンテンツ" class="project-contents-lists-img">
                    </li>

                    <li class="project-contents-lists col-md-3">
                        <img src="img/contentsImage.png" alt="コンテンツ" class="project-contents-lists-img">
                    </li>
                </ul>
        </div>

        <!-- おすすめプロジェクト -->
        <div class="project-recommendationProject project-margin-bottom container-fluid">
            <div class="project-title">おすすめプロジェクト</div>
            <a href="" class="more-link"><div class="more">すべて見る ></div></a>
                <ul class="project-contents-list row justify-content-start">
                    <li class="project-contents-lists col-md-3">
                        <img src="img/contentsImage.png" alt="コンテンツ" class="project-contents-lists-img">
                    </li>

                    <li class="project-contents-lists col-md-3">
                        <img src="img/contentsImage.png" alt="コンテンツ" class="project-contents-lists-img">
                    </li>

                    <li class="project-contents-lists col-md-3">
                        <img src="img/contentsImage.png" alt="コンテンツ" class="project-contents-lists-img">
                    </li>

                    <li class="project-contents-lists col-md-3">
                        <img src="img/contentsImage.png" alt="コンテンツ" class="project-contents-lists-img">
                    </li>
                </ul>
        </div>

        <!-- 達成したプロジェクト -->
        <div class="project-achievedProject project-margin-bottom container-fluid">
            <div class="project-title">達成したプロジェクト</div>
            <a href="" class="more-link"><div class="more">すべて見る ></div></a>
                <ul class="project-contents-list row justify-content-start">
                    <li class="project-contents-lists col-md-3">
                        <img src="img/contentsImage.png" alt="コンテンツ" class="project-contents-lists-img">
                    </li>

                    <li class="project-contents-lists col-md-3">
                        <img src="img/contentsImage.png" alt="コンテンツ" class="project-contents-lists-img">
                    </li>

                    <li class="project-contents-lists col-md-3">
                        <img src="img/contentsImage.png" alt="コンテンツ" class="project-contents-lists-img">
                    </li>

                    <li class="project-contents-lists col-md-3">
                        <img src="img/contentsImage.png" alt="コンテンツ" class="project-contents-lists-img">
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