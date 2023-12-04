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
        public function login($mail){
            $pdo= $this->dbConnect();
            $sql= "SELECT * FROM user WHERE user_mail = ?";
            $ps= $pdo->prepare($sql);
            $ps->bindValue(1, $mail, PDO::PARAM_STR);
            $ps->execute();
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
            // recipe_name
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
            $sql = "SELECT project.project_id, 
                           project.project_name, 
                           project.project_start, 
                           COUNT(project_support.project_id) AS support_count,
                           SUM(project_course.project_course_value) AS total_money,
                           project.project_goal_money,
                           SUM(project_course.project_course_value) / project.project_goal_money * 100 AS money_ratio
                    FROM project
                    LEFT JOIN project_course ON project.project_id = project_course.project_id
                    LEFT JOIN project_support ON project.project_id = project_support.project_id
                                             AND project_course.project_course_detail_id = project_support.project_course_detail_id
                    LEFT JOIN project_thumbnail ON project.project_id = project_thumbnail.project_id
                                              AND project_thumbnail.project_thumbnail_detail_id = 0
                    WHERE " . implode(' AND ', $likeConditions) . "
                    GROUP BY project.project_id";
        
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
        
        function insertProjectSupport($user_id,$method,$project_id,$course_detail_id,$address_detail_id) {
            $pdo = $this->dbConnect();
            
            $sql = "INSERT INTO `project_support`
                (`support_method`, `support_limit`, `support_flag`, `project_id`, `project_course_detail_id`, `user_id`, `address_detail_id`) 
            VALUES 
                (:support_method, :support_limit, :support_flag, :project_id, :project_course_detail_id, :user_id, :address_detail_id)";
            $date = new DateTime();
            $date->modify('+1 weeks');

            $q = $pdo->prepare($sql);
            $q->bindValue(":support_method", $method, PDO::PARAM_STR);
            $q->bindValue(":support_limit", $date->format('Y年m月d日 H時'), PDO::PARAM_STR);
            $q->bindValue(":support_flag", "決済完了待ち", PDO::PARAM_STR);
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
        


        // function  (){
        //     $pdo = $this->dbConnect();
        //     $sql = "";
        //     $q = $pdo->prepare($sql);
        //     $q->bindValue("",,PDO::PARAM_INT);


        //     $q->execute();

            
        // }


        















}

?>