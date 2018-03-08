$(document).ready(function() {
    //   $('#formInscripcion').click('submit', validar);

    // $('#send').on('click', function(evento) {
    //     evento.preventDefault();
    //     validar();

    // });

    $('#remove').on('click', function(evento) {

        swal({
            title: '¿Quieres borrar todos los datos?',
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Si',
            cancelButtonText: 'No'
        }).then((result) => {
            if (result.value) {
                swal(
                    'Borrado',
                    '',
                    'success'
                )
                evento.preventDefault();
                return true;
            }
        })

    });

    $('#email, #postalcode, #name, #surname, #tin, #province, #location, #address').after(function() {
        var idError = $(this).attr('id') + "error";
        var insertarSpan = "<span id=" + idError + ">" + "" + "</span>";
        return insertarSpan;
    });


    $('#send').on('click', function(evento) {
        var vEmail = validarCorreo($('#email'));
        var vCodPostal = validarCodPostal($('#postalcode'));
        var vNombre = validarLongitud($('#name'), 3);
        var vApellidos = validarLongitud($('#surname'), 3);
        var vDni = validarDni($('#tin'));
        var vProvincia = validarLongitud($('#province'), 0);
        var vPoblacion = validarLongitud($('#location'), 0);
        var vDireccion = validarLongitud($('#address'), 0);
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
        var dni = $('#tin').val();
        var letras = ['T', 'R', 'W', 'A', 'G', 'M', 'Y', 'F', 'P', 'D', 'X', 'B', 'N', 'J', 'Z', 'S', 'Q', 'V', 'H', 'L', 'C', 'K', 'E', 'T'];

        if (!(/^\d{8}[a-zA-Z]$/).test(dni)) {
            mostrarError.text("formato erroneo").css("color", "red");
            valido = false;
        }
        else {
            if (dni.charAt(8).toUpperCase() != letras[(dni.substring(0, 8)) % 23]) {
                mostrarError.text("dni erroneo").css("color", "red");;
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
        var correo = $('#email').val();

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

    function validarProvincia(campo) {
        var mostrarError = mensajeError(campo);
        var valido = true;

        var provincia = $('#provincia').val();

        if (provincia == "") {
            valido = false;
            mostrarError.text("campo requerido").css("color", "red");
        }
        else {
            mostrarError.text("");
        }
        return valido;

    }

    function validarLongitud(campo, min) {
        var valido = true;
        var mostrarError = mensajeError(campo);
        var valor = campo.val().trim();

        if (valor == "") {
            mostrarError.text("campo requerido").css("color", "red");;
            valido = false;
        }
        else if (valor.length < min) {
            mostrarError.text("solo minimo " + min + " caracteres").css("color", "red");;
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
            mostrarError.text("campo requerido").css("color", "red");;
            valido = false;
        }
        else if (!patronPostal.test(valor)) {
            mostrarError.text("solo formato 5 digitos numericos").css("color", "red");;
            valido = false;
        }
        else {
            mostrarError.text("");
        }
        return valido;
    };

});
