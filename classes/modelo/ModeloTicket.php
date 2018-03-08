<?php

class ModeloTicket extends Modelo {
    
 /* -- Conseguir el producto por Id para ticket --*/
 function getProductPorId($id){
        $manager = new ManageTicket($this->getDataBase());
        return $manager->getProductporIdBD($id);
    }
    
    function getTicketsBD(){
        $manager = new ManageTicket($this->getDataBase());
        return $manager->getAllTicketClientMember();
    }
    
    function deleteTicket($id){
         $manager = new ManageTicket($this->getDataBase());
         return $manager->deleteTicketBD($id);
    }
    
    function deleteTicketDetail($idticket){
         $manager = new ManageTicket($this->getDataBase());
         return $manager->deleteTicketDetailBD($idticket);
    }
    
    function deleteTicketDetailByIdBD($id){
         $manager = new ManageTicket($this->getDataBase());
         return $manager->deleteTicketDetailByIdBD($id);
    }
    
    function getTicketBD($id){
         $manager = new ManageTicket($this->getDataBase());
         return $manager->getTicketBD($id);
    }
    
    function regTicketBD($ticketClientId){
        $manager = new ManageTicket($this->getDataBase());
        return $manager->regTicketClientBD($ticketClientId);
    }
    
    function getCount(){
        $manager = new ManageTicket($this->getDataBase());
        return $manager->getCount();
    }
    
    function getAllLimitTicketBD($offset , $rpp){
        $manager = new ManageTicket($this->getDataBase());
        return $manager->getAllLimitMemberClientTicketBD($offset , $rpp);
    }
    
    function addTicketBD($ticket){
        $manager = new ManageTicket($this->getDataBase());
        return $manager->addTicketBD($ticket);
    }
    
    function addTicketDetailBD($ticketDetail){
        $manager = new ManageTicketDetail($this->getDataBase());
        return $manager->addTicketDetailBD($ticketDetail);
    }
    
}