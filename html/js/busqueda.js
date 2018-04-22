$(document).on('submit', '#search-room', function (e) {
    e.preventDefault();
    var myObject = new Object();
    ingreso = $("#hour-search option:selected").val();
    myObject.hora = ingreso;
    var str = $("#datepicker").val();
    var res = str.split("/");
    fecha = res[2] + "-" + res[0] + "-" + res[1];

    $.ajax({
        url: 'http://127.0.0.1:8000/habitaciones?fecha='+fecha+'&hora='+ingreso,
        type: 'GET',
        data: null,
        async: true,
        cache: false,
        contentType: false,
        processData: false,
    }).done(function (datos, textStatus, xhr) {
        var rooms = "";
        $.each(datos, function (i, habitaciones) {
            console.log(datos)
            console.log(habitaciones.habitacion.id + " " + habitaciones.salida);
            tiempo = ((parseInt(habitaciones.salida) + 2));
            costo = (tiempo-ingreso) * habitaciones.habitacion.precio;
            tiempo = ((parseInt(habitaciones.salida) + 2)-ingreso);
            rooms += "<div class='col-md-12 table-bordered'>";
            rooms += "<div class='col-md-3 col-lg-3'><img src='http://www.samanahotel.com.pe/images/habitacion-simple1.jpg' class='img-responsive'></div>"
            rooms += "<div class='col-md-9 col-lg-9'>";
            rooms += "<div class='col-md-12'>";
            rooms += "<h3>Tipo de habitación: sencilla</h3>"
            rooms += "</div>";
            rooms += "<div class='col-md-12'>";
            rooms += "<h3>Horas disponibles: " + tiempo+"</h3>"
            rooms += "</div>";
            rooms += "<div class='col-md-12'>";
            rooms += "<h3>Costo: €" + costo+"</h3>"
            rooms += "</div>";
            rooms += "<div class='col-md-12' ><button class='btn-danger btn habitaciones' id='" + habitaciones.habitacion.id + "' title='"+fecha+"' name='"+ingreso+"' data-toggle='modal' data-target='#myModal'>Reservar</button></div>";
            rooms += "</div>";
            rooms += "</div>";
        });
        $("#rooms").html(rooms);
    }).fail(function (jqXHR, textStatus, errorThrown) {
        if (jqXHR.status == "400") {
            swal("Error", "No hay habitaciones disponibles", "error");
        } else if (jqXHR.status == "401") {
            swal("Error", "No hay habitaciones disponibles", "error");
        } else {
            swal("Error", "No hay habitaciones disponibles", "error");
        }
    }).always(function (datos) {

    });


});


$('#rooms').on("click",'.habitaciones', function(){
	$("#habitacion").val($(this).attr("id"));
	$("#fecha").val($(this).attr("title"));
	$("#entrada").val($(this).attr("name"));
});

$(document).on('submit', '#reserva', function (e) {
    e.preventDefault();
	var $this = $(this);
    $.ajax({
        url: 'http://127.0.0.1:8000/api/v1/reservation',
        type: 'POST',
        data: new FormData($this[0]),
        async: true,
        cache: false,
        contentType: false,
        processData: false,
    }).done(function (datos, textStatus, xhr) {
		swal("Good job!", "Reserve Added Successfully", "success");
    }).fail(function (jqXHR, textStatus, errorThrown) {
        if (jqXHR.status == "406") {
            swal("Error", jqXHR.responseText.replace(/["]+/g, ''), "error");
        }
         else {
            swal("Error", "unrealized reservation", "error");
        }
    })
	
});