// 複数の画像読み込み用
const fileProjectThumbnail = document.getElementById('project_thumbnail');
const handleFileSelect = () => {
    const files = fileProjectThumbnail.files;
        for (let i = 0; i < files.length; i++) {
            previewFile(files[i]);
        }
}


function previewFile(file) {
    // プレビュー画像を追加する要素
    const preview = document.getElementById('preview');

    // FileReaderオブジェクトを作成
    const reader = new FileReader();

    // ファイルが読み込まれたときに実行する
    reader.onload = function (e) {
        const imageUrl = e.target.result; // 画像のURLはevent.target.resultで呼び出せる
        const img = document.createElement("img"); // img要素を作成
        img.src = imageUrl; // 画像のURLをimg要素にセット
        img.className="previewImg";
        // preview内の画像をいったん削除して表示されるのを一つにする
        preview.innerHTML="";

        preview.appendChild(img); // #previewの中に追加
    }

    // いざファイルを読み込む
    reader.readAsDataURL(file);
}

// previewのidを持つ要素(fileInput)が何かしら変更されたとき(投稿される画像のアップロード、変更等)handleFileSelectを起動する
fileProjectThumbnail.addEventListener('change', handleFileSelect);