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
    public function reservar($id_usuario, $id_pista, $id_hora, $fecha)
    {
        $stm = $this->dbconn->prepare("INSERT INTO reservas (id_usuario, id_pista, id_hora, fecha) VALUES (:id_usuario, :id_pista, :id_hora, :fecha)");
        $stm->bindValue(":id_usuario", $id_usuario);
        $stm->bindValue(":id_pista", $id_pista);
        $stm->bindValue(":id_hora", $id_hora);
        $stm->bindValue(":fecha", $fecha);
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
        $query = "SELECT horas.*, reservas.id AS id_reserva FROM horas
                LEFT JOIN reservas ON horas.id = reservas.id_hora AND reservas.id_pista = :id_pista AND reservas.fecha = :fecha
                ORDER BY horas.hora ASC";
        $stm = $this->dbconn->prepare($query);
        $stm->bindParam(':id_pista', $id_pista);
        $stm->bindParam(':fecha', $fecha);
        $stm->execute();

        // Devolver resultados de la consulta
        return $stm->fetchAll(PDO::FETCH_ASSOC);

    }
}