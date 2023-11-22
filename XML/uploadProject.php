<?php

require_once 'deleteUploadedImg.php';
// require_once '../DAO.php';
// $dao = new Dao();

function uploadProject($project_name,$project_goal_money,$project_start,$project_end,$user_id,
                       $thumbnailImg,$courseImg,$introImg,$thumbnailPiece,$coursePiece,
                       $introPiece,$courseName,$courseIntro,$courseValue,        
                       $introFlag,$introText,$tagPiece,
                       $tagText,
                       $dao,$thumbnailArray,$courseArray,$introArray){
    //投稿するボタンが押されたときに、プロジェクトに関するデータをDBにアップロードする

    //プロジェクトテーブルへ登録
    $project_id = $dao->insertProject($project_name,$project_goal_money,$project_start,$project_end,$user_id);

    //サムネイル画像のアップロード
    if(!empty($thumbnailImg)){
        $targetThumbnailDir = "img/project_thumbnail/";
        for($count_1 = 0; $count_1 < $thumbnailPiece; $count_1++){
            
            //拡張子を格納
            $imageFileType = strtolower(pathinfo($thumbnailImg["name"][$count_1], PATHINFO_EXTENSION));
            
            //保存するファイル名を格納
            $targetFile = $targetThumbnailDir.$project_id."_thumbnail_".$count_1.".".$imageFileType;

            //アップロード
            move_uploaded_file($thumbnailImg["tmp_name"][$count_1], $targetFile);

            $dao->insertProjectThumbnail($project_id,$count_1,$targetFile);
        }
        
    }
    // //プロジェクトサムネイルが存在する場合
    // if((int)$_POST['project_thumbnail_piece'] > 0){ 
    //     for($i = 0; $i < (int)$_POST['project_thumbnail_piece']; $i++){
    //         $dao->insertProjectThumbnail($project_id,$i,$thumbnailArray[$i]);
    //     }
    // }


    //プロジェクトコース画像のアップロード
    if(!empty($courseImg)){
        $targetCourseDir = "img/project_course/";
        for($count_2 = 0; $count_2 < $coursePiece; $count_2++){
            
            //拡張子を格納
            $imageFileType = strtolower(pathinfo($courseImg["name"][$count_2], PATHINFO_EXTENSION));
            
            //保存するファイル名を格納
            $targetFile = $targetCourseDir.$project_id."_thumbnail_".$count_2.".".$imageFileType;

            //アップロード
            move_uploaded_file($courseImg["tmp_name"][$count_2], $targetFile);
        
            $dao->insertProjectCourse($project_id,$count_2,$courseName[$count_2],$targetFile,$courseIntro[$count_2],$courseValue[$count_2]);
        }
        
    }
    // //プロジェクトコースが存在する場合
    // if($_POST['project_course_piece'] > 0){
    //     for($i = 0; $i < $_POST['project_course_piece']; $i++){
    //         $dao->insertProjectCourse($project_id,$i,$_POST['project_course_name'][$i],$courseArray[$i],$_POST['project_course_intro'][$i],$_POST['project_course_value'][$i]);
    //     }
    // }


    //プロジェクト内容画像の存在確認＋アップロード
if(!empty($introImg)){

    $fileCount = 0;
    $text = 0;
    $targetIntroDir = "img/project_intro/";

    for($count_3 = 0; $count_3 < $introPiece; $count_3++){

        if($introFlag[$count_3]==1){//画像ならば

            //拡張子を格納
            $imageFileType = strtolower(pathinfo($introImg["name"][$fileCount], PATHINFO_EXTENSION));
            
            //保存するファイル名を格納
            $targetFile = $targetIntroDir.$project_id."_thumbnail_".$fileCount.".".$imageFileType;

            //アップロード
            move_uploaded_file($introImg["tmp_name"][$fileCount], $targetFile);
        
            $dao->insertProjectIntro($project_id,$count_3,$introFlag[$count_3],$targetFile,null);

            //画像を格納した回数を記録する
            $fileCount++;
        }else if($introFlag[$count_3]==0){//テキストならば
            $dao->insertProjectIntro($project_id,$count_3,$introFlag[$count_3],null,$introText[$text]);    
                $text++;
        }
        
    }
    
}
    // //プロジェクト内容が存在する場合
    // if($_POST['project_intro_piece'] > 0){
        
    //     for ($i=0; $i < $_POST['project_intro_piece']; $i++) { 
    //         if($_POST['project_intro_flag'][$i] == "0"){ //テキストの場合
    //             $dao->insertProjectIntro($project_id,$i,$_POST['project_intro_flag'][$i],null,$_POST['project_intro_text'][$text]);    
    //             $text++;
    //         }else{  //画像の場合
    //             $dao->insertProjectIntro($project_id,$i,$_POST['project_intro_flag'][$i],$introArray[$i],null);
    //         }
            
    //     }
    // }

    //プロジェクトタグが存在する場合
    if($tagPiece > 0){
        // for($i = 0; $i < $_POST['project_tag_piece']; $i++){
        //     $dao->tagCheck($project_id,$_POST['project_tag_Text'][$i]);
        // }
        $dao->tagCheck($project_id,$tagText);
    }

    //本アップロードが完了したので仮アップロード画像を削除

    // deleteUploadedImg($thumbnailArray,$courseArray,$introArray);

    // header('Location:createProjectComplete.php');
    // exit;
}

$projectName = $_POST['project_name'];
$projectGoalMoney = $_POST['project_goal_money'];
$projectStart = $_POST['project_start'];
$projectEnd = $_POST['project_end'];
$id = $_SESSION['id'];
$projectThumbnailPiece = $_POST['project_thumbnail_piece'];
$projectCoursePiece = $_POST['project_course_piece'];
$projectIntroPiece = $_POST['project_intro_piece'];
$projectTagPiece = $_POST['project_tag_piece'];

// プロジェクトコースの名前は配列なので、配列で取得
$projectCourseNames = $_POST['project_course_name'];

// 他の配列データも同様に取得
$projectCourseIntro = json_encode($_POST['project_course_intro']);
$projectCourseValue = json_encode($_POST['project_course_value']);
$projectIntroFlag = json_encode($_POST['project_intro_flag']);
$projectIntroText = json_encode($_POST['project_intro_text']);
$projectTagText = json_encode($_POST['project_tag_Text']);

// 画像ファイルやその他のファイルも同様に取得
$thumbnailFiles = $_FILES['project_thumbnail'];
$courseFiles = $_FILES['project_course_file'];
$introFiles = $_FILES['project_intro_file'];

uploadProject(
    $projectName,
    $projectGoalMoney,
    $projectStart,
    $projectEnd,
    $id,
    $thumbnailFiles,
    $courseFiles,
    $introFiles,
    $projectThumbnailPiece,
    $projectCoursePiece,
    $projectIntroPiece,
    $projectCourseNames,
    $projectCourseIntro,
    $projectCourseValue,
    $projectIntroFlag,
    $projectIntroText,
    $projectTagPiece,
    $projectTagText,
    $dao,
    json_decode($_POST['thumbnailArray']),
    json_decode($_POST['courseArray']),
    json_decode($_POST['introArray'])
);

?>