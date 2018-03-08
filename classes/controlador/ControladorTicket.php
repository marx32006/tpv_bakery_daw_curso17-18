<?php

class ControladorTicket extends Controlador{
    
    /*-- sacar el id de producto por base de datos para carrito-- */
    function getProductPorId(){
        $id = Request::read('idproduct');
        if($this->isLogged()){
            $producto = $this->getModel()->getProductPorId($id);
            
            $linea = new Linea($producto->getId(), $producto);

            $this->getModel()->setDato('linea' , $linea->getItem()->getProduct());
            
            $sesion = $this->getSesion();
            $carrito = $sesion->get('carrito');
            if($carrito === null){
                $carrito = new Carrito();
            }
            $carrito->addLinea($linea);
            $sesion->set('carrito', $carrito);
            
            $carrito = $carrito->getCarrito();
            $this->getModel()->setDato('carrito' , $this->getCarritoAjax($carrito));

        }
    }
    /*-- resta la cantidad de producto para carrito --*/
    function getProductPorIdResta(){
        $id = Request::read('idproduct');
        if($this->isLogged()){
            $producto = $this->getModel()->getProductPorId($id);
            
            $linea = new Linea($producto->getId(), $producto);

            $this->getModel()->setDato('linea' , $linea->getItem()->getProduct());
            
            $sesion = $this->getSesion();
            $carrito = $sesion->get('carrito');
            if($carrito === null){
                $carrito = new Carrito();
            }
            $carrito->subLinea($linea);
            $sesion->set('carrito', $carrito);
            
            $carrito = $carrito->getCarrito();
            $this->getModel()->setDato('carrito' , $this->getCarritoAjax($carrito));

        }
    }
    /* --- borrar el id de producto de base de datos Carrito --*/
    function getProductPorIdRemove(){
        $id = Request::read('idproduct');
        if($this->isLogged()){
            $producto = $this->getModel()->getProductPorId($id);
            
            $linea = new Linea($producto->getId(), $producto);

            $this->getModel()->setDato('linea' , $linea->getItem()->getProduct());
            
            $sesion = $this->getSesion();
            $carrito = $sesion->get('carrito');
            if($carrito === null){
                $carrito = new Carrito();
            }
            $carrito->delLinea($linea);
            $sesion->set('carrito', $carrito);
            
            $carrito = $carrito->getCarrito();
            $this->getModel()->setDato('carrito' , $this->getCarritoAjax($carrito));

        }
    }
    /*-- AutoEjecutable la sesion carrito --*/ 
    function autoCarrito(){
        if($this->isLogged()){
            $sesion = $this->getSesion();
            $carrito = $sesion->get('carrito');
            if($carrito === null){
                $carrito = new Carrito();
            }
            $carrito = $carrito->getCarrito();
            $this->getModel()->setDato('carrito', $this->getCarritoAjax($carrito));
        }
    }
    
    
    /*-- sacar la informacion de productos de array de carrito --*/
    function getCarritoAjax($carrito){
        $arrayLinea = array();
        foreach ($carrito as $linea){
            $lineaAjax = new Linea ($linea->getId(), $linea->getItem(), $linea->getCantidad());
            $producto = $linea->getItem();
            $productoAjax = $producto->getAttributesValues();
            $lineaAjax->setItem($productoAjax);
            $arrayLinea[] = $lineaAjax->getAttributesValues();
        }
        
        return $arrayLinea;
    }
    /*-- plantilla de la lista de ticket --*/
    function listaTicketPlantilla(){
        $header = file_get_contents("plantilla/_header.html");
        $this->getModel()->setDato('header', $header);
        $footer = file_get_contents("plantilla/_footer.html");
        $this->getModel()->setDato('footer', $footer);
        $this->getModel()->setDato('archivo' , 'ticket/_ticket.html');

    }
    
    /*-- para sacar la lista de ticket con la paginacion --*/
    function getTicketsAjax(){
        if($this->isLogged()){

            $rows = $this->getModel()->getCount();
            $page = Request::read('page');
            $pagination = new Pagination($rows , $page , 5);
            $offset = $pagination->getOffset();
            $rpp = $pagination->getRpp();
            $rango = array(
                'first' => $pagination->getFirst(),
                'last' => $pagination->getLast(),
                'next' => $pagination->getNext(),
                'previous' => $pagination->getPrevius(),
                'range' => $pagination->getRange()
            );
            $tickets = $this->getModel()->getAllLimitTicketBD($offset , $rpp);
            $this->getModel()->setDato('listTicket' , $tickets);
            $this->getModel()->setDato('pagination' , $rango);
        }
    }
    
    /*-- eliminar el id de ticket con su ticket detalle --*/
    function removeListTicket(){
         $idTicketDetail = Request::read('idticket');
        if($this->isLogged()) {
            $res = $this->getModel()->deleteTicketDetail($idTicketDetail);
            $res1 = $this->getModel()->deleteTicket($idTicketDetail);
            $this->getModel()->setDato('deleteTicketDetail' , $res);
            $this->getModel()->setDato('deleteTicket' , $res1);

        } 
       
    }
    
    /*-- eliminar el id de ticketDetail --*/
    function deleteTicketDetailByIdBD(){
        $id = Request::read('id');
        if($this->isLogged()) {
            $res = $this->getModel()->deleteTicketDetailByIdBD($id);
            $this->getModel()->setDato('deleteTicketDetailById' , $res);
        }
    }
    
    /*-- guardar el ticket con cliente o sin cliente --*/
    function saveTicket(){
        if($this->isLogged()){
            //$idticket = Request::read('idticket');
            $idMember = $this->getUser()->getId();
            $idClient = Request::read('idClient');
            if ($idClient == '0'){
                $idClient = null;
            } 
            
            $ticket = new Ticket();
            $ticket->setIdClient($idClient);
            $ticket->setIdMember($idMember);
            $resTicket = $this->getModel()->addTicketBD($ticket);
            $this->getModel()->setDato('resultadoTicket', $resTicket);
            
           $arrayTicketDetail = Request::read('arrayTicketDetail');
            
            for($i = 0; $i < count($arrayTicketDetail); $i++){
                $ticketDetail = new TicketDetail();
                $ticketDetail->setIdticket($resTicket);
                $ticketDetail->setQuantity($arrayTicketDetail[$i][0]);
                $ticketDetail->setIdproduct($arrayTicketDetail[$i][1]);
                $ticketDetail->setPrice($arrayTicketDetail[$i][2]);
                $resTicketDetail[] = $this->getModel()->addTicketDetailBD($ticketDetail);
            }
            
            $this->getModel()->setDato('resultadoTicketDetail', $resTicketDetail);
        }
    }
    /*-- para registrar el ticket cliente --*/
    function registerTicket(){
        if($this->isLogged()){
            $idticket = Request::read('idticket');
            $idClient = Request::read('idClient');
            $ticket = $this->getModel()->getTicketBD($idticket);
            if($ticket !== null){
                $ticket->setIdClient($idClient);
                $res = $this->getModel()->regTicketBD($ticket);
                $res = array('res' => $res);
                $this->getModel()->setDato('res',$res);
            }
        }
        
    }
    /*-- limpiar el ticket --*/
    function newTicket2(){
        if($this->isLogged()){
            $sesion = $this->getSesion();
            $carrito = new Carrito();
            $sesion->set('carrito', $carrito);

        }
    }
}
