<?php

    //セッション
    session_start();

    //ここから処理を書いてください。
    session_destroy();

    header('Location: login.php');
    exit();
 
?>