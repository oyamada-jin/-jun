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

    //注目アイデア取得
    $searchArray = $dao->board_get_randam();
    shuffle($searchArray);
    $firstThree = array_slice($searchArray, 0, 3);

    //コメント全件取得
    $searchArray = $dao->board_get_all();
    //コメント新しい順取得
    $searchTimeASC = $dao->get_time_comment();
    //コメントいいね順取得
    $searchHeartDesc = $dao->get_heart_comment();

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
    <script src="./script/board.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>


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

        <?php
        foreach ($firstThree as $comment) {
            echo '<div class="featuredIdeas-contents">';
            echo '<div class="featuredIdeas-contents-area">';
            echo '<div class="featuredIdeas-contents-area-head">';
            echo '<img src="' . $comment['user_icon'] . '" alt="" class="featuredIdeas-contents-icon">';
            echo '<div class="featuredIdeas-contents-username">' . $comment['user_name'] . '</div>';
            echo '<div class="featuredIdeas-contents-date">' . $comment['comment_time'] . '</div>';
            echo '</div>';
            echo '<div class="featuredIdeas-contents-text">' . $comment['comment_content'] . '</div>';
            echo '</div>';
            echo '</div>';
        }
        ?>

    </div>


    <!-- みんなのアイデア -->
    <div class="everyoneIdeas">
        <div class="everyoneIdeas-title">みんなのアイデア</div>

        <div class="everyoneIdeas-head1">
            <img src="<?php echo $userdata['user_icon'] ?>" alt="" class="everyoneIdeas-head1-icon">
            <div class="everyoneIdeas-head1-username"><?php echo $userdata['user_name'] ?></div>
            <div class="everyoneIdeas-head1-toshite">として投稿</div>
            <div class="everyoneIdeas-head1-order active" id="sortByNewest">新しい順</div>
            <div class="everyoneIdeas-head1-order" id="sortByLikes">評価順</div>
        </div>

        <div class="everyoneIdeas-head2">
            <form action="" method="post">
                <input type="text" placeholder="コメントする..." class="everyoneIdeas-head2-comment" name="comment">
                <input type="submit" class="everyoneIdeas-head2-post" name="submit" value="投稿">
            </form>
            <?php
            // フォームが送信されたときの処理
            if (isset($_POST['submit'])) {
                $post_comment = $_POST['comment'];
                $post_comments = $dao->post_bord_comment($post_comment);
            }
            ?>
        </div>

        <div id="comments">
            <?php
            foreach ($comments as $comment) {
                echo '<div class="featuredIdeas-contents" data-comment-id="' . $comment['comment_id'] . '">';
                echo '<div class="featuredIdeas-contents-area">';
                echo '<div class="featuredIdeas-contents-area-head">';
                echo '<img src="' . $comment['user_icon'] . '" alt="" class="featuredIdeas-contents-icon">';
                echo '<div class="featuredIdeas-contents-username">' . $comment['user_name'] . '</div>';
                echo '<div class="featuredIdeas-contents-date">' . $comment['comment_time'] . '</div>';
                echo '</div>';
                echo '<div class="featuredIdeas-contents-text">' . $comment['comment_content'] . '</div>';
                echo '</div>';
                echo '</div>';
            }
            ?>
        </div>

        

        <?php
        // コメント投稿用の処理
        if (isset($_POST['submitComment'])) {
            $post_comment = $_POST['comment'];
            $post_comments = $dao->post_bord_comment($post_comment);
        }

        // 返信投稿用の処理
        if (isset($_POST['submitReply'])) {
            $post_reply_content = $_POST['replyContent'];
            $parent_comment_id = $_POST['parentCommentId'];
            // parent_comment_idがnullでない場合は、コメントがクリックされたものに対する返信として処理
            $post_comments = $dao->post_bord_comment($post_reply_content, $parent_comment_id);
        }
        ?>
        <!-- モーダルのHTML -->
        <div class="modal fade" id="replyModal" tabindex="-1" aria-labelledby="replyModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="replyModalLabel">コメントと返信</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <!-- クリックされたコメントの内容を表示 -->
                        <div id="commentContent"></div>

                        <!-- 返信コメント入力欄 -->
                        <div style="display: none;" id="replyInput">
                            <label for="replyTextarea" class="form-label">返信を入力してください:</label>
                            <textarea class="form-control" id="replyTextarea" rows="3"></textarea>
                            <button type="button" class="btn btn-primary mt-3">送信</button>
                        </div>
                    </div>
                </div>
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


    <script>
        const searchTimeASC = <?php echo json_encode($searchTimeASC); ?>;
        const searchHeartDesc = <?php echo json_encode($searchHeartDesc); ?>;
    </script>
    <?php
// コメントデータをJSON形式に変換
$comments_json = json_encode($searchArray);
?>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            var comments = <?php echo $comments_json; ?>;

            function renderComments(comments) {
                var commentsContainer = document.getElementById("comments");
                commentsContainer.innerHTML = '';

                for (var i = 0; i < comments.length; i++) {
                    var comment = comments[i];

                    var commentDiv = document.createElement("div");
                    commentDiv.classList.add("featuredIdeas-contents");
                    commentDiv.setAttribute("data-comment-id", comment.comment_id);

                    var contentsArea = document.createElement("div");
                    contentsArea.classList.add("featuredIdeas-contents-area");

                    var contentsAreaHead = document.createElement("div");
                    contentsAreaHead.classList.add("featuredIdeas-contents-area-head");

                    var icon = document.createElement("img");
                    icon.src = comment.user_icon;
                    icon.alt = "";
                    icon.classList.add("featuredIdeas-contents-icon");

                    var username = document.createElement("div");
                    username.classList.add("featuredIdeas-contents-username");
                    username.textContent = comment.user_name;

                    var date = document.createElement("div");
                    date.classList.add("featuredIdeas-contents-date");
                    date.textContent = comment.comment_time;

                    var text = document.createElement("div");
                    text.classList.add("featuredIdeas-contents-text");
                    text.textContent = comment.comment_content;

                    contentsAreaHead.appendChild(icon);
                    contentsAreaHead.appendChild(username);
                    contentsAreaHead.appendChild(date);
                    contentsArea.appendChild(contentsAreaHead);
                    contentsArea.appendChild(text);
                    commentDiv.appendChild(contentsArea);

                    commentsContainer.appendChild(commentDiv);
                }
            }

            // 新しい順をクリックしたときの処理
            document.getElementById("sortByNewest").addEventListener("click", function () {
                document.getElementById("sortByNewest").classList.add("active");
                document.getElementById("sortByLikes").classList.remove("active");

                renderComments(<?php echo json_encode($searchTimeASC); ?>);
            });

            // 評価順をクリックしたときの処理
            document.getElementById("sortByLikes").addEventListener("click", function () {
                document.getElementById("sortByLikes").classList.add("active");
                document.getElementById("sortByNewest").classList.remove("active");

                renderComments(<?php echo json_encode($searchHeartDesc); ?>);
            });

            // コメントをクリックしたときの処理
            document.getElementById("comments").addEventListener("click", function (event) {
                if (event.target.classList.contains("featuredIdeas-contents-text")) {
                    // クリックされた要素がコメントのテキストである場合
                    var commentId = event.target.closest(".featuredIdeas-contents").getAttribute("data-comment-id");
                    openReplyModal(commentId);
                }
            });

            // 返信入力欄表示用の関数
            function openReplyModal(commentId) {
                // モーダル内の要素にクリックされたコメントの情報をセット
                document.getElementById("parentCommentId").value = commentId;
                // モーダル表示
                $('#replyModal').modal('show');
            }

            // 初回表示時にコメントをレンダリング
            renderComments(comments);
        });
    </script>


    <!-- bootstrapのjavascriptの導入 -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
</html>