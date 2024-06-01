<?php

session_start();

$_SESSION['auth']  = null;
$_SESSION['login'] = null;
header('Location: ../pages/index.php');