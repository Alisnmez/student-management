<?php

class Student
{
    public $no;
    public $name;
    public $surname;
    public $class;
    public $date;
    public $gender;

    private $db;

    public function __construct(Database $db,$no = null)
    {
        $this->db = $db;
        if($no !== null){
            $columns = [
                'no',
                'name',
                'surname',
                'class',
                'date',
                'gender'
            ];
            $conditions = ['no=?'];
            $query = $db->getDatas('student',$columns,$conditions,[$no]);
            $student = $query->fetch(PDO::FETCH_ASSOC);
            if(!$student){
                echo "Öğrenci bulunamadı";
            }else{
                $this->no = $student['no'];
                $this->name = $student['name'];
                $this->surname = $student['surname'];
                $this->class = $student['class'];
                $this->date = $student['date'];
                $this->gender = $student['gender'];
            }
        }
    }
    public function addStudent()
    {  
        $data = [
            'name' => $this->name,
            'surname' => $this->surname,
            'class' => $this->class,
            'date' => $this->date,
            'gender' => $this->gender
        ];
        return $this->db->save('student', $data);
    }

    public function updateStudent()
    {
        $data = [
            'name' => $this->name,
            'surname' => $this->surname,
            'class' => $this->class,
            'date' => $this->date,
        ];
        return $this->db->updateDatas('student', $this->no, $data);
    }
}
