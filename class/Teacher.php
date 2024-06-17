<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
class Teacher
{

    public $no;
    public $name;
    public $surname;
    public $email;
    public $userName;
    public $userPassword;
    public $authorized;

    private $db;


    public function __construct(Database $db,$no = null)
    {
        $this->db = $db;
        if($no !== null){
            $columns = [
                'no',
                'name',
                'surname',
                'email',
                'userName',
                'userPassword',
                'authorized' 
            ];
            $conditions = ['no=?'];
    
            $query = $db->getDatas('teacher',$columns,$conditions,[$no]);
            $teacher = $query->fetch(PDO::FETCH_ASSOC);
    
            if(!$teacher){
                echo "öğretmen bulunamadı.";
               
            }else{
                $this->no = $teacher['no'];
                $this->name = $teacher['name'];
                $this->surname = $teacher['surname'];
                $this->email = $teacher['email'];
                $this->userName = $teacher['userName'];
                $this->userPassword = $teacher['userPassword'];
                $this->authorized = $teacher['authorized'];
            }
        }
        

    }

    public function saveTeacher()
    {
        $data = [
            'name' => $this->name,
            'surname' => $this->surname,
            'email' => $this->email,
            'userName' => $this->userName,
            'userPassword' => $this->userPassword,
            'authorized' =>$this->authorized ?? 0,
        ];
        return $this->db->save('teacher', $data); 
    }

    public function login($email, $userPassword,&$error)
    {
        $columns = ['email', 'userPassword', 'userName', 'authorized'];
        $conditions = ['email = ?', 'userPassword = ?'];
        $params = [$email,$userPassword];
        
        $query = $this->db->getDatas('teacher', $columns, $conditions, $params);
        $user = $query->fetch(PDO::FETCH_ASSOC);
        $error = '';
        if ($user && $user['userPassword'] === $userPassword) {
            $this->name = $user['name'];
            $this->surname = $user['surname'];
            $this->email = $user['email'];
            $this->userName = $user['userName'];
            $this->userPassword = $user['userPassword'];
            $this->authorized = $user['authorized'];
            return $user;
        } else {
            $error = '<div class="alert alert-danger" role="alert">E-posta veya şifre hatalı.</div>';
            return false;
        }
    }

    public function updateTeacher()
    {
        $data = [
            'name' => $this->name,
            'surname' => $this->surname,
            'userNAME' => $this->userName
        ];
        return $this->db->updateDatas('teacher',$this->no,$data);
    }

}
