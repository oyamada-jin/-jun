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


    var_dump($_FILES);

    //現在登録されているプロジェクト数を取得
    // $query1 = $dao->insertProject($_POST['project_name'], $_POST['project_goal_money'], $_POST['project_start'], $_POST['project_end'], $_SESSION['id']);
    // $allProjectCount = $query1[0];
    

    //画像の情報を格納する配列を宣言
    $thumbnailArray = array();
    $courseArray = array();
    $introArray = array();

    // //サムネイル画像のアップロード
    // if(!empty($_FILES['project_thumbnail'])){
    //     $targetThumbnailDir = "img/project_thumbnail/";
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
    //     $targetCourseDir = "img/project_course/";
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
    //     $targetIntroDir = "img/project_intro/";

    //     for($count_3 = 0; $count_3 < $_POST['project_intro_piece']; $count_3++){

    //         if($_POST['project_intro_flag'][$count_3]==1){//画像ならば

    //             //拡張子を格納
    //             $imageFileType = strtolower(pathinfo($_FILES["project_intro_file"]["name"][$fileCount], PATHINFO_EXTENSION));
                
    //             //保存するファイル名を格納
    //             $targetFile = $targetIntroDir.$allProjectCount."_thumbnail_".$fileCount.".".$imageFileType;

    //             //アップロード
    //             move_uploaded_file($_FILES["project_intro_file"]["tmp_name"][$fileCount], $targetFile);
            
    //             $introArray[$count_3] = $targetFile;

    //             //画像を格納した回数を記録する
    //             $fileCount++;
    //         }
            
    //     }
        
    // }

    
    

?>

<!-- 関数 -->
<?php

    function deleteUploadedImg($id){//(未完)入力画面に戻るときに、アップロート済みの画像とprojectテーブルのデータを削除する
        $dir = "image/";
        if(!empty($thumbnailArray)){//サムネイル画像の削除
            foreach($thumbnailArray as $ta){
                if(file_exists($dir."project_thumbnail/".$ta)){
                    unlink($dir."project_thumbnail/".$ta);
                }
            }
        }

        if(!empty($courseArray)){//プロジェクトコース画像の削除
            foreach($courseArray as $ca){
                if(file_exists($dir."project_thumbnail/".$ca)){
                    unlink($dir."project_thumbnail/".$ca);
                }
            }
        }

        if(!empty($introArray)){//プロジェクト内容画像の削除
            foreach($introArray as $ia){
                if(file_exists($dir."project_thumbnail/".$ia)){
                    unlink($dir."project_thumbnail/".$ia);
                }
            }
        }

        // header('Location:createProject.php');
        // exit;
        
    }

    function uploadProject($id,$dao,$thumbnailArray,$courseArray,$introArray){//投稿するボタンが押されたときに、プロジェクトに関するデータをDBにアップロードする

        //プロジェクトテーブルへ登録
        $project_id = $dao->insertProject($_POST['project_name'],$_POST['project_goal_money'],$_POST['project_start'],$_POST['project_end'],$_SESSION['id']);

        //サムネイル画像のアップロード
        if(!empty($_FILES['project_thumbnail'])){
            $targetThumbnailDir = "img/project_thumbnail/";
            for($count_1 = 0; $count_1 < $_POST['project_thumbnail_piece']; $count_1++){
                
                //拡張子を格納
                $imageFileType = strtolower(pathinfo($_FILES["project_thumbnail"]["name"][$count_1], PATHINFO_EXTENSION));
                
                //保存するファイル名を格納
                $targetFile = $targetThumbnailDir.$project_id."_thumbnail_".$count_1.".".$imageFileType;

                //アップロード
                move_uploaded_file($_FILES["project_thumbnail"]["tmp_name"][$count_1], $targetFile);
            
                $thumbnailArray[$count_1] = $targetFile;
            }
            
        }
        //プロジェクトサムネイルが存在する場合
        if((int)$_POST['project_thumbnail_piece'] > 0){ 
            for($i = 0; $i < (int)$_POST['project_thumbnail_piece']; $i++){
                $dao->insertProjectThumbnail($project_id,$i,$thumbnailArray[$i]);
            }
        }


        //プロジェクトコース画像のアップロード
        if(!empty($_FILES['project_course_file'])){
            $targetCourseDir = "img/project_course/";
            for($count_2 = 0; $count_2 < $_POST['project_course_piece']; $count_2++){
                
                //拡張子を格納
                $imageFileType = strtolower(pathinfo($_FILES["project_course_file"]["name"][$count_2], PATHINFO_EXTENSION));
                
                //保存するファイル名を格納
                $targetFile = $targetCourseDir.$project_id."_thumbnail_".$count_2.".".$imageFileType;

                //アップロード
                move_uploaded_file($_FILES["project_course_file"]["tmp_name"][$count_2], $targetFile);
            
                $courseArray[$count_2] = $targetFile;
            }
            
        }
        //プロジェクトコースが存在する場合
        if($_POST['project_course_piece'] > 0){
            for($i = 0; $i < $_POST['project_course_piece']; $i++){
                $dao->insertProjectCourse($project_id,$i,$_POST['project_course_name'][$i],$courseArray[$i],$_POST['project_course_intro'][$i],$_POST['project_course_value'][$i]);
            }
        }


        //プロジェクト内容画像の存在確認＋アップロード
    if(!empty($_FILES['project_intro_file'])){

        $fileCount = 0;
        $targetIntroDir = "img/project_intro/";

        for($count_3 = 0; $count_3 < $_POST['project_intro_piece']; $count_3++){

            if($_POST['project_intro_flag'][$count_3]==1){//画像ならば

                //拡張子を格納
                $imageFileType = strtolower(pathinfo($_FILES["project_intro_file"]["name"][$fileCount], PATHINFO_EXTENSION));
                
                //保存するファイル名を格納
                $targetFile = $targetIntroDir.$project_id."_thumbnail_".$fileCount.".".$imageFileType;

                //アップロード
                move_uploaded_file($_FILES["project_intro_file"]["tmp_name"][$fileCount], $targetFile);
            
                $introArray[$count_3] = $targetFile;

                //画像を格納した回数を記録する
                $fileCount++;
            }
            
        }
        
    }
        //プロジェクト内容画損サイズする場合
        if($_POST['project_intro_piece'] > 0){
            for ($i=0; $i < $_POST['project_intro_piece']; $i++) { 
                if($_POST['project_intro_flag'][$i] == "0"){ //テキストの場合
                    $dao->insertProjectIntro($project_id,$i,$_POST['project_intro_flag'][$i],null,$_POST['project_intro_text'][$i]);    
                }else{  //画像の場合
                    $dao->insertProjectIntro($project_id,$i,$_POST['project_intro_flag'][$i],$introArray[$i],null);
                }
                
            }
        }

        //プロジェクトタグが存在する場合
        if($_POST['project_tag_piece'] > 0){
            for($i = 0; $i < $_POST['project_tag_piece']; $i++){
                $dao->tagCheck($project_id,$_POST['project_tag_Text'][$i]);
            }
        }

        // header('Location:createProjectComplete.php');
        // exit;
    }

?>
<?php
    echo "<script>";
    echo "function insertProjectJS() {";
    echo "";
    echo "";
    echo "";
    echo "";
    echo "";
    echo "";
?>

    
        <?php
            uploadProject($allProjectCount,$dao,$thumbnailArray,$courseArray,$introArray);
        ?>
    }

    function deleteUploadedImg() {
        <?php
            deleteUploadedImg($allProjectCount);
        ?>
    }
</script>

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
        for($i = 0; $i < (int)$_POST['project_thumbnail_piece']; $i++){

            if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES['project_thumbnail'][$i])) {
                $image = $_FILES['project_thumbnail'][$i];
            
 
                $imageType = strtolower(pathinfo($_FILES["project_thumbnail"]["name"][$i], PATHINFO_EXTENSION));
                $base64ImageData = base64_encode(file_get_contents($image["tmp_name"]));
                echo "<img src='data:$imageType;base64,$base64ImageData' />";
        
                // 画像をブラウザに直接表示
                header("Content-Type: $imageType");
                echo $imageData;

            }

        }

        for ($i = 0; $i < (int)$_POST['project_thumbnail_piece']; $i++) {
            if (isset($_FILES['project_thumbnail']['name'][$i])) {
                $imageType = strtolower(pathinfo($_FILES['project_thumbnail']['name'][$i], PATHINFO_EXTENSION));
                $base64ImageData = base64_encode(file_get_contents($_FILES['project_thumbnail']['tmp_name'][$i]));
                echo "<img src='data:image/$imageType;base64,$base64ImageData' />";
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
            echo "<p>コース番号".$j."</p>";
            echo "<p>コース名：".$_POST['project_course_name'][$j]."</p>";
            echo "<p>コース画像：";
            
            if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES['project_course_file'][$j])) {
                $image = $_FILES['project_course_file'][$j];
            
                // ファイルのエラーチェック
                if ($image["error"] == UPLOAD_ERR_OK) {
                    $base64ImageData = base64_encode(file_get_contents($image["tmp_name"]));
                    echo "<img src='data:$imageType;base64,$base64ImageData' />";;
            
                    // 画像をブラウザに直接表示
                    header("Content-Type: $imageType");
                    echo $imageData;
                } else {
                    echo "プロジェクトコース画像のアップロード中にエラーが発生しました。";
                }
            }
            
            echo "</p>"; 
            echo "<p>コース説明：".$_POST['project_course_intro'][$j]."</p>";
            echo "<p>コース料金：".$_POST['project_course_value'][$j]."</p>";
        }

        echo "<hr>";

        $introText = 0;//プロジェクト内容に出現したテキストの数を保持
        $introImg = 0;//プロジェクト内容に出現した画像の数を保持
        //プロジェクト内容表示
        for($k = 0; $k < $_POST['project_intro_piece']; $k++){

            // var_dump($_POST['project_intro_flag']);
            // var_dump($_POST['project_intro_text']);
            var_dump($_FILES['project_intro_file']);

            if ($_POST['project_intro_flag'][$k] == "0") {//テキストボックスの場合  
                
                echo "<p>".$_POST['project_intro_text'][$introText]."</p>";

                $introText++;
            }else if($_POST['project_intro_flag'][$k] == "1"){//画像の場合

                $image = $_FILES['project_intro_file'];
            
                $base64ImageData = base64_encode(file_get_contents($image["tmp_name"][$introImg]));
                echo "<img src='data:$imageType;base64,$base64ImageData' />";
        
                // 画像をブラウザに直接表示
                header("Content-Type: $imageType");
                echo $imageData;
                $introImg++;
            }

        }

        echo "<hr>";

        //タグ情報表示
        for ($l=0; $l < $_POST['project_tag_piece']; $l++) { 
            
            echo "<p>タグ".($l+1).":".$_POST['project_tag_Text'][$l]."</p>";

            
        }

        echo "<button onclick='deleteUploadedImgJS()'>戻る</button>";
        echo "<button onclick='insertProjectJS()'>投稿する</button>"    
    ?>
    


<!-- bootstrapのjavascriptの導入 -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
</html>