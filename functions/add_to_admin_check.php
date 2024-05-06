<?php

require_once './connect.php';
session_start();

$dbc = get_dbc();

$orders = implode(', ', $_SESSION['basket']);

if ( ! empty($_SESSION['auth'])) {
    $login   = $_SESSION['login'];
    $query   = "SELECT * from users WHERE login='$login'";
    $result  = mysqli_query($dbc, $query);
    $row     = mysqli_fetch_assoc($result);
    $user_id = $row['user_id'];
    
    $query
        = "INSERT INTO orders (user_id, products, status) VALUES ('$user_id', '$orders', 'waiting')";
    mysqli_query($dbc, $query);
    header('location: ../pages/basket.php');
    $_SESSION['basket'] = [];
} else {
    $query
        = "INSERT INTO orders (products, status) VALUES ('$orders', 'waiting')";
    mysqli_query($dbc, $query);
    header('location: ../pages/basket.php');
    $_SESSION['basket'] = [];
}


