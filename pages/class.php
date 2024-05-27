<?php

session_start();
include "../dbConnection.php";
include_once "../autoload.php";

if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {

    if (isset($_GET['delete'])) {

        $sqlDelete = "DELETE FROM `student` WHERE `student`.`no` = ?";
        $queryDelete = $connection->prepare($sqlDelete);
        $queryDelete->execute([$_GET['delete']]);
        header('Location:class.php');
        exit;
    }
} else {

    echo "Giriş yapmanız gerekmektedir";
    exit;
}

$sql = "SELECT * FROM student";
$query = $connection->prepare($sql);
$query->execute();

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sınıf</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body>
    <header>
        <div class="container">
            <div class="row">
                <div class="col">

                    <div class="display-1 text-center">Öğrenci Ekle Çıkar</div>
                </div>
            </div>
            <?php if ($_SESSION['user_auth'] && $_SESSION['user_auth'] == true) { ?>
                <div>
                    <a href="../teacherDetails.php">Öğretmen detay</a>
                </div>
            <?php }  ?>

            <?php  ?>
            <div>
                <?php include '../logout/logout_button.php'; ?>
            </div>
            <h1>Merhaba <h1>Hoşgeldiniz, <?php echo $_SESSION['user_name']; ?>!</h1>
            </h1>
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
            <div class="row mt-4">
                <div class="col">
                    <table class="table table-hover table-dark table-striped">
                        <thead>
                            <tr>
                                <th>NO</th>
                                <th>Ad</th>
                                <th>Soyad</th>
                                <th>İşlem</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($row = $query->fetch(PDO::FETCH_ASSOC)) { ?>
                                <tr>
                                    <td><?= $row['no'] ?></td>
                                    <td><?= $row['name'] ?></td>
                                    <td><?= $row['surname'] ?></td>
                                    <td>
                                        <div class="btn-group">
                                            <a href="details.php?no=<?= $row['no'] ?>" class="btn btn-success">Detay</a>
                                            <a href="update.php?no=<?= $row['no'] ?>" class="btn btn-secondary">Güncelle</a>
                                            <a href="?delete=<?= $row['no'] ?>" onclick="return confirm('silinsin mi') " class="btn btn-danger">Sil</a>
                                        </div>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </main>
    <footer>

    </footer>
</body>

</html>