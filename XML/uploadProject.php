<?php

session_start();

require_once 'deleteUploadedImg.php';
require_once '../DAO.php';
$dao = new Dao();

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
        $targetThumbnailDirFrom = "../img/project_thumbnail/uploadNow/pre";
        for($count_1 = 0; $count_1 < $thumbnailPiece; $count_1++){
            
            //拡張子を格納
            $imageFileType = strtolower(pathinfo($thumbnailImg["name"][$count_1], PATHINFO_EXTENSION));
            
            //保存するファイル名を格納
            $DBtargetFile = $targetThumbnailDir.$project_id."_thumbnail_".$count_1.".".$imageFileType;
            rename($targetThumbnailDirFrom.$thumbnailImg['name'][$count_1],"../".$DBtargetFile);
            $dao->insertProjectThumbnail($project_id,$count_1,$DBtargetFile);
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
        $targetCourseDirFrom = "../img/project_course/uploadNow/pre";
        for($count_2 = 0; $count_2 < $coursePiece; $count_2++){
            
            //拡張子を格納
            $imageFileType = strtolower(pathinfo($courseImg["name"][$count_2], PATHINFO_EXTENSION));
            
            //保存するファイル名を格納
            $DBtargetFile = $targetCourseDir.$project_id."_courseThumbnail_".$count_2.".".$imageFileType;
            rename($targetCourseDirFrom.$courseImg['name'][$count_2],"../".$DBtargetFile);
            $dao->insertProjectCourse($project_id,$count_2,$courseName[$count_2],$DBtargetFile,$courseIntro[$count_2],(int)$courseValue[$count_2]);
        }
        
    }



 
    //プロジェクト内容画像の存在確認＋アップロード
    if(!empty($introImg)){

        $fileCount = 0;
        $text = 0;
        $targetIntroDir = "img/project_intro/";
        $targetIntroDirFrom = "../img/project_intro/uploadNow/pre";

        for($count_3 = 0; $count_3 < $introPiece; $count_3++){

            if((int)$introFlag[$count_3]==1){//画像ならば

                //拡張子を格納
                $imageFileType = strtolower(pathinfo($introImg["name"][$fileCount], PATHINFO_EXTENSION));
                
                //保存するファイル名を格納
                $DBtargetFile = $targetIntroDir.$project_id."_introThumbnail_".$fileCount.".".$imageFileType;
                rename($targetIntroDirFrom.$introImg['name'][$fileCount],"../".$DBtargetFile);
                $dao->insertProjectIntro($project_id,$count_3,$introFlag[$count_3],$DBtargetFile,null);

                //画像を格納した回数を記録する
                $fileCount++;
            }else if($introFlag[$count_3]==0){//テキストならば
                $dao->insertProjectIntro($project_id,$count_3,$introFlag[$count_3],null,$introText[$text]);    
                    $text++;
            }
            
        }
        
    }




    //プロジェクトタグが存在する場合
    if($tagPiece > 0){
        
        $dao->tagCheck($project_id,$tagText);
    }

    //本アップロードが完了したので仮アップロード画像を削除

    deleteUploadedImg($thumbnailArray,$courseArray,$introArray);


    // レスポンスデータ
    $responseData = array(
        'status' => 'success',
        'message' => 'プロジェクトの作成が完了しました。',
    );

    // データをJSON形式にエンコードして出力
    header('Content-Type: application/json');
    echo json_encode($responseData);
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
$projectCourseIntro = explode(",",json_decode(json_encode($_POST['project_course_intro'])));
$projectCourseValue = explode(",",json_decode(json_encode($_POST['project_course_value']),true));
$projectCourseValue = str_replace("[","",$projectCourseValue);
$projectCourseValue = str_replace("]","",$projectCourseValue);
$projectCourseValue = str_replace('"',"",$projectCourseValue);

$projectIntroFlag = explode(",",json_decode(json_encode($_POST['project_intro_flag']),true));
$projectIntroFlag = str_replace("[","",$projectIntroFlag);
$projectIntroFlag = str_replace("]","",$projectIntroFlag);
$projectIntroFlag = str_replace('"',"",$projectIntroFlag);

$projectIntroText = explode(",",json_decode(json_encode($_POST['project_intro_text']),true));
$projectIntroText = str_replace("[","",$projectIntroText);
$projectIntroText = str_replace("]","",$projectIntroText);
$projectIntroText = str_replace('"',"",$projectIntroText);

$projectTagText = explode(",",json_decode(json_encode($_POST['project_tag_Text']),true));
$projectTagText = str_replace("[","",$projectTagText);
$projectTagText = str_replace("]","",$projectTagText);
$projectTagText = str_replace('"',"",$projectTagText);

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