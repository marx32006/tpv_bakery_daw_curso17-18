<?php

class ManageMember {

    private $db;

    function __construct(DataBase $db) {
        $this->db = $db;
    }
    
    public function getFromNombreUsuario($nombreusuario){
        $sql = 'select * from member where login = :nombreusuario';
        $params = array(
            'nombreusuario' => $nombreusuario
        );
        $resultado = $this->db->execute($sql, $params);//true o false
        $sentencia = $this->db->getStatement();
        $objeto = new Member();
        if($resultado && $fila = $sentencia->fetch()) {
            $objeto->set($fila);
        } else {
            $objeto = null;
        }
        return $objeto;
    }
    
    public function getMember($id) {
        $sql = 'select * from member where id = :id';
        $params = array(
            'id' => $id
        );
        $resultado = $this->db->execute($sql, $params);//true o false
        $sentencia = $this->db->getStatement();
        $client = new Member();
        if($resultado && $fila = $sentencia->fetch()) {
            $client->set($fila);
        } else {
            $client = null;
        }
        return $client;
    }
    
    function addMember($member){
        $sql = 'insert into member (login, clave) values (:login, :clave)';
        $params = array(
            'login' => $member->getLogin(),
            'clave' => Util::encriptar($member->getClave(), 10)
        );
        $result = $this->db->execute($sql, $params);
        if($result) {
            $id = $this->db->getId();
            $member->setId($id);
        } else {
            $id = 0;
        }
        return $id;
    }
    
    /* editar miembro en base de datos */
    
    function editMember($member){
        $sql = 'update member set login = :login, clave = :clave where id = :id';
        $params = array(
            'login' => $member->getLogin(),
            'clave' => Util::encriptar($member->getClave(), 10),
            'id' => $member->getId()
        );
        $result = $this->db->execute($sql, $params);
        if($result) {
            $affectedRows = $this->db->getRowNumber();
        } else {
            $affectedRows = -1;
        }
        return $affectedRows;
    }
    
     /* borrar miembro en base de datos */
    
     public function removeMemberBD($id){
        $sql = 'delete from member where id = :id';
        $params = array(
            'id' => $id
        );
        $resultado = $this->db->execute($sql, $params);
        return $resultado;
    }
    
    function editMemberSinClave($member){
        $sql = 'update member set login = :login where id = :id';
        $params = array(
            'login' => $member->getLogin(),
            'id' => $member->getId()
        );
        $result = $this->db->execute($sql, $params);
        if($result) {
            $affectedRows = $this->db->getRowNumber();
        } else {
            $affectedRows = -1;
        }
        return $affectedRows;
    }
    
    function countMember() {
        $sql = 'select count(*) from member WHERE 1';
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
    
    function getAllLimitMember($offset , $rpp){
        $sql = 'select * from member order by login limit ' . $offset . ',' . $rpp . ';';
        $res = $this->db->execute($sql);
        $datos = array();
        if($res){
            $sentencia = $this->db->getStatement();
            while($fila = $sentencia->fetch()){
                $client = new Member();
                $client->set($fila);
                $datos[] = $client;
            }
        }
        return $datos;
    }
}