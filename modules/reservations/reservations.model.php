<?php

// Clase para gestionar reservas en la tabla 'reservas'
class Reservation
{
    protected $dbconn;

    public function __construct($conn)
    {
        $this->dbconn = $conn;
    }

    // Reservar
    public function reservar($id_usuario, $id_pista, $id_hora, $fecha, $j1, $j2, $j3, $j4)
    {
        $stm = $this->dbconn->prepare("INSERT INTO padel_reservas (id_usuario, id_pista, id_hora, fecha, j1, j2, j3, j4)
                                 VALUES (:id_usuario, :id_pista, :id_hora, :fecha, :j1, :j2, :j3, :j4)");
        $stm->bindValue(":id_usuario", $id_usuario);
        $stm->bindValue(":id_pista", $id_pista);
        $stm->bindValue(":id_hora", $id_hora);
        $stm->bindValue(":fecha", $fecha);
        $stm->bindValue(":j1", $j1 == null ? "" : $j1);
        $stm->bindValue(":j2", $j2 == null ? "" : $j2);
        $stm->bindValue(":j3", $j3 == null ? "" : $j3);
        $stm->bindValue(":j4", $j4 == null ? "" : $j4);
        $stm->execute();
    }

    // Añadir participantes
    public function anhadirJugadores($id_reserva, $j1, $j2, $j3, $j4)
    {
        $stm = $this->dbconn->prepare("UPDATE padel_reservas SET j1=:j1, j2=:j2, j3=:j3, j4=:j4 WHERE id=:id");
        $stm->bindValue(":j1", $j1 == null ? "" : $j1);
        $stm->bindValue(":j2", $j2 == null ? "" : $j2);
        $stm->bindValue(":j3", $j3 == null ? "" : $j3);
        $stm->bindValue(":j4", $j4 == null ? "" : $j4);
        $stm->bindValue(":id", $id_reserva);
        $stm->execute();
    }

    // Eliminar reserva
    public function deleteById($id_reserva)
    {
        $stm = $this->dbconn->prepare("DELETE FROM padel_reservas WHERE id=:id");
        $stm->bindValue(":id", $id_reserva);
        $stm->execute();
    }

    // Obtiene las reservas por día
    public function getByFechaPista($fecha, $id_pista)
    {
        $query = "SELECT padel_horas.*, padel_reservas.id AS id_reserva, padel_reservas.j1, padel_reservas.j2, padel_reservas.j3, padel_reservas.j4 FROM padel_horas
                LEFT JOIN padel_reservas ON padel_horas.id = padel_reservas.id_hora AND padel_reservas.id_pista = :id_pista AND padel_reservas.fecha = :fecha
                ORDER BY padel_horas.hora ASC";
        $stm = $this->dbconn->prepare($query);
        $stm->bindParam(':id_pista', $id_pista);
        $stm->bindParam(':fecha', $fecha);
        $stm->execute();

        // Devolver resultados de la consulta
        return $stm->fetchAll(PDO::FETCH_ASSOC);
    }

    // Obtiene los jugadores por id de reserva
    public function getJugadoresReserva($id_reserva)
    {
        $query = "SELECT j1, j2, j3, j4 FROM padel_reservas WHERE id=:id";
        $stm = $this->dbconn->prepare($query);
        $stm->bindParam(':id', $id_reserva);
        $stm->execute();

        // Devolver resultados de la consulta
        return $stm->fetchAll(PDO::FETCH_ASSOC);
    }

    // Obtiene las reservas por id de usuario
    // Sólo aquellas cuya fecha sea igual o posterior a la fecha actual
    public function getReservasByIdUsuario($id_usuario)
    {
        $query = "SELECT padel_reservas.*, padel_horas.hora AS hora, padel_pistas.nombre AS pista
                FROM padel_reservas
                INNER JOIN padel_horas ON padel_reservas.id_hora = padel_horas.id
                INNER JOIN padel_pistas ON padel_reservas.id_pista = padel_pistas.id 
                WHERE padel_reservas.id_usuario=:id_usuario AND padel_reservas.fecha >= '" . date('Y-m-d') . "'
                ORDER BY padel_reservas.fecha ASC, padel_reservas.id_hora ASC";
        $stm = $this->dbconn->prepare($query);
        $stm->bindParam(':id_usuario', $id_usuario);
        $stm->execute();

        // Devolver resultados de la consulta
        return $stm->fetchAll(PDO::FETCH_ASSOC);
    }


}