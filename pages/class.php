<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();

include "../dbConnection.php";
include_once "../autoload.php";
include "../functions.php";


if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location:../index.php");
    exit;
}
$db = new Database();
$db->startConnection($config);

if (isset($_GET['delete'])) {
    $query = $db->deleteDatas('student', $_GET['delete']);
    header('Location:class.php');
}
$input = '';
if (isset($_POST['search'])) {

    $input = secure_data($_POST['input']);
    $keywords = '%' . str_replace(' ', '%', $input) . '%';
    $sql = "SELECT no, name, surname,class FROM student WHERE CONCAT(name, ' ', surname) LIKE ?";
    $query = $db->startConnection($config)->prepare($sql);
    $query->execute([$keywords]);
} else {
    $query = $db->getDatas('student', ['no', 'name', 'surname', 'class']);
    $db->closeConnection();
}


?>
<!DOCTYPE html>
<html lang="tr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sınıf</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="./class.css">
</head>

<body>
    <header>
        <div class="container">
            <div class="row">
                <div class="col">
                    <div class="display-1 text-center">Öğrenci Ekle Çıkar</div>
                </div>
            </div>
            <?php if (isset($_SESSION['user_auth']) && $_SESSION['user_auth'] == 1) { ?>
                <a href="./teacher.php">
                    <button class="mb-5 btn btn-secondary">
                        Öğretmen detay
                    </button>
                </a>
            <?php } ?>
            <div>
                <?php include_once '../logout/logout_button.php'; ?>
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
        <div class="container-search">
            <form method="POST" action="class.php">
                <input name="input" class="search" type="search" value="<?php echo htmlspecialchars($input); ?>">
                <button type="submit" name="search" class="search-button">Öğrenci Ara</button>
            </form>
        </div>
    </header>
    <main>
        <div class="container">
            <div class="row mt-4">
                <div class="col">
                    <table class="table table-hover table-dark table-striped">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Ad</th>
                                <th>Soyad</th>
                                <th>Sınıf</th>
                                <th>İşlem</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($row = $query->fetch(PDO::FETCH_ASSOC)) { ?>
                                <tr>
                                    <td><?= $row['no'] ?></td>
                                    <td><?= $row['name'] ?></td>
                                    <td><?= $row['surname'] ?></td>
                                    <td><?= $row['class'] ?></td>
                                    <td>
                                        <div class="btn-group">
                                            <a href="details.php?no=<?= $row['no'] ?>" class="btn btn-success">Detay</a>
                                            <a href="update.php?no=<?= $row['no'] ?>" class="btn btn-secondary">Güncelle</a>
                                            <a href="?delete=<?= $row['no'] ?>" onclick="return confirm('Öğrenci silinsin mi')" class="btn btn-danger">Sil</a>
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