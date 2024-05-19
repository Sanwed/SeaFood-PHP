<?php

require_once 'connect.php';

session_start();
$dbc = get_dbc();

$category = $_GET['category'];
$id       = $_GET['id'];

if (empty($_SESSION['basket'])) {
    $_SESSION['basket']   = [];
    $product              = ['id' => $id, 'amount' => 1];
    $_SESSION['basket'][] = $product;
    header("Location: ../pages/catalog.php?category=$category");
    exit();
}

$found = false;
foreach ($_SESSION['basket'] as &$value) {
    if ($value['id'] === $id) {
        $value['amount'] += 1;
        $found           = true;
        break;
    }
}

if ( ! $found) {
    $product              = ['id' => $id, 'amount' => 1];
    $_SESSION['basket'][] = $product;
}

header("Location: ../pages/catalog.php?category=$category");
exit();