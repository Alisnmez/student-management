<?php


session_start();
include './dbConnection.php';
include_once './autoload.php';


$teachers = Teacher::fetchAll($connection);
if($_SESSION['loggedin'] && $_SESSION['loggedin']){


if($_SESSION['user_auth']&& $_SESSION['user_auth']=true){

if (!empty($teachers)) {
    foreach ($teachers as $teacher) {
        echo "Name: " . $teacher->name . "<br>";
        echo "Surname: " . $teacher->surname . "<br>";
        echo "Email: " . $teacher->email . "<br>";
        echo "Username: " . $teacher->userName . "<br>";
        echo "Authorized: " . $teacher->authorized . "<br><br>";
    }
} else {
    echo "Öğretmen bulunamadı";
}
}else{
    echo "Yetkiniz bulunmamaktadır.";
}
}else{
    echo "Giriş yapmanız gerekmektedir.";
}

?>