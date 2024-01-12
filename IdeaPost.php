<!-- 多分sessionは全ページ必須？なので消さないでください。 -->
<?php
session_start();
?>
<!-- sessionここまで -->

<!-- ログイン必須ページだけここのコードを残してください。 -->
<?php
// if(isset($_SESSION['id']) == false){
//    header('Location: login.php');
//    exit();
// }
?>
<!-- ログイン必須用はここまで -->

<!-- DAOを使用する場合は残してください。 -->
<?php
    //DAOの呼び出し
    require_once 'DAO.php';
    $dao = new DAO();
    
    $userdata = null;
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
    <link rel="stylesheet" href="css/IdeaPost.css">

    <!-- javascriptの導入 -->
    <script src="./script/script.js"></script>

    <!-- bootstrapのCSSの導入 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

</head>
<body class="background">
    <!-- ヘッダーここから -->
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

    <!-- メインビュー -->
    <div class="mainView">
        <img src="img/idea.png" alt="メインビュー" class="mainView-image">
    </div>

    <!-- ホームへ -->
    <a href="top.php" style="text-decoration: none;"><button class="home-button">ホームへ</button></a>

    <!-- 注目のアイデア -->
    <div class="featuredIdeas">
        <h1 class="featuredIdeas-title">注目のアイデア</h1>

        <!-- アイデア投稿ここから -->
        <div class="featuredIdeas-contents">
            <div class="featuredIdeas-contents-area">
                <div class="featuredIdeas-contents-area-head">
                    <img src="img/usericon.png" alt="" class="featuredIdeas-contents-icon">
                    <div class="featuredIdeas-contents-username">アイデアマン</div>
                    <div class="featuredIdeas-contents-date">2023/01/23 04:56:07</div>
                </div>
                <div class="featuredIdeas-contents-text">みかん味のマーガリンを作って欲しいです。毎朝トーストにバターを塗って食べているのですが、それだけだと空きが来てしまいます。いろいろトーストの上にのっけてアレンジをしているのですが、マーガリン自体の味を変えてしまうのもアレンジとして面白いのではないかと考えつきました。しかしそれを作ることは技術的に厳しいためみかん味のマーガリンを作って欲しいです。毎朝トーストにバターを塗って食べているのですが、それだけだと空きが来てしまいます。いろいろトーストの上にのっけてアレンジをしているのですが、マーガリン自体の味を変えてしまうのもアレンジとして面白いのではないかと考えつきました。しかしそれを作ることは技術的に厳しいため</div>
                
                <!-- <div class="featuredIdeas-contents-text-continue">
                    <a href="#" style="text-decoration: none;">続きを読む</a>
                </div> -->
            </div>
        </div>
        <!-- アイデア投稿ここまで -->

        <!-- アイデア投稿ここから -->
        <div class="featuredIdeas-contents">
            <div class="featuredIdeas-contents-area">
                <div class="featuredIdeas-contents-area-head">
                    <img src="img/usericon.png" alt="" class="featuredIdeas-contents-icon">
                    <div class="featuredIdeas-contents-username">アイデアマン</div>
                    <div class="featuredIdeas-contents-date">2023/01/23 04:56:07</div>
                </div>
                <div class="featuredIdeas-contents-text">みかん味のマーガリンを作って欲しいです。毎朝トーストにバターを塗って食べているのですが、それだけだと空きが来てしまいます。いろいろトーストの上にのっけてアレンジをしているのですが、マーガリン自体の味を変えてしまうのもアレンジとして面白いのではないかと考えつきました。しかしそれを作ることは技術的に厳しいためみかん味のマーガリンを作って欲しいです。毎朝トーストにバターを塗って食べているのですが、それだけだと空きが来てしまいます。いろいろトーストの上にのっけてアレンジをしているのですが、マーガリン自体の味を変えてしまうのもアレンジとして面白いのではないかと考えつきました。しかしそれを作ることは技術的に厳しいため</div>
                
                <!-- <div class="featuredIdeas-contents-text-continue">
                    <a href="#" style="text-decoration: none;">続きを読む</a>
                </div> -->
            </div>
        </div>
        <!-- アイデア投稿ここまで -->

        <!-- アイデア投稿ここから -->
        <div class="featuredIdeas-contents">
            <div class="featuredIdeas-contents-area">
                <div class="featuredIdeas-contents-area-head">
                    <img src="img/usericon.png" alt="" class="featuredIdeas-contents-icon">
                    <div class="featuredIdeas-contents-username">アイデアマン</div>
                    <div class="featuredIdeas-contents-date">2023/01/23 04:56:07</div>
                </div>
                <div class="featuredIdeas-contents-text">みかん味のマーガリンを作って欲しいです。毎朝トーストにバターを塗って食べているのですが、それだけだと空きが来てしまいます。いろいろトーストの上にのっけてアレンジをしているのですが、マーガリン自体の味を変えてしまうのもアレンジとして面白いのではないかと考えつきました。しかしそれを作ることは技術的に厳しいためみかん味のマーガリンを作って欲しいです。毎朝トーストにバターを塗って食べているのですが、それだけだと空きが来てしまいます。いろいろトーストの上にのっけてアレンジをしているのですが、マーガリン自体の味を変えてしまうのもアレンジとして面白いのではないかと考えつきました。しかしそれを作ることは技術的に厳しいため</div>
                
                <!-- <div class="featuredIdeas-contents-text-continue">
                    <a href="#" style="text-decoration: none;">続きを読む</a>
                </div> -->
            </div>
        </div>
        <!-- アイデア投稿ここまで -->
    </div>


    <!-- みんなのアイデア -->
    <div class="everyoneIdeas">
        <div class="everyoneIdeas-title">みんなのアイデア</div>

        <div class="everyoneIdeas-head1">
            <img src="img/usericon.png" alt="" class="everyoneIdeas-head1-icon">
            <div class="everyoneIdeas-head1-username">アイデアマン</div>
            <div class="everyoneIdeas-head1-toshite">として投稿</div>
            <div class="everyoneIdeas-head1-order">新しい順</div>
            <div class="everyoneIdeas-head1-order">評価潤</div>
        </div>

        <div class="everyoneIdeas-head2">
            <input type="text" placeholder="コメントする..." class="everyoneIdeas-head2-comment">
            <button class="everyoneIdeas-head2-post">投稿</button>
        </div>

         <!-- アイデア投稿ここから -->
         <div class="featuredIdeas-contents">
            <div class="featuredIdeas-contents-area">
                <div class="featuredIdeas-contents-area-head">
                    <img src="img/usericon.png" alt="" class="featuredIdeas-contents-icon">
                    <div class="featuredIdeas-contents-username">アイデアマン</div>
                    <div class="featuredIdeas-contents-date">2023/01/23 04:56:07</div>
                </div>
                <div class="featuredIdeas-contents-text">みかん味のマーガリンを作って欲しいです。毎朝トーストにバターを塗って食べているのですが、それだけだと空きが来てしまいます。いろいろトーストの上にのっけてアレンジをしているのですが、マーガリン自体の味を変えてしまうのもアレンジとして面白いのではないかと考えつきました。しかしそれを作ることは技術的に厳しいためみかん味のマーガリンを作って欲しいです。毎朝トーストにバターを塗って食べているのですが、それだけだと空きが来てしまいます。いろいろトーストの上にのっけてアレンジをしているのですが、マーガリン自体の味を変えてしまうのもアレンジとして面白いのではないかと考えつきました。しかしそれを作ることは技術的に厳しいため</div>
                
                <!-- <div class="featuredIdeas-contents-text-continue">
                    <a href="#" style="text-decoration: none;">続きを読む</a>
                </div> -->
            </div>
        </div>
        <!-- アイデア投稿ここまで -->

         <!-- アイデア投稿ここから -->
         <div class="featuredIdeas-contents">
            <div class="featuredIdeas-contents-area">
                <div class="featuredIdeas-contents-area-head">
                    <img src="img/usericon.png" alt="" class="featuredIdeas-contents-icon">
                    <div class="featuredIdeas-contents-username">アイデアマン</div>
                    <div class="featuredIdeas-contents-date">2023/01/23 04:56:07</div>
                </div>
                <div class="featuredIdeas-contents-text">みかん味のマーガリンを作って欲しいです。毎朝トーストにバターを塗って食べているのですが、それだけだと空きが来てしまいます。いろいろトーストの上にのっけてアレンジをしているのですが、マーガリン自体の味を変えてしまうのもアレンジとして面白いのではないかと考えつきました。しかしそれを作ることは技術的に厳しいためみかん味のマーガリンを作って欲しいです。毎朝トーストにバターを塗って食べているのですが、それだけだと空きが来てしまいます。いろいろトーストの上にのっけてアレンジをしているのですが、マーガリン自体の味を変えてしまうのもアレンジとして面白いのではないかと考えつきました。しかしそれを作ることは技術的に厳しいため</div>
                
                <!-- <div class="featuredIdeas-contents-text-continue">
                    <a href="#" style="text-decoration: none;">続きを読む</a>
                </div> -->
            </div>
        </div>
        <!-- アイデア投稿ここまで -->

         <!-- アイデア投稿ここから -->
         <div class="featuredIdeas-contents">
            <div class="featuredIdeas-contents-area">
                <div class="featuredIdeas-contents-area-head">
                    <img src="img/usericon.png" alt="" class="featuredIdeas-contents-icon">
                    <div class="featuredIdeas-contents-username">アイデアマン</div>
                    <div class="featuredIdeas-contents-date">2023/01/23 04:56:07</div>
                </div>
                <div class="featuredIdeas-contents-text">みかん味のマーガリンを作って欲しいです。毎朝トーストにバターを塗って食べているのですが、それだけだと空きが来てしまいます。いろいろトーストの上にのっけてアレンジをしているのですが、マーガリン自体の味を変えてしまうのもアレンジとして面白いのではないかと考えつきました。しかしそれを作ることは技術的に厳しいためみかん味のマーガリンを作って欲しいです。毎朝トーストにバターを塗って食べているのですが、それだけだと空きが来てしまいます。いろいろトーストの上にのっけてアレンジをしているのですが、マーガリン自体の味を変えてしまうのもアレンジとして面白いのではないかと考えつきました。しかしそれを作ることは技術的に厳しいため</div>
                
                <!-- <div class="featuredIdeas-contents-text-continue">
                    <a href="#" style="text-decoration: none;">続きを読む</a>
                </div> -->
            </div>
        </div>
        <!-- アイデア投稿ここまで -->

        
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