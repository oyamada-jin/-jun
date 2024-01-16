<?php
// セッション
session_start();

// DAOの呼び出し
require_once 'DAO.php';
$dao = new DAO();

function func_alert($message){
    // アラート表示
    echo "<script>alert('$message');</script>";
    
    // アラートのOKを押したら新規登録画面に移動
    echo "<script>location.href='login.php';</script>";

    exit();
}

// 入力されたuser_mailとuser_passwordを受け取る
$user_mail = $_POST['user_mail'];
$user_password = $_POST['user_password'];

// ユーザーの情報を取得
$user = $dao->login($user_mail);

// ユーザーが存在するか確認
if ($user !== false) {
    // パスワードの照合
    if (password_verify($user_password, $user['user_password'])) {
        // セッションでuser_idを保持
        $_SESSION['id'] = $user['user_id'];
        // top.phpへ移動する
        header("Location: top.php");
        exit();
    } else {
        // パスワードが違う場合
        func_alert("メールアドレス又はパスワードが違います。");
    }
} else {
    // ユーザーが存在しない場合
    func_alert("メールアドレス又はパスワードが違います。");
}
?>
