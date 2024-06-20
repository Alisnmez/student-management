<?php
ini_set('display_errors', 1);
session_start();

include "../dbConnection.php";
include_once "../autoload.php";
require_once "../functions.php";

$errors = [];
$db = new Database();
$db->startConnection($config);

if (isset($_POST['register'])) {

    $name = secure_data($_POST['name']);
    $surname = secure_data($_POST['surname']);
    $email = filter_var(secure_data($_POST['email']), FILTER_SANITIZE_EMAIL);
    $userName = secure_data($_POST['userName']);
    $userPassword = secure_data($_POST['userPassword']);

    if (empty($name) || empty($surname) || empty($email) || empty($userName) || empty($userPassword)) {
        $errors[] = 'Lütfen tüm alanları doldurun.';
    }

    if (strlen($userPassword) < 6 || !validate_with_number($userPassword)) {
        $errors[] = 'Şifre en az 6 karakter olmalıdır ve yalnızca harf ve sayı içermelidir.';
    }

    if (!validate_letter($name) || !validate_letter($surname)) {
        $errors[] = 'Ad ve soyad yalnızca harf içermelidir.';
    }

    if (!validate_with_number($userName)) {
        $errors[] = 'Kullanıcı adı yalnızca harf ve sayı içermelidir.';
    }

    if (empty($errors)) {
        $teacher = new Teacher($db); 
        $teacher->name = $name;
        $teacher->surname = $surname;
        $teacher->email = $email;
        $teacher->userName = $userName;
        $teacher->userPassword = secure_data(md5($userPassword)); 
        $result = $teacher->saveTeacher();
        if ($result) {
            echo '<div class="alert alert-success" role="alert">Kayıt başarıyla eklendi.</div>';
            echo '<meta http-equiv="refresh" content="2;url=' . $_SERVER['PHP_SELF'] . '">';
            $db->closeConnection();
        } else {
            $errors[] = '';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="tr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kayıt ol</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="register.css">
</head>

<body>
    <form action="" method="post">
        <section class="vh-60 bg-image" style="background-image: url('https://mdbcdn.b-cdn.net/img/Photos/new-templates/search-box/img4.webp');">
            <div class="mask d-flex align-items-center h-100 gradient-custom-3">
                <div class="container h-100 mt-5 mb-5">
                    <div class="row d-flex justify-content-center align-items-center h-100">
                        <div class="col-12 col-md-9 col-lg-7 col-xl-6">
                            <div class="card" style="border-radius: 15px;">
                                <div class="card-body p-5">
                                    <h2 class="text-uppercase text-center mb-5">Hesap Oluşturun</h2>
                                    <?php if (!empty($errors)) { ?>
                                        <?php foreach ($errors as $error) { ?>
                                            <div class="alert alert-danger" role="alert"><?= htmlspecialchars($error) ?></div>
                                        <?php } ?>
                                    <?php } ?>
                                    <div class="form-outline mb-4">
                                        <input require name="name" type="text" id="form3Example1cg" class="form-control form-control-lg" />
                                        <label class="form-label" for="form3Example1cg">Adınız</label>
                                    </div>

                                    <div class="form-outline mb-4">
                                        <input require name="surname" type="text" id="form3Example1cg" class="form-control form-control-lg" />
                                        <label class="form-label" for="form3Example1cg">Soyadınız</label>
                                    </div>

                                    <div class="form-outline mb-4">
                                        <input require name="email" type="email" id="form3Example3cg" class="form-control form-control-lg" />
                                        <label class="form-label" for="form3Example3cg">E-mailiniz</label>
                                    </div>

                                    <div class="form-outline mb-4">
                                        <input require name="userName" title="Kullanıcı adınızı giriniz." type="text" id="form3Example3cg" class="form-control form-control-lg" />
                                        <label class="form-label" for="form3Example3cg">Kullanıcı Adınız</label>
                                    </div>
                                    <div class="form-outline mb-4">
                                        <input require name="userPassword" type="password" id="form3Example4cg" class="form-control form-control-lg" />
                                        <label class="form-label" for="form3Example4cg">Şifreniz</label>
                                    </div>
                                    <div class="d-flex justify-content-center">
                                        <button name="register" type="submit" data-mdb-button-init data-mdb-ripple-init class="btn btn-success btn-block btn-lg gradient-custom-4 text-body">Kayıt ol</button>
                                    </div>
                                    <p class="text-center text-muted mt-5 mb-0">Zaten bir hesabınız var mı? <a href="../index.php" class="fw-bold text-body"><u>Giriş Yapın</u></a></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </form>
</body>

</html>
