window.onload = () => {

    // Lógica para marcar o desmarcar las horas
    $('td').click(function () {
        if (!$(this).hasClass('reservado')) {
            if ($(this).hasClass('disponible')) {
                $(this).removeClass('disponible');
                $(this).addClass('seleccionado');
            } else {
                $(this).removeClass('seleccionado');
                $(this).addClass('disponible');
            }
        }
    });

    // Agregar las horas seleccionadas al enviar el formulario
    let formulario = $('form#formulario-reservas');
    formulario.submit(function (event) {
        let horas = obtenerHorasSeleccionadas();
        $('<input>').attr({
            type: 'hidden',
            name: 'horas',
            value: JSON.stringify(horas)
        }).appendTo(formulario);
        formulario.submit();
        event.preventDefault();
    });

    // Función que obtiene las horas seleccionadas
    function obtenerHorasSeleccionadas() {
        let horas = [];
        $('table tr td').each(function () {
            if ($(this).hasClass('seleccionado')) {
                horas.push($(this).attr('id'));
            }
        });
        return horas;
    }

    // Obtener datos de reservas mediante API
    function obtenerDatosAPI(fecha, id_pista) {
        var datos = {
            fecha: fecha,
            id_pista: id_pista
        };
        $.post('reservations.api.php', datos, function (respuesta) {
            // La función de devolución de llamada maneja la respuesta del servidor
            pintarHorario(respuesta);
        }, 'json');
    }

    // Obtener datos al cambiar de pista
    $('#id_pista').change(function () {
        // La función que se ejecuta cuando cambia el select
        obtenerDatosAPI($('#fecha').val(), $('#id_pista').val());
    });

    // Obtener datos al cambiar la fecha
    $('#fecha').change(function () {
        // La función que se ejecuta cuando cambia el input fecha
        obtenerDatosAPI($('#fecha').val(), $('#id_pista').val());
    });

    // Pintar el horario según los datos obtenidos de la API
    function pintarHorario(datos) {
        console.log(datos);
    }

}