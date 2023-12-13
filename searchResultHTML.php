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
    <link rel="stylesheet" href="css/searchResult.css">

    <!-- javascriptの導入 -->
    <script src="./script/script.js"></script>

    <!-- bootstrapのCSSの導入 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

</head>
<body class="background">
    <!-- ヘッダーここから -->
    <header class="header">
        <a href="top.php"><img class="header-logo" src="img/IdecaLogo.png"></a>

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

    <div class="mainView">
        <h1 class="searchResult-title">”次世代”の検索結果</h1>

        <div class="container-fluid">
            <ul class="searchResult-list row justify-content-start">
                <li class="searchResult-lists col-md-3">
                    <img src="img/contentsImage.png" alt="ピックアップコンテンツ" class="searchResult-image">
                </li>

                <li class="searchResult-lists col-md-3">
                    <img src="img/contentsImage.png" alt="ピックアップコンテンツ" class="searchResult-image">
                </li>
                    
                <li class="searchResult-lists col-md-3">
                    <img src="img/contentsImage.png" alt="ピックアップコンテンツ" class="searchResult-image">
                </li>

                <li class="searchResult-lists col-md-3">
                    <img src="img/contentsImage.png" alt="ピックアップコンテンツ" class="searchResult-image">
                </li>

                <li class="searchResult-lists col-md-3">
                    <img src="img/contentsImage.png" alt="ピックアップコンテンツ" class="searchResult-image">
                </li>
            </ul>
        </div>
    </div>

    <!-- タグで検索 -->
    <a href="searchTag.php" style="text-decoration: none;"><button class="tag-button">タグで検索</button></a>

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