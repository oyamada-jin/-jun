<!-- 多分sessionは全ページ必須？なので消さないでください。 -->
<?php
session_start();
?>
<!-- sessionここまで -->

<!-- ログイン必須ページだけここのコードを残してください。 -->
<?php
if(isset($_SESSION['id']) == false){
   header('Location: login.php');
   exit();
}
?>
<!-- ログイン必須用はここまで -->

<!-- DAOを使用する場合は残してください。 -->
<?php
    //DAOの呼び出し
    require_once 'DAO.php';
    $dao = new DAO();

    
    $userdata = null;
    if(isset($_SESSION['id'])){
        $userdata = $dao->selectUserById($_SESSION['id']);
    }

    // データの取得
    $project = $dao->selectProjectAndCourseById((int)$_POST['project_id'],(int)$_POST['project_detail_id']);

    // 取得したデータがあるかどうかの確認
    if (!empty($project)) {

    } else {//POSTを使用すると考えられるページにデータを入れずに遷移しているため、何か別の方法を考える必要あり
        echo "<alert>コースが選択された物と異なる可能性がある為。プロジェクトページに移動します。</alert>";
        header("Location: projectDetail.php");
        exit();
    }

    $address = $dao ->selectAddressById($_SESSION['id'],(int)$_POST['address']); 

?>
<!-- ここまで -->
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>購入内容確認</title>

    <!-- cssの導入 -->
    <link rel="stylesheet" href="css/projectSupportConfirm.css">
    <link rel="stylesheet" href="css/header.css">
    <!-- javascriptの導入 -->
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>


    <!-- bootstrapのCSSの導入 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

</head>
<body>
    <!-- ヘッダーここから -->
    <header class="header">
        <img class="header-logo" src="img/IdecaLogo.png" onclick="window.location.href = 'top.php'">
    </header>
    <!-- ヘッダーここまで -->
    
    <div class="borderContents">
        <h3>以下の内容でよろしいですか？</h3>
        
        <?php 
            echo "<img src='".$project['project_course_thumbnail']."' class='Img' alt='コースサムネイル'><br/>";
            echo "<h5>請求金額</h5>";
            echo "<p>".$project['project_course_value']."円（税込み）</p>";
            echo "<h5>コース名</h5>";
            echo "<p>".$project['project_course_name']."</p><hr>";
            echo "<h5>コース内容</h5>";
            echo "<p>".$project['project_course_intro']."</p>";



           
        ?>
        <hr>

        <h5>お届け先</h5>
        <?php echo "<p>"
            .$address['chi_name']
            .$address['kana_name']
            .$address['post_code']
            .$address['user_address']
            .$address['mail_address'].
            "</p>" 
        ?>
        <hr>

        <h3>支払方法</h3>
        <p><?php if($_POST['howToPay']==="card"){echo "クレジットカード決済";}else if($_POST['howToPay']==="convenience"){echo "コンビニ払い";} else if($_POST['howToPay']==="payEasy"){echo "ペイジー決済";}else if($_POST['howToPay']==="bank"){echo "銀行振込";}  ?></p>

    </div>
    <div class="buttonArea">
        <button class="button" style="background-color: darkgrey;">戻る</button>
        <button class="button" onclick="submitForm()">確定する</button>
    </div>

    

<script>
    function submitForm() {
        var formData = new FormData();
        formData.append("support_method",'<?php echo $_POST['howToPay'] ?>');
        formData.append("project_id",<?php echo $_POST['project_id'] ?>);
        formData.append("project_course_detail_id",<?php echo $_POST['project_detail_id'] ?>);
        formData.append("address_detail_id",<?php echo $_POST['address'] ?>);
    
        $.ajax({
                url: 'XML/insertProjectSupport.php',
                type: 'post',
                processData: false,
                contentType: false,
                data: formData,
                dataType: 'json',
                success: function(response) {
                    console.log(response);
                    window.location.href = "supportProjectComplete.php";
                },
                error: function(xhr) {
                    console.log('Error:', xhr);
                },
                complete: function(msg) {
                    console.log('Complete:', msg);
                }
            });
    }
</script>
<!-- bootstrapのjavascriptの導入 -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
</html>