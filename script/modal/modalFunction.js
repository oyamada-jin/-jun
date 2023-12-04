function submitForm(id,detailId) {
    // テキストボックスの入力値を取得
    var chiName = $("input[name='chi_name']").val();
    var kanaName = $("input[name='kana_name']").val();
    var phoneNumber = $("input[name='phone_number']").val();
    var postCode = $("input[name='post_code']").val();
    var userAddress = $("input[name='user_address']").val();
    var mailAddress = $("input[name='mail_address']").val();

    // 入力値のチェック
    if (chiName === '' || kanaName === '' || phoneNumber === '' || postCode === '' || userAddress === '' || mailAddress === '') {
        alert("全ての項目を入力してください。");
        return;
    }

    // Ajaxリクエストの設定
    $.ajax({
        type: 'POST',
        url: 'XML/insertAddressCheck.php',
        data: {
            chi_name: chiName,
            kana_name: kanaName,
            phone_number: phoneNumber,
            post_code: postCode,
            user_address: userAddress,
            mail_address: mailAddress
        },
        success: function(response) {
            // 成功時の処理
            console.log('Ajax request successful');
            console.log(response);

            var projectId = id;
            var projectDetailId = detailId;
            var url = "projectSupport.php?project_id=" + projectId + "&project_detail_id=" + projectDetailId;
        
            window.location.href = url;
        },
        error: function(error) {
            // エラー時の処理
            console.error('Ajax request failed');
            console.error(error);
        },
        complete: function(msg) {
            console.log('Complete:', msg);
        }
    });
}
