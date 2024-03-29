<?php

class DAO{

    private function dbConnect(){//ローカル用
        $pdo= new PDO('mysql:host=localhost;dbname=Ideka;charset=utf8','root', 'root');
    
        return $pdo; 
    }


    //共通する便利機能

        //プロジェクトの総数を取得する
        public function allProjectCount(){
            $pdo = $this->dbConnect();
            $sql = "SELECT COUNT(*) as row FROM project";
            $query = $pdo->prepare($sql);
            $query->execute();
            return $query->fetch();
        }

    //新規登録関連
    
        //新規登録の際、同じメールアドレスが使われていないかチェック
        public function insertSearchMail($searchMail){
            $pdo= $this->dbConnect();
            $sql= "SELECT * FROM user WHERE user_mail LIKE :mail ";;
            $ps= $pdo->prepare($sql);
            $ps->bindValue(":mail", $searchMail,PDO::PARAM_STR);
            $ps->execute();
            return $ps->rowCount();
        }

         //新規追加部分
        public function insertUser($mail,$pass,$user){         
            $pdo= $this->dbConnect();
            $sql= "INSERT INTO user(user_mail,user_name,user_password)VALUES(?,?,?)";
            $ps= $pdo->prepare($sql);
            $ps->bindValue(1, $mail, PDO::PARAM_STR);
            $ps->bindValue(2, $user, PDO::PARAM_STR);
            $ps->bindValue(3, password_hash($pass, PASSWORD_DEFAULT), PDO::PARAM_STR);
            $ps->execute();
        }

    //ログイン機能
    
        //ログイン機能
        public function login($mail) {
            $pdo = $this->dbConnect();
            $sql = "SELECT * FROM user WHERE user_mail = ?";
            $ps = $pdo->prepare($sql);
            $ps->bindValue(1, $mail, PDO::PARAM_STR);
            $ps->execute();
        
            // ユーザーが存在するか確認
            $user = $ps->fetch(PDO::FETCH_ASSOC);
        
            if ($ps->rowCount() > 0) {//                //パスワードの照合のため、login_check.phpに移動
                $log_check = $ps->fetchAll();
                //SESSION使うかもしれないから一応置いとく
                return $log_check;
                
            }else{
                //データベースに登録していないとき
                function func_alert($message){
                    echo "<script>alert('$message');</script>";
                    //アラートのOKを押したら新規登録画面に移動
                    echo "<script>location.href='login.php';</script>";
                }
                func_alert("メールアドレスが間違っています。");
                $log_check = $ps->fetchAll();
                return $log_check;
            }
        }
        
//掲示板関連
        //掲示板ランダム投稿取得
        public function board_get_randam(){
            $pdo=$this->dbConnect();
            $sql= "SELECT bc.comment_id,bc.comment_content,bc.comment_time,u.user_name,u.user_icon FROM board_comment bc JOIN user u ON bc.user_id = u.user_id WHERE bc.parent_comment_id IS NULL";
            $ps= $pdo->prepare($sql);
            $ps->execute();
            $randamBord = $ps->fetchAll();
            return $randamBord;
        }
        public function board_get_all(){
            $pdo=$this->dbConnect();
            $sql= "SELECT bc.comment_id,bc.comment_content,bc.comment_time,u.user_name,u.user_icon FROM board_comment bc JOIN user u ON bc.user_id = u.user_id WHERE bc.parent_comment_id IS NULL";
            $ps= $pdo->prepare($sql);
            $ps->execute();
            $allBord = $ps->fetchAll();
            return $allBord;
        }
        //ユーザー名、アイコン取得
        public function get_username_icon(){
            $pdo=$this->dbConnect();
            $sql= "SELECT user_name,user_icon FROM user WHERE user_id = ?";
            $ps= $pdo->prepare($sql);
            if(isset($_SESSION['id'])==false){
                header("Location: login.php");
            }
            $ps->bindValue(1, $_SESSION['id'], PDO::PARAM_STR);
            $ps->execute();
            $searchUser = $ps->fetchAll();
            return $searchUser;
        }

        // 掲示板コメント投稿
        public function post_bord_comment($post_comment){
            $pdo = $this->dbConnect();
            $sql = "INSERT INTO board_comment(comment_id, comment_content, comment_time, parent_comment_id, user_id) VALUES (0, ?, CURRENT_TIMESTAMP, NULL, ?)";
            $ps = $pdo->prepare($sql);
            $ps->bindValue(1, $post_comment, PDO::PARAM_STR);
            $ps->bindValue(2, $_SESSION['id'], PDO::PARAM_STR);
            $ps->execute();
            $postcomments = $ps->fetchAll();
            return $postcomments;
        }
        //掲示板いいね順にコメントを表示するメソッド.
        public function get_heart_comment(){
            $pdo=$this->dbConnect();
            $sql= "SELECT bc.comment_id,bc.comment_content,bc.comment_time,COUNT(bh.comment_id) AS heart_count,u.user_name,u.user_icon
                    FROM board_comment AS bc LEFT JOIN board_heart AS bh ON bc.comment_id = bh.comment_id LEFT JOIN user AS u ON bc.user_id = u.user_id GROUP BY bc.comment_id, bc.comment_content, bc.comment_time, u.user_name, u.user_icon ORDER BY heart_count DESC;";
            $ps= $pdo->prepare($sql);
            $ps->execute();
            $comments = $ps->fetchAll();
            return $comments;
        }


        public function get_time_comment(){
            $pdo=$this->dbConnect();
            $sql="SELECT bc.comment_id,bc.comment_content,bc.comment_time,u.user_name,u.user_icon
                   FROM board_comment AS bc LEFT JOIN board_heart AS bh ON bc.comment_id = bh.comment_id LEFT JOIN user AS u ON bc.user_id = u.user_id ORDER BY bc.comment_time DESC;";
            $ps= $pdo->prepare($sql);
            $ps->execute();
            $tcomments = $ps->fetchAll();
            return $tcomments;
        }

        public function heart_add($user_id, $comment_id) {
            try {
                $pdo = $this->dbConnect();
                $sql = "INSERT INTO board_heart (comment_id, user_id, heart_time) VALUES (?, ?, CURRENT_TIMESTAMP)";
                $ps = $pdo->prepare($sql);
                $ps->bindParam(1, $comment_id, PDO::PARAM_INT);
                $ps->bindParam(2, $user_id, PDO::PARAM_INT);
                $ps->execute();
        
                // 成功した場合に true を返す
                return true;
            } catch (PDOException $e) {
                // エラーが発生した場合にログを出力などの処理を行う
                error_log("heart_add error: " . $e->getMessage());
        
                // 失敗した場合に false を返す
                return false;
            }
        }
        
        public function heart_del($user_id, $comment_id) {
            try {
                $pdo = $this->dbConnect();
                $sql = "DELETE FROM board_heart WHERE user_id = ? AND comment_id = ?";
                $ps = $pdo->prepare($sql);
                $ps->bindParam(1, $user_id, PDO::PARAM_INT);
                $ps->bindParam(2, $comment_id, PDO::PARAM_INT);
                $ps->execute();
        
                // 成功した場合に true を返す
                return true;
            } catch (PDOException $e) {
                // エラーが発生した場合にログを出力などの処理を行う
                error_log("heart_del error: " . $e->getMessage());
        
                // 失敗した場合に false を返す
                return false;
            }
        }
        
        public function checkHeartExists($user_id, $comment_id) {
            $pdo = $this->dbConnect();
            $sql = "SELECT * FROM board_heart WHERE user_id = ? AND comment_id = ?";
            $ps = $pdo->prepare($sql);
            $ps->bindValue(1, $user_id, PDO::PARAM_INT);
            $ps->bindValue(2, $comment_id, PDO::PARAM_INT);
            $ps->execute();
        
            // 結果を取得
            $result = $ps->fetch(PDO::FETCH_ASSOC);
        
            // ハートが存在するかどうかの確認
            return ($result !== false);
        }
        
        
                

    //プロジェクト作成関連
        
        //projectテーブル新規登録
        function insertProject($name, $goalMoney, $start, $end, $user_id){
            $pdo = $this->dbConnect();
            $sql = "INSERT INTO project(project_name, project_goal_money, project_start, project_end, user_id) VALUES (:project_name,:project_goal_money,:project_start,:project_end,:user_id)";
            $iP = $pdo->prepare($sql);
            $iP->bindValue(":project_name",$name,PDO::PARAM_STR);
            $iP->bindValue(":project_goal_money",$goalMoney,PDO::PARAM_INT);
            $iP->bindValue("project_start",$start,PDO::PARAM_STR);
            $iP->bindValue("project_end",$end,PDO::PARAM_STR);
            $iP->bindValue("user_id",$user_id, PDO::PARAM_INT);

            $iP->execute();

            return $pdo->lastInsertId();

        }

        //tagテーブル全件検索
        function selectAllTag(){
            $pdo = $this->dbConnect();
            $sql = "SELECT * FROM tag";
            $iET = $pdo->prepare($sql);
            $iET->execute();
            return $iET->fetchAll();
        }

        //tagテーブル新規登録
        function insertTag($tag_name){
            $pdo = $this->dbConnect();
            $sql = "INSERT INTO `tag`(`tag_name`) VALUES (:tag_name)";
            $iT = $pdo->prepare($sql);

            $iT->bindValue(":tag_name", $tag_name, PDO::PARAM_STR);

            $iT->execute();

            return $pdo->lastInsertId();
        }

        //project_tag全件検索
        function selectAllProjectTag(){
            $pdo = $this->dbConnect();
            $sql = "SELECT * FROM project_tag";
            $sAPT = $pdo->prepare($sql);
            $sAPT->execute();
            $sAPT->fetchAll();
            return $sAPT;
        }

        //project_tag行数取得
        function countProjectTag($project_id){
            $pdo = $this->dbConnect();
            $sql = "SELECT * FROM project_tag WHERE project_id = :project_id";
            $sAPT = $pdo->prepare($sql);
            $sAPT ->bindValue(":project_id",$project_id,PDO::PARAM_INT);
            $sAPT->execute();
            $sAPT->fetchAll();
            $re = $sAPT ->rowCount();
            return $re;
        }

        //project_tagテーブル新規登録
        function insertProjectTag($project_id,$tag_id){
            $pdo = $this->dbConnect();
            $count = $this->countProjectTag($project_id);
            
            $sql = "INSERT INTO `project_tag`(`project_id`, `project_tag_detail_id`, `tag_id`) VALUES (:project_id,:detail_id,:tag_id)";
            $iPT = $pdo->prepare($sql);
            $iPT->bindValue(":project_id",$project_id,PDO::PARAM_INT);
            $iPT->bindValue(":detail_id",$count,PDO::PARAM_INT);
            $iPT->bindValue(":tag_id",$tag_id,PDO::PARAM_INT);

            $iPT->execute();
            
        }


        //タグが存在するかチェックする
        function tagCheck($project_id,$tag_names){
            $pdo = $this->dbConnect();
            $tag_data = $this->selectAllTag();
            if(is_array($tag_names)===true){
                foreach ($tag_names as $name) {
                    $isExistChecker = 0;
                    foreach ($tag_data as $data) {
                        if($name === $data['tag_name']){//タグが存在したら
                            $this->insertProjectTag($project_id,$data['tag_id']);
                            $isExistChecker++;
                            break;
                        }
                    }
                    if ($isExistChecker===0) {//タグが存在しない場合
                        $tag_id = $this->insertTag($name);
                        $this->insertProjectTag($project_id,$tag_id);
                    }
                }
            }else{
                $isExistChecker = 0;
                foreach ($tag_data as $data) {
                    if($tag_names === $data['tag_name']){//タグが存在したら
                        $this->insertProjectTag($project_id,$data['tag_id']);
                        $isExistChecker++;
                        break;
                    }
                }
                if ($isExistChecker==0) {//タグが存在しない場合
                    $tag_id = $this->insertTag($tag_names);
                    $this->insertProjectTag($project_id,$tag_id);
                }
            }
        }

        //project_thumbnailテーブル　新規登録
        function insertProjectThumbnail($id,$detail_id,$image){
            $pdo = $this->dbConnect();
            $sql = "INSERT INTO project_thumbnail(project_id,project_thumbnail_detail_id, project_thumbnail_image) VALUES (:id,:detail_id,:thumbnail)";
            $q = $pdo->prepare($sql);
            $q->bindValue(":id",$id,PDO::PARAM_INT);
            $q->bindValue(":detail_id",$detail_id,PDO::PARAM_INT);
            $q->bindValue(":thumbnail",$image,PDO::PARAM_STR);

            $q->execute();
        }


        //project_courseテーブル　新規登録
        function insertProjectCourse($id,$detail_id,$name,$thumbnail,$intro,$value){
            $pdo = $this->dbConnect();
            $sql = "INSERT INTO project_course(project_id, project_course_detail_id, project_course_name, project_course_thumbnail, project_course_intro, project_course_value) VALUES (:id,:detail_id,:courseName,:thumbnail,:intro,:courseValue)";
            $q = $pdo->prepare($sql);
            $q->bindValue(":id",$id,PDO::PARAM_INT);
            $q->bindValue(":detail_id",$detail_id,PDO::PARAM_INT);
            $q->bindValue(":courseName",$name,PDO::PARAM_STR);
            $q->bindValue(":thumbnail",$thumbnail,PDO::PARAM_STR);
            $q->bindValue(":intro",$intro,PDO::PARAM_STR);
            $q->bindValue(":courseValue",(int)$value,PDO::PARAM_INT);

            $q->execute();     
        }

        //project_introテーブル　新規登録  ※画像とテキストの判別は呼び出し側で判別して、不要な方の引数にはnullを指定してください。
        function insertProjectIntro($id,$detail_id,$flag,$image,$text){
            $pdo = $this->dbConnect();
            $sql = "INSERT INTO project_intro(project_id, project_intro_detail_id, project_intro_flag, project_intro_image, project_intro_text) VALUES (:id,:detail_id,:flag,:image,:text)";
            $q = $pdo->prepare($sql);
            $q->bindValue(":id",$id,PDO::PARAM_INT);
            $q->bindValue(":detail_id",$detail_id,PDO::PARAM_INT);
            $q->bindValue(":flag",(int)$flag,PDO::PARAM_INT);
            $q->bindValue(":image",$image,PDO::PARAM_STR);
            $q->bindValue(":text",$text,PDO::PARAM_STR);
 
            $q->execute();
        }

    // プロジェクトを検索するメソッド
    function searchProjects($keyword) {
        // 入力を空白で分割
        $searchTerms = explode(' ', $keyword);

        // データベース接続
        $pdo = $this->dbConnect();

        // プレースホルダーの準備
        $placeholders = array_fill(0, count($searchTerms), '?');

        // LIKE検索の条件を生成
        $likeConditions = array_map(function ($term) {
            return "(project.project_name LIKE ? OR project_course.project_course_name LIKE ?)";
        }, $searchTerms);

        // SQLクエリの生成
        $sql = "SELECT 
                    project.project_id AS project_id,
                    project.project_name AS project_name,
                    support_count,
                    total_money,
                    (SUM(DISTINCT project_support.total_money) / project.project_goal_money * 100) AS money_ratio,
                    project.project_end AS project_end,
                    project_thumbnail.project_thumbnail_image
                FROM project
                LEFT JOIN (SELECT project_id, SUM(support_money) AS total_money, COUNT(project_id) AS support_count FROM project_support GROUP BY project_support.project_id) AS project_support
                    ON project.project_id = project_support.project_id
                LEFT JOIN project_course
                    ON project.project_id = project_course.project_id
                LEFT JOIN project_thumbnail
                    ON project.project_id = project_thumbnail.project_id
                WHERE " . implode(' AND ', $likeConditions) . "
                GROUP BY project.project_id;
                ";

        // プリペアドステートメントの準備
        $stmt = $pdo->prepare($sql);

        // プレースホルダーに値をバインド
        $params = [];
        foreach ($searchTerms as $term) {
            $params[] = '%' . $term . '%';
            $params[] = '%' . $term . '%';
        }
        $stmt->execute($params);

        // 結果の取得
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // データベース接続のクローズ
        $pdo = null;

        // 結果を返す
        return $results;
    }



    
    
    
    function  selectProjectAndCourseById($project_id,$detail_id){
        $pdo = $this->dbConnect();
        $sql = "SELECT
                    p.project_id AS project_id,
                    pc.project_course_detail_id AS project_detail_id,
                    p.project_name AS project_name,
                    pc.project_course_name AS project_course_name,
                    pc.project_course_thumbnail AS project_course_thumbnail,
                    pc.project_course_intro AS project_course_intro,
                    pc.project_course_value AS project_course_value
                FROM
                    project p
                JOIN
                    project_course pc ON p.project_id = pc.project_id
                WHERE
                    p.project_id = :project_id
                    AND pc.project_course_detail_id = :project_course_detail_id;";
        $q = $pdo->prepare($sql);
        $q->bindValue(":project_id",$project_id,PDO::PARAM_INT);
        $q->bindValue(":project_course_detail_id",$detail_id,PDO::PARAM_INT);

        $q->execute();

        return $q->fetch();
    }

    function selectAddressById($user_id,$detail_id){
        $pdo = $this->dbConnect();
        $sql = "SELECT * FROM Address WHERE user_id = :user_id AND address_detail_id = :address_detail_id";
        $q = $pdo->prepare($sql);
        $q->bindValue(":user_id",$user_id,PDO::PARAM_INT);
        $q->bindValue(":address_detail_id",$detail_id,PDO::PARAM_INT);

        $q->execute();

        return $q->fetch();            
    }

    function selectAllAddressById($user_id){
        $pdo = $this->dbConnect();
        $sql = "SELECT * FROM Address WHERE user_id = :user_id";
        $q = $pdo->prepare($sql);
        $q->bindValue(":user_id",$user_id,PDO::PARAM_INT);

        $q->execute();

        return $q->fetchAll();            
    }


    function insertAddress($user_id, $chi_name, $kana_name, $phone_number, $post_code, $user_address, $mail_address) {
        $pdo = $this->dbConnect();
        
        $sql = "INSERT INTO `address` 
                (`user_id`, `address_detail_id`, `chi_name`, `kana_name`, `phone_number`, `post_code`, `user_address`, `mail_address`) 
                VALUES 
                (:user_id, :address_detail_id, :chi_name, :kana_name, :phone_number, :post_code, :user_address, :mail_address)";
        
        $addressDetailId = $this->countAddressById($user_id);
        
        $q = $pdo->prepare($sql);
        $q->bindValue(":user_id", $user_id, PDO::PARAM_INT);
        $q->bindValue(":address_detail_id", $addressDetailId, PDO::PARAM_INT);
        $q->bindValue(":chi_name", $chi_name, PDO::PARAM_STR);
        $q->bindValue(":kana_name", $kana_name, PDO::PARAM_STR);
        $q->bindValue(":phone_number", $phone_number, PDO::PARAM_STR);
        $q->bindValue(":post_code", $post_code, PDO::PARAM_STR);
        $q->bindValue(":user_address", $user_address, PDO::PARAM_STR);
        $q->bindValue(":mail_address", $mail_address, PDO::PARAM_STR);
    
        $q->execute();
    }

    function insertProjectSupport($user_id, $method, $project_id, $course_detail_id, $address_detail_id) {
        $pdo = $this->dbConnect();
        
        $sql = "INSERT INTO `project_support`
            (`support_method`, `support_limit`, `support_flag`, `support_money` , `project_id`, `project_course_detail_id`, `user_id`, `address_detail_id`) 
        VALUES 
            (:support_method, :support_limit, :support_flag, :support_money, :project_id, :project_course_detail_id, :user_id, :address_detail_id)";
        
        $date = new DateTime();
        $date->modify('+1 weeks');
    
        $money = $this->selectProjectAndCourseById($project_id, $course_detail_id);
    
        $q = $pdo->prepare($sql);
        $q->bindValue(":support_method", $method, PDO::PARAM_STR);
        // ここで PDO::PARAM_STR を使用する
        $q->bindValue(":support_limit", $date->format('Y-m-d H:i:s'), PDO::PARAM_STR);
        $q->bindValue(":support_flag", "決済完了待ち", PDO::PARAM_STR);
        // ここで PDO::PARAM_STR を使用する
        $q->bindValue(":support_money", $money['project_course_value'], PDO::PARAM_STR);
        $q->bindValue(":project_id", $project_id, PDO::PARAM_INT);
        $q->bindValue(":project_course_detail_id", $course_detail_id, PDO::PARAM_INT);
        $q->bindValue(":user_id", $user_id, PDO::PARAM_INT);
        $q->bindValue(":address_detail_id", $address_detail_id, PDO::PARAM_INT);
    
        $q->execute();
    }

    function countAddressById($user_id) {
        $pdo = $this->dbConnect();
        $sql = "SELECT COUNT(*) AS record_count FROM address WHERE user_id = :user_id";
        
        $q = $pdo->prepare($sql);
        $q->bindValue(":user_id", $user_id, PDO::PARAM_INT);
        $q->execute();
    
        $result = $q->fetch(PDO::FETCH_ASSOC);
    
        return $result['record_count'];
    }
    


    


    function selectUserById($user_id){
        $pdo = $this->dbConnect();
        $sql = "SELECT * FROM user WHERE user_id = :user_id";
        $q = $pdo->prepare($sql);
        $q->bindValue(":user_id",$user_id,PDO::PARAM_INT);

        $q->execute();

        return $q->fetch();
    }

    function searchProjectsByUserId($user_id) {

        $pdo = $this->dbConnect();
        
        $sql = "SELECT 
                    project.project_id AS project_id,
                    project.project_name AS project_name,
                    COALESCE(support_count,0),
                    COALESCE(total_money,0),
                    COALESCE(SUM(DISTINCT project_support.total_money) / project.project_goal_money * 100,0) AS money_ratio,
                    project.project_end AS project_end,
                    project_thumbnail.project_thumbnail_image
                FROM project
                LEFT JOIN (SELECT project_id, SUM(support_money) AS total_money, COUNT(project_id) AS support_count FROM project_support GROUP BY project_support.project_id) AS project_support
                    ON project.project_id = project_support.project_id
                LEFT JOIN project_course
                    ON project.project_id = project_course.project_id
                LEFT JOIN project_thumbnail
                    ON project.project_id = project_thumbnail.project_id
                WHERE project.user_id = :user_id 
                GROUP BY project.project_id;
                ";

        // プリペアドステートメントの準備
        $stmt = $pdo->prepare($sql);

        $stmt ->bindValue(":user_id",$user_id,PDO::PARAM_INT);;
        
        $stmt->execute();

        // 結果の取得
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // 結果を返す
        return $results;
    }


    //view表示(プロジェクトを1つだけ表示)
    function  selectAllProjectView(){
        $pdo = $this->dbConnect();
        $currentDate = date("Y-m-d");
        $sql = "SELECT 
                    project.project_id AS project_id,
                    project.project_name AS project_name,
                    COALESCE(support_count,0),
                    COALESCE(total_money,0),
                    COALESCE(SUM(DISTINCT project_support.total_money) / project.project_goal_money * 100,0) AS money_ratio,
                    project.project_end AS project_end,
                    project_thumbnail.project_thumbnail_image,
                    IFNULL(project_heart.heart_count, 0) AS heart_count
                FROM project
                LEFT JOIN (
                    SELECT 
                        project_id, 
                        SUM(support_money) AS total_money, 
                        COUNT(project_id) AS support_count 
                    FROM project_support 
                    GROUP BY project_support.project_id
                ) AS project_support ON project.project_id = project_support.project_id
                LEFT JOIN project_course ON project.project_id = project_course.project_id
                LEFT JOIN project_thumbnail ON project.project_id = project_thumbnail.project_id
                LEFT JOIN (
                    SELECT 
                        project_id, 
                        COUNT(*) AS heart_count 
                    FROM project_heart 
                    GROUP BY project_id
                ) AS project_heart ON project.project_id = project_heart.project_id
                WHERE project.project_start <= :currentDate 
                    AND project.project_end >= :currentDate
                GROUP BY project.project_id
                LIMIT 1;
            ";
        $q = $pdo->prepare($sql);
        $q ->bindValue(':currentDate', $currentDate, PDO::PARAM_STR);
        $q->execute();
        return $q->fetchAll();
    }


    //ランキング表示
    function  selectAllProjectRanking(){
        $pdo = $this->dbConnect();
        $currentDate = date("Y-m-d");
        $sql = "SELECT 
                    project.project_id AS project_id,
                    project.project_name AS project_name,
                    IFNULL(project_support.support_count, 0) AS support_count,
                    IFNULL(project_support.total_money, 0) AS total_money,
                    (IFNULL(SUM(DISTINCT project_support.total_money), 0) / project.project_goal_money * 100) AS money_ratio,
                    project.project_end AS project_end,
                    project_thumbnail.project_thumbnail_image,
                    IFNULL(project_heart.heart_count, 0) AS heart_count
                FROM project
                LEFT JOIN (
                    SELECT 
                        project_id, 
                        COALESCE(SUM(support_money),0) AS total_money, 
                        COALESCE(COUNT(project_id),0) AS support_count 
                    FROM project_support 
                    GROUP BY project_support.project_id
                ) AS project_support ON project.project_id = project_support.project_id
                LEFT JOIN project_course ON project.project_id = project_course.project_id
                LEFT JOIN project_thumbnail ON project.project_id = project_thumbnail.project_id
                LEFT JOIN (
                    SELECT 
                        project_id, 
                        COUNT(*) AS heart_count 
                    FROM project_heart 
                    GROUP BY project_id
                ) AS project_heart ON project.project_id = project_heart.project_id
                WHERE project.project_start <= :currentDate AND project.project_end >= :currentDate
                GROUP BY project.project_id
                ORDER BY heart_count DESC";
                $q = $pdo->prepare($sql);
                $q ->bindValue(':currentDate', $currentDate, PDO::PARAM_STR);
                $q->execute();
                return $q->fetchAll();

    }

    // 新着表示
    function  selectAllProjectNew(){
        $pdo = $this->dbConnect();
        $currentDate = date("Y-m-d");
        $sql = "SELECT 
                    project.project_id AS project_id,
                    project.project_name AS project_name,
                    project.project_goal_money AS project_goal_money,
                    IFNULL(project_support.support_count, 0) AS support_count,
                    IFNULL(project_support.total_money, 0) AS total_money,
                    (IFNULL(SUM(DISTINCT project_support.total_money), 0) / project.project_goal_money * 100) AS money_ratio,
                    project.project_end AS project_end,
                    project_thumbnail.project_thumbnail_image,
                    IFNULL(project_heart.heart_count, 0) AS heart_count
                FROM project
                LEFT JOIN (
                    SELECT 
                        project_id, 
                        COALESCE(SUM(support_money), 0) AS total_money, 
                        COALESCE(COUNT(project_id), 0) AS support_count 
                    FROM project_support 
                    GROUP BY project_support.project_id
                ) AS project_support ON project.project_id = project_support.project_id
                LEFT JOIN project_course ON project.project_id = project_course.project_id
                LEFT JOIN project_thumbnail ON project.project_id = project_thumbnail.project_id
                LEFT JOIN (
                    SELECT 
                        project_id, 
                        COUNT(*) AS heart_count 
                    FROM project_heart 
                    GROUP BY project_id
                ) AS project_heart ON project.project_id = project_heart.project_id
                WHERE project.project_start <= :currentDate AND project.project_end >= :currentDate
                GROUP BY project.project_id
                ORDER BY project.project_id DESC";
        $q = $pdo->prepare($sql);
        $q ->bindValue(':currentDate', $currentDate, PDO::PARAM_STR);
        $q->execute();
        return $q->fetchAll();
    }

    // おすすめ表示
    function  selectAllProjectLike(){
        $pdo = $this->dbConnect();
        $currentDate = date("Y-m-d");
        $sql = "SELECT 
                    project.project_id AS project_id,
                    project.project_name AS project_name,
                    IFNULL(project_support.support_count, 0) AS support_count,
                    IFNULL(project_support.total_money, 0) AS total_money,
                    (IFNULL(SUM(DISTINCT project_support.total_money), 0) / project.project_goal_money * 100) AS money_ratio,
                    project.project_end AS project_end,
                    project_thumbnail.project_thumbnail_image,
                    IFNULL(project_heart.heart_count, 0) AS heart_count
                FROM project
                LEFT JOIN (
                    SELECT 
                        project_id, 
                        COALESCE(SUM(support_money), 0) AS total_money, 
                        COALESCE(COUNT(project_id), 0) AS support_count 
                    FROM project_support 
                    GROUP BY project_support.project_id
                ) AS project_support ON project.project_id = project_support.project_id
                LEFT JOIN project_course ON project.project_id = project_course.project_id
                LEFT JOIN project_thumbnail ON project.project_id = project_thumbnail.project_id
                LEFT JOIN (
                    SELECT 
                        project_id, 
                        COUNT(*) AS heart_count 
                    FROM project_heart 
                    GROUP BY project_id
                ) AS project_heart ON project.project_id = project_heart.project_id
                WHERE project.project_start <= :currentDate AND project.project_end >= :currentDate
                GROUP BY project.project_id
                ORDER BY project.project_id DESC";
        $q = $pdo->prepare($sql);
        $q ->bindValue(':currentDate', $currentDate, PDO::PARAM_STR);
        $q->execute();
        return $q->fetchAll();
    }

    //もうすぐ始まる表示
    function  selectAllProjectReady(){
        $pdo = $this->dbConnect();
        $currentDate = date("Y-m-d");
        $sql = "SELECT 
                    project.project_id AS project_id,
                    project.project_name AS project_name,
                    IFNULL(project_support.support_count, 0) AS support_count,
                    IFNULL(project_support.total_money, 0) AS total_money,
                    (IFNULL(SUM(DISTINCT project_support.total_money), 0) / project.project_goal_money * 100) AS money_ratio,
                    project.project_end AS project_end,
                    project_thumbnail.project_thumbnail_image,
                    IFNULL(project_heart.heart_count, 0) AS heart_count
                FROM project
                LEFT JOIN (
                    SELECT 
                        project_id, 
                        COALESCE(SUM(support_money), 0) AS total_money, 
                        COALESCE(COUNT(project_id), 0) AS support_count 
                    FROM project_support 
                    GROUP BY project_support.project_id
                ) AS project_support ON project.project_id = project_support.project_id
                LEFT JOIN project_course ON project.project_id = project_course.project_id
                LEFT JOIN project_thumbnail ON project.project_id = project_thumbnail.project_id
                LEFT JOIN (
                    SELECT 
                        project_id, 
                        COUNT(*) AS heart_count 
                    FROM project_heart 
                    GROUP BY project_id
                ) AS project_heart ON project.project_id = project_heart.project_id
                WHERE project.project_start <= :currentDate AND project.project_end >= :currentDate
                GROUP BY project.project_id
                ORDER BY project.project_id DESC";
        $q = $pdo->prepare($sql);
        $q ->bindValue(':currentDate', $currentDate, PDO::PARAM_STR);
        $q->execute();
        return $q->fetchAll();
    }

    //達成済み表示
    function  selectAllProjectComplete(){
        $pdo = $this->dbConnect();
        $currentDate = date("Y-m-d");
        $sql = "SELECT 
                    project.project_id AS project_id,
                    project.project_name AS project_name,
                    IFNULL(project_support.support_count, 0) AS support_count,
                    IFNULL(project_support.total_money, 0) AS total_money,
                    (IFNULL(SUM(DISTINCT project_support.total_money), 0) / project.project_goal_money * 100) AS money_ratio,
                    project.project_end AS project_end,
                    project_thumbnail.project_thumbnail_image,
                    IFNULL(project_heart.heart_count, 0) AS heart_count
                FROM project
                LEFT JOIN (
                    SELECT 
                        project_id, 
                        COALESCE(SUM(support_money), 0) AS total_money, 
                        COALESCE(COUNT(project_id), 0) AS support_count 
                    FROM project_support 
                    GROUP BY project_support.project_id
                ) AS project_support ON project.project_id = project_support.project_id
                LEFT JOIN project_course ON project.project_id = project_course.project_id
                LEFT JOIN project_thumbnail ON project.project_id = project_thumbnail.project_id
                LEFT JOIN (
                    SELECT 
                        project_id, 
                        COUNT(*) AS heart_count 
                    FROM project_heart 
                    GROUP BY project_id
                ) AS project_heart ON project.project_id = project_heart.project_id
                WHERE project.project_start <= :currentDate 
                    AND project.project_end >= :currentDate
                GROUP BY project.project_id
                HAVING money_ratio >= 100";
        $q = $pdo->prepare($sql);
        $q ->bindValue(':currentDate', $currentDate, PDO::PARAM_STR);
        $q->execute();
        return $q->fetchAll();
    }

    function  selectProjectDetailById($project_id){
        $pdo = $this->dbConnect();
        $currentDate = date("Y-m-d");
        $sql = "SELECT 
                    project.project_id AS project_id,
                    project.project_name AS project_name,
                    IFNULL(project_support.support_count, 0) AS support_count,
                    IFNULL(project_support.total_money, 0) AS total_money,
                    (IFNULL(SUM(DISTINCT project_support.total_money), 0) / project.project_goal_money * 100) AS money_ratio,
                    project.project_end AS project_end,
                    project.project_goal_money,
                    project.user_id,
                    IFNULL(project_heart.heart_count, 0) AS heart_count
                FROM project
                LEFT JOIN (
                    SELECT 
                        project_id, 
                        COALESCE(SUM(support_money), 0) AS total_money, 
                        COALESCE(COUNT(project_id), 0) AS support_count 
                    FROM project_support 
                    GROUP BY project_support.project_id
                ) AS project_support ON project.project_id = project_support.project_id
                LEFT JOIN project_course ON project.project_id = project_course.project_id
                LEFT JOIN project_thumbnail ON project.project_id = project_thumbnail.project_id
                LEFT JOIN (
                    SELECT 
                        project_id, 
                        COUNT(*) AS heart_count 
                    FROM project_heart 
                    GROUP BY project_id
                ) AS project_heart ON project.project_id = project_heart.project_id
                WHERE project.project_id = :project_id
                GROUP BY project.project_id
        ";
        $q = $pdo->prepare($sql);
        $q->bindValue(":project_id",$project_id,PDO::PARAM_INT);


        $q->execute();

        return $q->fetch();
    }

    
    
    function  selectProjectTagById($project_id){
        $pdo = $this->dbConnect();
        $sql = "SELECT tag.tag_name 
                FROM project_tag
                LEFT JOIN tag
                    ON project_tag.tag_id = tag.tag_id
                WHERE project_id = :project_id";
        $q = $pdo->prepare($sql);
        $q->bindValue(":project_id",$project_id,PDO::PARAM_INT);

        $q->execute();
        return $q->fetchAll();        
    }

    function  selectProjectThumbnailById($project_id){
        $pdo = $this->dbConnect();
        $sql = "SELECT project_thumbnail_image FROM project_thumbnail WHERE project_id = :project_id";
        $q = $pdo->prepare($sql);
        $q->bindValue(":project_id",$project_id,PDO::PARAM_INT);

        $q->execute();
        return $q->fetchAll();        
    }

    function  selectProjectIntroById($project_id){
        $pdo = $this->dbConnect();
        $sql = "SELECT project_intro_flag,project_intro_image, project_intro_text
                FROM project_intro
                WHERE project_id = :project_id
                ORDER BY project_id,project_intro_detail_id
        ";
        $q = $pdo->prepare($sql);
        $q->bindValue(":project_id",$project_id,PDO::PARAM_INT);

        $q->execute();
        return $q->fetchAll();        
    }

    function  selectProjectCourseById($project_id){
        $pdo = $this->dbConnect();
        $sql = "SELECT
                    project_course.project_id,
                    project_course.project_course_name,
                    project_course.project_course_thumbnail,
                    project_course.project_course_intro,
                    project_course.project_course_value,
                    COALESCE(supported_users.total_support_users_count, 0) AS total_support_users_count
                FROM project_course
                LEFT JOIN (
                    SELECT project_id, COUNT(DISTINCT user_id) AS total_support_users_count
                    FROM project_support
                    GROUP BY project_id
                ) AS supported_users ON supported_users.project_id = project_course.project_id
                WHERE project_course.project_id = :project_id
        ";
        $q = $pdo->prepare($sql);
        $q->bindValue(":project_id",$project_id,PDO::PARAM_INT);

        $q->execute();
        return $q->fetchAll();
    }

    function checkIfHeartExists($user_id, $project_id) {
        $pdo = $this->dbConnect();
    
        $sql = "SELECT COUNT(*) AS record_count FROM project_heart WHERE user_id = :user_id AND project_id = :project_id";
    
        $q = $pdo->prepare($sql);
        $q->bindValue(":user_id", $user_id, PDO::PARAM_INT);
        $q->bindValue(":project_id", $project_id, PDO::PARAM_INT);
    
        $q->execute();
    
        $result = $q->fetch(PDO::FETCH_ASSOC);
    
        return $result['record_count'] > 0;
    }

    // データベースからproject_heartレコードを削除する関数
    function unlikeProject($user_id, $project_id) {
        $pdo = $this->dbConnect();

        $sql = "DELETE FROM project_heart WHERE user_id = :user_id AND project_id = :project_id";

        $q = $pdo->prepare($sql);
        $q->bindValue(":user_id", $user_id, PDO::PARAM_INT);
        $q->bindValue(":project_id", $project_id, PDO::PARAM_INT);

        $q->execute();
    }

    // データベースに新しいproject_heartレコードを追加する関数
    function likeProject($user_id, $project_id) {
        $pdo = $this->dbConnect();

        $sql = "INSERT INTO project_heart (user_id, project_id) VALUES (:user_id, :project_id)";

        $q = $pdo->prepare($sql);
        $q->bindValue(":user_id", $user_id, PDO::PARAM_INT);
        $q->bindValue(":project_id", $project_id, PDO::PARAM_INT);

        $q->execute();
    }

    function selectUploadUserById($user_id){
        $pdo = $this->dbConnect();
        $sql = "SELECT user.user_id, user.user_name, user.user_icon, user.user_intro, counters.totalProjectCount
        FROM user 
        LEFT JOIN 
            (SELECT COUNT(*) AS totalProjectCount,user_id FROM project WHERE user_id = :user_id1) 
        AS counters 
            ON user.user_id = counters.user_id
        WHERE user.user_id = :user_id2";
        $q = $pdo->prepare($sql);
        $q->bindValue(":user_id1",$user_id,PDO::PARAM_INT);
        $q->bindValue(":user_id2",$user_id,PDO::PARAM_INT);

        $q->execute();

        return $q->fetch();
    }

    




}
// function  (){
    //     $pdo = $this->dbConnect();
    //     $sql = "";
    //     $q = $pdo->prepare($sql);
    //     $q->bindValue("",,PDO::PARAM_INT);


    //     $q->execute();

        
    // }
?>