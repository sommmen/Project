<?php
/*
 *              in al haar professionaliteit gemaakt door:
 *                          Jurrian Fisher
 */

$token = $_SESSION['user']['token'];
$username = $_SESSION['user']['name'];

//verwijder het token (hierdoor zal op elke pagina de minrole functie foutief zijn en de uitgelogde gebruiker terugsturen.)
$mysqli->query("UPDATE user SET token = '' WHERE username = '" . $username . "' AND token = '" . $token . "'");

session_destroy();

redirect('/beheer/');