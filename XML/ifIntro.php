<?php

    function ifUploadIntro($project_intro,$piece,$flag){
        
        $introArray = array();

        //プロジェクト内容画像の存在確認＋アップロード
        if(!empty($_FILES['project_intro_file'])){

            $fileCount = 0;
            $targetIntroDir = "img/project_intro/uploadNow/";

            for($count_3 = 0; $count_3 < $piece; $count_3++){

                if($flag[$count_3]==1){//画像ならば

                    //拡張子を格納
                    // $imageFileType = strtolower(pathinfo($project_intro["name"][$fileCount], PATHINFO_EXTENSION));
                    
                    //保存するファイル名を格納
                    $targetFile = $targetIntroDir."pre".$project_intro['name'][$fileCount];

                    //アップロード
                    move_uploaded_file($project_intro["tmp_name"][$fileCount], $targetFile);
                
                    $introArray[$fileCount] = $targetFile;

                    //画像を格納した回数を記録する
                    $fileCount++;
                }
            
            }
        }


        return $introArray;


    }

?>