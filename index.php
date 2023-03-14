<?php
require_once("config/app.php");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!--Jquery-->
    <script src="vendor/js/jquery-3.6.3.min.js"></script>
    <!--Popper.js-->
    <script src="vendor/js/popper.min.js"></script>
    <!--Bootstrap-->
    <script src="vendor/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="vendor/css/bootstrap.min.css">
    <!--Font Awesome-->
    <link rel="stylesheet" href="vendor/fontawesome/css/all.min.css">
    <!--Mis estilos-->
    <link rel="stylesheet" href="css/style.css">
    <!--Favicon-->
    <link rel="icon" type="image/png" href="favicon.png">
    <!--Título de la página-->
    <title>
        <?= SITE_TITLE ?>
    </title>
</head>

<?php
require_once("modules/nav/nav.php");
require_once("modules/carousel/carousel.php");
require_once("modules/about/about.php");
?>
<!--Sección Reservas-->
<section class="py-5" id="section-reservations">
    <div class="container">
        <h2 class="text-center mb-4 section-title">Reservas</h2>
        <p>Accede y haz tu reserva:</p>
        <div class="text-center">
            <a href="modules/reservations/reservations.php"><button class="btn btn-danger">Reserva</button></a>
        </div>
    </div>
</section>
<?php
require_once("modules/contact/contact.php");
require_once("modules/map/map.php");
require_once("modules/footer/footer.php");
?>

<body>

</body>

</html>