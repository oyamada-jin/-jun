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
    <title>プロジェクト作成</title>

    <!-- cssの導入 -->
    <link rel="stylesheet" href="css/style.css?v=2">
    <link rel="stylesheet" href="css/createProject.css?v=2">

    <!-- bootstrapのCSSの導入 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

</head>
<body>
    


    <a href="top.php">HOMEへ戻る</a>

    <form action="createProjectConfirm.php" method="post" enctype="multipart/form-data">

        <span>

            <p>プロジェクト名</p>
            <input type="text" name="project_name">
        
        </span><hr>
       
        <span class="row mb-5">

            <!-- 画像追加のinputタグ -->
            <div class="project_Thumbnail">

                <p>サムネイル画像</p>
                <input type="hidden" name="project_thumbnail_piece" id="project_thumbnail_piece" value=1>
                <p onclick="addThumbnail()">入力欄を追加する</p>
                
                <div id="project_thumbnail_1">
            
                    <input class="noneDisplay" type="file" name="project_thumbnail[]" id="project_thumbnail_input_1" onchange="handleFileSelectThumbnail('project_thumbnail_input_1','project_thumbnail_img_1')"><br>
                    <img src="img/project_thumbnail/default.png" class="ThumbnailImg" id="project_thumbnail_img_1" alt="Image" onclick="document.getElementById('project_thumbnail_input_1').click()">

                </div>
                
                
            
            </div>
            
            
        </span><hr>
        

        <span>

            <p>目標金額</p>
            <input type="num" name="project_goal_money" required>円

        </span><hr>

        <span>
            <p>プロジェクト期間</p>

            <input type="date" name="project_start" required>
            <input type="date" name="project_end" required>

        </span><hr>

        <!-- ここは一旦プロジェクトコースの入力欄にしておきました -->
        <span>
    
            <p>プロジェクトリターン内容</p>
            <input type="hidden" name="project_course_piece" id="project_course_piece" value=1>
            <p onclick="addCourse()">コースの入力欄を増やす</p>
        
            <div class="project_course">

                <div id="project_course_1">
                    
                    <input type="text" name="project_course_name[]" id="project_course_name_1">
                    <input class="noneDisplay" type="file" name="project_course_file[]" id="project_course_file_1" onchange="handleFileSelectCourse('project_course_file_1','project_course_img_1')"><br>
                    <img src="img/project_Course/default.png" class="CourseImg" id="project_course_img_1" alt="Image" onclick="document.getElementById('project_course_file_1').click()">
                    <input type="text" name="project_course_intro[]" id="project_course_intro_1"><br>
                    <input type="number" name="project_course_value[]" id="project_course_value_1">

                </div>
            
            </div>
    
        </span><hr>
        
        
        
        <span>

            

            <div class="project_intro">

                <p>プロジェクト内容</p>
                <input type="hidden" name="project_intro_piece" id="project_intro_piece" value=0>
                <p onclick="addIntro(0)">テキストを追加する</p><p onclick="addIntro(1)">画像を追加する</p>
            
            </div>


        </span><hr>
        


        <span>
            <div class="project_tag">
            
                <p>タグ</p>
                <input type="hidden" name="project_tag_piece" id="project_tag_piece" value=0>
                <p onclick="addTag()">タグを追加する</p>
                

            </div>
            
        </span>
        
        <input type="submit" value="投稿する">


    </form>

















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