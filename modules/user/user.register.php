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
    $nombre = $_POST["nombre"];
    $password = $_POST["password"];
    $telefono = $_POST["telefono"];
    $email = $_POST["email"];

    // Nos conectamos a la base de datos
    $db = new Database();
    $user = new User($db->getConnection());

    // Y llamamos al método register para registrar un nuevo usuario
    $registro = $user->register($num_socio, $nombre, $password, $telefono, $email);
    // Si el resultado es positivo
    if ($registro["result"]) {
        // Registro correcto, redirigimos a la página de login para que el usuario pueda iniciar sesión
        header("Location: user.login.php");
    } else {
        // Registro no realizado, guardamos el mensaje de error a mostrar más abajo
        $msg = $registro["msg"];
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
        <?= SITE_TITLE ?> - Registro
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
    <div class="container">
        <div class="row">
            <div class="col-md-6 mx-auto">
                <!-- Título del formulario -->
                <h2 class="section-title">Crear cuenta</h2>
                <!-- Formulario de registro -->
                <form action="" method="post" class="login-form" id="registerForm">
                    <div class="form-group">
                        <label for="num_socio" class="form-label ">Número de socio</label>
                        <input type="text" name="num_socio" class="form-control" required placeholder="Introduce tu número de socio" autofocus>
                    </div>
                    <div class="form-group">
                        <label for="nombre" class="form-label ">Nombre</label>
                        <input type="text" name="nombre" class="form-control" required placeholder="Introduce tu nombre">
                    </div>
                    <div class="form-group">
                        <label for="telefono" class="form-label ">Teléfono</label>
                        <input type="text" name="telefono" class="form-control" required placeholder="Introduce tu número de teléfono">
                    </div>
                    <div class="form-group">
                        <label for="email" class="form-label ">Email</label>
                        <input type="text" name="email" class="form-control" required placeholder="Introduce tu email">
                    </div>
                    <div class="form-group">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" name="password" id="password" class="form-control" required placeholder="Password">
                    </div>
                    <div class="form-group">
                        <label for="c_password" class="form-label">Repetir password</label>
                        <input type="password" name="c_password" id="c-password" class="form-control" required placeholder="Repetir password">
                    </div>
                    <!-- Mostramos el mensaje de error, si lo hubiera -->
                    <div class="form-group">
                        <p class="error-text" id="error">
                            <?php echo $msg; ?>
                        </p>
                    </div>
                    <div class="form-group">
                        <button type="submit" value="Login" class="btn btn-danger">Registrarse</button>
                    </div>
                    <!-- Enlace a la página de inicio de sesión -->
                    <div class="form-group">
                        <span class="form-text">¿Ya estás registrad@?</span><a href="user.login.php" class="form-link">
                            Inicia
                            sesión</a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!--Pie de página-->

    <script>
        // Comprobamos que el cambo Repetir password coincida con el campo Password
        window.onload = function() {
            let form = document.getElementById("registerForm");
            form.onsubmit = function(e) {
                let passw = document.getElementById("password").value;
                let cpassw = document.getElementById("c-password").value;
                if (passw != cpassw) {
                    e.preventDefault();
                    document.getElementById("error").innerHTML = "La contraseña no coincide.";
                }
            }
        }
    </script>

</body>

</html>