<?php

// Clase para gestionar los usuarios en la tabla "usuarios"
class User
{
    protected $dbconn;

    // Constructor
    public function __construct($conn)
    {
        $this->dbconn = $conn;
    }

    // Comprueba que la combinación usuario/contraseña sea correcta
    public function login($num_socio, $password)
    {
        // Encriptar contraseña
        $pw = md5($password);

        // Prepare
        $stm = $this->dbconn->prepare("SELECT * FROM padel_usuarios WHERE 
                num_socio=:num_socio AND password=:password");
        $stm->bindValue(":num_socio", $num_socio);
        $stm->bindValue(":password", $pw);

        // Execute
        $stm->execute();

        // Devolver resultado
        return $stm->fetch();
    }

    // Registrar nuevo usuario
    public function register($num_socio, $nombre, $password, $telefono, $email)
    {
        $result = array();

        // Comprueba que el usuario no exista ya en la base de datos mediante la función existsUser (declarada más abajo)
        if ($this->existUser($num_socio)) {
            // Si existe devolvemos $result=false y el mensaje a mostrar $result="Usuario ya existe"
            $result["result"] = false;
            $result["msg"] = "El número de socio ya está registrado.";
            return $result;
        }

        // Encriptar password
        $pw = md5($password);

        // Prepare
        $stm = $this->dbconn->prepare("INSERT INTO padel_usuarios (num_socio, nombre, password, telefono, email)
                VALUES (:num_socio, :nombre, :password, :telefono, :email)");

        $stm->bindValue(":num_socio", $num_socio);
        $stm->bindValue(":nombre", $nombre);
        $stm->bindValue(":password", $pw);
        $stm->bindValue(":telefono", $telefono);
        $stm->bindValue(":email", $email);

        // Execute
        $stm->execute();

        // Registrado con éxito
        $result["result"] = true;
        return $result;
    }

    // Comprueba si un nombre de usuario ya existe en la base de datos
    public function existUser($num_socio)
    {
        // Prepare
        $stm = $this->dbconn->prepare("SELECT id FROM padel_usuarios WHERE num_socio = :num_socio");
        $stm->bindValue(":num_socio", $num_socio);

        // Execute
        $stm->execute();

        // Devolvemos el resultado
        return $stm->fetch();
    }

    // Obtiene el número de socio a partir de su id
    public function getNumSocio($id_usuario)
    {
        $num_socio = "";
        // Prepare
        $stm = $this->dbconn->prepare("SELECT num_socio FROM padel_usuarios WHERE id = :id");
        $stm->bindValue(":id", $id_usuario);
        $stm->bindColumn("num_socio", $num_socio);

        // Execute
        $stm->execute();

        // Get username
        $stm->fetch();

        // Devolvemos el nombre de usuario
        return $num_socio;
    }

    // Obtiene el id de un usuario a partir de su número de socio
    public function getId($num_socio)
    {
        $id = 0;
        // Prepare
        $stm = $this->dbconn->prepare("SELECT id FROM padel_usuarios WHERE num_socio = :num_socio");
        $stm->bindValue(":num_socio", $num_socio);
        $stm->bindColumn("id", $id);

        // Execute
        $stm->execute();

        // Get username
        $stm->fetch();

        // Devolvemos el id
        return $id;
    }
}