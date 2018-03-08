$(document).ready(function() {


    $('#borrarcliente > tr').find('#borrar').each(function() {
        $(this).on('click', function() {
            var idcliente = $(this).closest('tr').data('id');
            console.log(idcliente);
            var mostrarNombreCliente = $(this).closest('tr').data('name');
            console.log(mostrarNombreCliente);
            //registerTicket(idclient);
            swal({
                title: '¿Estás seguro que quieres eliminar cliente: ' + mostrarNombreCliente,
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Si, eliminalo',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.value) {
                    swal(
                        '¡Eliminado correctamente!',
                        '',
                        'success'
                    )
                    $(this).closest('tr').remove();
            $.ajax({
                url: 'clientajax/doborrarCliente',
                type: 'get',
                dataType: 'json',
                data: {
                    id: idcliente
                }
            }).done(
                function(json) {
                    console.log(json.res);
                }
            ).fail(
                function() {
                    alert('Error borrar cliente');
                }
            );
                }

            })
        });
    });

    $('#borrarProducto > tr').find('#borrar').each(function() {
        $(this).on('click', function() {
            var idproduct = $(this).closest('tr').data('id');
            var mostrarNombreProducto = $(this).closest('tr').data('product');
            //registerTicket(idclient);
            swal({
                title: '¿Estás seguro que quieres eliminar Producto: ' + mostrarNombreProducto,
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Si, eliminalo',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.value) {
                    swal(
                        '¡Eliminado correctamente!',
                        '',
                        'success'
                    )
                    $(this).closest('tr').remove();
                    $.ajax({
                        url: 'productajax/doborrarProducto',
                        type: 'get',
                        dataType: 'json',
                        data: {
                            id: idproduct
                        }
                    }).done(

                    ).fail(
                        function() {
                            alert('Error nueva ticket');
                        }
                    );
                }

            })
        });
    });
    
        $('#borrarMiembro > tr').find('#borrar').each(function() {
        $(this).on('click', function() {
            var idmember = $(this).closest('tr').data('id');
            var mostrarNombreLogin = $(this).closest('tr').data('login');
            //registerTicket(idclient);
            swal({
                title: '¿Estás seguro que quieres eliminar miembro: ' + mostrarNombreLogin,
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Si, eliminalo',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.value) {
                    swal(
                        '¡Eliminado correctamente!',
                        '',
                        'success'
                    )
                    $(this).closest('tr').remove();
                    $.ajax({
                        url: 'memberajax/doremoveMember',
                        type: 'get',
                        dataType: 'json',
                        data: {
                            id: idmember
                        }
                    }).done(

                    ).fail(
                        function() {
                            alert('Error nueva ticket');
                        }
                    );
                }

            })
        });
    });


});
