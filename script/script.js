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
                ${row.comment_content}<br>`;
            commentsContainer.appendChild(commentDiv);
        });
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
