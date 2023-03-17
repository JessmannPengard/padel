// Lógica para marcar o desmarcar las horas
function marcar(me) {
    if (!me.parentNode.classList.contains('reservado') && !me.parentNode.classList.contains('tit-pista')) {
        if (me.parentNode.classList.contains('disponible')) {
            me.parentNode.classList.remove('disponible');
            me.parentNode.classList.add('seleccionado');
        } else {
            if (!me.parentNode.classList.contains('incompleto')) {
                me.parentNode.classList.remove('seleccionado');
                me.parentNode.classList.add('disponible');
            } else {
                // Añadimos el id de reserva al botón confirmar del modal
                $('#confirmar').attr('data-id-reserva', me.parentNode.attributes['data-id-reserva'].value);
                // Añadir participantes al modal
                obtenerDatosAPIJugadores(me.parentNode.attributes['data-id-reserva'].value);
            }
        }
    }
};

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

// Añadir jugadores
function anhadirJugadores() {
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
}

window.onload = () => {

    // Lógica para controlar los botones de borrar reserva
    function agregarEventoClickBorrar() {
        $('.eliminar-reserva').click(function () {
            // Añadimos el id de reserva al botón borrar del modal
            $('#confirmar-borrado').attr('data-id-reserva', $(this).attr('data-id-reserva'));
        });
    }

    // Agregar las horas y las pistas seleccionadas al enviar el formulario
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

    // Función que obtiene las horas y pistas seleccionadas
    function obtenerHorasSeleccionadas() {
        let horas = [];
        $('table tr td').each(function () {
            if ($(this).hasClass('seleccionado')) {
                horas.push($(this).attr('id') + '/' + $(this).attr('data-id-pista'));
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
            pistas.sort();
            pistas.forEach(pista => {
                var accion = "getReservas";
                var id_pista = pista['id'];
                var datos = {
                    accion: accion,
                    fecha: fecha,
                    id_pista: id_pista
                };
                var url = location.origin + "/padel/modules/reservations/reservations.api.php";
                $.post(url, datos, function (response) {
                    // La función de devolución de llamada maneja la respuesta del servidor
                    pintarHorario(response, pista);
                }, 'json');
            });
        }, 'json');
    }

    // Obtener datos al cambiar la fecha
    $('#fecha').change(function () {
        // La función que se ejecuta cuando cambia el input fecha
        obtenerHorarioAPI($('#fecha').val(), $('#id_pista').val());
    });

    // Pintar el horario según los datos obtenidos de la API
    function pintarHorario(datos, pista) {
        var clase = "";
        var html = "<tr><td class='tit-pista'>" + pista['nombre'] + "<img class='pic-pista' src='"+pista['url_imagen']+"'></img></td>";

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
            html += '<td class="' + clase + '" id="' + element['id'] + '"data-id-reserva="' + element['id_reserva'] + '"data-id-pista="' + pista["id"] + '"><button class="btn-celda" type="button" onclick="marcar(this)">' + contenido + '</button></td>';

        });
        html += "</tr>";
        $('#seleccion').append(html);
    }




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