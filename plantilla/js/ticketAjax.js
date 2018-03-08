$(document).ready(function() {

    /*-- El Boton nuevo ticket -- */

    $('#newTicket').on('click', newTicket);


    function newTicket(event) {
        if ($('#tableTicket tr td').length > 1) {
            swal({
                title: '¿Empezar el ticker nuevo?',
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Si',
                cancelButtonText: 'No'
            }).then((result) => {
                if (result.value) {
                    swal(
                        '¡Ticket nuevo!',
                        '',
                        'success'
                    )

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
            })
        }
    }

    listAllTicket();
    /* -- lista de Ticket --*/
    function listAllTicket() {
        $.ajax({
            url: 'ticketajax/getTicketsAjax',
            type: 'get',
            dataType: 'json',
            data: {
                page: $('#page').data('page')
            }
        }).done(
            function(json) {
                if ($('#listTicket').length > 0) {
                    $('#listTicket').text('');
                }
                var listado = json.listTicket;
                console.log(listado);
                $('#listTicket').empty();
                // var id = json.listTicket.id;
                for (var i = 0; i < listado.length; i++) {
                    var idcliente = '';
                    var nombre = '';
                    var apellidos = '';
                    var dni = '';
                    if (listado[i].id == null || listado[i].name == null || listado[i].surname == null || listado[i].tin == null) {
                        idcliente = '-';
                        nombre = '-';
                        apellidos = '-';
                        dni = '-';
                    }
                    else {
                        idcliente = listado[i].id_client;
                        nombre = listado[i].name;
                        apellidos = listado[i].surname;
                        dni = listado[i].tin;
                    }
                    var tr = '<tr role="row" style="text-align:center; font-weight:500;">' +
                        '<td id="id">' + listado[i].id + '</td>' +
                        '<td id="date">' + listado[i].date + '</td>' +
                        '<td id="login">' + listado[i].login + '</td>' +
                        '<td style="text-align:center;" id="id_client">' + idcliente + '</td>' +
                        '<td id="name">' + nombre + '</td>' +
                        '<td id="surname">' + apellidos + '</td>' +
                        '<td id="tin">' + dni + '</td>' +
                        '<td id="detail" data-id=' + listado[i].id + '><button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModalCenter">Ver detalle</button></td>' +
                        '<td id="remove" data-id=' + listado[i].id + '><button type="button"  class="btn btn-danger" >Borrar ticket</button></td>' +
                        '</tr>';
                    $('#listTicket').append(tr);
                }
                $('tr').find('#remove').on('click', removeTicket);
                $('tr').find('#detail').on('click', function() {
                    $("#modalTicketDetail").css('display', 'block');
                    var id = $(this).data('id');
                    getTicketDetails(id);
                });
                pagination(json.pagination);
            }
        ).fail(
            function() {
                alert('Error listado de ticket');
            }
        );
    }

    function pagination(page) {
        $('#page').empty();
        var first = $('<li><a title="Primero" id="pag" data-page="' + page.first + '" class="m-datatable__pager-link m-datatable__pager-link--first"><i class="la la-angle-double-left"></i></a></li>' +
            '<li><a title="Anterior" id="pag" data-page="' + page.previous + '" class="m-datatable__pager-link m-datatable__pager-link--prev"><i class="la la-angle-left"></i></a></li>');
        $('#page').append(first);
        for (var i = 0; i < page.range.length; i++) {
            var pageRange = $('<li><a id="pag" data-page="' + page.range[i] + '"class="m-datatable__pager-link m-datatable__pager-link-number"> ' + page.range[i] + ' </a></li>');
            $('#page').append(pageRange);
        }
        var last = $('<li><a title="Siguiente" id="pag" data-page="' + page.next + '"  class="m-datatable__pager-link m-datatable__pager-link--next"><i class="la la-angle-right"></i></a></li>' +
            '<li><a title="Último" id="pag" data-page="' + page.last + '" class="m-datatable__pager-link m-datatable__pager-link--last" ><i class="la la-angle-double-right"></i></a></li>')
        $('#page').append(last);

        $('#page').find('a').each(function() {
            $(this).on('click', function() {
                //  alert('pulsado');
                var modifyPag = $(this).data('page');
                $('#page').data('page', modifyPag);
                console.log($('#page').data('page'));
                listAllTicket();
            })
        })
    }


    $('#general-table2').DataTable({
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json"
        }
    });

    function removeTicket() {
        var id = $(this).attr('data-id');
        var name = $(this).parent('tr').find('#name').text();

        swal({
            title: '¿Estás seguro que quieres borrar este ID de Ticket: ' + id + '?',
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
                $(this).parent('tr').remove();
                $.ajax({
                    url: 'ticketajax/removeListTicket',
                    type: 'get',
                    dataType: 'json',
                    data: {
                        idticket: id
                    }
                }).done(
                    function(json) {
                        var delete1 = json.deleteTicketDetail;
                        var delete2 = json.deleteTicket;
                        console.log(delete1);
                        console.log(delete2);
                    }
                ).fail(
                    function() {
                        alert('Error no se puede eliminar');
                    }
                );

            }
        })

    }

    function getTicketDetails(id) {
        // var id = $(this).attr('data-id');
        //console.log('Informacion: ' + id);
        $.ajax({
            url: 'ticketdetailajax/getTicketDetailIdsAjax',
            type: 'get',
            dataType: 'json',
            data: {
                idticket: id
                //, page: $('#page').data('page')
            }
        }).done(
            function(json) {
                var listado = json.listTicketDetail;
                console.log(listado);
                $('#listTicketDetail').empty();
                for (var i = 0; i < listado.length; i++) {
                    var tr = '<tr role="row" style="text-align:center; font-weight:500;">' +
                        '<td id="id">' + listado[i].id + '</td>' +
                        '<td id="idticket">' + listado[i].login + '</td>' +
                        '<td id="product">' + listado[i].product + '</td>' +
                        '<td id="quantiy">' + listado[i].quantity + '</td>' +
                        '<td id="price">' + listado[i].price + '</td>' +
                        '<td id="removeDetail" data-id="' + listado[i].id + '"><button type="button"  class="btn btn-danger" > eliminar </button></td>' +
                        '</tr>';
                    $('#listTicketDetail').append(tr);
                }
                $('tr').find('#removeDetail').on('click', removeTicketDetail);
                //paginationTicketDetail(json.pagination);
            }
        ).fail(
            function() {
                alert('Error listado de ticketDetail');
            }
        );
    }

  

    function removeTicketDetail() {
        var id = $(this).attr('data-id');
        var product = $(this).parent('tr').find('#product').text();
        swal({
            title: '¿Estás seguro que quieres borrar este ticket' + product + '?',
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
                $(this).parent('tr').remove();
                $.ajax({
                    url: 'ticketajax/deleteTicketDetailByIdBD',
                    type: 'get',
                    dataType: 'json',
                    data: {
                        id: id
                    }
                }).done(
                    function(json) {
                        var delete1 = json.deleteTicketDetailById;
                        console.log(delete1);

                    }
                ).fail(
                    function() {
                        alert('Error no se puede eliminar');
                    }
                );
            }
        })
    }

});
