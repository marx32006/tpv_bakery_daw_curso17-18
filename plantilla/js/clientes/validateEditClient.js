$(document).ready(function() {
    //   $('#formInscripcion').click('submit', validar);

    // $('#send').on('click', function(evento) {
    //     evento.preventDefault();
    //     validar();

    // });

    // $('#remove2').on('click', function(evento) {
    //     if (!confirm('¿Quieres borrar todos los datos?')) {
    //         evento.preventDefault();
    //     }
    // });

    $('#email2, #postalcode2, #name2, #surname2, #tin2, #province2, #location2, #address2').after(function() {
        var idError = $(this).attr('id') + "error";
        var insertarSpan = "<span id=" + idError + ">" + "" + "</span>";
        return insertarSpan;
    });


    $('#send2').on('click', function(evento) {
        var vEmail = validarCorreo($('#email2'));
        var vCodPostal = validarCodPostal($('#postalcode2'));
        var vNombre = validarLongitud($('#name2'), 3);
        var vApellidos = validarLongitud($('#surname2'), 3);
        var vDni = validarDni($('#tin2'));
        var vProvincia = validarLongitud($('#province2'),0);
        var vPoblacion = validarLongitud($('#location2'),0);
        var vDireccion = validarLongitud($('#address2'),0);
        if (vNombre && vApellidos && vDni && vEmail && vCodPostal && vProvincia && vPoblacion && vDireccion) {}
        else {
             swal(
                'Revisar los datos!',
                '',
                'warning'
            )
            evento.preventDefault();
        }
    });

    function mensajeError(campo) {
        var atributoId = campo.attr('id') + "error";
        var localizarId = $('#' + atributoId);
        return localizarId;
    };

    function validarDni(campo) {
        var mostrarError = mensajeError(campo);
        var valido = true;
        var dni = $('#tin2').val();
        var letras = ['T', 'R', 'W', 'A', 'G', 'M', 'Y', 'F', 'P', 'D', 'X', 'B', 'N', 'J', 'Z', 'S', 'Q', 'V', 'H', 'L', 'C', 'K', 'E', 'T'];

        if (!(/^\d{8}[a-zA-Z]$/).test(dni)) {
            mostrarError.text("formato erroneo");
            valido = false;
        }
        else {
            if (dni.charAt(8).toUpperCase() != letras[(dni.substring(0, 8)) % 23]) {
                mostrarError.text("dni erroneo");
                valido = false;
            }
            else {
                mostrarError.text("");
                valido = true;
            }
        }
        return valido;
    };

    function validarCorreo(campo) {
        var mostrarError = mensajeError(campo);
        var valido = true;
        var correoPatron = /^(([^<>()[\]\.,;:\s@\"]+(\.[^<>()[\]\.,;:\s@\"]+)*)|(\".+\"))@(([^<>()[\]\.,;:\s@\"]+\.)+[^<>()[\]\.,;:\s@\"]{2,})$/i;
        var correo = $('#email2').val();

        if (correo === "") {
            valido = false;
            mostrarError.text("campo requerido").css("color", "red");
        }
        else if (!correoPatron.test(correo)) {
            valido = false;
            mostrarError.text("Escriba bien Correo Electronico").css("color", "red");
        }
        else {
            valido = true;
            mostrarError.text("");
        }
        return valido;
    };


    function validarLongitud(campo, min) {
        var valido = true;
        var mostrarError = mensajeError(campo);
        var valor = campo.val().trim();

        if (valor == "") {
            mostrarError.text("campo requerido").css("color", "red");
            valido = false;
        }
        else if (valor.length < min) {
            mostrarError.text("solo minimo " + min + " caracteres").css("color", "red");
            valido = false;
        }
        else {
            mostrarError.text("");
        }
        return valido;
    }

    function validarCodPostal(campo) {
        var valido = true;
        var mostrarError = mensajeError(campo);
        var valor = campo.val();
        var patronPostal = /^\d{5}$/;
        if (valor == "") {
            mostrarError.text("campo requerido").css("color", "red");
            valido = false;
        }
        else if (!patronPostal.test(valor)) {
            mostrarError.text("solo formato 5 digitos numericos").css("color", "red");
            valido = false;
        }
        else {
            mostrarError.text("");
        }
        return valido;
    };

});
