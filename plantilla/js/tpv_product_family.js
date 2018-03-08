(function() {
    $.ajax({
        url: 'family/getFamilies',
        type: 'get',
        dataType: 'json'
    }).done(
        function(json) {
            var listado = json.listado;
            for (var i = 0; i < listado.length; i++) {
                var li = $('<button type="button" class="btn btn-dark" data-id="' + listado[i].id + '">' + listado[i].family + '</button> ');
                insertEvent(listado[i].id, li);
                $('#listFamily').append(li);
            }
        }
    ).fail(
        function() {
            alert('Error listado de familias');
        }
    );

    function insertEvent(id, line) {
        line.on('click', function(e) {
            idfamily = id;
            getAllProductFamily(idfamily);
        });
    }


    function getAllProductFamily(idfamily) {
        $.ajax({
            url: 'productajax/getLimitProductsAjax',
            type: 'get',
            dataType: 'json',
            data: {
                idfamily: idfamily
            }
        }).done(
            function(json) {
                if ($('#listProduct').length > 0) {
                    $('#listProduct').text('');
                }
                var listado = json.listado;
                for (var i = 0; i < listado.length; i++) {
                    console.log(listado[i]);
                    var li = $('<li class = "pbox" data-id="' +
                        listado[i].id + '"><div>' +
                        listado[i].product +
                        '</div><div><img style="width: 150px;" src="product/viewPhotoAndPhotoDefault&idPhoto=' + listado[i].id + '.jpg"></div></li>');
                    $('#listProduct').append(li);

                    li.on('click', addProductTable2);
                }
            }

        ).fail(
            function() {
                alert('Error listado de productos');
            }
        );
    }

    /* --- pulsa para ver todos productos --*/
    $('#showProductAllTPV').on('click', function() {
        getAllProductShowTPV();
    });

    /*---- mostrar la lista de productos -- en TPV --*/
    getAllProductShowTPV();

    function getAllProductShowTPV() {
        $.ajax({
            url: 'productajax/getProductsAjax',
            type: 'get',
            dataType: 'json',
        }).done(
            function(json) {
                if ($('#listProduct').length > 0) {
                    $('#listProduct').text('');
                }
                var listado = json.listado;
                for (var i = 0; i < listado.length; i++) {
                    var li = $('<li class = "pbox" data-id="' + listado[i].id + '"><div>' + listado[i].product + '</div><div><img style="width: 150px;"src="product/viewPhotoAndPhotoDefault&idPhoto=' + listado[i].id + '.jpg"></div></li>');
                    $('#listProduct').append(li);

                    li.on('click', addProductTable2);
                }
            }
        ).fail(
            function() {
                alert('Error listado de productos');
            }
        );
    }
    
    function addProductTable2(event) {
        event.preventDefault();
        var id = $(this).attr('data-id');

        $.ajax({
            url: 'ticketajax/getProductPorId',
            type: 'get',
            dataType: 'json',
            data: {
                idproduct: id
            }
        }).done(
            function(json) {
                var carrito = json.carrito;
                carrito2(carrito);
            }
        ).fail(
            function() {
                alert('Error ticket');
            }
        );
    }

    function ProductSuma() {
        var id = $(this).parent('tr').attr('data-id');
        $.ajax({
            url: 'ticketajax/getProductPorId',
            type: 'get',
            dataType: 'json',
            data: {
                idproduct: id
            }
        }).done(
            function(json) {
                var carrito = json.carrito;
                carrito2(carrito);
            }
        ).fail(
            function() {
                alert('Error ticket');
            }
        );
    }


    function ProductRemove(event) {
        var id = $(this).parent('tr').attr('data-id');
        var rem = $(this).parent('tr').attr('data-rem');

        swal({
            title: '¿Estás seguro que quieres borrar este ticket: ' + rem + '?',
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
                    url: 'ticketajax/getProductPorIdRemove',
                    type: 'get',
                    dataType: 'json',
                    data: {
                        idproduct: id
                    }
                }).done(
                    function(json) {
                        var carrito = json.carrito;
                        carrito2(carrito);
                    }
                ).fail(
                    function() {
                        alert('Error ticket');
                    }
                );

            }
        })
    }

    function ProductRestaID(id) {
        //event.preventDefault();
        $.ajax({
            url: 'ticketajax/getProductPorIdResta',
            type: 'get',
            dataType: 'json',
            data: {
                idproduct: id
            }
        }).done(
            function(json) {
                //      alert("funciona click resta");
                var carrito = json.carrito;
                var total = json.total;
                console.log(total);
                carrito2(carrito);

            }
        ).fail(
            function() {
                alert('Error ticket');
            }
        );
    }

    function carrito2(carrito) {
        $('#tableTicket').empty();
        for (var i = 0; i < carrito.length; i++) {
            var tr = '<tr data-id=' + carrito[i].item.id + '>' +
                '<td id="id">' + carrito[i].item.id + '</td>' +
                '<td id="product">' + carrito[i].item.description + '</td>' +
                '<td id="cant">' + carrito[i].cantidad + '</td>' +
                '<td id="price">' + carrito[i].item.price + '<span>€</span></td>' +
                '<td id="result" data-price="' + carrito[i].item.price * carrito[i].cantidad + '">' + carrito[i].item.price * carrito[i].cantidad + '<span>€</span></td>' +
                '<td id="sum"><div class="btn btn-effect-ripple btn-xs btn-success"><i class="fa fa-plus"></i></div></td>' +
                '<td id="sub"><div class="btn btn-effect-ripple btn-xs btn-warning"><i class="fa fa-minus"></i></div></td>' +
                '<td id="rem"><div class="btn btn-effect-ripple btn-xs btn-danger"><i class="fa fa-times"></i></div></td>' +
                '</tr>';
            $('#tableTicket').append(tr);

        }
        $('tr').find('#sum').on('click', ProductSuma);
        // $('tr').find('#sum').on('click', addProductResta);
        $('tr').find('#sub').on('click', function() {
            var id = $(this).parent('tr').data('id');
            //  alert('funciona click' + ', cantidad: ' + $(this).parent('tr').find('#cant').text() + ', product: ' + $(this).parent('tr').find('#product').text() + ' ,id: ' + $(this).parent('tr').data('id'));
            if ($(this).parent('tr').find('#cant').text() == 1) {

                swal({
                    title: '¿Desea borrar la ultima cantidad: ' + $(this).parent('tr').find('#product').text() + '?',
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
                        ProductRestaID(id);
                    }
                });

            }
            else {
                ProductRestaID(id);
            }
        });
        $('tr').find('#rem').on('click', ProductRemove);
        priceTotal();

    }
    /*-- AutoEjecutable Carrito al reiniciar F5 --*/
    $.ajax({
        url: 'ticketajax/autoCarrito',
        type: 'GET',
        dataType: 'json'
    }).done(
        function(json) {
            var carrito = json.carrito;
            carrito2(carrito);
        }
    ).fail();



    function priceTotal() {
        var total = 0.0;
        $('#tableTicket > tr').each(function() {
            var priceId = $(this).find('#result').data('price') * 1.00;
            total = total + priceId;
        });
        $('#totalPrice').text(Number((total).toFixed(2)) + ' €');
    }


    var guardarIdCliente = 0;

    var mostrarNombreCliente = '';

    $('#tableClient > tr').each(function() {
        $(this).on('click', function() {
            guardarIdCliente = $(this).data('idclient');
            mostrarNombreCliente = $(this).data('name');
            //registerTicket(idclient);
            swal({
                title: '¿el Cliente ' + mostrarNombreCliente + ' es correcto?',
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Si',
                cancelButtonText: 'No',
            }).then((result) => {
                if (result.value) {
                    swal(
                        '¡apuntado Cliente ' + mostrarNombreCliente + '!',
                        '',
                        'success'
                    )
                }
                else {
                    guardarIdCliente = 0;
                }
            })
        });
    });


    /* --- Guardar ticket --- */

    $('#saveTicket').on('click', function() {
        saveTicket(guardarIdCliente);
    });

    function saveTicket(guardarIdCliente) {
        var getTableTicket = $('#tableTicket > tr');
        console.log(getTableTicket);

        var ticketDetails = [];

        getTableTicket.each(function() {
            var tempArray = [];
            $(this).find('td').each(function() {
                tempArray.push($(this).text());
            });
            ticketDetails.push(tempArray);
        });
        console.log(ticketDetails);

        var ticketDetails2 = [
            [],
            []
        ]

        for (var i = 0; i < ticketDetails.length; i++) {
            ticketDetails2[i] = [ticketDetails[i][2], ticketDetails[i][0], ticketDetails[i][4]];
        };
        console.log(ticketDetails2);
        //var hi = Object.values(ticketDetails2);
        $.ajax({
            url: 'ticketajax/saveTicket',
            type: 'get',
            dataType: 'json',
            data: {
                arrayTicketDetail: ticketDetails2,
                idClient: guardarIdCliente
            }
        }).done(
            function(json) {
                var result = json.resultadoTicket;
                var result2 = json.resultadoTicketDetail;
                console.log('rresultadoTicket: ' + result);
                console.log('resultadoTicketDetail: ' + result2);

                var guardarClienteTexto = '';
                if (guardarIdCliente == 0) {
                    guardarClienteTexto = 'Guardado sin cliente';
                }
                else {
                    guardarClienteTexto = 'Guardado cliente es: ' + mostrarNombreCliente;
                }
                swal(
                    guardarClienteTexto,
                    '',
                    'success'
                )

            }


        ).fail(
            function() {
                alert('Ha fallado guardar ticket');
            }
        ).always(
            function() {}
        );


    }
    $('#saveTicket').on('click', newTicket);

    function newTicket(event) {
        if ($('#tableTicket tr td').length > 1) {
            $.ajax({
                url: 'ticketajax/newTicket2',
                type: 'get',
                dataType: 'json'
            }).done(
                // function(json) {
                //     var res = json.res;
                //     alert(res);
                // }
            ).fail(
                function() {
                    alert('Error nueva ticket');
                }
            );
            $('#tableTicket').empty();
            $('#totalPrice').text("0 €");
        }
    }
})();
