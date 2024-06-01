<?php

session_start();

$id = $_GET['id'];

foreach ($_SESSION['basket'] as &$item) {
    if ($item['id'] == $id) {
        $item['amount'] += 1;
        header('Location: ../pages/basket.php');
        exit();
    }
}
