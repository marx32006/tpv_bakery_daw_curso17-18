<?php

class ManageTicketDetail {

    private $db;

    function __construct(DataBase $db) {
        $this->db = $db;
    }

    
    public function getTicketDetailIdBD($idticket) {
        $sql = 'SELECT td.id, me.login, td.price, td.quantity, pr.product FROM ticketdetail td
        join product pr on pr.id = td.idproduct
        join ticket t on td.idticket = t.id
        join member me on t.idmember = me.id WHERE td.idticket = :idticket;';
       // $sql = 'SELECT td.id, td.price, td.quantity, pr.product FROM ticketdetail td join product pr on pr.id = td.idproduct WHERE td.idticket = :idticket;';
        $params = array('idticket' => $idticket);
        $resultado = $this->db->execute($sql, $params);
        $sentencia = $this->db->getStatement();
        $objetos = array();
        if($resultado){
            while($fila = $sentencia->fetch()) {
                $objetos[] = array(
                    'id' => $fila[0],
                    'login' => $fila[1],
                    'price' => $fila[2],
                    'quantity' => $fila[3],
                    'product' => $fila[4]
                );
            }
        }
        return $objetos;
    }
    
       
    // public function getTicketDetailIdBD($idticket) {
    //      $sql = 'SELECT td.id, td.price, td.quantity, pr.product FROM ticketdetail
    //      td join product pr on pr.id = td.idproduct WHERE td.idticket = :idticket;';
    //   //  $sql = 'select * from ticketdetail where idticket = :idticket';
    //     $params = array(
    //         'idticket' => $idticket
    //     );
    //     $resultado = $this->db->execute($sql, $params);//true o false
    //     $sentencia = $this->db->getStatement();
    //     $product = new TicketDetail();
    //     if($resultado && $fila = $sentencia->fetch()) {
    //         $product->set($fila);
    //     } else {
    //         $product = null;
    //     }
    //     return $product;
    // }
     

    
    public function getAllTicketDetail() {
        $sql = 'select * from ticketdetail';
        $resultado = $this->db->execute($sql);
        $objetos = array();
        if($resultado){
            $sentencia = $this->db->getStatement();
            while($fila = $sentencia->fetch()) {
                $objeto = new TicketDetail();
                $objeto->set($fila);
                $objetos[] = $objeto;
            }
        }
        return $objetos;
    }
    
    function getCount(){
        $sql = 'SELECT count(*) from ticketdetail';
        
        $res = $this->db->execute($sql);
        $sentencia = $this->db->getStatement();
        if($res && $fila = $sentencia->fetch()){
            return $fila[0];
        }
        return 0;
    }
    
    public function getLimitTicketDetailIdsAjax($offset , $rpp) {
        $sql = 'SELECT td.id, me.login, td.price, td.quantity, pr.product FROM ticketdetail td
        join product pr on pr.id = td.idproduct
        join ticket t on td.idticket = t.id
        join member me on t.idmember = me.id WHERE td.idticket = :idticket ORDER BY td.id LIMIT ' . $offset . ',' . $rpp . ';';
       // $sql = 'SELECT td.id, td.price, td.quantity, pr.product FROM ticketdetail td join product pr on pr.id = td.idproduct WHERE td.idticket = :idticket;';
        $params = array('idticket' => $idticket);
        $resultado = $this->db->execute($sql, $params);
        $sentencia = $this->db->getStatement();
        $objetos = array();
        if($resultado){
            while($fila = $sentencia->fetch()) {
                $objetos[] = array(
                    'id' => $fila[0],
                    'login' => $fila[1],
                    'price' => $fila[2],
                    'quantity' => $fila[3],
                    'product' => $fila[4]
                );
            }
        }
        return $objetos;
    }
    
    function addTicketDetailBD($ticketDetail){
        $sql = 'insert into ticketdetail (idticket, idproduct, quantity, price) values (:idticket, :idproduct, :quantity, :price)';
        $params = array(
                'idticket' => $ticketDetail->getIdticket(),
                'idproduct' => $ticketDetail->getIdproduct(),
                'quantity' => $ticketDetail->getQuantity(),
                'price' => $ticketDetail->getPrice()
            );
        $result = $this->db->execute($sql, $params);
        //echo Util::varDump($params);
        if($result) {
            $id = $this->db->getId();
            $ticketDetail->setId($id);
        } else {
            $id = 0;
        }
        return $id;
    }
    
}