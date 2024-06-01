<?php

session_start();

if (isset($_GET['id'])) {
    foreach ($_SESSION['basket'] as $key => $value) {
        if ($value['id'] === $_GET['id']) {
            unset($_SESSION['basket'][$key]);
            break;
        }
    }
}

// Перенаправление и завершение скрипта
header('Location: ../pages/basket.php');
exit;