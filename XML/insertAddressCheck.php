<?php

    //セッション
    session_start();

    if(isset($_SESSION['id']) == false){
        header('Location: login.php');
        exit();
    }

    //DAOの呼び出し
    require_once '../DAO.php';
    $dao = new DAO();

    //ここから処理を書いてください。

    $chiName = $_POST['chi_name'];
    $kanaName = $_POST['kana_name'];
    $phoneNumber = $_POST['phone_number'];
    $postCode = $_POST['post_code'];
    $userAddress = $_POST['user_address'];
    $mailAddress = $_POST['mail_address'];
    

    // データベースへの挿入
    $dao->insertAddress($_SESSION['id'], $chiName, $kanaName, $phoneNumber, $postCode, $userAddress, $mailAddress);



    $responseData = array(
        'status' => 'success',
        'message' => 'アドレスの登録が完了しました。',
    );

    header('Content-Type: application/json');
    echo json_encode($responseData);
    

    // $dao->insertAddress($_SESSION['id'],$_POST['chi_name'],$_POST['kana_name'],$_POST['phone_number'],$_POST['post_code'],$_POST['user_address'],$_POST['mail_address']);
?>
