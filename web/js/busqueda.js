var url_= BASE_URL+"api/v1/";
$(document).on('submit', '#search-room', function (e) {
    e.preventDefault();

    ingreso = $("#hour-search option:selected").val();
    var fecha = $("#datepicker").val();
    if ("yyyy/mm/dd" == fecha) {
        swal("Seleccione una fecha");
    } else {
        $.ajax({
            url: url_+'habitaciones',
            type: 'GET',
            data: $(this).serialize(),
            async: true,
            cache: false,
            contentType: false,
            processData: false,
            beforeSend:function (xhr) {
                var rooms = "<h3>Cargando Habitaciones...</h3>";
                $("#rooms").html(rooms);
            }

        }).done(function (datos, textStatus, xhr) {
            var rooms = "";
            $.each(datos, function (i, habitaciones) {
                rooms += "<div class='col-md-12 table-bordered'>";
                rooms += "<div class='col-md-3 col-lg-3'><img src='https://www.samanahotel.com.pe/images/habitacion-simple1.jpg' class='img-responsive'></div>"
                rooms += "<div class='col-md-9 col-lg-9'>";
                rooms += "<div class='col-md-12'>";
                rooms += "<h3>Tipo de habitación: sencilla</h3>"
                rooms += "</div>";
                rooms += "<div class='col-md-12'>";
                rooms += "<h3>Disponible: " + habitaciones.entrada + ":00H -" + habitaciones.salida + ":00H</h3>"
                rooms += "</div>";
                rooms += "<div class='col-md-12'>";
                rooms += "<h3>Costo: €" + habitaciones.habitacion.precio + " por hora</h3>"
                rooms += "</div>";
                rooms += "<div class='col-md-12' ><button class='btn-danger btn habitaciones' id='" + habitaciones.habitacion.id + "' title='" + fecha + "' name='" + ingreso + "' type='"+habitaciones.salida+"'  data-toggle='modal' data-target='#myModal'>Reservar</button></div>";
                rooms += "</div>";
                rooms += "</div>";
            });
            $("#rooms").html(rooms);
        }).fail(function (jqXHR, textStatus, errorThrown) {
            var rooms = "";
            $("#rooms").html(rooms);
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
    $("#maxdisponible").val($(this).attr("type"));


});

$(document).on('submit', '#reserva', function (e) {
    e.preventDefault();

    var $this = $(this);
    var email = $("#username").val();
    if(validarEmail(email)) {
        $("#loading").show();
        $.ajax({
            url: url_ + 'users',
            type: 'POST',
            data: new FormData($this[0]),
            async: true,
            cache: false,
            contentType: false,
            processData: false,
        }).done(function (datos, textStatus, xhr) {
            addReserva($this, datos);
        }).fail(function (jqXHR, textStatus, errorThrown) {
            $("#loading").hide();
            if (jqXHR.status == "406") {
                swal("", jqXHR.responseText.replace(/["]+/g, ''), "info");
            }
            else {
                swal("", "Error de conexión", "error");
            }
        })
    } else {
        swal("", "El email no es correto", "info");
    }

});

function addReserva($this, usuario) {
    var formData = new FormData($this[0]);
    formData.append("usuario", usuario);
    $.ajax({
        url: url_+'reservas',
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
        swal("", "Reserva agregada con éxito", "success");
        $("#loading").hide();
    }).fail(function (jqXHR, textStatus, errorThrown) {
        $("#loading").hide();
        if (jqXHR.status == "406") {
            swal("", jqXHR.responseText.replace(/["]+/g, ''), "info");
        }
        else {
            swal("", "Reserva no realizada", "error");
        }
    })
}

function validarEmail( email )
{
    var regex = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
    return regex.test(email) ? true : false;
}