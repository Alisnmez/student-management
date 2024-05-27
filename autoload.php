<?php

spl_autoload_register(function ($className) {
    $classFile = __DIR__ . '/class/' . $className . '.php';
    if (file_exists($classFile)) {
        require_once $classFile;
    } else {
        echo "Class dosyası bulunamadı: $classFile";
    }
});
