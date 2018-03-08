<?php

class ManageTpv {

    private $db;

    function __construct(DataBase $db) {
        $this->db = $db;
    }
    
    /*- --- Obtener la lista de producto para ticket con ajax --*/
    
    public function getProductporIdBD($id) {
        $sql = 'select * from product where id = :id';
        $params = array(
            'id' => $id
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
    
}