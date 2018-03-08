<?php

class ManageFamily {

    private $db;

    function __construct(DataBase $db) {
        $this->db = $db;
    }
    
    public function getAll() {
        $sql = 'select * from family';
        $resultado = $this->db->execute($sql);
        $objetos = array();
        if($resultado){
            $sentencia = $this->db->getStatement();
            while($fila = $sentencia->fetch()) {
                $objeto = new Family();
                $objeto->set($fila);
                $objetos[] = $objeto;
            }
        }
        return $objetos;
    }
    
    public function getNameFamily($idFamily) {
        $sql = 'select * from family where id = :id';
        $params = array(
            'id' => $idFamily
        );
        $resultado = $this->db->execute($sql, $params); //true o false
        $sentencia = $this->db->getStatement();
        $objeto = new Family();
        if($resultado && $fila = $sentencia->fetch()) {
            $objeto->set($fila);
        } else {
            $objeto = null;
        }
        return $objeto;
    }

}
    
?>