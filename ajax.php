<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
// セッション
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php'); // ログインしていない場合、ログインページにリダイレクト
    exit();
}
$user_id = $_SESSION['user_id'];

// DAOの呼び出し
require_once 'DAO.php';
$dao = new DAO();

// POSTデータを受け取り
if (isset($_POST['action'])) {
    if ($_POST['action'] === 'add') {
        // コメントIDを取得
        $commentId = $_POST['comment_id'];

        // ハートをデータベースに追加
        $result = $dao->heart_add($user_id, $commentId);
        if ($result) {
            echo 'ハートをデータベースに追加しました。';
        } else {
            echo 'ハートの追加に失敗しました。';
        }
    } elseif ($_POST['action'] === 'delete') {
        // コメントIDを取得
        $commentId = $_POST['comment_id'];

        // ハートをデータベースから削除
        $result = $dao->heart_del($user_id, $commentId);
        if ($result) {
            echo 'ハートをデータベースから削除しました。';
        } else {
            echo 'ハートの削除に失敗しました。';
        }
    }
}
?>
