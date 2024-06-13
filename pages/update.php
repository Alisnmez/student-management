<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();
include "../autoload.php";
include "../dbConnection.php";
include "../functions.php";

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location:../index.php");
    exit;
}

$db = new Database();
$db->startConnection($config);

$row = $db->getDatas('student', '*', ['no=?'], [$_GET['no']])->fetch(PDO::FETCH_ASSOC);

if (!$row) {
    echo "Böyle bir öğrenci bulunamadı.";
    exit;
}

$updateMessage = '';

if (isset($_POST['update'])) {
    $name = secure_data($_POST['name']);
    $surname = secure_data($_POST['surname']);
    $class = secure_data($_POST['class']);
    $date = $_POST['date'];
    $student = Student::updateStudent($db, $name, $surname, $class, $date, $_GET['no']);

    if (!validate_letter($name) || !validate_letter($surname)) {
        $error = '<div class="alert alert-danger" role="alert">Ad ve soyad sadece harf içermelidir.</div>';
    } elseif (!validate_with_number($class)) {
        $error = '<div class="alert alert-danger" role="alert">Ad ve soyad sadece harf içermelidir.</div>';
    } else {
        $student = Student::updateStudent($db, $name, $surname, $class, $date, $_GET['no']);
        if ($student) {
            $updateMessage = "Öğrenci başarılı şekilde güncellendi.";
        } else {
            $updateMessage = "Güncelleme sırasında bir hata oluştu.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="tr">

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
            <?php if ($updateMessage) : ?>
                <div class="alert alert-info">
                    <?= $updateMessage ?>
                </div>
            <?php endif; ?>
            <form action="" method="post" class="row">
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