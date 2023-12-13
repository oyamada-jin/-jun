function changeTab(tabNumber) {
    // 全てのタブとコンテンツを非表示にする
    for (let i = 1; i <= 3; i++) {
        document.getElementById('tab' + i).classList.remove('active');
    }

    // 選択されたタブとコンテンツを表示する
    document.getElementById('tab' + tabNumber).classList.add('active');
}