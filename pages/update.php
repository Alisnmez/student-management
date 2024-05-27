<?php
session_start();
include "../dbConnection.php";

if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
if (isset($_POST['update'])) {
    if($_SESSION['user_auth']){
    $sql = "UPDATE `student` SET  `name` = ?, `surname` = ?, `class` = ?, `date` = ? WHERE `student`.`no` = ? ";

    $array = [
        $_POST['name'],
        $_POST['surname'],
        $_POST['class'],
        $_POST['date'],
        $_POST['no']
    ];
    
    $query = $connection->prepare($sql);
    $query->execute($array);
    header("Location:class.php");
    
}else{
    echo "Bu işlemi gerçekleştirmek için yetkiniz yok.";
    exit;
}
}
}else {
    echo "Giriş yapmanız gerekmektedir.";
    exit;
}

$sql = "SELECT * FROM student WHERE no= ?";
$query = $connection->prepare($sql);
$query->execute(
    [
        $_GET['no']
    ]
);

$row = $query->fetch(PDO::FETCH_ASSOC);

?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Güncelle</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body>
    <header>
        <div class="container">
            <div class="row">
                <div class="col">
                    <div class="display-1 text-center">Öğrenci Güncelle </div>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <div class="btn-group">
                        <a href="class.php" class="btn btn-outline-primary">Sınıf</a>
                        <a href="add.php" class="btn btn-outline-primary">Öğrenci Ekle</a>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <main>
        <div class="container">
            <form action="" method="post" class="row">
                <input type="hidden" name="no" value="<?= $row['no'] ?>">
                <div class="row mb-3">

                    <div class="col-6">
                        <label for="name" class="form-label">Ad</label>
                        <input type="text" class="form-control" name="name" value="<?= $row['name'] ?>">
                    </div>
                    <div class="col-6">
                        <label for="surname" class="form-label">Soyad</label>
                        <input type="text" class="form-control" name="surname" value="<?= $row['surname'] ?>">
                    </div>
                    <div class="col-6">
                        <label for="class" class="form-label">Sınıf</label>
                        <input type="text" class="form-control" name="class" value="<?= $row['class'] ?>">
                    </div>
                    <div class="col-6">
                        <label for="date" class="form-label">Doğum Tarihi</label>
                        <input type="date" class="form-control" name="date" value="<?= $row['date'] ?>">
                    </div>
                </div>
                <button name="update" type="submit" class="btn btn-primary">
                    Güncelle
                </button>
            </form>

        </div>
    </main>
    <footer>

    </footer>
</body>

</html>