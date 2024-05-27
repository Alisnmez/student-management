<?php


class Teacher
{

    public $name;
    public $surname;
    public $email;
    public $userName;
    public $userPassword;
    public $authorized = 0;

    public function __construct($name, $surname, $email, $userName, $userPassword, $authorized)
    {

        $this->name = $name;
        $this->surname = $surname;
        $this->email = $email;
        $this->userName = $userName;
        $this->userPassword = $userPassword;
        $this->authorized = $authorized;
    }

    public function save()
    {
        include '../dbConnection.php';
        $sql = 'INSERT INTO `teacher` (`name`, `surname`, `email`,`userName`,`userPassword`,`authorized`) VALUES (?,?,?,?,?,?)';
        $sth = $connection->prepare($sql);
        return $sth->execute([$this->name, $this->surname, $this->email, $this->userName, $this->userPassword, $this->authorized=0]);
    }


    public static function fetchAll($connection)
    {

        $sql = "SELECT * FROM teacher";
        $sth = $connection->prepare($sql);
        $sth->execute();
        $teachers = $sth->fetchAll(PDO::FETCH_ASSOC);

        $teacherObjects = [];

        foreach ($teachers as $teacher) {
            $teacherObjects[] = new Teacher(
                $teacher['name'],
                $teacher['surname'],
                $teacher['email'],
                $teacher['userName'],
                $teacher['userPassword'],
                $teacher['authorized'],
            );
        }
        return $teacherObjects;
    }
}
