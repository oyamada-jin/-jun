<?php

    //セッション
    session_start();

    //DAOの呼び出し
    require_once 'DAO.php';
    $dao = new DAO();

    //ここから処理を書いてください。

    $mailCount = $dao->insertSearchMail($_POST['user_mail']);//既に入力されたメースアドレスが使われているか確認する
    
    if($mailCount == 0){//入力されたメールが未使用
    
        $dao->insertUser($_POST['user_mail'],$_POST['user_password'],$_POST['user_name']);
    
        //トップページに移動
        header("Location: login.php");
        exit();

    }else{//データベースに同じメールアドレスがあったらアラートで表示
        
        echo "<script>alert('既に使われているメールアドレスです。');</script>";
    
            //アラートのOKを押したら新規登録画面に移動  余裕があれば戻ったときにテキストボックスに入力値が残るようにしたい
        echo "<script>location.href='signUp.php';</script>";
        
    }

?>