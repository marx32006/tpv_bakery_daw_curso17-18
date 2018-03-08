<?php

class ModeloTicketDetail extends Modelo {
    
    /* -- Conseguir el producto por Id para ticket --*/
    function getTicketDetailIdsAjax($id){
        $manager = new ManageTicketDetail($this->getDataBase());
        return $manager->getTicketDetailIdBD($id);
    }
    
        function getCount(){
        $manager = new ManageTicket($this->getDataBase());
        return $manager->getCount();
    }
    
    function getAllLimitTicketBD($offset , $rpp){
        $manager = new ManageTicket($this->getDataBase());
        return $manager->getLimitTicketDetailIdsAjax($offset , $rpp);
    }
    
        function insertTicketDetail($tDetail){
        $manager = new ManagerTicketDetail($this->getDataBase());
        return $manager->add($tDetail);
    }
}