<?php

class ModeloProduct extends Modelo {
    
        /* -- insertar producto base de datos -- */
    
    function insertarProductoBD($producto){
        $manager = new ManageProduct($this->getDataBase());
        return $manager->addProducto($producto);
    }
    
    /* --- borrar producto base de datos --- */
    
    function borrarProductoBD($id){
        $manager = new ManageProduct($this->getDataBase());
        return $manager->removeProducto($id);
    }
    
    /* --- editar producto base de datos --- */
    function editarProductoBD($id){
        $manager = new ManageProduct($this->getDataBase());
        return $manager->editProducto($id);
    }
    
    /* ---- Obtener datos de producto ---*/
    
    function getProduct($id) {
        $manager = new ManageProduct($this->getDataBase());
        return $manager->getProductBD($id);
    }
    /* ---- Obtener datos de productos Ajax --- */
    function getProducts() {
        $manager = new ManageProduct($this->getDataBase());
        return $manager->getAll();
    }
    
    function getLimitProductsAjax($idfamily) {
        $manager = new ManageProduct($this->getDataBase());
        return $manager->getLimitProductsAjax($idfamily);
    }
    
     /* --- Cuantos  productos --- */
    
    function countProductos(){
        $manager = new ManageProduct($this->getDataBase());
        return $manager->countProducts();
    }
   
   /* cuantos paginacion productos --*/ 
    function getAllLimitProductos($offset , $rpp){
        $manager = new ManageProduct($this->getDataBase());
        return $manager->getAllLimitProduct($offset , $rpp);
    }
    
    /* -- Devuelve nombre de familia de producto por Idfamily -- */
    function getNombreFamilia($idfamily){
        $manager = new ManageFamily($this->getDataBase());
        return $manager->getNameFamily($idfamily);
    }
    
    function getAllFamilies(){
        $manager = new ManageFamily($this->getDataBase());
        $families = $manager->getAll();
        $todos = '';
        foreach($families as $family){
            $todos .= '<option value="' . $family->getId() . '">' . $family->getFamily() . '</option>';
        }
        return $todos;
    }
    
}