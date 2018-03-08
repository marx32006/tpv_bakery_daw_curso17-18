<?php

class ManageTicket {

    private $db;

    function __construct(DataBase $db) {
        $this->db = $db;
    }
    
    
    public function addTicketBD(Ticket $ticket) {
        $sql = 'insert into ticket (idmember, idclient) 
        values (:idmember, :idclient)';
        $params = array(
            'idmember' => $ticket->getIdMember(),
            'idclient' => $ticket->getIdClient()
        );
        $resultado = $this->db->execute($sql, $params);
        if($resultado) {
            $id = $this->db->getId();
            $ticket->setId($id);
        } else {
            $id = 0;
        }
        return $id;
    }
    
    /*- --- Obtener la lista de producto para ticket con ajax --*/
    
    public function getProductporIdBD($id) {
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
    
    public function getAllTicket() {
        $sql = 'select * from ticket';
        $resultado = $this->db->execute($sql);
        $objetos = array();
        if($resultado){
            $sentencia = $this->db->getStatement();
            while($fila = $sentencia->fetch()) {
                $objeto = new Ticket();
                $objeto->set($fila);
                $objetos[] = $objeto;
            }
        }
        return $objetos;
    }
    
    public function getAllTicketClientMember() {
        $sql = 'select t.id, date, login, name, surname, tin, c.id from ticket t 
        join member m on m.id = t.idmember left join client c on c.id = t.idclient';
        $resultado = $this->db->execute($sql);
        $objetos = array();
        if($resultado){
            $sentencia = $this->db->getStatement();
            while($fila = $sentencia->fetch()) {
                $objetos[] = array(
                    'id' => $fila[0],
                    'date' => $fila[1],
                    'login' => $fila[2],
                    'name' => $fila[3],
                    'surname' => $fila[4],
                    'tin' => $fila[5],
                    'id_client' => $fila[6]
                );
            }
        }
        return $objetos;
    }
    
    public function getAllLimitMemberClientTicketBD($offset , $rpp) {
        $sql = 'select t.id, date, login, name, surname, tin, c.id from ticket t 
        join member m on m.id = t.idmember left join client c on c.id = t.idclient ORDER BY t.id LIMIT ' . $offset . ',' . $rpp . ';';
        $resultado = $this->db->execute($sql);
        $objetos = array();
        if($resultado){
            $sentencia = $this->db->getStatement();
            while($fila = $sentencia->fetch()) {
                $objetos[] = array(
                    'id' => $fila[0],
                    'date' => $fila[1],
                    'login' => $fila[2],
                    'name' => $fila[3],
                    'surname' => $fila[4],
                    'tin' => $fila[5],
                    'id_client' => $fila[6]
                );
            }
        }
        return $objetos;
    }
    
    function getCount(){
        $sql = 'SELECT count(*) from ticket';
        
        $res = $this->db->execute($sql);
        $sentencia = $this->db->getStatement();
        if($res && $fila = $sentencia->fetch()){
            return $fila[0];
        }
        return 0;
    }
    
    function deleteTicketBD($id){
          $sql = 'delete from ticket where id = :idticket';
           $params = array(
            'idticket' => $id
                );
                $resultado = $this->db->execute($sql, $params);
                if($resultado) {
                    $filasAfectadas = $this->db->getRowNumber();
                } else {
                    $filasAfectadas = -1;
                }
                return $filasAfectadas;
            }
            
    function deleteTicketDetailBD($idticket){
        $sql = 'delete from ticketdetail where idticket = :idticket';
        $params = array(
            'idticket' => $idticket
        );
        $resultado = $this->db->execute($sql, $params);
        if($resultado) {
            $filasAfectadas = $this->db->getRowNumber();
        } else {
            $filasAfectadas = -1;
        }
        return $filasAfectadas;
    }
    
    function deleteTicketDetailByIdBD($id){
        $sql = 'delete from ticketdetail where id = :id';
        $params = array(
            'id' => $id
        );
        $resultado = $this->db->execute($sql, $params);
        if($resultado) {
            $filasAfectadas = $this->db->getRowNumber();
        } else {
            $filasAfectadas = -1;
        }
        return $filasAfectadas;
    }
    
    function getTicketBD($id){
        $sql = 'select * from ticket where id = :idticket';
        $params = array(
            'idticket' => $id
        );
        $resultado = $this->db->execute($sql, $params);//true o false
        $sentencia = $this->db->getStatement();
        $ticket = new Ticket();
        if($resultado && $fila = $sentencia->fetch()) {
            $ticket->set($fila);
        } else {
            $ticket = null;
        }
        return $ticket;
    }
    
    
    function regTicketClientBD($ticketClientId){
        $sql = 'update ticket set idclient = :idclient where id = :id';
        $params = array(
            'idclient' => $ticketClientId->getIdClient(),
            'id' => $ticketClientId->getId()
        );
        $res = $this->db->execute($sql, $params);
        if($res) {
            $filasAfectadas = $this->db->getRowNumber();
        } else {
            $filasAfectadas = -1;
        }
        return $filasAfectadas;
    }
    
}