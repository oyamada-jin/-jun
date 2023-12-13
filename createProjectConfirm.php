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

    //3画像の仮アップロードファイルの呼び出し
    require_once 'XML/ifThumbnail.php';
    require_once 'XML/ifCourse.php';
    require_once 'XML/ifIntro.php';
    

    //仮アップロード画像の削除用ファイルの呼び出し
    // require_once 'XML/deleteUploadedImg.php';

    // //プロジェクト単体のデータを纏めて登録するファイルの呼び出し
    // require_once 'XML/uploadProject.php';


    

    //現在登録されているプロジェクト数を取得
    $allProjectCount = $dao->allProjectCount()[0];
    

    //画像の情報を格納する配列を宣言
    if(!empty($_FILES['project_thumbnail'])){
        $thumbnailArray = ifUploadThumbnail($_FILES['project_thumbnail'],$_POST['project_thumbnail_piece']);
    }else{
        $thumbnailArray = null;
    }
    if(!empty($_FILES['project_course_file'])){
        $courseArray = ifUploadCourse($_FILES['project_course_file'],$_POST['project_course_piece']);
    }else{
        $courseArray = null;
    }
    if(!empty($_FILES['project_intro_file'])){
        $introArray = ifUploadIntro($_FILES['project_intro_file'],$_POST['project_intro_piece'],$_POST['project_intro_flag']);
    }else{
        $introArray = null;
    }
    


    

?>

<!-- ここまで -->
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>プロジェクト確認</title>

    <!-- cssの導入 -->
    <!-- <link rel="stylesheet" href="css/createProject.css"> -->
    <link rel="stylesheet" href="css/createProjectConfirm.css">
    <link rel="stylesheet" href="css/header.css">
    <link rel="stylesheet" href="css/footer.css">

    <!-- javascriptの導入 -->

    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    


    <!-- bootstrapのCSSの導入 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

</head>

<body class="background">
    <!-- ヘッダーここから -->
    <header class="header">
        <img class="header-logo" src="img/IdecaLogo.png" onclick="window.location.href = 'top.php'">
    </header>
    <?php


        //プロジェクトタイトル表示
        echo "<p>プロジェクト名：".$_POST['project_name']."</p>";

        echo "<hr>";

        //プロジェクトサムネイル全件表示
        echo "<p>サムネイル画像</p>";

        if(!empty($thumbnailArray)){
            foreach ($thumbnailArray as $imgName) {
                echo "<img src='".$imgName."'>";
            }
        }



        echo "<hr>";

        //目標金額表示
        echo "<p>".$_POST['project_goal_money']."</p>";

        echo "<hr>";

        //プロジェクト期間表示
        echo "<p>開始".$_POST['project_start']."</p>";
        echo "<p>終了".$_POST['project_end']."</p>";

        echo "<hr>";

        //プロジェクトコース表示
        for($j = 0; $j < $_POST['project_course_piece']; $j++){

            echo "<p>コース名：".$_POST['project_course_name'][$j]."</p>";

            if(!empty($courseArray[$j])){
                echo "<p>コース画像：";
            
                echo "<img src='".$courseArray[$j]."'>";
                
                echo "</p>";     
            }
            echo "<p>コース説明：".$_POST['project_course_intro'][$j]."</p>";
            echo "<p>コース料金：".$_POST['project_course_value'][$j]."</p>";
        }

        echo "<hr>";

        $introText = 0;//プロジェクト内容に出現したテキストの数を保持
        $introImg = 0;//プロジェクト内容に出現した画像の数を保持
        //プロジェクト内容表示
        echo "<p>プロジェクト内容</p>";
        for($k = 0; $k < $_POST['project_intro_piece']; $k++){


            if ($_POST['project_intro_flag'][$k] == "0") {//テキストボックスの場合  
                
                echo "<p>".$_POST['project_intro_text'][$introText]."</p>";

                $introText++;
            }else if($_POST['project_intro_flag'][$k] == "1"){//画像の場合

                echo "<img src='".$introArray[$introImg]."'>";
                
                $introImg++;
            }

        }

        echo "<hr>";

        //タグ情報表示
        for ($l=0; $l < $_POST['project_tag_piece']; $l++) { 
            
            echo "<p>タグ".($l+1).":".$_POST['project_tag_Text'][$l]."</p>";

            
        }

        ?>

        <div class="buttonArea">
            <button class = "backButton" onclick="clickReturns()">　戻る　</button>
            <button class = "postButton" "onclick="clickUpload()">投稿する</button>
        </div>

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
    
    




<!-- bootstrapのjavascriptの導入 -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
<script>
        

         function clickUpload() {
            
            var formData = new FormData();

            formData.append('project_name', '<?php echo $_POST["project_name"]; ?>');
            formData.append('project_goal_money', '<?php echo $_POST["project_goal_money"]; ?>');
            formData.append('project_start', '<?php echo $_POST["project_start"]; ?>');
            formData.append('project_end', '<?php echo $_POST["project_end"]; ?>');
            formData.append('id', '<?php echo $_SESSION["id"]; ?>');
            formData.append('project_thumbnail_piece', '<?php echo $_POST["project_thumbnail_piece"]; ?>');
            formData.append('project_course_piece', '<?php echo $_POST["project_course_piece"]; ?>');
            formData.append('project_intro_piece', '<?php echo $_POST["project_intro_piece"]; ?>');
            formData.append('project_tag_piece', '<?php echo $_POST["project_tag_piece"]; ?>');

            var projectCourseNames = <?php echo json_encode($_POST['project_course_name']); ?>;
            for (var j = 0; j < projectCourseNames.length; j++) {
                formData.append('project_course_name[]', projectCourseNames[j]);
            }

            formData.append('project_course_intro', (<?php echo json_encode($_POST['project_course_intro']); ?>));
            formData.append('project_course_value', JSON.stringify(<?php echo json_encode($_POST['project_course_value']); ?>));
            formData.append('project_intro_flag', JSON.stringify(<?php echo json_encode($_POST['project_intro_flag']); ?>));
            formData.append('project_intro_text', JSON.stringify(<?php echo json_encode($_POST['project_intro_text']); ?>));
            formData.append('project_tag_Text', JSON.stringify(<?php if(!empty($_POST['project_tag_Text'])){echo json_encode($_POST['project_tag_Text']);}else{echo null;} ?>));
            formData.append('thumbnailArray', JSON.stringify(<?php echo json_encode($thumbnailArray); ?>));
            formData.append('courseArray', JSON.stringify(<?php echo json_encode($courseArray); ?>));
            formData.append('introArray', JSON.stringify(<?php echo json_encode($introArray); ?>));


            // ファイルデータの追加
            var thumbnailFiles = <?php echo json_encode($_FILES['project_thumbnail']); ?>;
            for (var i = 0; i < thumbnailFiles['name'].length; i++) {
                var thumbnailBlob = new Blob([thumbnailFiles['tmp_name'][i]], { type: 'application/octet-stream' });
                formData.append('project_thumbnail[]', thumbnailBlob, thumbnailFiles['name'][i]);
            }

            // courseFiles の修正
            var courseFiles = <?php echo json_encode($_FILES['project_course_file']); ?>;
            for (var i = 0; i < courseFiles['name'].length; i++) {
                var courseBlob = new Blob([courseFiles['tmp_name'][i]], { type: 'application/octet-stream' });
                formData.append('project_course_file[]', courseBlob, courseFiles['name'][i]);
            }

            // introFiles の修正
            var introFiles = <?php echo json_encode($_FILES['project_intro_file']); ?>;
            for (var i = 0; i < introFiles['name'].length; i++) {
                var introBlob = new Blob([introFiles['tmp_name'][i]], { type: 'application/octet-stream' });
                formData.append('project_intro_file[]', introBlob, introFiles['name'][i]);
            }

            $.ajax({
                url: 'XML/uploadProject.php',
                type: 'post',
                processData: false,
                contentType: false,
                data: formData,
                dataType: 'json',
                success: function(response) {
                    console.log(response);
                    window.location.href = "createProjectComplete.php";
                },
                error: function(xhr) {
                    console.log('Error:', xhr);
                },
                complete: function(msg) {
                    console.log('Complete:', msg);
                }
            });
            
        }


        function clickReturns() {
            window.location.href = "createProject.php";
        }
</script>


</body>
</html>