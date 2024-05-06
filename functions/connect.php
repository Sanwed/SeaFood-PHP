<?php

const DB_HOSTNAME = '127.0.0.1';
const DB_DATABASE = 'seafood';
const DB_USERNAME = 'root';
const DB_PASSWORD = '';

function get_dbc()
{
    $dbc = mysqli_connect(DB_HOSTNAME, DB_USERNAME, DB_PASSWORD, DB_DATABASE);
    if ( ! $dbc) {
        die("Unable to connect to MySQL: ".mysqli_error($dbc));
    }
    
    return $dbc;
}