<?php

class Student
{


    public static function addStudent($db, $name, $surname, $class, $date, $gender)
    {  
        $data = [
            'name' => $name,
            'surname' => $surname,
            'class' => $class,
            'date' => $date,
            'gender' => $gender
        ];
        return $db->save('student', $data);
    }

    public static function updateStudent($db, $name, $surname, $class, $date, $no)
    {
        $data = [
            'name' => $name,
            'surname' => $surname,
            'class' => $class,
            'date' => $date,
        ];
        return $db->updateDatas('student', $no, $data);
    }
}
