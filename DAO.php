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
        function countProjectTag(){
            $pdo = $this->dbConnect();
            $sql = "SELECT * FROM project_tag";
            $sAPT = $pdo->prepare($sql);
            $sAPT->execute();
            $sAPT->fetchAll();
            $re = $sAPT ->rowCount();
            return $re;
        }

        //project_tagテーブル新規登録
        function insertProjectTag($project_id,$tag_id){
            $pdo = $this->dbConnect();
            $count = $this->countProjectTag();
            
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
            foreach ($tag_names as $name) {
                $isExistChecker = 0;
                foreach ($tag_data as $data) {
                    if($name = $data['tag_name']){//タグが存在したら
                        $this->insertProjectTag($project_id,$data['tag_id']);
                        $isExistChecker++;
                        break;
                    }
                }
                if ($isExistChecker==0) {//タグが存在しない場合
                    $tag_id = $this->insertTag($name);
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
            $sql = "INSERT INTO project_course(project_id, project_course_detail_id, project_course_name, project_course_thumbnail, project_course_intro, project_course_value) VALUES (:id,:detail_id,:name,:thumbnail,:intro,:courseValue)";
            $q = $pdo->prepare($sql);
            $q->bindValue(":id",$id,PDO::PARAM_INT);
            $q->bindValue(":detail_id",$detail_id,PDO::PARAM_INT);
            $q->bindValue(":name",$name,PDO::PARAM_STR);
            $q->bindValue(":thumbnail",$thumbnail,PDO::PARAM_STR);
            $q->bindValue(":intro",$intro,PDO::PARAM_STR);
            $q->bindValue(":courseValue",$value,PDO::PARAM_INT);

            $q->execute();     
        }

        //project_introテーブル　新規登録  ※画像とテキストの判別は呼び出し側で判別して、不要な方の引数にはnullを指定してください。
        function insertProjectIntro($id,$detail_id,$flag,$image,$text){
            $pdo = $this->dbConnect();
            $sql = "INSERT INTO project_intro(project_id, project_intro_detail_id, project_intro_flag, project_intro_image, project_intro_text) VALUES (:id,:detail_id,:flag,:image,:text)";
            $q = $pdo->prepare($sql);
            $q->bindValue(":id",$id,PDO::PARAM_INT);
            $q->bindValue(":detail_id",$detail_id,PDO::PARAM_INT);
            $q->bindValue(":flag",$flag,PDO::PARAM_INT);
            $q->bindValue(":image",$image,PDO::PARAM_INT);
            $q->bindValue(":text",$text,PDO::PARAM_INT);
 
            $q->execute();
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