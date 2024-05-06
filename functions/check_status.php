<?php

require_once('connect.php');

function check_status()
{
    if ( ! empty($_SESSION['auth'])) {
        $dbc    = get_dbc();
        $login  = $_SESSION['login'];
        $query  = "SELECT * from users WHERE login='$login'";
        $result = mysqli_query($dbc, $query);
        $row    = mysqli_fetch_assoc($result);
        
        return $row['role'];
    }
    
    return null;
}