var BASE_URL = "http://localhost:8000/";

$.getJSON(BASE_URL+"api/v1/hotels",function(data){
    $.each(data,function(key,value){
        $('#hotels').append('<option value=' + value.id + '>' + value.nombre + '</option>');
    });
});

$("#hotels").change(function() {
    $('#reservations').html('');
    $.getJSON(BASE_URL+"api/v1/reservas/hotel/"+this.value,function(data){
        $.each(data,function(key,value){
            $('#reservations').append('<tr> <td>'+value.fecha+'</td> <td>'+value.codigo+'</td> <td>'+value.precio+'</td> <td>'+value.entrada+'</td> <td>'+value.salida+'</td> <td>'+value.estado+'</td> </tr>');
        });
    });
});

$(document).on('submit', '#reservas', function (e) {
    e.preventDefault();
    alert("hotel mundo");
    codeReservation = $("#focusedinput").val();

    $.ajax({
        url: 'http://127.0.0.1:8001/reservas/code/' + codeReservation,
        type: 'GET',
        data: null,
        async: true,
        cache: false,
        contentType: false,
        processData: false,
    }).done(function (datos) {
        rooms += "<div class=\"w3l-footer\">\n" +
            "    <div class=\"container\">\n" +
            "        <div class=\"connect-agileits newsletter\">\n" +
            "            <h4>Confirmation Report</h4>\n" +
            "            <p>Condirmation of the reservation code with the pin of the hotel.</p>\n" +
            "            <form id='resconfirm' action=\"#\" method=\"post\" class='form-horizontal'>\n" +
            "                    <div class='form-group'>\n" +
            "                    <label for='focusedinput' class='col-sm-2 control-label'><p>PIN</p></label>\n" +
            "                        <div class='col-sm-8'>\n" +
            "                            <input disabled=\"\" type='hidden' class='form-control1' id='inputidreserva' placeholder='Default Input' value='" + datos[0]["id"] + "'>\n" +

            "                            <input disabled=\"\" type='text' class='form-control1' id='focusedinput' placeholder='Default Input' value='" + datos[0]["habitacion"]["hotel"]["pin"] + "'>\n" +
            "                        </div>\n" +
            "                    </div><br>\n" +
            "                    <div class='form-group'>\n" +
            "                    <label for='focusedinput' class='col-sm-2 control-label'><p>Nombre</p></label>\n" +
            "                        <div class='col-sm-8'>\n" +
            "                            <input disabled=\"\" type='text' class='form-control1' id='focusedinput' placeholder='Default Input' value='" + datos[0]["habitacion"]["hotel"]["nombre"] + "'>\n" +
            "                        </div>\n" +
            "                    </div><br>\n" +
            "                    <div class='form-group'>\n" +
            "                    <label for='focusedinput' class='col-sm-2 control-label'><p>Habitación No</p></label>\n" +
            "                        <div class='col-sm-8'>\n" +
            "                            <input disabled=\"\" type='text' class='form-control1' id='focusedinput' placeholder='Default Input' value='" + datos[0]["habitacion"]["id"] + "'>\n" +
            "                        </div>\n" +
            "                    </div><br>\n" +
            "                <input type='submit' class='submit' value='Confirm'>\n" +
            "            </form>\n" +
            "        </div>\n" +
            "    </div>\n" +
            "</div>";
        $("#rooms").html(rooms);

    }).fail(function (jqXHR, textStatus, errorThrown) {
        if (jqXHR.status == "400") {
            swal("Error", "No exsite la reserva en el hotel", "error");
        } else if (jqXHR.status == "401") {
            swal("Error", "No exsite la reserva en el hotel", "error");
        } else {
            swal("Error", "No exsite la reserva en el hotel", "error");
        }
    }).always(function (datos) {

    });


});

$(document).on('submit', '#resconfirm', function (e) {
    e.preventDefault();
    alert("hoal")
    idReserva = $("#inputidreserva").val();
    $.ajax({
        url: 'http://127.0.0.1:8001/reservas/' + idReserva + '/update',
        type: 'GET',
        data: null,
        async: true,
        cache: false,
        contentType: false,
        processData: false,
    }).done(function (jqXHR, textStatus, xhr) {
        var rooms = "";
        swal("Inform", "Confirm reservation!!! ", "success");
        $("#rooms").html(rooms);
    }).fail(function (jqXHR, textStatus, errorThrown) {
        if (jqXHR.status == "400") {
            swal("Error", "No exsite la reserva en el hotel", "error");
        } else if (jqXHR.status == "401") {
            swal("Error", "No exsite la reserva en el hotel", "error");
        } else {
            swal("Error", "No exsite la reserva en el hotel", "error");
        }
    })


});