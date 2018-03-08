$(document).ready(function() {

    // $('#removeMember2').on('click' ,function(evento){
    //     if(!confirm('¿Quieres borrar todos los datos?')){
    //         evento.preventDefault();
    //     }
    // });

    $('#newMember2, #newPassword2').after(function() {
        var idError = $(this).attr('id') + "error";
        var insertarSpan = "<span id=" + idError + ">" + "" + "</span>";
        return insertarSpan;
    });

    $('#sendMember2').on('click', function(evento) {
        var vMember = validarLongitud($('#newMember2'), 3);
        var vPassword = validarLongitud($('#newPassword2'), 5);

        if (vMember && vPassword) {}
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

    // function validarPassword(campo){
    //     var mostrarError = mensajeError(campo);
    //     var valido = true;
    //     var password = $('#password').val();

    //     if(password == ""){
    //         valido = false;
    //         mostrarError.text("No puede dejar en blanco");
    //     }else{
    //         mostrarError.text("Correcto");
    //     }
    //     return valido;
    // }

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

});
