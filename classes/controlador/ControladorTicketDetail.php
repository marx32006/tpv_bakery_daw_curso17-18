<?php

class ControladorTicketDetail extends Controlador{
    
    
    function ticketDetailPlantilla(){
        $header = file_get_contents("plantilla/_header.html");
        $this->getModel()->setDato('header', $header);
        $footer = file_get_contents("plantilla/_footer.html");
        $this->getModel()->setDato('footer', $footer);
        $this->getModel()->setDato('archivo' , 'ticket/_ticketDetail.html');
    }
    
    function getTicketDetailIdsAjax(){
        $id = Request::read('idticket');
        if($this->isLogged()){
            $product = $this->getModel()->getTicketDetailIdsAjax($id);
            //$product = $id;
            $this->getModel()->setDato('listTicketDetail' , $product);
        }
    }
    
    function getLimitTicketDetailIdsAjax(){
        if($this->isLogged()){
            $id = Request::read('idticket');
            $rows = $this->getModel()->getCount();
            $page = Request::read('page');
            $pagination = new Pagination($rows , $page , 3);
            $offset = $pagination->getOffset();
            $rpp = $pagination->getRpp();
            $rango = array(
                'first' => $pagination->getFirst(),
                'last' => $pagination->getLast(),
                'next' => $pagination->getNext(),
                'previous' => $pagination->getPrevius(),
                'range' => $pagination->getRange()
            );
            $ticketDetails = $this->getModel()->getLimitTicketDetailIdsAjax($offset , $rpp);
            $this->getModel()->setDato('listTicketDetail' , $ticketDetails);
            $this->getModel()->setDato('pagination' , $rango);
        }
    }
    
    function saveTicketDetail(){
    //    $carrito = $this->getSession()->getCarro()->getCarrito();//obtengo carrito de la compra
        $res = array();
        
         foreach($carrito as $linea){
               $tDetail = new TicketDetail();
        //       //$producto = $linea->getItem();
              $tDetail->setIdticket(Request::read('idticket'));
              $tDetail->setIdproduct($linea['item']['id']);
              $tDetail->setQuantity($linea['cantidad']);
              $tDetail->setPrice($linea['item']['price'] * $linea['cantidad']);
           
           $res[] = $this->getModel()->insertTicketDetail($tDetail);
        // }
        $this->getModel()->setDato('res',$res);
    }
    
}

}
