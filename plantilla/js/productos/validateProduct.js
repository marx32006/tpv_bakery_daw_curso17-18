$(document).ready(function() {
    //   $('#formInscripcion').click('submit', validar);

    // $('#send').on('click', function(evento) {
    //     evento.preventDefault();
    //     validar();

    // });

    $('#removeProduct').on('click', function(evento) {
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

    $('#product3, #description3, #price3, #foto3, #idfamily3').after(function() {
        var idError = $(this).attr('id') + "error";
        var insertarSpan = "<span id=" + idError + "></span>";
        return insertarSpan;
    });


    $('#sendProduct').on('click', function(evento) {
        var vNombreProducto = validarLongitud($('#product3'), 3);
        var vPrecio = validarPrecio($('#price3'));
        var vDescripcion = validarLongitud($('#description3'), 3);
        //  var vFichero = validarFichero($('#foto'));
        var vFamilia = validarFamilia($('#idfamily3'));
        if (vNombreProducto && vPrecio && vDescripcion && vFamilia) {}
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


    function validarFichero(campo) {
        var mostrarError = mensajeError(campo);
        var valido = true;
        var fichero = campo;
        if (!fichero.val()) {
            mostrarError.text(" No has seleccionado foto").css("color", "red");
            valido = false;
        }
        else {
            mostrarError.text("");
            valido = true;
        }
        return valido;
    }

    function validarPrecio(campo) {
        var mostrarError = mensajeError(campo);
        var valido = true;
        var validarNumero = true;
        var validarCampo = true;

        var precio = campo.val();

        if (precio == "") {
            valido = false;
            mostrarError.text("campo requerido").css("color", "red");
        }
        else {
            for (var i = 0; i < precio.length; i++) {
                if (isNaN(precio.charAt(i))) {
                    valido = false;
                    mostrarError.text("numero requerido").css("color", "red");
                }
                else {
                    valido = true;
                    mostrarError.text("");
                }
            }
        }
        return valido;
    }

    function validarFamilia(campo) {
        var valido = true;
        var mostrarError = mensajeError(campo);
        var seleccionFamilia = $("#idfamily3 option:selected").text();

        if (!seleccionFamilia) {
            mostrarError.text("no has seleccionado familia").css("color", "red");
            valido = false;
        }
        else {
            mostrarError.text("");
            valido = true;
        }
        return valido;
    }

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


});
