<?php

class Student
{
    public $name;
    public $surname;
    public $class;
    public $date;
    public $gender;

    public function __construct($name, $surname, $class, $date, $gender = null)
    {
        $this->name = $name;
        $this->surname = $surname;
        $this->class = $class;
        $this->date = $date;
        $this->gender = $gender;
    }


    public function addStudent($connection)
    {
        $sql = "INSERT INTO `student` (`name`, `surname`, `class`, `date`, `gender`) VALUES (?, ?, ?, ?, ?)";
        $sth = $connection->prepare($sql);
        $sth->execute([$this->name, $this->surname, $this->class, $this->date, $this->gender]);
    }

    public function updateStudent($connection, $no)
    {
        $sql = "UPDATE `student` SET `name` = ?, `surname` = ?, `class` = ?, `date` = ? WHERE `no` = ?";
        $array = [
            $this->name,
            $this->surname,
            $this->class,
            $this->date,
            $no
        ];
        $sth = $connection->prepare($sql);
        $sth->execute($array);
    }

    public static function deleteStudent($connection, $no)
    {
        $sql = "DELETE FROM student WHERE `student`.`no`=?";
        $sth = $connection->prepare($sql);
        $sth->execute([$no]);
    }

    public static function detailsStudent($connection,$no){
        $sql = "SELECT * FROM student WHERE `no`=?";
        $sth = $connection->prepare($sql);
        $sth->execute([$no]);
        return $sth->fetch(PDO::FETCH_ASSOC);
    }
}
