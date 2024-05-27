<?php

include '../dbConnection.php';
class Student
{
    public $name;
    public $surname;
    public $class;
    public $date;
    public $gender;

    public function __construct($name, $surname, $class, $date, $gender)
    {
        $this->name = $name;
        $this->surname = $surname;
        $this->class = $class;
        $this->date = $date;
        $this->gender = $gender;
    }


    public function addStudent($connection)
    {
        ini_set('display_errors', 1);
        $sql = "INSERT INTO `student` (`name`, `surname`, `class`, `date`, `gender`) VALUES (?, ?, ?, ?, ?)";
        $sth = $connection->prepare($sql);
        $result = $sth->execute([$this->name, $this->surname, $this->class, $this->date, $this->gender]);

        return $result;
    }
}
