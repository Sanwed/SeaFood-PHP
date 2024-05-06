<?php

require_once 'connect.php';

session_start();
$dbc = get_dbc();

$category = $_GET['category'];
$id = $_GET['id'];

if (empty($_SESSION['basket'])) {
    $_SESSION['basket']   = array();
}
$_SESSION['basket'][] = $id;

header("Location: ../pages/catalog.php?category=$category");
