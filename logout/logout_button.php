<?php

if (isset($_POST['logout'])) {

    session_start();
    $_SESSION['loggedin'] = false;
    session_unset();
    session_destroy();
    header("Location:../index.php");
    exit;
}

?>

<form method="post">
    <button name="logout" type="submit" class="btn btn-secondary mb-5">Çıkış yap</button>
</form>