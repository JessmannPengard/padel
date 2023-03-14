<?php

// Clase para gestionar la tabla 'horas'
class Hours
{
    protected $dbconn;

    public function __construct($conn)
    {
        $this->dbconn = $conn;
    }

    // Obtener el listado de pistas
    public function getAll()
    {
        $id = 0;
        // Prepare
        $stm = $this->dbconn->prepare("SELECT * FROM horas");
        // Execute
        $stm->execute();

        // Get username
        return $stm->fetchAll(PDO::FETCH_ASSOC);
    }
}