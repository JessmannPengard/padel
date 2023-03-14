<?php
require_once("../database/database.php");
require_once("reservations.model.php");

if (isset($_POST["fecha"]) && isset($_POST["id_pista"])) {

    $fecha = $_POST["fecha"];
    $id_pista = $_POST["id_pista"];

    $db = new Database;
    $reserva = new Reservation($db->getConnection());

    echo json_encode($reserva->getByFechaPista($fecha, $id_pista));
}