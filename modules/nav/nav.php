<!--Sección Home-->
<section id="section-home">
    <div class="container-fluid">
        <!--Barra de navegación-->
        <nav class="navbar navbar-expand-sm fixed-top">
            <!--Botón de expandir/contraer el menú en pantallas pequeñas-->
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"><i class="fa-solid fa-bars"></i></span>
            </button>
            <!--Menú-->
            <div class="collapse navbar-collapse" id="navbarNav">
                <a class="navbar-brand" href="#">
                    <img src="img/logo.jpg" alt="logo" id="logo">
                </a>
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link text-danger active" href="#section-home">INICIO</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-danger" href="#section-about">INFO</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-danger" href="#section-reservations">RESERVAS</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-danger" href="#section-contact">CONTACTO</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-danger" href="#"><i class="fa-brands fa-facebook"></i></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-danger" href="#"><i class="fa-brands fa-instagram"></i></a>
                    </li>
                </ul>
            </div>
        </nav>
    </div>
</section>

<!-- Botón de scroll al inicio de página -->
<a href="#section-home" id="scroll-top-button"><i class="fa fa-chevron-up"></i></a>

<!-- Estilos -->
<link rel="stylesheet" href="./modules/nav/nav.css">
<!-- Script -->
<script src="./modules/nav/nav.js"></script>