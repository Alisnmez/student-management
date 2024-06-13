<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
class Teacher
{
    public function saveTeacher($name, $surname, $email, $userName, $userPassword, $db)
    {
        $data = [
            'name' => $name,
            'surname' => $surname,
            'email' => $email,
            'userName' => $userName,
            'userPassword' => $userPassword,
            'authorized' => 0,
        ];
        return $db->save('teacher', $data);
    }

    public static function login($email, $userPassword, $db)
    {
        $columns = ['email', 'userPassword', 'userName', 'authorized'];
        $conditions = ['email = ?', 'userPassword = ?'];
        $params = [$email, $userPassword];

        $query = $db->getDatas('teacher', $columns, $conditions, $params);
        $user = $query->fetch(PDO::FETCH_ASSOC);

        if ($user && $user['userPassword'] === $userPassword) {
            return $user;
        } else {
            echo '<div class="alert alert-danger" role="alert">E-posta veya şifre yanlış.</div>';
            return false;
        }
    }

    public static function updateTeacher($no, $name,$surname,$userName, $db)
    {
        $data = [
            'name'=>$name,
            'surname'=>$surname,
            'userNAME'=>$userName
        ];
        return $db->updateDatas('teacher',$no,$data);
    }

    public static function deleteTeacher($connection, $no)
    {
        $sql = "DELETE FROM teacher WHERE `teacher`.`no`=?";
        $sth = $connection->prepare($sql);
        $sth->execute([$no]);
        $result = $sth->execute([$no]);
        return $result;
    }
}
