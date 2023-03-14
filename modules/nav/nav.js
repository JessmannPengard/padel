$(document).ready(function () {
    
    // Desplazamiento a la sección correspondiente al clicar el menú
    $(".nav-link").on('click', function (event) {
        if (this.hash !== "") {
            event.preventDefault();
            var hash = this.hash;
            console.log(hash);
            if (hash == '#section-home') {
                $('html, body').animate({ scrollTop: 0 }, 'slow');
            } else {
                $('html, body').animate({
                    scrollTop: $(hash).offset().top
                }, 700, function () {
                    window.location.hash = hash;
                });
            }
        }
    });

    // Navbar collapse
    $(document).click(function (event) {
        var clickover = $(event.target);
        var $navbar = $(".navbar-collapse");
        var _opened = $navbar.hasClass("show");
        if (_opened === true && !clickover.hasClass("navbar-toggler") && !clickover.hasClass("dropdown-toggle")) {
            $navbar.collapse("hide");
        }
    });

    // Eventos al hacer scroll de la página
    window.onscroll = function () {
        // Mostrar botón de desplazamiento al inicio de página
        mostrarBoton();
        // Cambiar el color de los menús según la sección en que nos encontremos
        $('section').each(function () {
            if ($(window).scrollTop() >= $(this).offset().top - 100) {
                var id = $(this).attr('id');
                $('a.nav-link').removeClass('active');
                $('a.nav-link[href="#' + id + '"]').addClass('active');
            }
        });
    };

    // Botón para volver al inicio de la página
    function mostrarBoton() {
        if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
            document.getElementById("scroll-top-button").style.display = "block";
        } else {
            document.getElementById("scroll-top-button").style.display = "none";
        }
    }

    document.getElementById("scroll-top-button").onclick = function (event) {
        $('html, body').animate({ scrollTop: 0 }, 'slow');
    };

});