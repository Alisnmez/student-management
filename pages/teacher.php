<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();

include '../autoload.php';
include "../dbConnection.php";

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location:../index.php");
    exit;
}
$db = new Database();
$db->startConnection($config);
if (isset($_SESSION['user_auth']) && $_SESSION['user_auth'] == 1) {
    if (isset($_GET['deleteTeacher'])) {
        $teacher = $db->deleteDatas('teacher',$_GET['deleteTeacher']);
        header("Location:./teacher.php");
    }
    $query = $db->getDatas('teacher', ['no', 'name', 'surname', 'email', 'userName', 'authorized']);
} else {
    echo "Yetkiniz yok.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="tr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Öğretmen Detay</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body>
    <main>
        <div class="container">
            <div class="row">
                <div class="col">
                    <div class="display-1 text-center mb-5 mt-5">Öğretmen İşlemleri</div>
                </div>
            </div>
            <div class="row mt-4">
                <div class="col">
                    <div class="row">
                        <div class="col">
                            <div class="btn-group">
                                <a href="class.php" class="btn btn-outline-primary">Sınıf</a>
                            </div>
                        </div>
                    </div>
                    <table class="table table-hover table-dark table-striped">
                        <thead>
                            <tr>
                                <th>Ad</th>
                                <th>Soyad</th>
                                <th>Eposta</th>
                                <th>Kullanıcı Adı</th>
                                <th>Yetki</th>
                                <th>İşlem</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($row = $query->fetch(PDO::FETCH_ASSOC)) : ?>
                                <tr>
                                    <td><?= $row['name'] ?></td>
                                    <td><?= $row['surname'] ?></td>
                                    <td><?= $row['email'] ?></td>
                                    <td><?= $row['userName'] ?></td>
                                    <td><?= $row['authorized'] == 1 ? 'Yönetici' : 'Öğretmen' ?></td>
                                    <td>
                                        <dv class="btn-group">
                                            <a href="./teacherPages/teacherDetails.php?no=<?= $row['no'] ?>" class="btn btn-success">Detay</a>
                                            <a href="./teacherPages/teacherUpdate.php?no=<?= $row['no'] ?>" class="btn btn-secondary">Güncelle</a>
                                            <a href="?deleteTeacher=<?= $row['no'] ?>" onclick="return confirm('Silinsin mi?')" class="btn btn-danger"> Sil </a>
                                        </dv>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </main>
</body>

</html>