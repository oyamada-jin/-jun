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
    require_once 'XML/deleteUploadedImg.php';

    //プロジェクト単体のデータを纏めて登録するファイルの呼び出し
    require_once 'XML/uploadProject.php';

    //実験用
    // var_dump($_FILES);
    var_dump($_POST);
    

    //現在登録されているプロジェクト数を取得
    $allProjectCount = $dao->allProjectCount()[0];
    

    //画像の情報を格納する配列を宣言
    $thumbnailArray = ifUploadThumbnail($_FILES['project_thumbnail'],$_POST['project_thumbnail_piece']);
    $courseArray = ifUploadCourse($_FILES['project_course_file'],$_POST['project_course_piece']);
    $introArray = ifUploadIntro($_FILES['project_intro_file'],$_POST['project_intro_piece'],$_POST['project_intro_flag']);



    // //サムネイル画像のアップロード
    // if(!empty($_FILES['project_thumbnail'])){
    //     $targetThumbnailDir = "img/project_thumbnail/uploadNow/";
    //     for($count_1 = 0; $count_1 < $_POST['project_thumbnail_piece']; $count_1++){
            
    //         //拡張子を格納
    //         $imageFileType = strtolower(pathinfo($_FILES["project_thumbnail"]["name"][$count_1], PATHINFO_EXTENSION));
            
    //         //保存するファイル名を格納
    //         $targetFile = $targetThumbnailDir.$allProjectCount."_thumbnail_".$count_1.".".$imageFileType;

    //         //アップロード
    //         move_uploaded_file($_FILES["project_thumbnail"]["tmp_name"][$count_1], $targetFile);
        
    //         $thumbnailArray[$count_1] = $targetFile;
    //     }
        
    // }

    // //プロジェクトコース画像のアップロード
    // if(!empty($_FILES['project_course_file'])){
    //     $targetCourseDir = "img/project_course/uploadNow/";
    //     for($count_2 = 0; $count_2 < $_POST['project_course_piece']; $count_2++){
            
    //         //拡張子を格納
    //         $imageFileType = strtolower(pathinfo($_FILES["project_course_file"]["name"][$count_2], PATHINFO_EXTENSION));
            
    //         //保存するファイル名を格納
    //         $targetFile = $targetCourseDir.$allProjectCount."_thumbnail_".$count_2.".".$imageFileType;

    //         //アップロード
    //         move_uploaded_file($_FILES["project_course_file"]["tmp_name"][$count_2], $targetFile);
        
    //         $courseArray[$count_2] = $targetFile;
            
    //     }
        
    // }

    // //プロジェクト内容画像の存在確認＋アップロード
    // if(!empty($_FILES['project_intro_file'])){

    //     $fileCount = 0;
    //     $targetIntroDir = "img/project_intro/uploadNow/";

    //     for($count_3 = 0; $count_3 < $_POST['project_intro_piece']; $count_3++){

    //         if($_POST['project_intro_flag'][$count_3]==1){//画像ならば

    //             //拡張子を格納
    //             $imageFileType = strtolower(pathinfo($_FILES["project_intro_file"]["name"][$fileCount], PATHINFO_EXTENSION));
                
    //             //保存するファイル名を格納
    //             $targetFile = $targetIntroDir.$allProjectCount."_thumbnail_".$fileCount.".".$imageFileType;

    //             //アップロード
    //             move_uploaded_file($_FILES["project_intro_file"]["tmp_name"][$fileCount], $targetFile);
            
    //             $introArray[$fileCount] = $targetFile;

    //             //画像を格納した回数を記録する
    //             $fileCount++;
    //         }
            
    //     }
        
    // }

    
    

?>

<!-- 関数 -->
<?php

    // function deleteUploadedImg(){//(未完)入力画面に戻るときに、アップロート済みの画像とprojectテーブルのデータを削除する
    //     $dir = "image/";
    //     if(!empty($thumbnailArray)){//サムネイル画像の削除
    //         foreach($thumbnailArray as $ta){
    //             if(file_exists($dir."project_thumbnail/uploadNow".$ta)){
    //                 unlink($dir."project_thumbnail/uploadNow".$ta);
    //             }
    //         }
    //     }

    //     if(!empty($courseArray)){//プロジェクトコース画像の削除
    //         foreach($courseArray as $ca){
    //             if(file_exists($dir."project_thumbnail/uploadNow".$ca)){
    //                 unlink($dir."project_thumbnail/uploadNow".$ca);
    //             }
    //         }
    //     }

    //     if(!empty($introArray)){//プロジェクト内容画像の削除
    //         foreach($introArray as $ia){
    //             if(file_exists($dir."project_thumbnail/uploadNow".$ia)){
    //                 unlink($dir."project_thumbnail/uploadNow".$ia);
    //             }
    //         }
    //     }

    //     // header('Location:createProject.php');
    //     // exit;
        
    // }

    // function uploadProject($id,$dao,$thumbnailArray,$courseArray,$introArray){//投稿するボタンが押されたときに、プロジェクトに関するデータをDBにアップロードする

    //     //プロジェクトテーブルへ登録
    //     $project_id = $dao->insertProject($_POST['project_name'],$_POST['project_goal_money'],$_POST['project_start'],$_POST['project_end'],$_SESSION['id']);

    //     //サムネイル画像のアップロード
    //     if(!empty($_FILES['project_thumbnail'])){
    //         $targetThumbnailDir = "img/project_thumbnail/";
    //         for($count_1 = 0; $count_1 < $_POST['project_thumbnail_piece']; $count_1++){
                
    //             //拡張子を格納
    //             $imageFileType = strtolower(pathinfo($_FILES["project_thumbnail"]["name"][$count_1], PATHINFO_EXTENSION));
                
    //             //保存するファイル名を格納
    //             $targetFile = $targetThumbnailDir.$project_id."_thumbnail_".$count_1.".".$imageFileType;

    //             //アップロード
    //             move_uploaded_file($_FILES["project_thumbnail"]["tmp_name"][$count_1], $targetFile);
            
    //             $thumbnailArray[$count_1] = $targetFile;

    //         }
            
    //     }
    //     //プロジェクトサムネイルが存在する場合
    //     if((int)$_POST['project_thumbnail_piece'] > 0){ 
    //         for($i = 0; $i < (int)$_POST['project_thumbnail_piece']; $i++){
    //             $dao->insertProjectThumbnail($project_id,$i,$thumbnailArray[$i]);
    //         }
    //     }


    //     //プロジェクトコース画像のアップロード
    //     if(!empty($_FILES['project_course_file'])){
    //         $targetCourseDir = "img/project_course/";
    //         for($count_2 = 0; $count_2 < $_POST['project_course_piece']; $count_2++){
                
    //             //拡張子を格納
    //             $imageFileType = strtolower(pathinfo($_FILES["project_course_file"]["name"][$count_2], PATHINFO_EXTENSION));
                
    //             //保存するファイル名を格納
    //             $targetFile = $targetCourseDir.$project_id."_thumbnail_".$count_2.".".$imageFileType;

    //             //アップロード
    //             move_uploaded_file($_FILES["project_course_file"]["tmp_name"][$count_2], $targetFile);
            
    //             $courseArray[$count_2] = $targetFile;
    //         }
            
    //     }
    //     //プロジェクトコースが存在する場合
    //     if($_POST['project_course_piece'] > 0){
    //         for($i = 0; $i < $_POST['project_course_piece']; $i++){
    //             $dao->insertProjectCourse($project_id,$i,$_POST['project_course_name'][$i],$courseArray[$i],$_POST['project_course_intro'][$i],$_POST['project_course_value'][$i]);
    //         }
    //     }


    //     //プロジェクト内容画像の存在確認＋アップロード
    // if(!empty($_FILES['project_intro_file'])){

    //     $fileCount = 0;
    //     $targetIntroDir = "img/project_intro/";

    //     for($count_3 = 0; $count_3 < $_POST['project_intro_piece']; $count_3++){

    //         if($_POST['project_intro_flag'][$count_3]==1){//画像ならば

    //             //拡張子を格納
    //             $imageFileType = strtolower(pathinfo($_FILES["project_intro_file"]["name"][$fileCount], PATHINFO_EXTENSION));
                
    //             //保存するファイル名を格納
    //             $targetFile = $targetIntroDir.$project_id."_thumbnail_".$fileCount.".".$imageFileType;

    //             //アップロード
    //             move_uploaded_file($_FILES["project_intro_file"]["tmp_name"][$fileCount], $targetFile);
            
    //             $introArray[$count_3] = $targetFile;

    //             //画像を格納した回数を記録する
    //             $fileCount++;
    //         }
            
    //     }
        
    // }
    //     //プロジェクト内容が存在する場合
    //     if($_POST['project_intro_piece'] > 0){
    //         $text = 0;
    //         for ($i=0; $i < $_POST['project_intro_piece']; $i++) { 
    //             if($_POST['project_intro_flag'][$i] == "0"){ //テキストの場合
    //                 $dao->insertProjectIntro($project_id,$i,$_POST['project_intro_flag'][$i],null,$_POST['project_intro_text'][$text]);    
    //                 $text++;
    //             }else{  //画像の場合
    //                 $dao->insertProjectIntro($project_id,$i,$_POST['project_intro_flag'][$i],$introArray[$i],null);
    //             }
                
    //         }
    //     }

    //     //プロジェクトタグが存在する場合
    //     if($_POST['project_tag_piece'] > 0){
    //         // for($i = 0; $i < $_POST['project_tag_piece']; $i++){
    //         //     $dao->tagCheck($project_id,$_POST['project_tag_Text'][$i]);
    //         // }
    //         $dao->tagCheck($project_id,$_POST['project_tag_Text']);
    //     }

    //     deleteUploadedImg();

    //     // header('Location:createProjectComplete.php');
    //     // exit;
    // }

?>



<!-- ここまで -->
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>プロジェクト確認</title>

    <!-- cssの導入 -->
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/createProject.css">

    <!-- javascriptの導入 -->
    <script src="./script/script.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    


    <!-- bootstrapのCSSの導入 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

</head>
<body>
    <?php

        //プロジェクトタイトル表示
        echo "<p>プロジェクト名：".$_POST['project_name']."</p>";

        echo "<hr>";
        
        //プロジェクトサムネイル全件表示
        echo "<p>サムネイル画像</p>";
        var_dump($thumbnailArray);
        foreach ($thumbnailArray as $imgName) {
            echo "<img src='".$imgName."'>";
        }
        

        echo "<hr>";

        //目標金額表示
        echo "<p>".$_POST['project_goal_money']."</p>";

        echo "<hr>";

        //プロジェクト期間表示
        echo "<p>開始".$_POST['project_start']."</p>";
        echo "<p>終了".$_POST['project_end']."</p>";

        echo "<hr>";
        var_dump($courseArray);
        //プロジェクトコース表示
        for($j = 0; $j < $_POST['project_course_piece']; $j++){
            echo "<p>コース番号".$j."</p>";
            echo "<p>コース名：".$_POST['project_course_name'][$j]."</p>";
            echo "<p>コース画像：";
            
            echo "<img src='".$courseArray[$j]."'>";
            
            echo "</p>"; 
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


    <button onclick="clickReturns()">戻る</button>
    <button onclick="clickUpload()">投稿する</button>
    




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
            formData.append('project_tag_Text', JSON.stringify(<?php echo json_encode($_POST['project_tag_Text']); ?>));
            formData.append('thumbnailArray', JSON.stringify(<?php echo json_encode($thumbnailArray); ?>));
            formData.append('courseArray', JSON.stringify(<?php echo json_encode($courseArray); ?>));
            formData.append('introArray', JSON.stringify(<?php echo json_encode($introArray); ?>));


            // ファイルデータの追加
            var thumbnailFiles = <?php echo json_encode($_FILES['project_thumbnail']); ?>;
            for (var i = 0; i < thumbnailFiles['name'].length; i++) {
                formData.append('project_thumbnail[]', thumbnailFiles['tmp_name'][i], thumbnailFiles['name'][i]);
            }

            var courseFiles = <?php echo json_encode($_FILES['project_course_file']); ?>;
            for (var i = 0; i < courseFiles['name'].length; i++) {
                formData.append('project_course_file[]', courseFiles['tmp_name'][i], courseFiles['name'][i]);
            }

            var introFiles = <?php echo json_encode($_FILES['project_intro_file']); ?>;
            for (var i = 0; i < introFiles['name'].length; i++) {
                formData.append('project_intro_file[]', introFiles['tmp_name'][i], introFiles['name'][i]);
            }

            $.ajax({
                url: 'uploadProject.php',
                type: 'post',
                processData: false,
                contentType: false,
                data: formData,
                dataType: 'json',
                success: function(response) {
                    console.log(response);
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
            var result2 = '';<?php
                //  deleteUploadedImg($thumbnailArray,$courseArray,$introArray); 
                 
                ?>
            document.write(result2);
        }
</script>


</body>
</html>