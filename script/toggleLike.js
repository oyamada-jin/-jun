function toggleLike(userId,projectId) {

    // Ajaxリクエスト
    $.ajax({
        type: 'POST',
        url: 'XML/toggleLike.php',
        data: { userId: userId, projectId: projectId },
        success: function (response) {
            // サーバーからの応答に基づいて表示を切り替える
            if (response === 'liked') {
                $('#likeButton').text('気になる済み');
            } else {
                $('#likeButton').text('気になる');
            }
        }
    });
}