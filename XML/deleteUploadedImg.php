<?php
//仮アップロートの画像を削除する
function deleteUploadedImg($thumbnailArray,$courseArray,$introArray){
    
    if(!empty($thumbnailArray)){//サムネイル画像の削除
        foreach($thumbnailArray as $ta){
            if(file_exists($ta)){
                unlink($ta);
            }
        }
    }

    if(!empty($courseArray)){//プロジェクトコース画像の削除
        foreach($courseArray as $ca){
            if(file_exists($ca)){
                unlink($ca);
            }
        }
    }

    if(!empty($introArray)){//プロジェクト内容画像の削除
        foreach($introArray as $ia){
            if(file_exists($ia)){
                unlink($ia);
            }
        }
    }

    // header('Location:createProject.php');
    // exit;
    
}

?>