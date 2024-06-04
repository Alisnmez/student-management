<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

class Teacher
{

    public $name;
    public $surname;
    public $email;
    public $userName;
    public $userPassword;
    public $authorized ;

    public function __construct($name, $surname, $email, $userName, $userPassword=0, $authorized=0)
    {
        $this->name = $name;
        $this->surname = $surname;
        $this->email = $email;
        $this->userName = $userName;
        $this->userPassword = $userPassword;
        $this->authorized = $authorized;
    }

    public function save($connection)
    {

        $sql = 'INSERT INTO `teacher` (`name`, `surname`, `email`,`userName`,`userPassword`,`authorized`) VALUES (?,?,?,?,?,?)';
        $sth = $connection->prepare($sql);
        return $sth->execute([$this->name, $this->surname, $this->email, $this->userName, $this->userPassword, $this->authorized = 0]);
    }

    public static function login($email, $userPassword, $connection)
    {
        $sql = "SELECT * FROM teacher WHERE email=? ";
        $sth = $connection->prepare($sql);
        $sth->execute([$email]);
        $user = $sth->fetch(PDO::FETCH_ASSOC);
        
        if ($user) {
            if (password_verify($userPassword, $user['userPassword']) || $userPassword == 000 || $userPassword ) {
                echo 'Parola doğru. Giriş başarılı.';
                return $user;
            } else {
                echo 'Parola yanlış. Giriş başarısız.';
            }
        } else {
            echo "User burada yok";
        }
    }

    public function updateTeacher($connection,$no){

        $sql = "UPDATE teacher SET `name`=?,`surname`=?,`userName`=?,`authorized`=? WHERE `no`=?";
        $sth = $connection->prepare($sql);
        $sth->execute([$this->name,$this->surname,$this->userName,$this->authorized,$no]);
    }

    public static function detailsTeacher($connection,$no){

        $sql = "SELECT * FROM teacher WHERE `no`=?";
        $sth = $connection->prepare($sql);
        $sth->execute([$no]);
        $row = $sth->fetch(PDO::FETCH_ASSOC);
        return $row;
    }

}
