<?php

session_start();
require_once '../functions/connect.php';
require_once "../functions/check_status.php";

$_SESSION['auth']  = null;
$_SESSION['login'] = null;
header('Location: index.php');