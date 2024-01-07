<?php
session_start();

require_once '../DAO.php';
$dao = new DAO();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $isLiked = $dao->checkIfHeartExists($_POST['userId'], $_POST['projectId']);

    if ($isLiked) {
        // 既に気になっている場合は削除
        $dao->unlikeProject($_POST['userId'], $_POST['projectId']);
        echo 'unliked';
    } else {
        // 気になっていない場合は追加
        $dao->likeProject($_POST['userId'], $_POST['projectId']);
        echo 'liked';
    }
}
?>
