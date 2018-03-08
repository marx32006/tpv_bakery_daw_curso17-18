<?php

class ModeloTpv extends Modelo {
    
 /* -- Conseguir el producto por Id para ticket --*/
 function getProductPorId($id){
        $manager = new ManageTpv($this->getDataBase());
        $product = $manager->getProductporIdBD($id);
        return $product;
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
    
    function getAllClientes(){
        $manager = new ManageClient($this->getDataBase());
        return $manager->getAllClientes();
    }
}