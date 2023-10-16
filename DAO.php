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























}

?>