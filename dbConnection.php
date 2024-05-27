<?php
$config = include('config.php');

$dsn = 'mysql:host=' . $config['host'] . ';dbname=' . $config['dbname'];
$user = $config['user'];
$password = $config['password'];

try {
    $connection = new PDO($dsn, $user, $password);
} catch (PDOException $e) {
    echo 'Bağlantı kurulamadı: ' . $e->getMessage();
}

?>
