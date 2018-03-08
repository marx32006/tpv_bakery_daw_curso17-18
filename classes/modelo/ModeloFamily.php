<?php

class ModeloFamily extends Modelo {
    
    function getAllFamilies(){
        $manager = new ManageFamily($this->getDataBase());
        return $manager->getAll();
    }
    
}