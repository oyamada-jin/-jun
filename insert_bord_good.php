<?php
// セッション
session_start();

// ログインしていない場合、ログインページにリダイレクト
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

// DAOの呼び出し
require_once 'DAO.php';
$dao = new DAO();

// POSTリクエストの処理
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // comment_idがPOSTされているか確認
    if (isset($_POST['comment_id'])) {
        $user_id = $_SESSION['user_id'];
        $comment_id = $_POST['comment_id'];

        // ハートがすでに存在するか確認
        $heartExists = $dao->checkHeartExists($user_id, $comment_id);

        if (!$heartExists) {
            // ハートが存在しない場合は追加
            $dao->heart_add($user_id, $comment_id);
            echo 'Heart added successfully';
            header('Location: bord_top.php');
        } else {
            // ハートが既に存在する場合は削除（またはエラーメッセージを返すなど）
            // $dao->heart_del($user_id, $comment_id);
            // echo 'Heart removed successfully';
            echo 'Heart already exists';
            header('Location: bord_top.php');
        }
    } else {
        // comment_idがPOSTされていない場合のエラー処理
        http_response_code(400); // Bad Request
        echo 'Bad Request';
    }
} else {
    // POSTリクエスト以外の場合のエラー処理
    http_response_code(405); // Method Not Allowed
    echo 'Method Not Allowed';
}
?>
