<?php
require_once("config/app.php");

session_start();

if (!isset($_SESSION["num_socio"])) {
    header("Location: modules/user/user.login.php");
} else {
    header("Location: modules/reservations/reservations.php");
}

?>