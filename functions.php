<?php

function secure_data($data) {
    $data = trim($data);
    $data = htmlspecialchars($data, ENT_QUOTES, 'UTF-8');
    return $data;
}

function validate_with_number($data) {
    if (!preg_match('/^[a-zA-Z0-9]+$/', $data)) {
        return false; 
    }
    return true; 
}
function validate_letter($data) {
    if (!preg_match('/^[a-zA-ZüöçşğıİÜÖÇŞĞ\s]+$/', $data)) {
        return false; 
    }
    return true; 
}
?>
