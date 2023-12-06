<?php

class DAO{

    private function dbConnect(){//ローカル用
        $pdo= new PDO('mysql:host=localhost;dbname=Ideka;charset=utf8','root', 'root');
    
        return $pdo; 
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

        //掲示板コメント投稿
        public function post_bord_comment($post_comment){
            $pdo=$this->dbConnect();
            $sql= "INSERT INTO board_comment(comment_id,comment_content,comment_time,parent_comment_id,user_id) VALUES (0,?,CURRENT_DATE(),NULL,?)";
            $ps= $pdo->prepare($sql);
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
            $sql="SELECT bc.comment_content,bc.comment_time,u.user_name,u.user_icon
                   FROM board_comment AS bc LEFT JOIN board_heart AS bh ON bc.comment_id = bh.comment_id LEFT JOIN user AS u ON bc.user_id = u.user_id ORDER BY bc.comment_time DESC;";
            $ps= $pdo->prepare($sql);
            $ps->execute();
            $tcomments = $ps->fetchAll();
            return $tcomments;
        }

        public function heart_add($user_id, $commentId) {
            try {
                $pdo = $this->dbConnect();
                $sql = "INSERT INTO board_heart (project_id, user_id, comment_id, heart_id) VALUES (?, ?, ?, CURRENT_DATE())";
                $ps = $pdo->prepare($sql);
                $ps->bindParam(1, $commentId, PDO::PARAM_INT);
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
        public function heart_del($user_id, $commentId) {
            try {
                $pdo = $this->dbConnect();
                $sql = "DELETE FROM board_heart WHERE project_id = ? AND user_id = ? AND comment_id = ?";
                $ps = $pdo->prepare($sql);
                $ps->bindParam(1, $commentId, PDO::PARAM_INT);
                $ps->bindParam(2, $user_id, PDO::PARAM_INT);
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
                

}

?>