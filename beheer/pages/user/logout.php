<?php
$token = $_SESSION['user']['token'];
$username = $_SESSION['user']['name'];
$mysqli->query("UPDATE user SET token = '' WHERE username = '" . $username . "' AND token = '" . $token . "'");

session_destroy();

redirect('/beheer/');