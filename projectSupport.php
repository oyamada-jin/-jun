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

?>
<!-- ここまで -->

<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // POSTリクエストの場合
    $projectId = isset($_POST['project_id']) ? $_POST['project_id'] : null;
    $projectDetailId = isset($_POST['project_detail_id']) ? $_POST['project_detail_id'] : null;
} elseif ($_SERVER['REQUEST_METHOD'] === 'GET') {
    // GETリクエストの場合
    $projectId = isset($_GET['project_id']) ? $_GET['project_id'] : null;
    $projectDetailId = isset($_GET['project_detail_id']) ? $_GET['project_detail_id'] : null;
} else {
    // それ以外の場合はエラー処理などを行う
    // この例では何もしませんが、実際のプロジェクトではエラーページなどにリダイレクトするなどの対応が必要です
    die('Invalid request method');
}

// $projectIdと$projectDetailIdが取得できたかどうかの確認
if ($projectId !== null && $projectDetailId !== null) {

    // データの取得
    $project = $dao->selectProjectAndCourseById($projectId, $projectDetailId);

    // 取得したデータがあるかどうかの確認
    if (!empty($project)) {
        var_dump($project);
    } else {
        header("Location: projectDetail.php");
        exit();
    }

    // その他の処理（必要に応じて追加）

} else {
    // $projectIdか$projectDetailIdが取得できなかった場合のエラー処理
    // この例では何もしませんが、実際のプロジェクトではエラーページなどにリダイレクトするなどの対応が必要です
    die('Invalid project or project detail ID');
}

    // $project = $dao->selectProjectAndCourseById($_POST['project_id'],$_POST['project_detail_id']);

    // if(!empty($project)){
    //     var_dump($project);
    // }else{
    //     header("Location:projectDetail.php");
    //     exit();
    // }

    $addressArray = $dao ->selectAllAddressById($_SESSION['id']); 


?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>プロジェクト応援</title>

    <!-- cssの導入 -->
    <link rel="stylesheet" href="css/projectSupport.css">
    <link rel="stylesheet" href="css/header.css">


    <!-- javascriptの導入 -->
    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/2.0.0/jquery.min.js"></script>
    <script type="text/javascript" src="script/modal/modalFunction.js"></script>
    

    <!-- bootstrapのCSSの導入 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

</head>
<body class="body">
    <!-- ヘッダーここから -->
    <header class="header">
        <img class="header-logo" src="img/IdecaLogo.png" onclick="window.location.href = 'top.php'">
    </header>
    <!-- ヘッダーここまで -->
    
    <div class="borderContents">
        <h3 class="text-center" style="color: #d70026;">応援購入の内容を確認する</h3>
    </div>

    <div class="borderContents">
        <?php 
            echo "<img src='".$project['project_course_thumbnail']."' class='Img' alt='コースサムネイル'><br/>";
            echo "<h5>請求金額</h5>";
            echo "<p>".$project['project_course_value']."円（税込み）</p>";
            echo "<h5>コース名</h5>";
            echo "<p>".$project['project_course_name']."</p><hr>";
            echo "<h5>コース内容</h5>";
            echo "<p>".$project['project_course_intro']."</p>";


            // echo "<p>".$project['']."</p>";
        ?>

    </div>
    <form id="mainForm" action="projectSupportConfirm.php" method="post">
    <input type="hidden" name="project_id" value="<?php echo $projectId ?>">
    <input type="hidden" name="project_detail_id" value="<?php echo $projectDetailId ?>">
        <div class="borderContents">
            <h3 style="color: #d70026;">お届け先を選択してください</h3>

            <?php
                if(!empty($addressArray)){
                    foreach ($addressArray as $address) {
                        
                        echo "<label for='".$address['address_detail_id']."'>
                                <input type='radio' id='".$address['address_detail_id']."' value='".$address['address_detail_id']."' name='address'>"
                                    .$address['chi_name']
                                    .$address['kana_name']
                                    .$address['post_code']
                                    .$address['user_address']
                                    .$address['mail_address']
                            ."</label><hr/>";
                    }
                }


            ?>

        </div>

        <div class="borderContents">

            <h3 data-bs-toggle="modal" data-bs-target="#staticBackdrop" style="color: #d70026;">お届け先を追加する</h3>

            <!-- Modal -->
            <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="staticBackdropLabel">お届け先入力フォーム</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form  method="post" id="myForm" name="myFormName">
                                <p class="mb-1">お名前【全角文字】</p>
                                <input type="text" class="mb-3" name="chi_name" form="myForm" required>
                                <p class="mb-1">お名前(カナ)【全角カタカナ】</p>
                                <input type="text" class="mb-3" name="kana_name" form="myForm" required>
                                <p class="mb-1">電話番号【半角数字】</p>
                                <input type="text" class="mb-3" name="phone_number" form="myForm" required>
                                <p class="mb-1">郵便番号【半角数字】</p>
                                <input type="text" class="mb-3" name="post_code" form="myForm" required>
                                <p class="mb-1">ご自宅住所【全角文字】</p>
                                <input type="text" class="mb-3" name="user_address" form="myForm" required>
                                <p class="mb-1">携帯メールアドレス【全角英数字】</p>
                                <input type="text" class="mb-3" name="mail_address" form="myForm" required><br>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">戻る</button>
                            <button type="button" class="btn btn-primary" onclick="submitForm(<?php echo $projectId.','.$projectDetailId  ?>)">登録する</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        
       






        <div class="borderContents">
            <h3 style="color: #d70026;">支払方法</h3>
        </div>

        <div class="borderContents">
            <label for="radio1">
                <p>    
                   <input type="radio" id="radio1" name="howToPay" value="card" form="mainForm">
                    クレジットカード決済
                </p>
            </label><br/>
            <label for="radio2">
                <p>    
                    <input type="radio" id="radio2" name="howToPay" value="convenience" form="mainForm">
                    コンビニ払い（ローソン、ファミマ、ミニストップ）
                </p>
            </label><br/>
            <label for="radio3">
                <p>    
                    <input type="radio" id="radio3" name="howToPay" value="payEasy" form="mainForm">
                    ペイジー決済（Pay-easy）
                </p>
            </label><br/>
            <label for="radio4">
                <p>
                    <input type="radio" id="radio4" name="howToPay" value="bank" form="mainForm">
                    銀行振込（GMO青空ネット銀行バーチャル口座）
                </p>
            </label><br/>
        
        </div>
    </form>




    <div class="borderContents">
        <h3 style="color: #d70026;">支払い期限</h3>
        <p>・前払いなり、以下の支払い方法に応じてお支払いいただくこととなります。</p>
        <p>・クレジットカード：リターンの注文受付完了において課金されます。</p>
        <p>・コンビニ払い・ペイジー決済・銀行振込：注文が完了され次第、お支払い番号を発行し、
            Ｅメールをお知らせしますので、お支払い番号の発行日を含めて7日以内かつプロジェクト終了日までに代金をお支払いください。
        </p>
        <p>・お支払期限を過ぎますとご注文が自動的にキャンセルとなりますのでご注意ください。
            なお、キャンセルが発生した場合でも、所定の手数料が発生いたしますことをご理解いただきますようお願い申し上げます。
            何かご不明点がございましたら、お気軽にお問い合わせください。何卒よろしくお願いいたします。
        </p>
    </div>

    <div class="buttonArea">
        <button class="button" style="background-color: darkgrey;">戻る</button>
        <button class="button" type="submit" form="mainForm">次へ</button>
    </div>
    
    

<!-- bootstrapのjavascriptの導入 -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

</body>
</html>