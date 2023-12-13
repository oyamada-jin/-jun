<?php

    function ifUploadCourse($project_course,$piece){
        
        $courseArray = array();

        //プロジェクトコース画像のアップロード
        if(!empty($project_course)){
            $targetCourseDir = "img/project_course/uploadNow/";
            for($count_2 = 0; $count_2 < $piece; $count_2++){
                
                //拡張子を格納
                // $imageFileType = strtolower(pathinfo($project_course["name"][$count_2], PATHINFO_EXTENSION));
                
                //保存するファイル名を格納
                $targetFile = $targetCourseDir."pre".$project_course['name'][$count_2];

                //アップロード
                move_uploaded_file($project_course["tmp_name"][$count_2], $targetFile);
            
                $courseArray[$count_2] = $targetFile;
                
            }
            
        }

        return $courseArray;


    }

?>