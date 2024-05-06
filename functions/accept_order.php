<?php

require_once 'connect.php';
$dbc = get_dbc();

session_start();
$order_id = $_GET['id'];
$query    = "UPDATE orders SET status = 'accepted' WHERE id = '$order_id'";
mysqli_query($dbc, $query);
header('location: ../pages/admin.php');

