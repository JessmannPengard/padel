<?php
require_once("../database/database.php");
require_once("reservations.model.php");

// Obtener reservas por Fecha y Pista
if (isset($_POST["fecha"]) && isset($_POST["id_pista"])) {

    $fecha = $_POST["fecha"];
    $id_pista = $_POST["id_pista"];

    $db = new Database;
    $reserva = new Reservation($db->getConnection());

    echo json_encode($reserva->getByFechaPista($fecha, $id_pista));
}

// Obtener participantes de una determinada reserva
if (isset($_POST["id_reserva"]) && !isset($_POST["j1"]) && !isset($_POST["accion"])) {

    $id_reserva = $_POST["id_reserva"];

    $db = new Database;
    $reserva = new Reservation($db->getConnection());

    echo json_encode($reserva->getJugadoresReserva($id_reserva));
}

// Añadir participantes a una reserva
if (isset($_POST["id_reserva"]) && isset($_POST["j1"]) && isset($_POST["j2"]) && isset($_POST["j3"]) && isset($_POST["j4"])) {

    $id_reserva = $_POST["id_reserva"];
    $j1 = $_POST["j1"];
    $j2 = $_POST["j2"];
    $j3 = $_POST["j3"];
    $j4 = $_POST["j4"];

    $db = new Database;
    $reserva = new Reservation($db->getConnection());

    $reserva->anhadirJugadores($id_reserva, $j1, $j2, $j3, $j4);
}

// Borrar reserva
if (isset($_POST["id_reserva"]) && isset($_POST["accion"])) {

    $id_reserva = $_POST["id_reserva"];

    if ($_POST["accion"] == 'borrar') {
        $db = new Database;
        $reserva = new Reservation($db->getConnection());

        $reserva->deleteById($id_reserva);
    }
}
