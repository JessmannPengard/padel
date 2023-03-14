window.onload = () => {

    function agregarEventoClick() {
        // Lógica para marcar o desmarcar las horas
        $('td').click(function () {
            if (!$(this).hasClass('reservado')) {
                if ($(this).hasClass('disponible')) {
                    $(this).removeClass('disponible');
                    $(this).addClass('seleccionado');
                } else {
                    if (!$(this).hasClass('incompleto')) {
                        $(this).removeClass('seleccionado');
                        $(this).addClass('disponible');
                    } else {
                        // Añadir participantes al modal
                        obtenerDatosAPIJugadores($(this).attr('data-id-reserva'));
                    }
                }
            }
        });
    }

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
        var clase = "";
        var html = "";

        datos.forEach(element => {
            if (element['id_reserva'] != null) {
                if (element['j1'] == "" || element['j2'] == "" || element['j3'] == "" || element['j4'] == "") {
                    clase = 'incompleto';
                } else {
                    clase = 'reservado';
                }
            }
            else {
                clase = 'disponible';
            }
            // En caso de que esté incompleto ponemos el enlace al modal para añadir participantes
            contenido = clase == 'incompleto' ? '<a href="" data-toggle="modal" data-target="#participantesModal" id=' + element["id_reserva"] + '>' + element['hora'] + '</a>' : element['hora'];
            html += '<td class="' + clase + '" id="' + element['id'] + '"data-id-reserva="' + element['id_reserva'] + '">' + contenido + '</td>';

        });
        $('#seleccion').html(html);
        agregarEventoClick();
    }

    // Obtenemos los jugadores inscritos en una reserva mediante la API
    function obtenerDatosAPIJugadores(id_reserva) {
        var datos = {
            id_reserva: id_reserva
        };
        console.log(datos);
        $.post('reservations.api.php', datos, function (respuesta) {
            // La función de devolución de llamada maneja la respuesta del servidor
            console.log(respuesta);
            pintarJugadores(respuesta);
        }, 'json');
    }

    function pintarJugadores(datos) {
        console.log("Pintar participantes: " + datos);
    }

    // Llamar por primera vez al cargar la página
    obtenerDatosAPI($('#fecha').val(), $('#id_pista').val());

}