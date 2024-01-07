document.addEventListener("DOMContentLoaded", function () {
    const sortByNewestButton = document.getElementById("sortByNewest");
    const sortByLikesButton = document.getElementById("sortByLikes");
    const commentsContainer = document.getElementById("comments");

    let currentSort = "newest"; // 初期表示は新しい順

    // 初期表示を行う関数
    function displayInitialData() {
        commentsContainer.innerHTML = "";
        if (currentSort === "newest") {
            displayComments(searchTimeASC);
        } else if (currentSort === "likes") {
            displayComments(searchHeartDesc);
        }
    }

    // コメントを表示する関数
    function displayComments(comments) {
        commentsContainer.innerHTML = "";
        comments.forEach(function (row) {
            const commentDiv = document.createElement("div");
            commentDiv.innerHTML = `
            <img src="${row.user_icon}" class="user_icon_ft">
            ${row.user_name}
            ${row.comment_time}<br>
            ${row.comment_content}
            <form action="insert_bord_good.php" method="post" class="heart-form">
                <input type="hidden" name="comment_id" value="${row.comment_id}">
                <button type="submit">
                    <img src="img/button/good_button.png" class="hart" data-comment-id="${row.comment_id}">
                </button>
            </form><br>`;
            commentsContainer.appendChild(commentDiv);
        });

        // ハートボタンにクリックイベントを追加
        const heartForms = document.querySelectorAll('.heart-form');
        heartForms.forEach(function (form) {
            form.addEventListener('submit', handleHeartSubmit);
        });
    }
    function handleHeartSubmit(event) {
        event.preventDefault();
    
        const commentId = event.currentTarget.querySelector('[name="comment_id"]').value;
    
        // AJAXを使用してinsert_bord_good.phpにPOSTリクエストを送信
        var xhr = new XMLHttpRequest();
        xhr.open('POST', 'insert_bord_good.php', true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    
        // ハートの追加か削除かを判断するためのデータを送信
        var data = 'comment_id=' + encodeURIComponent(commentId);
        xhr.send(data);
    
        // サーバーからのレスポンスを受け取り、必要に応じて処理
        xhr.onreadystatechange = function () {
            if (xhr.readyState == 4 && xhr.status == 200) {
                // レスポンスを処理するコード（任意）
                console.log(xhr.responseText);
            }
        };
    }

    // 新しい順ボタンのクリックイベント
    sortByNewestButton.addEventListener("click", function () {
        if (currentSort !== "newest") {
            currentSort = "newest";
            displayInitialData();
        }
    });

    // いいねが多い順ボタンのクリックイベント
    sortByLikesButton.addEventListener("click", function () {
        if (currentSort !== "likes") {
            currentSort = "likes";
            displayInitialData();
        }
    });

    // 初期表示
    displayInitialData();
});