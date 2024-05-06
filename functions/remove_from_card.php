<?php

session_start();

$_SESSION['basket'] = array_diff($_SESSION['basket'], [$_GET['id']]);
header('Location: ../pages/basket.php');