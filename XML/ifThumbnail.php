<?php

function ifUploadThumbnail($project_thumbnail,$piece){
        
    $thumbnailArray = array();

    //サムネイル画像のアップロード
    if(!empty($project_thumbnail)){
        $targetThumbnailDir = "img/project_thumbnail/uploadNow/";
        for($count_1 = 0; $count_1 < $piece; $count_1++){
            
            //拡張子を格納
            // $imageFileType = strtolower(pathinfo($project_thumbnail["name"][$count_1], PATHINFO_EXTENSION));
            
            //保存するファイル名を格納
            $targetFile = $targetThumbnailDir."pre".$project_thumbnail['name'][$count_1];

            //アップロード
            move_uploaded_file($project_thumbnail["tmp_name"][$count_1], $targetFile);
        
            $thumbnailArray[$count_1] = $targetFile;
        }
        
    }

    return $thumbnailArray;


}


?>