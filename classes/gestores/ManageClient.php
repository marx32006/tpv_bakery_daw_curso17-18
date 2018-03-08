<?php

class ManageClient {

    private $db;

    function __construct(DataBase $db) {
        $this->db = $db;
    }

    /* -- insertar cliente base de datos -- */
    
    function addCliente($cliente){
        $sql = 'insert into client (name, surname, tin, address, location, postalcode, province, email)
            values (:name, :surname, :tin, :address, :location, :postalcode, :province, :email)';
        
        $params = array(
            'name' => $cliente->getName(),
            'surname' => $cliente->getSurname(),
            'tin' => $cliente->getTin(),
            'address' => $cliente->getAddress(),
            'location' => $cliente->getLocation(),
            'postalcode' => $cliente->getPostalcode(),
            'province' => $cliente->getProvince(),
            'email' => $cliente->getEmail()
        );
        $result = $this->db->execute($sql, $params);
        if($result) {
            $id = $this->db->getId();
            $cliente->setId($id);
        } else {
            $id = 0;
        }
        return $id;
    }
    
    /* borrar cliente base de datos */
    public function removeCliente($id){
        $sql = 'delete from client where id = :id';
        $params = array(
            'id' => $id
        );
        $resultado = $this->db->execute($sql, $params);
        return $resultado;
    }
    
    /* editar cliente base de datos */
        function editCliente($client){
        $sql = 'update client set name = :name, surname = :surname, 
        tin = :tin, address = :address, location = :location, 
        postalcode = :postalcode, province = :province, email = :email where id = :id';
        $params = array(
            'name' => $client->getName(),
            'surname' => $client->getSurname(),
            'tin' => $client->getTin(),
            'address' => $client->getAddress(),
            'location' => $client->getLocation(),
            'postalcode' => $client->getPostalcode(),
            'province' => $client->getProvince(),
            'email' => $client->getEmail(),
            'id' => $client->getId()
        );
        $result = $this->db->execute($sql, $params);
        if($result) {
            $affectedRows = $this->db->getRowNumber();
        } else {
            $affectedRows = -1;
        }
        return $affectedRows;
    }
    
    /* -- obtener id de Cliente -- */
    
    public function getClient($id) {
        $sql = 'select * from client where id = :id';
        $params = array(
            'id' => $id
        );
        $resultado = $this->db->execute($sql, $params);//true o false
        $sentencia = $this->db->getStatement();
        $client = new Client();
        if($resultado && $fila = $sentencia->fetch()) {
            $client->set($fila);
        } else {
            $client = null;
        }
        return $client;
    }
    
        
    /* --- Cuantos todos clietnes --- */
    
    function countClients() {
        $sql = 'select count(*) from client WHERE 1';
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
    
        /* --- limitado cliente de datos por paginacion --- */
    
    function getAllLimitClientes($offset , $rpp){
        $sql = 'select * from client order by name limit ' . $offset . ',' . $rpp . ';';
        $res = $this->db->execute($sql);
        $datos = array();
        if($res){
            $sentencia = $this->db->getStatement();
            while($fila = $sentencia->fetch()){
                $client = new Client();
                $client->set($fila);
                $datos[] = $client;
            }
        }
        return $datos;
    }
    
    function getAllClientes(){
        $sql = 'select * from client;';
        $res = $this->db->execute($sql);
        $datos = array();
        if($res){
            $sentencia = $this->db->getStatement();
            while($fila = $sentencia->fetch()){
                $client = new Client();
                $client->set($fila);
                $datos[] = $client;
            }
        }
        return $datos;
    }
}