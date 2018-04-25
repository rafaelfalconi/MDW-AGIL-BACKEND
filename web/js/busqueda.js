$(document).on('submit', '#search-room', function (e) {
    e.preventDefault();

    ingreso = $("#hour-search option:selected").val();
    var fecha = $("#datepicker").val();
    if ("yyyy/mm/dd" == fecha) {
        swal("Seleccione una fecha");
    } else {
        $.ajax({
            url: 'http://127.0.0.1:8000/api/v1/habitaciones',
            type: 'GET',
            data: $(this).serialize(),
            async: true,
            cache: false,
            contentType: false,
            processData: false,
        }).done(function (datos, textStatus, xhr) {
            var rooms = "";
            $.each(datos, function (i, habitaciones) {
                tiempo = (parseInt(habitaciones.entrada));
                tiempoEntrada=parseInt(habitaciones.salida)+2
                rooms += "<div class='col-md-12 table-bordered'>";
                rooms += "<div class='col-md-3 col-lg-3'><img src='http://www.samanahotel.com.pe/images/habitacion-simple1.jpg' class='img-responsive'></div>"
                rooms += "<div class='col-md-9 col-lg-9'>";
                rooms += "<div class='col-md-12'>";
                rooms += "<h3>Tipo de habitación: sencilla</h3>"
                rooms += "</div>";
                rooms += "<div class='col-md-12'>";
                console.log(tiempoEntrada+" "+parseInt(ingreso));
                if (parseInt(ingreso) == parseInt(habitaciones.entrada)) {
                    rooms += "<h3>No Disponible</h3>"
                } else if (24 == parseInt(habitaciones.entrada)) {
                    rooms += "<h3>Disponible: " + ingreso + ":00H -" + tiempo + ":00H</h3>"
                } else if (parseInt(habitaciones.salida) >= parseInt(ingreso)) {
                    rooms += "<h3>No Disponible</h3>"
                } else if(tiempoEntrada <= parseInt(ingreso)){
                    let ingresoRoom = 0;
                    rooms += "<h3>Disponible: " + ingreso + ":00H -" + tiempo + ":00H</h3>"
                }else{
                    rooms += "<h3>No Disponible</h3>"
                }
                rooms += "</div>";
                rooms += "<div class='col-md-12'>";
                rooms += "<h3>Costo: €" + habitaciones.habitacion.precio + " por hora</h3>"
                rooms += "</div>";
                if (parseInt(ingreso) == parseInt(habitaciones.entrada)) {
                    rooms += "<div class='col-md-12' ></div>";
                } else if (24 == parseInt(habitaciones.entrada)) {
                    rooms += "<div class='col-md-12' ><button class='btn-danger btn habitaciones' id='" + habitaciones.habitacion.id + "' title='" + fecha + "' name='" + ingreso + "' data-toggle='modal' data-target='#myModal'>Reservar</button></div>";
                } else if (parseInt(habitaciones.salida) >= parseInt(ingreso)) {
                    rooms += "<div class='col-md-12' ></div>";
                } else if(tiempoEntrada <= parseInt(ingreso)){
                    rooms += "<div class='col-md-12' ><button class='btn-danger btn habitaciones' id='" + habitaciones.habitacion.id + "' title='" + fecha + "' name='" + ingreso + "' data-toggle='modal' data-target='#myModal'>Reservar</button></div>";
                }else{
                    rooms += "<div class='col-md-12' ></div>";
                }

                rooms += "</div>";
                rooms += "</div>";
            });
            $("#rooms").html(rooms);
        }).fail(function (jqXHR, textStatus, errorThrown) {
            if (jqXHR.status == "400") {
                swal("No hay habitaciones disponibles");
            } else if (jqXHR.status == "401") {
                swal("No hay habitaciones disponibles");
            } else {
                swal("No hay habitaciones disponibles");
            }
        }).always(function (datos) {

        });
    }


});


$('#rooms').on("click", '.habitaciones', function () {
    $("#habitacion").val($(this).attr("id"));
    $("#fecha").val($(this).attr("title"));
    $("#entrada").val($(this).attr("name"));
});

$(document).on('submit', '#reserva', function (e) {
    e.preventDefault();
    var $this = $(this);

    $.ajax({
        url: 'http://127.0.0.1:8000/user',
        type: 'POST',
        data: new FormData($this[0]),
        async: true,
        cache: false,
        contentType: false,
        processData: false,
    }).done(function (datos, textStatus, xhr) {
        addReserva($this, datos);
    }).fail(function (jqXHR, textStatus, errorThrown) {
        if (jqXHR.status == "406") {
            swal("Alerta", jqXHR.responseText.replace(/["]+/g, ''), "info");
        }
        else {
            swal("Error", "Error de conexión", "error");
        }
    })

});

function addReserva($this, usuario) {
    var formData = new FormData($this[0]);
    formData.append("usuario", usuario);
    $.ajax({
        url: 'http://127.0.0.1:8000/reserva',
        type: 'POST',
        data: formData,
        async: true,
        cache: false,
        contentType: false,
        processData: false,
    }).done(function (datos, textStatus, xhr) {
        $("#rooms").html('');
        $('#myModal').modal('toggle');
        $('#reserva')[0].reset();
        swal("Buen trabajo!", "Reserva agregada con éxito", "success");
    }).fail(function (jqXHR, textStatus, errorThrown) {
        if (jqXHR.status == "406") {
            swal("Alerta", jqXHR.responseText.replace(/["]+/g, ''), "info");
        }
        else {
            swal("Error", "Reserva no realizada", "error");
        }
    })
}