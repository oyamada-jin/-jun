<?
require_once "deleteUploadedImg.php";

deleteUploadedImg($_POST['project_thumbnail'],$_POST['project_course_fiile'],$_POST['project_intro_file']);
$responseData = array(
    'status' => 'success',
    'message' => 'プロジェクトの作成が完了しました。',
    // 他に必要なデータがあれば追加
);

// データをJSON形式にエンコードして出力
header('Content-Type: application/json');
echo json_encode($responseData);
?>