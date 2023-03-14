<?php
require_once("../../config/app.php");
require_once("../database/database.php");
require_once("reservations.model.php");
require_once("reservations.places.model.php");
require_once("reservations.hours.model.php");
require_once("../user/user.model.php");

session_start();
if (!isset($_SESSION["num_socio"])) {
    header("Location: ../../modules/user/user.login.php");
}

$msg = "";

if (isset($_POST["id_pista"]) && isset($_POST["fecha"]) && isset($_POST["horas"])) {
    $horas = json_decode($_POST["horas"], true);
    if (count($horas) > 0) {
        $id_pista = $_POST["id_pista"];
        $fecha = $_POST["fecha"];
        $j1 = $_POST["j1"];
        $j2 = $_POST["j2"];
        $j3 = $_POST["j3"];
        $j4 = $_POST["j4"];

        $db = new Database;
        $usuario = new User($db->getConnection());
        $id_usuario = $usuario->getId($_SESSION["num_socio"]);
        $reservation = new Reservation($db->getConnection());
        foreach ($horas as $key => $value) {
            $reservation->reservar($id_usuario, $id_pista, $value, $fecha, $j1, $j2, $j3, $j4);
            header("Location: reservations.php");
        }
    } else {
        $msg = "No ha seleccionado ninguna franja horaria";
    }
}
?>

<!-- Encabezado de página -->

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- JQuery -->
    <script src="../../vendor/js/jquery-3.6.3.min.js"></script>
    <!-- Font Awesome -->
    <link rel="stylesheet" href="../../vendor/fontawesome/css/all.min.css">
    <!-- Bootstrap -->
    <link rel="stylesheet" href="../../vendor/css/bootstrap.min.css">
    <script src="../../vendor/js/bootstrap.bundle.min.js"></script>
    <!-- Mis estilos -->
    <link rel="stylesheet" href="../../css/style.css">
    <link rel="stylesheet" href="reservations.css">
    <!-- Mi script -->
    <script src="reservations.js"></script>
    <!-- Favicon -->
    <link rel="icon" type="image/png" href="../../favicon.png">
    <!-- Título de la página -->
    <title>
        <?= SITE_TITLE ?>
    </title>
</head>

<body>
    <!-- Header -->
    <header>
        <nav class="navbar navbar-expand-xxxl">
            <!-- Logo -->
            <div class="d-flex">
                <a class="navbar-brand" href="../../index.php">
                    <img src="../../img/logo.jpg" alt="logo" id="logo">
                </a>
            </div>
        </nav>
    </header>

    <!-- Contenido de la página -->
    <section>
        <div class="container">
            <div class="row">
                <div class="col-md-6 mx-auto">
                    <!-- Título del formulario -->
                    <h2 class="section-title">Reservas</h2>
                    <!-- Formulario de inicio de sesión -->
                    <form action="" method="post" id="formulario-reservas">
                        <div class="form-group">
                            <label for="id_pista" class="form-label"><i class="fa-solid fa-table-tennis-paddle-ball"></i>
                                Pista</label>
                            <select class="form-select" aria-label="Selección de pista" name="id_pista" id="id_pista" autofocus>
                                <?php
                                // Llenamos el select con las pistas de la base de datos
                                $db = new Database;
                                $pista = new Places($db->getConnection());
                                $pistas = $pista->getAll();

                                foreach ($pistas as $key => $value) {
                                    echo '<option value="' . $value["id"] . '">' . $value["nombre"] . '</option>';
                                }
                                ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="fecha" class="form-label"><i class="fa-solid fa-calendar"></i> Fecha</label>
                            <?php
                            // Obtenemos la fecha actual
                            $hoy = new DateTime();
                            // Agregamos dos semanas a la fecha actual
                            $dos_semanas_despues = $hoy->add(new DateInterval('P2W'));
                            // Convertimos la fecha a formato ISO para el input type="date"
                            $fecha_maxima = $dos_semanas_despues->format('Y-m-d');
                            ?>
                            <input type="date" class="form-control" name="fecha" id="fecha" required value="<?= date("Y-m-d"); ?>" min="<?= date("Y-m-d"); ?>" max="<?= $fecha_maxima ?>">
                            <small>Las reservas se podrán realizar con un máximo de dos semanas de
                                antelación</small>
                        </div>
                        <label class="form-label"><i class="fa-solid fa-clock"></i> Horario</label>
                        <table class="table">
                            <tbody>
                                <tr id="seleccion">
                                    <!-- Zona de seleción de horarios -->
                                    <!-- Se rellena mediante AJAX -->
                                </tr>
                            </tbody>
                        </table>
                        <div id="leyenda">
                            <div id="cuadro-disponible"></div><small>Disponible</small>
                            <div id="cuadro-seleccionado"></div><small>Seleccionado</small>
                            <div id="cuadro-incompleto"></div><small>Incompleto</small>
                            <div id="cuadro-completo"></div><small>Completo</small>
                        </div><br>
                        <div class="form-group">
                            <label for="id_pista" class="form-label"><i class="fa-solid fa-table-tennis-paddle-ball"></i>
                                Participantes</label>
                            <input type="text" class="form-control" name="j1" id="j1" placeholder="Participante 1" required>
                            <input type="text" class="form-control" name="j2" id="j2" placeholder="Participante 2">
                            <input type="text" class="form-control" name="j3" id="j3" placeholder="Participante 3">
                            <input type="text" class="form-control" name="j4" id="j4" placeholder="Participante 4">
                            <small>Introduce al menos un participante para efectuar la reserva</small>
                        </div>
                        <!-- Mostramos el mensaje de error, si lo hubiera -->
                        <div class="form-group">
                            <p class='error-text'>
                                <?php echo $msg; ?>
                            </p>
                        </div>
                        <div class="form-group text-center">
                            <button type="submit" value="Reservar" class="btn btn-danger">Reservar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <!-- Modal para añadir participantes a una reserva -->
    <div class="modal fade" id="participantesModal" tabindex="-1" role="dialog" aria-labelledby="participantesLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="participantesLabel">Añadir participantes</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <label class="form-label"><i class="fa-solid fa-table-tennis-paddle-ball"></i>
                        Participantes</label>
                    <input type="text" class="form-control" id="p1" placeholder="Participante 1" required>
                    <input type="text" class="form-control" id="p2" placeholder="Participante 2">
                    <input type="text" class="form-control" id="p3" placeholder="Participante 3">
                    <input type="text" class="form-control" id="p4" placeholder="Participante 4">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <a href="" class="btn btn-danger" id="confirmar">Añadir</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Reservas del usuario -->
    <section>
        <div class="container">
            <div class="row">
                <div class="col-md-6 mx-auto">
                    <h2 class="section-title">Tus reservas</h2>
                </div>
            </div>
        </div>
    </section>

    <!--Pie de página-->
    <footer class="footer">
        <div class="container">
            <div class="row">
                <div class="col text-center">
                    <!--Copyright-->
                    <p>&copy;
                        <?= date("Y"); ?> Jessmann
                    </p>
                    <!--Email-->
                    <p><a href="mailto: servicios@jessmann.com" class="mail"><i class="fas fa-envelope"></i>
                            servicios@jessmann.com</a></p>
                </div>
            </div>
        </div>
    </footer>

</body>

</html>