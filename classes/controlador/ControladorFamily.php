<?php

class ControladorFamily extends Controlador {
    
    function getFamilies(){
        if($this->isLogged()){
            $familias = $this->getModel()->getAllFamilies();
            $array = [];
            foreach($familias as $familia){
                $array[]= $familia->getAttributesValues();
            }
            $this->getModel()->setDato('listado' , $array);
        }
    }
    
}