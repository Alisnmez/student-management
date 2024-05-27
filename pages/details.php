<?php

session_start();
include "../dbConnection.php";

if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {

    $sql = "SELECT * FROM student WHERE no=?";
    $query = $connection->prepare($sql);
    $query->execute(
        [
            $_GET['no']
        ]
    );
    $row = $query->fetch(PDO::FETCH_ASSOC);
}
else{
    echo "Giriş yapmanız gerekmektedir.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

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
                    <div class="display-1 text-center">Öğrenci Ekle Çıkar</div>
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

                            <h5 class="card-title">
                                <?= $row["name"] ?>
                            </h5>
                            <?php if($_SESSION['user_auth'] && $_SESSION['user_auth']=true) : ?>
                            <h5>
                            <?= $row["surname"] ?>
                            </h5>
                            <?php endif; ?>
                            <h6 class="card-subtitle mb-2 text-body-secondary"><?= $row["class"] ?> <?= $row["gender"] ?></h6>
                            <p class="card-text"> <?= $row["date"] ?></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <footer></footer>
</body>

</html>