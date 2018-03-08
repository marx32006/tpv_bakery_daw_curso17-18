$(document).ready(function() {
    //   $('#formInscripcion').click('submit', validar);

    // $('#send').on('click', function(evento) {
    //     evento.preventDefault();
    //     validar();

    // });

    // $('#removeProduct').on('click', function(evento) {
    //     if (!confirm('¿Quieres borrar todos los datos?')) {
    //         evento.preventDefault();
    //     }
    // });

    $('#product2, #description2, #price2, #foto2, #idfamily2').after(function() {
        var idError = $(this).attr('id') + "error";
        var insertarSpan = "<span id=" + idError + ">" + "" + "</span>";
        return insertarSpan;
    });


    $('#sendProduct2').on('click', function(evento) {
        var vNombreProducto = validarLongitud($('#product2'), 3);
        var vPrecio = validarPrecio($('#price2'));
        var vDescripcion = validarLongitud($('#description2'),3);
       // var vFichero = validarFichero($('#foto2'));
        var vFamilia = validarFamilia($('#idfamily2'));
        if (vNombreProducto && vPrecio && vDescripcio && vFamilia ) {}
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
            } else {
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
            for(var i=0;i<precio.length;i++){
                if(isNaN(precio.charAt(i))){
                     valido = false;
                   mostrarError.text("numero requerido").css("color", "red");
                }else{
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
        var seleccionFamilia = $( "#idfamily2 option:selected" ).text();
            
        if(!seleccionFamilia){
            mostrarError.text("no has seleccionado familia").css("color", "red");
            valido = false;
        }else{
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
