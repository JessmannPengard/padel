<?php
require_once("../database/database.php");
require_once("reservations.model.php");
require_once("reservations.places.model.php");


// Acciones permitidas:
//
// Obtener reservas: 'getReservas' ['fecha']['idpista']
// Borrar reserva: 'delReserva' ['id_reserva']
// Obtener participantes: 'getParticipantes' ['id_reserva']
// Añadir participantes: 'setParticipantes' ['id_reserva']

if (isset($_POST['accion'])) {
    $accion = $_POST['accion'];
    switch ($accion) {
        case 'getReservas':
            $fecha = $_POST["fecha"];
            $id_pista = $_POST["id_pista"];
            getReservas($fecha, $id_pista);
            break;
        case 'delReserva':
            $id_reserva = $_POST["id_reserva"];
            delReserva($id_reserva);
            break;
        case 'getParticipantes':
            $id_reserva = $_POST["id_reserva"];
            getParticipantes($id_reserva);
            break;
        case 'setParticipantes':
            $id_reserva = $_POST["id_reserva"];
            $j1 = $_POST["j1"];
            $j2 = $_POST["j2"];
            $j3 = $_POST["j3"];
            $j4 = $_POST["j4"];
            setParticipantes($id_reserva, $j1, $j2, $j3, $j4);
            break;
        case 'getPistas':
            getPistas();
            break;
        default:
            // Operación no permitida
            echo "Operación no permitida";
            break;
    }
}

// Obtener reservas por Fecha y Pista
function getReservas($fecha, $id_pista)
{
    $db = new Database;
    $reserva = new Reservation($db->getConnection());

    echo json_encode($reserva->getByFechaPista($fecha, $id_pista));
}

// Borrar reserva
function delReserva($id_reserva)
{
    $db = new Database;
    $reserva = new Reservation($db->getConnection());

    $reserva->deleteById($id_reserva);
}

// Obtener participantes de una determinada reserva
function getParticipantes($id_reserva)
{
    $db = new Database;
    $reserva = new Reservation($db->getConnection());

    echo json_encode($reserva->getJugadoresReserva($id_reserva));
}

// Añadir participantes a una reserva
function setParticipantes($id_reserva, $j1, $j2, $j3, $j4)
{
    $db = new Database;
    $reserva = new Reservation($db->getConnection());

    $reserva->anhadirJugadores($id_reserva, $j1, $j2, $j3, $j4);
}

// Obtener pistas
function getPistas()
{
    $db = new Database;
    $pista = new Places($db->getConnection());

    echo json_encode($pista->getAll());
}