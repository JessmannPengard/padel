<?php

// Clase para gestionar la tabla 'pistas'
class Places
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
        $stm = $this->dbconn->prepare("SELECT * FROM padel_pistas ORDER BY id");
        // Execute
        $stm->execute();

        // Get username
        return $stm->fetchAll(PDO::FETCH_ASSOC);
    }
}