<?php

session_start();
include_once '../autoload.php';

if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {

    if (isset($_POST["save"])) {
        include "../dbConnection.php";

        $student = new Student(


            $_POST['name'],
            $_POST['surname'],
            $_POST['class'],
            $_POST['birth'],
            $_POST['gender'],


        );

        $student->addStudent($connection);
        if ($student->addStudent($connection)) {
            header("Location: " . $_SERVER['PHP_SELF'] . "?success=1");
            exit;
        } else {
            $errorInfo = $sth->errorInfo();
            echo $errorInfo;
        }
    }

    if (isset($_GET['success'])) {
        $message = "Kayıt başarıyla eklendi.";
    }
} else {
    echo "Giriş yapmanız gerekmektedir.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ekle</title>
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
            <?php if (!empty($message)) : ?>
                <div class="alert alert-success">
                    <?= htmlspecialchars($message) ?>
                </div>
            <?php endif; ?>
            <form action="" method="post" class="row">
                <div class="row">
                    <div class="col-6">
                        <label for="name" class="form-label">Ad</label>
                        <input type="text" class="form-control" name="name" value="">
                    </div>
                    <div class="col-6">
                        <label for="surname" class="form-label">Soyad</label>
                        <input type="text" class="form-control" name="surname" value="">
                    </div>
                    <div class="col-6">
                        <label for="class" class="form-label">Sınıf</label>
                        <input type="text" class="form-control" name="class" value="">
                    </div>
                    <div class="col-6">
                        <label for="birth">Doğum Tarihi</label>
                        <input type="date" name="birth" class="form-control" value="">
                    </div>
                    <div class="col-6 mt-3">
                        <label for="gender" class="form-label">Kız
                            <input type="radio" name="gender" value="Kadın">
                        </label>
                        <label for="gender" class="form-label">Erkek
                            <input type="radio" name="gender" value="Erkek">
                        </label>
                    </div>
                </div>
                <button name="save" type="submit" class="btn btn-primary mt-4">
                    Kaydet
                </button>
            </form>
        </div>
    </main>
    <footer>
    </footer>
</body>

</html>
<?php

/*
session_start();

if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {

    if (isset($_POST["save"])) {
        include "../dbConnection.php";

        try {
            $sql = "INSERT INTO `student` (`name`, `surname`, `class`, `date`, `gender`) VALUES (?, ?, ?, ?, ?)";
            $sth = $connection->prepare($sql);
            $result = $sth->execute([$_POST["name"], $_POST["surname"], $_POST["class"], $_POST["birth"], $_POST["gender"]]);

            if ($result) {
                header("Location: " . $_SERVER['PHP_SELF'] . "?success=1");
                exit;
            } else {
                $errorInfo = $sth->errorInfo();
                echo $errorInfo;
            }
        } catch (PDOException $e) {
           echo "Veritabanı hatası: " . $e->getMessage();
        }
    }

    if (isset($_GET['success'])) {
        $message = "Kayıt başarıyla eklendi.";
    }
} else {
    echo "Giriş yapmanız gerekmektedir.";
    exit;
}
?>
*/