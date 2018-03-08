$(document).ready(function() {

    $('#removeMember').on('click', function(evento) {
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

    $('#newMember, #newPassword, #newPasswordVerify').after(function() {
        var idError = $(this).attr('id') + "error";
        var insertarSpan = "<span id=" + idError + ">" + "" + "</span>";
        return insertarSpan;
    });

    $('#sendMember').on('click', function(evento) {
        var vMember = validarLongitud($('#newMember'), 3);
        var vPassword = validarLongitud($('#newPassword'), 5);
        var vPassword2 = validarPassword2($('#newPasswordVerify'), 6);

        if (vMember && vPassword && vPassword2) {}
        else {
            //  alert("revisar los datos");
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

    function validarPassword(campo) {
        var mostrarError = mensajeError(campo);
        var valido = true;
        var password = $('#password').val();

        if (password == "") {
            valido = false;
            mostrarError.text("campo requerido").css("color", "red");
        }
        else {
            mostrarError.text("");
        }
        return valido;
    }

    function validarPassword2(campo) {
        var mostrarError = mensajeError(campo);
        var valido = true;
        var password = $('#newPassword').val();
        var password2 = campo.val();

        if (password != password2) {
            valido = false;
            mostrarError.text("No coinciden las dos contraseñas").css("color", "red");
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
