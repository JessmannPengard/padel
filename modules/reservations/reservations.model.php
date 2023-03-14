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
        $stm = $this->dbconn->prepare("INSERT INTO reservas (id_usuario, id_pista, id_hora, fecha, j1, j2, j3, j4)
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

    // Eliminar reserva
    public function deleteById($id_reserva)
    {
        $stm = $this->dbconn->prepare("DELETE FROM reservas WHERE id=:id");
        $stm->bindValue(":id", $id_reserva);
        $stm->execute();
    }

    // Obtiene las reservas por día
    public function getByFechaPista($fecha, $id_pista)
    {
        $query = "SELECT horas.*, reservas.id AS id_reserva, reservas.j1, reservas.j2, reservas.j3, reservas.j4 FROM horas
                LEFT JOIN reservas ON horas.id = reservas.id_hora AND reservas.id_pista = :id_pista AND reservas.fecha = :fecha
                ORDER BY horas.hora ASC";
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
        $query = "SELECT j1, j2, j3, j4 FROM reservas WHERE id=:id";
        $stm = $this->dbconn->prepare($query);
        $stm->bindParam(':id', $id_reserva);
        $stm->execute();

        // Devolver resultados de la consulta
        return $stm->fetchAll(PDO::FETCH_ASSOC);
    }
}
