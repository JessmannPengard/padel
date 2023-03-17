window.onload = () => {

    // Lógica para marcar o desmarcar las horas
    function agregarEventoClick() {
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
                        // Añadimos el id de reserva al botón confirmar del modal
                        $('#confirmar').attr('data-id-reserva', $(this).attr('data-id-reserva'));
                        // Añadir participantes al modal
                        obtenerDatosAPIJugadores($(this).attr('data-id-reserva'));
                    }
                }
            }
        });
    }

    // Lógica para controlar los botones de borrar reserva
    function agregarEventoClickBorrar() {
        $('.eliminar-reserva').click(function () {
            // Añadimos el id de reserva al botón borrar del modal
            $('#confirmar-borrado').attr('data-id-reserva', $(this).attr('data-id-reserva'));
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
    function obtenerHorarioAPI(fecha) {
        $('#seleccion').html("");
        var accion = "getPistas";
        var datos = {
            accion: accion,
        };
        var url = location.origin + "/padel/modules/reservations/reservations.api.php";
        $.post(url, datos, function (respuesta) {
            // La función de devolución de llamada maneja la respuesta del servidor
            var pistas = respuesta;
            pistas.forEach(pista => {
                var accion = "getReservas";
                var id_pista = pista['id'];
                var datos = {
                    accion: accion,
                    fecha: fecha,
                    id_pista: id_pista
                };
                var url = location.origin + "/padel/modules/reservations/reservations.api.php";
                $.post(url, datos, function (respuesta) {
                    // La función de devolución de llamada maneja la respuesta del servidor
                    pintarHorario(respuesta, pista);
                }, 'json');
            });
        }, 'json');
    }

    // Obtener datos al cambiar de pista
    $('#id_pista').change(function () {
        // La función que se ejecuta cuando cambia el select
        obtenerHorarioAPI($('#fecha').val(), $('#id_pista').val());
    });

    // Obtener datos al cambiar la fecha
    $('#fecha').change(function () {
        // La función que se ejecuta cuando cambia el input fecha
        obtenerHorarioAPI($('#fecha').val(), $('#id_pista').val());
    });

    // Pintar el horario según los datos obtenidos de la API
    function pintarHorario(datos, pista) {
        var clase = "";
        var html = "<tr>";

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
            html += '<td class="' + clase + '" id="' + element['id'] + '"data-id-reserva="' + element['id_reserva'] + '"data-id-pista="' + pista["id"] + '">' + contenido + '</td>';

        });
        html += "</tr>";
        $('#seleccion').append(html);
        agregarEventoClick();
    }

    // Obtenemos los jugadores inscritos en una reserva mediante la API
    function obtenerDatosAPIJugadores(id_reserva) {
        var accion = "getParticipantes";
        var datos = {
            accion: accion,
            id_reserva: id_reserva
        };
        var url = location.origin + "/padel/modules/reservations/reservations.api.php";
        $.post(url, datos, function (respuesta) {
            // La función de devolución de llamada maneja la respuesta del servidor
            pintarJugadores(respuesta);
        }, 'json');
    }

    // Pintamos los jugadores inscritos en el modal y
    // deshabilitamos los input que ya tengan algún jugador inscrito
    function pintarJugadores(datos) {
        if (datos[0]['j1'] != '') {
            $('#p1').prop("disabled", true);
            $('#p1').val(datos[0]['j1']);
        } else {
            $('#p1').prop("disabled", false);
            $('#p1').val('');
        }
        if (datos[0]['j2'] != '') {
            $('#p2').prop("disabled", true);
            $('#p2').val(datos[0]['j2']);
        } else {
            $('#p2').prop("disabled", false);
            $('#p2').val('');
        }
        if (datos[0]['j3'] != '') {
            $('#p3').prop("disabled", true);
            $('#p3').val(datos[0]['j3']);
        } else {
            $('#p3').prop("disabled", false);
            $('#p3').val('');
        }
        if (datos[0]['j4'] != '') {
            $('#p4').prop("disabled", true);
            $('#p4').val(datos[0]['j4']);
        } else {
            $('#p4').prop("disabled", false);
            $('#p4').val('');
        }
    }

    // Evento click de confirmar en el modal para añadir jugadores
    $('#confirmar').click(function (e) {
        var accion = "setParticipantes";
        var id_reserva = $("#confirmar").attr('data-id-reserva');
        var j1 = $('#p1').val();
        var j2 = $('#p2').val();
        var j3 = $('#p3').val();
        var j4 = $('#p4').val();
        var datos = {
            accion: accion,
            id_reserva: id_reserva,
            j1: j1,
            j2: j2,
            j3: j3,
            j4: j4
        };
        var url = location.origin + "/padel/modules/reservations/reservations.api.php";
        $.post(url, datos, function (respuesta) {
            // La función de devolución de llamada maneja la respuesta del servidor
            location = location;
        }, 'json');
    });

    // Evento click de confirmar en el modal para borrar reserva
    $('#confirmar-borrado').click(function (e) {
        var id_reserva = $("#confirmar-borrado").attr('data-id-reserva');
        var accion = "delReserva";
        var datos = {
            accion: accion,
            id_reserva: id_reserva,
        };
        var url = location.origin + "/padel/modules/reservations/reservations.api.php";
        $.post(url, datos, function (respuesta) {
            // La función de devolución de llamada maneja la respuesta del servidor
            location = location;
        }, 'json');
    });

    // Llamar por primera vez al cargar la página
    obtenerHorarioAPI($('#fecha').val());

    // Agregar evento click a los botones de borrar reserva
    agregarEventoClickBorrar();

}