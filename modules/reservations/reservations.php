<?php
require_once("../../config/app.php");
require_once("../database/database.php");
require_once("reservations.model.php");
require_once("reservations.places.model.php");
require_once("reservations.hours.model.php");
require_once("../user/user.model.php");

$msg = "";

if (isset($_POST["id_pista"]) && isset($_POST["fecha"]) && isset($_POST["horas"])) {
    $horas = json_decode($_POST["horas"], true);
    if (count($horas) > 0) {
        $id_pista = $_POST["id_pista"];
        $fecha = $_POST["fecha"];

        $db = new Database;
        $usuario = new User($db->getConnection());
        $id_usuario = $usuario->getId($_SESSION["num_socio"]);
        $reservation = new Reservation($db->getConnection());
        foreach ($horas as $key => $value) {
            $reservation->reservar($id_usuario, $id_pista, $value, $fecha);
            header("Location: reservations.php");
        }
    } else {
        $msg = "No ha seleccionado ninguna hora";
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
                <p>
                    <?= SITE_TITLE ?>
                </p>
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
                            <label for="id_pista" class="form-label"><i
                                    class="fa-solid fa-table-tennis-paddle-ball"></i>
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
                            <input type="date" class="form-control" name="fecha" id="fecha" required
                                value="<?= date("Y-m-d"); ?>" min="<?= date("Y-m-d"); ?>" max="<?= $fecha_maxima ?>">
                            <small>Las reservas sólo se podrán realizar con un máximo de dos semanas de
                                antelación</small>
                        </div>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Hora</th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th><i class="fa-solid fa-clock"></i></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <?php
                                    // Llenamos la tabla con la situación de las reservas para la pista y fecha seleccionadas
                                    $db = new Database;
                                    $reservation = new Reservation($db->getConnection());
                                    $reservas = $reservation->getByFechaPista(date("Y-m-d"), 1);

                                    $celdas = 1;
                                    foreach ($reservas as $key => $value) {
                                        // Hacemos filas de 6 para que se adapte al diseño
                                        if ($celdas > 6) {
                                            echo '</tr>';
                                            $celdas = 1;
                                        }
                                        if ($value['id_reserva'] != null)
                                            $clase = 'reservado';
                                        else
                                            $clase = 'disponible';
                                        echo '<td class="' . $clase . '" id="' . $value['id'] . '">' . $value['hora'] . '</td>';
                                        $celdas++;
                                    }
                                    ?>
                                </tr>
                            </tbody>
                        </table>
                        <!-- Mostramos el mensaje de error, si lo hubiera -->
                        <div class="form-group">
                            <p class='error-text'>
                                <?php echo $msg; ?>
                            </p>
                        </div>
                        <div class="form-group">
                            <button type="submit" value="Reservar" class="btn btn-danger">Reservar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <!--Pie de página-->
    <footer class="footer fixed-bottom">
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