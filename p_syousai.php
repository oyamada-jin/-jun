<?php
session_start();
?>
<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>新規登録</title>

    <!-- cssの導入 -->
    <link rel="stylesheet" href="css/p_syousai.css">
    <link rel="stylesheet" href="css/footer.css">


    <!-- javascriptの導入 -->
    <script src="./script/p_syousai.js"></script>

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
            <div class="project-link">プロジェクトを始める</div>
            <div class="project-link">プロジェクト掲載</div>
            <button class="header-button login-button">ログイン</button>
            <button class="header-button signUp-button">新規登録</button>
        </div>
    </header>
    <!-- ヘッダーここまで -->  

    <!-- タイトルとハッシュタグ機能 -->
<div class="a">
    <section class="project-name">
        <h1>プロジェクト名</h1>
        <p>ハッシュタグ、プロジェクト説明</p>
    </section>

        <!-- メイン -->


    <div class= "container">
        <div class="row">
            <div class="col-xs-12 col-lg-8">
                <div class="pp">
                    <div class="photo">
                        <img src="img/Sauna.jpg" alt="画像1">
                    </div>
                    <!-- <div class="photo">
                        <img src="img/Sauna.jpg" alt="画像2">
                    </div> -->
                    <!-- <div class="photo">
                        <img src="img/Sauna.jpg" alt="画像3">
                    </div> -->
                </div>
            </div>
            <div class="col-xs-12 col-lg-4">
                <div class="aa">
                    <p class="money">￥ 現在の支援金額</p> 
                    <h1>設定金額</h1>
                    <progress value="70" max="100">70%</progress><br>
                    <p class="m">目標金額1000000</p>
                    <div class="sien">
                            <span>  支援者</span>
                    </div><br>
                        <div class="sien">
                            <span>  残　り</span>
                    </div>
                            <div class="icon">
                                <!-- <img src="img/Sauna.jpg" alt="アイコン">                        </div> -->
                                    <div class="user-name">
                                        <p>wawawaw</p>
                                    </div>
                            <div class="comment">
                                <p>学生も勉学に励めると思うので応援お願いします！</p>
                            </div>
                            <div class="sien_b">
                                <button>支援にすすむ</button>
                            </div>
                            <p class="like">気になる</p>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12 col-lg-8">
                <div class="goods">
                    <h1>麻生情報ビジネス専門学校</h1>
                    <h2>情報工学科</h2>
                    <img src="img/aso.jpg" alt="" id="aso_p">
                </div>
            </div>
            <div class="col-xs-12 col-lg-4">
                <div class="plofile">
                    <img src="img/dog.jpg" alt="">
                    <p>name</p>
                    <p>他に○○件のプロジェクトを掲載しています</p>
                    <p>こんにちは、私はAIアシスタントです。OpenAIのGPT-3.5モデルをベースにした言語モデルです。幅広いトピックに関する質問に答えたり、テキスト生成をサポートしたりします。情報提供やアイデアの共有など、お手伝いできることがありましたらお知らせください。</p>
                </div><br>
                <div class="plan">
                    <p id="p_money">1000円</p>
                    <p id="stock">残り１００</p>
                    <img src="img/aso2.jpg" alt="" id="aso2_p">
                    <h2>【麻生情報ビジネス専門学校】</h2>
                    <p>●おおおおお</p>
                    <p>oooooo</p>
                    <div class="sien">
                            <span>  支援者:</span>
                    </div><br>
                        <div class="sien">
                            <span>  お届け予定：</span>
                    </div>
                    <button>支援にすすむ</button>
                </div>
            </div>
        </div>
    </div>
    
    
</div>
</div>
    <!-- メインここまで -->

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
</body>
<!-- bootstrapのjavascriptの導入 -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</html>