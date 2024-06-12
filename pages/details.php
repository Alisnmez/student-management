<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();

include "../autoload.php";
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location:../index.php");
    exit;
}
include "../dbConnection.php";
$db = new Database();
$db->startConnection($config);

$result = $db->getDatas('student', ['name', 'surname', 'class', 'gender', 'date'], ['no=?'], [$_GET['no']]);
$row = $result->fetch(PDO::FETCH_ASSOC);
if (!$row) {
    echo "Böyle bir öğrenci bulunamadı.";
    exit;
}

?>

<!DOCTYPE html>
<html lang="tr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detaylar</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body>
    <header>
        <div class="container">
            <div class="row">
                <div class="col">
                    <div class="display-1 text-center">Öğrenci Detayları</div>
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
            <div class="row">
                <div class="col">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title"><?= htmlspecialchars($row["name"]) ?></h5>
                            <?php if ($_SESSION['user_auth'] && $_SESSION['user_auth'] == true) : ?>
                                <h5><?= htmlspecialchars($row["surname"]) ?></h5>
                            <?php endif; ?>
                            <h6 class="card-subtitle mb-2 text-body-secondary"><?= htmlspecialchars($row["class"]) ?> <?= htmlspecialchars($row["gender"]) ?></h6>
                            <p class="card-text"><?= htmlspecialchars($row["date"]) ?></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <footer></footer>
</body>

</html>