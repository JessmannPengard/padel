<!--Carrusel de imágenes-->
<div class="mt-5justify-content-center align-items-center position-relative" id="carrusel">
    <!--Logotipo-->
    <!--<img src="img/logo.png" alt="" class="img-fluid img-logo position-absolute">-->
    <!--<h2 class="txt-logo position-absolute">PADEL PRO</h2>-->

    <!--Carrusel-->
    <div id="carouselIndicators" class="carousel slide" data-ride="carousel" data-interval="3000">
        <!--Indicadores inferiores-->
        <ol class="carousel-indicators">
            <li data-target="#carouselIndicators" data-slide-to="0" class="active"></li>
            <li data-target="#carouselIndicators" data-slide-to="1"></li>
            <li data-target="#carouselIndicators" data-slide-to="2"></li>
            <li data-target="#carouselIndicators" data-slide-to="3"></li>
        </ol>
        <!--Imágenes-->
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img class="d-block w-100" src="modules/carousel/img/carr1.jpg" alt="">
            </div>
            <div class="carousel-item">
                <img class="d-block w-100" src="modules/carousel/img/carr2.jpg" alt="">
            </div>
            <div class="carousel-item">
                <img class="d-block w-100" src="modules/carousel/img/carr3.jpg" alt="">
            </div>
            <div class="carousel-item">
                <img class="d-block w-100" src="modules/carousel/img/carr4.jpg" alt="">
            </div>
        </div>
        <!--Control anterior-->
        <a class="carousel-control-prev" href="#carouselIndicators" role="button" data-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="sr-only">Anterior</span>
        </a>
        <!--Control siguiente-->
        <a class="carousel-control-next" href="#carouselIndicators" role="button" data-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="sr-only">Siguiente</span>
        </a>
    </div>
</div>

<!-- Estilos -->
<link rel="stylesheet" href="./modules/carousel/carousel.css">