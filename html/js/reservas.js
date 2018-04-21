// Empty JS for your own code to be here
//Variables globales

var REQUEST_ESTATUS;
var READY_STATE;
var http_request = new XMLHttpRequest();
var urlPage;
var uname;
var pass;
( function( window ) {

    //Variables globales
    // --TODO CAMBIAR A LOGOUT
    REQUEST_ESTATUS = [
        {code: 200, status: 'OK', respuesta: "Token de seguridad"},
        {code: 400, status: 'Bad Request', respuesta: 'No username or password'},
        {code: 401, Status: 'Unauthorized', respuesta: "Wrong user or password"}
    ];
    READY_STATE = [
        {code: 1, respuesta: "Open"},
        {code: 2, respuesta: "Headers received"},
        {code: 3, respuesta: "Load"},
        {code: 4, respuesta: "Completed"},
    ]
    alert("hola");
    // Router page
    $('a').on('click', function (e) {

        // Evitar que se ejecute el evento por defecto que nos lleve a la pagina, pero nosotros no deseamos esto.
        // necesitamos solo que nos realiza la peticion mediante este evento y ejecute esta funcion
        e.preventDefault();
        var routerPage = $(this).attr('href');
        callPage(routerPage);
    });




    function callPage(routerPageInput) {
        var http_request = new XMLHttpRequest();
        var url = routerPageInput;
        urlPage = url;
        http_request.open("GET", url, true);
        http_request.responseType = 'text';
        http_request.onload = TrataRespuesta;
        http_request.send();
        function TrataRespuesta() {
            if (http_request.readyState == READY_STATE[3]["code"]) {
                var Respuesta;
                if (http_request.status == REQUEST_ESTATUS[0]["code"]) {
                    Respuesta = http_request.response;
                    if (urlPage == "confirm-reservation.html") {
                        document.getElementById("contenidos").innerHTML = Respuesta;
                        mapaInstalaciones();
                    } else if (urlPage == "inicio.html") {
                        document.getElementById("contenidos").innerHTML = Respuesta;

                    } else if (urlPage == "login.html") {
                        document.getElementById("contenidos").innerHTML = Respuesta;

                    } else if (urlPage == "register.html") {
                        document.getElementById("contenidos").innerHTML = Respuesta;

                    } else {
                        window.location = "index.html";
                        // document.getElementById("contenidos").innerHTML = Respuesta;
                    }
                }
                else
                    alert("Ocurrio un problema con la URL.");
            }
        }
    }

    //GET parametros urlencode

    function $_GET(q, s) {
        s = s ? s : window.location.search;
        var re = new RegExp('&' + q + '(?:=([^&]*))?(?=&|$)', 'i');
        return (s = s.replace(/^[?]/, '&').match(re)) ? (typeof s[1] == 'undefined' ? '' : decodeURIComponent(s[1])) : undefined;
    }





    $(document).on("click", '#logout', function (e) {
        if (sessionStorage.getItem('tokenTour')) {
            sessionStorage.clear();
            window.location = "index.html";
        } else {
            window.location = "index.html";
        }

    })

})( window );



$(document).on('submit', '#form', function (e) {
    e.preventDefault();

    //Save Parametros GET locales Authoritation
    uname = document.getElementById("uname").value;
    pass = document.getElementById("psw").value;
    // var url = "http://fenw.etsisi.upm.es/login?userid=" + uname + "&password=" + pass;
    var url = "http://salonso.etsisi.upm.es/fenw/padel/login.php?userid=" + uname + "&password=" + pass;
    http_request.open("GET", url, true);
    http_request.responseType = 'json';
    http_request.onload = RequestLocalStorage;
    http_request.send()

    //Save session storage token
    function RequestLocalStorage() {
        var Respuesta;
        if (http_request.status == REQUEST_ESTATUS[0]["code"]) {
            Respuesta = http_request.response;
            sessionStorage.setItem("tokenTour", Respuesta);
            sessionStorage.setItem("uname", uname);
            sessionStorage.setItem("psw", pass);
            window.location = "index.html";

        }
        else
            alert("Ocurrio un problema con la URL.");
    }


})










