<?php
session_start();

include "../../dbConnection.php";
include "../../autoload.php";

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location:../../index.php");
    exit;
}

if (isset($_SESSION['user_auth']) && $_SESSION['user_auth'] == 1) {
    $row = Teacher::detailsTeacher($connection, $_GET['no']);

    if(isset($_POST['updateAuth'])){
        $newAuth = $_POST['authorized'];
        $teacher = Teacher::updateAuth($connection,$_GET['no'],$newAuth);
        header("Location:../teacher.php");
    }

    if (!$row) {
        echo "Böyle bir Öğretmen bulunmamaktadır";
        exit;
    }
} else {
    echo "İşlem yapmak için yetkiniz bulunmamaktadır.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>
    <div class="container mt-5">
        <div class="row">
            <div class="col">
                <div class="row">
                    <div class="col">
                        <div class="btn-group">
                            <a href="../teacher.php" class="btn btn-outline-primary">Öğretmen İşlemleri</a>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body">

                        <h5 class="card-title">
                            Ad: <?=htmlspecialchars($row["name"]) ?>
                        </h5>
                        <?php if ($_SESSION['user_auth'] && $_SESSION['user_auth'] == true) : ?>
                            <h5>Soyad:
                                <?= htmlspecialchars($row["surname"]) ?>
                            </h5>
                        <?php endif; ?>
                        <h6 class="card-subtitle mb-2 text-body-secondary"> Kullanıcı Adı:<?= htmlspecialchars($row["userName"])?> </h6>
                        <?php if($row['authorized'] == 0 ): ?>
                        <form method="post" action="">
                            Yetki:
                            <select name="authorized" class="mb-3">
                                <option value="1" <?= $row['authorized'] == 1 ? 'selected' : '' ?>>Yönetici</option>
                                <option value="0" <?= $row['authorized'] == 0 ? 'selected' : '' ?>>Öğretmen</option>
                            </select>
                            <button name="updateAuth" type="submit" onclick="return confirm('Öğretmen yetkisi güncellensin mi?')" class="btn btn-primary btn-sm">Yetki değiştir</button>
                        </form>
                        <?php endif;?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>