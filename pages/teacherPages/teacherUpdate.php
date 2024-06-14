<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();
include "../../dbConnection.php";
include "../../autoload.php";
require_once "../../functions.php";

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location:../../index.php");
    exit;
}

$db = new Database();
$db->startConnection($config);

if (isset($_SESSION['user_auth']) && $_SESSION['user_auth'] == 1) {
    $query = $db->getDatas('teacher', ['no', 'name', 'surname', 'userName'], ['no=?'], [$_GET['no']]);
    $row = $query->fetch(PDO::FETCH_ASSOC);
    if (!$row) {
        echo "Böyle bir Öğretmen bulunmamaktadır.";
        exit;
    }
    $error = '';
    if (isset($_POST['update'])) {

        $name = secure_data($_POST['name']);
        $surname = secure_data($_POST['surname']);
        $userName = secure_data($_POST['userName']);

        if (empty($name) || empty($surname) || empty($userName)) {
            $error = '<div class="alert alert-danger" role="alert">Lütfen boş alan bırakmayın.</div>';
        } elseif (!validate_letter($name) || !validate_letter($surname)) {
            $error = '<div class="alert alert-danger" role="alert">Ad ve soyad yalnızca harflerden oluşabilir.</div>';
        } elseif (!validate_with_number($userName)) {
            $error = '<div class="alert alert-danger" role="alert">Kullanıcı adı yalnızca harf ve sayılardan oluşabilir.</div>';
        } else {
            $teacher = Teacher::updateTeacher($_GET['no'], $name, $surname, $userName, $db);
            header("Location:../teacher.php");
            $db->closeConnection();
        }
    }
} else {
    echo "İşlem yapmak için yetkiniz bulunmamaktadır";
    header("Location:../class.php");
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
                    <div class="display-1 text-center">Öğretmen Güncelle </div>
                </div>
            </div>
            <?php if ($error) : ?>
                <div>
                    <?= $error ?>
                </div>
            <?php endif; ?>
            <div class="row">
                <div class="col">
                    <div class="btn-group">
                        <a href="../teacher.php" class="btn btn-outline-primary">Öğretmen İşlemleri</a>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <main>
        <div class="container">
            <form action="" method="post" class="row">
                <input type="hidden" name="no">
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
                        <label for="userName" class="form-label">Kullanıcı Adı</label>
                        <input type="text" class="form-control" name="userName" value="<?= $row['userName'] ?>">
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