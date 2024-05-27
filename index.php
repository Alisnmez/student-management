<?php
session_start();

include "dbConnection.php";

if (isset($_POST['loginButton'])) {
  
  $uEmail = $_POST['uEmail'];
  $uPassword = $_POST['uPassword'];
  $user_name = $_POST['user_name'];



  $sql = "SELECT * FROM teacher WHERE email=? AND userPassword=? AND userName=?";
  $sth = $connection->prepare($sql);
  $sth->execute([$uEmail, $uPassword, $user_name]);
  $result = $sth->fetch(PDO::FETCH_ASSOC);

  if ($result) {

    $_SESSION['loggedin'] = true;
    $_SESSION['user_name'] = $result['userName'];
    $_SESSION['user_auth'] = $result['authorized'];


    header("Location:./pages/class.php");
    exit;
  } else {
    echo '<div class="alert alert-danger" role="alert">Hatalı e-posta, şifre veya kullanıcı adı.</div>';
  }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Giriş</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <link rel="stylesheet" href="index.css">
</head>

<body>
  <form method="post">
    <section class="vh-60 gradient-custom">
      <div class="container py-5 h-100">
        <div class="row d-flex justify-content-center align-items-center h-100">
          <div class="col-12 col-md-8 col-lg-6 col-xl-5">
            <div class="card bg-dark text-white" style="border-radius: 1rem;">
              <div class="card-body p-5 text-center">

                <div class="mb-md-5 mt-md-4 pb-5">

                  <h2 class="fw-bold mb-2 ">Giriş Yap</h2>
                  <p class="text-white-50 mb-5">Lütfen e-posta ve şifrenizi giriniz!</p>

                  <div data-mdb-input-init class="form-outline form-white mb-4">
                    <input name="uEmail" type="email" id="typeEmailX" class="form-control form-control-lg" placeholder="E-posta Giriniz" />
                    <label class="form-label" for="typeEmailX">E-posta</label>
                  </div>

                  <div data-mdb-input-init class="form-outline form-white mb-4">
                    <input name="user_name" type="text" id="typeUserName" class="form-control form-control-lg" placeholder="Kullanıcı adı" />
                    <label class="form-label" for="typeUserName">Kullanıcı Adı</label>
                  </div>

                  <div data-mdb-input-init class="form-outline form-white mb-4">
                    <input name="uPassword" type="password" id="typePasswordX" class="form-control form-control-lg" placeholder="Şifrenizi Giriniz" />
                    <label class="form-label" for="typePasswordX">Şifre</label>
                  </div>
                  <button name="loginButton" data-mdb-button-init data-mdb-ripple-init class="btn btn-outline-light btn-lg px-5" type="submit">Giriş</button>
                </div>
                <div>
                  <p class="mb-0">Hesabınız yok mu? <a href="./register/register.php" class="text-white-50 fw-bold">Kayıt ol!</a>
                  </p>
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