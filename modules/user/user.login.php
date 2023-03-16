<?php
// Importamos los módulos necesarios
require_once("../../config/app.php");
require_once("../../modules/database/database.php");
require_once("user.model.php");

// Inicializamos la variable que usaremos para mostrar mensajes en caso de algún error
$msg = "";

// Si nos están enviando el formulario...
if (isset($_POST["num_socio"])) {
    // Obtenemos el nombre de usuario y contraseña
    $num_socio = $_POST["num_socio"];
    $password = $_POST["password"];

    // Nos conectamos a la base de datos
    $db = new Database();
    $user = new User($db->getConnection());

    // Y llamamos al método login para iniciar sesión
    if ($user->login($num_socio, $password)) {
        // Login correcto, iniciamos sesión
        session_start();
        // Guardamos la variable de sesión
        $_SESSION["num_socio"] = $num_socio;
        // Redirigimos a la página de inicio
        header("Location: ../../modules/reservations/reservations.php");
    } else {
        // Login incorrecto, guardamos el mensaje de error a mostrar más abajo
        $msg = "Usuario y/o contraseña incorrectos.";
    }
}

?>

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
    <link rel="stylesheet" href="user.css">
    <!-- Favicon -->
    <link rel="icon" type="image/png" href="../../favicon.png">
    <!-- Título de la página -->
    <title>
        <?= SITE_TITLE ?> - Login
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
                    <h2 class="section-title">Inicia sesión</h2>
                    <!-- Formulario de inicio de sesión -->
                    <form action="" method="post">
                        <div class="form-group">
                            <label for="num_socio" class="form-label">Número de socio</label>
                            <input type="text" class="form-control" name="num_socio" placeholder="Introduce tu número de socio" required autofocus>
                        </div>
                        <div class="form-group">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control" name="password" placeholder="Password" required>
                        </div>
                        <!-- Mostramos el mensaje de error, si lo hubiera -->
                        <div class="form-group">
                            <p class='error-text'>
                                <?php echo $msg; ?>
                            </p>
                        </div>
                        <div class="form-group">
                            <button type="submit" value="Login" class="btn btn-danger">Login</button>
                        </div>
                        <!-- Enlace a la página de registro -->
                        <div class="form-group">
                            <span class="form-text">¿Aún no tienes una cuenta?</span><a href="user.register.php" class="form-link">
                                Regístrate aquí</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <!--Pie de página-->
    <footer class="footer">
        <hr>
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