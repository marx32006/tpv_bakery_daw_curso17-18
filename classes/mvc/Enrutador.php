<?php

class Enrutador {
    
    private $rutas = array();

    function __construct() {
       // $this->rutas['index'] = new Ruta('ModeloUsuario', 'VistaUsuario', 'ControladorUsuario');
        $this->rutas['index'] = new Ruta('Modelo' , 'Vista' , 'Controlador');
 
        /* -- Miembro -- */
        $this->rutas['member'] = new Ruta('ModeloMember' , 'Vista' , 'ControladorMember');
        $this->rutas['memberajax'] = new Ruta('ModeloMember' , 'VistaAjax' , 'ControladorMember');
        /*-- Cliente --*/
        $this->rutas['client'] = new Ruta('ModeloClient' , 'Vista' , 'ControladorClient');
        $this->rutas['clientajax'] = new Ruta('ModeloClient' , 'VistaAjax' , 'ControladorClient');
        /*-- Producto y Producto Ajax--*/
        $this->rutas['product'] = new Ruta('ModeloProduct' , 'Vista' , 'ControladorProduct');
        $this->rutas['productajax'] = new Ruta('ModeloProduct' , 'VistaAjax' , 'ControladorProduct');
        /*-- Familia --*/
        $this->rutas['family'] = new Ruta('ModeloFamily' , 'VistaAjax' , 'ControladorFamily');
        /*-- Ticket y Ticket Ajax--*/
        $this->rutas['ticket'] = new Ruta('ModeloTicket' , 'Vista' , 'ControladorTicket');
        $this->rutas['ticketajax'] = new Ruta('ModeloTicket' , 'VistaAjax' , 'ControladorTicket');
        /*-- TicketDetail y TicketDetail Ajax--*/
        $this->rutas['ticketdetail'] = new Ruta('ModeloTicketDetail' , 'Vista' , 'ControladorTicketDetail');
        $this->rutas['ticketdetailajax'] = new Ruta('ModeloTicketDetail' , 'VistaAjax' , 'ControladorTicketDetail');
        //añadir rutas
        
        
        //$this->rutas['tpv'] = new Ruta('Modelo' , 'Vista' , 'ControladorTpv');
        $this->rutas['tpv'] = new Ruta('ModeloTpv' , 'Vista' , 'ControladorTpv');
    }

    function getRoute($ruta) {
        if (!isset($this->rutas[$ruta])) {
            return $this->rutas['member'];
        }
        return $this->rutas[$ruta];
    }
}