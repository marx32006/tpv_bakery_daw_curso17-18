<?php

class ModeloClient extends Modelo {

    /* -- insertar cliente base de datos -- */
    
    function insertarClienteBD($cliente){
        $manager = new ManageClient($this->getDataBase());
        return $manager->addCliente($cliente);
    }
    
    /* -- borrar cliente base de datos -- */
    function borrarClienteBD($id){
        $manager = new ManageClient($this->getDataBase());
        return $manager->removeCliente($id);
    }
    
    /* editar cliente base de datos --*/
    function editarClienteBD($id){
        $manager = new ManageClient($this->getDataBase());
        return $manager->editCliente($id);
    }
    
     /* --- Obtener datos de cliente --- */
    
    function getClient($id){
        $manager = new ManageClient($this->getDataBase());
        return $manager->getClient($id);
    }
    
    /* --- Cuantos  clientes --- */
    
    function countClientes(){
        $manager = new ManageClient($this->getDataBase());
        return $manager->countClients();
    }
    
    function getAllLimitClientes($offset , $rpp){
        $manager = new ManageClient($this->getDataBase());
        return $manager->getAllLimitClientes($offset , $rpp);
    }
}