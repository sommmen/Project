<?php

/* Include important files */
require_once('config.php');

/* Create DB Connection */
$myslqi = new mysqli($config['host'], $config['username'], $config['password'], $config['database']);
if(mysqli_connect_errno()){
    trigger_error('Er is een fout opgetreden tijdens het verbinden met de database: '.$mysqli->error);
}

