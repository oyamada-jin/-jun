<?php

    //セッション
    session_start();

    //DAOの呼び出し
    require_once '../DAO.php';
    $dao = new DAO();

    //ここから処理を書いてください。

    $dao->insertProjectSupport($_SESSION['id'],$_POST['support_method'],$_POST['project_id'],$_POST['project_course_detail_id'],$_POST['address_detail_id']);

    $responseData = array(
        'status' => 'success',
        'message' => 'プロジェクト応援の登録が完了しました。',
    );

    header('Content-Type: application/json');
    echo json_encode($responseData);
?>