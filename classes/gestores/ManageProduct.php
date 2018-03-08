<?php

class ManageProduct {

    private $db;

    function __construct(DataBase $db) {
        $this->db = $db;
    }
    
        /* -- insertar producto base de datos -- */
    
    public function addProducto($producto){
        $sql = 'insert into product (idfamily, product, price, description) 
            values (:idfamily, :product, :price, :description)';
        $params = array(
            'idfamily' => $producto->getIdfamily(),
            'product' => $producto->getProduct(),
            'price' => $producto->getPrice(),
            'description' => $producto->getDescription()
        );
        $result = $this->db->execute($sql, $params);
        if($result) {
            $id = $this->db->getId();
            $producto->setId($id);
        } else {
            $id = 0;
        }
        return $id;
    }
    /* borrar producto base de datos */
    
        public function removeProducto($id){
        $sql = 'delete from product where id = :id';
        $params = array(
            'id' => $id
        );
        $resultado = $this->db->execute($sql, $params);
        return $resultado;
    }
    
    /*editar producto base de datos */
    function editProducto($product) {
       $sql = 'update product set idfamily = :idfamily , product = :product , price = :price , 
       description = :description where id = :id';
        $params = array(
            'id' => $product->getId(),
            'idfamily' => $product->getIdfamily(),
            'product' => $product->getProduct(),
            'price' => $product->getPrice(),
            'description' => $product->getDescription()
        );
        $result = $this->db->execute($sql, $params);
        if($result) {
            $affectedRows = $this->db->getRowNumber();
        } else {
            $affectedRows = -1;
        }
        return $affectedRows;
    }
    
 
     /* -- obtener id de Producto -- */
    
    public function getProductBD($id) {
        $sql = 'select * from product where id = :id';
        $params = array(
            'id' => $id
        );
        $resultado = $this->db->execute($sql, $params);//true o false
        $sentencia = $this->db->getStatement();
        $product = new Product();
        if($resultado && $fila = $sentencia->fetch()) {
            $product->set($fila);
        } else {
            $product = null;
        }
        return $product;
    }
    
    /*- --- Obtener la lista de producto con ajax --*/
    
    public function getAll() {
        $sql = 'select * from product';
        $resultado = $this->db->execute($sql);
        $objetos = array();
        if($resultado){
            $sentencia = $this->db->getStatement();
            while($fila = $sentencia->fetch()) {
                $objeto = new Product();
                $objeto->set($fila);
                $objetos[] = $objeto;
            }
        }
        return $objetos;
    }
    
    /*- --- Obtener la lista limitada de producto con ajax --*/
    
    public function getLimitProductsAjax($idfamily) {
        $sql = 'select * from product where idfamily = :idfamily';
        $params = array(
            'idfamily' => $idfamily
        );
        $resultado = $this->db->execute($sql, $params);//true o false
        $objetos = array();
        if($resultado){
            $sentencia = $this->db->getStatement();
            while($fila = $sentencia->fetch()) {
                $objeto = new Product();
                $objeto->set($fila);
                $objetos[] = $objeto;
            }
        }
        return $objetos;
    }
    
    
    /* --- Cuantos todos productos --- */
    
    function countProducts() {
        $sql = 'select count(*) from product WHERE 1';
        $res = $this->db->execute($sql);
        $cuenta = 0;
        if($res) {
            $sentencia = $this->db->getStatement();
            if($fila = $sentencia->fetch()) {
                $cuenta = $fila[0];
            }
        }
        return $cuenta;
    }
    
    /* --- limitado product de datos por paginacion --- */
    function getAllLimitProduct($offset , $rpp){
        $sql = 'select * from product order by product limit ' . $offset . ',' . $rpp . ';';
        $res = $this->db->execute($sql);
        $datos = array();
        if($res){
            $sentencia = $this->db->getStatement();
            while($fila = $sentencia->fetch()){
                $product = new Product();
                $product->set($fila);
                $datos[] = $product;
            }
        }
        return $datos;
    }
    
}