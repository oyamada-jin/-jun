<?php

    //セッション
    session_start();

    //DAOの呼び出し
    require_once 'DAO.php';
    $dao = new DAO();

    //ここから処理を書いてください。
    $searchArray = $dao->login($_POST['user_mail']);
    foreach($searchArray as $row){
        if(password_verify($_POST['user_password'], $row['user_password'])  ==  true){

            //セッションでuser_idを保持
            $_SESSION['id'] = $row['user_id'];

            //top.phpへ移動する
            header("Location: top.php");
            exit();
    }else{
        function func_alert($message){

            //アラート表示
            echo "<script>alert('$message');</script>";
            
            //アラートのOKを押したら新規登録画面に移動
            echo "<script>location.href='login.php';</script>";
        
        }
        func_alert("パスワードが間違っています。");
        }
    }

?>