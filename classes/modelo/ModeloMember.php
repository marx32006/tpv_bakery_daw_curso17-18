<?php

class ModeloMember extends Modelo {

    /* --- acceso member --- */
    
    function loginNombreUsuario($member){
        $manager = new ManageMember($this->getDataBase());
        $memberDB = $manager->getFromNombreUsuario($member);
        return $memberDB;
    }
    
    function insertMemberBD($member){
        $manager = new ManageMember($this->getDataBase());
        return $manager->addMember($member);
    }
    
    /* -- borrar member base de datos -- */
    function removeMemberBD($id){
        $manager = new ManageMember($this->getDataBase());
        return $manager->removeMemberBD($id);
    }
    
    /* editar member base de datos --*/
    function editMemberBD($id){
        $manager = new ManageMember($this->getDataBase());
        return $manager->editMember($id);
    }
    
    /* editar member sin clave base de datos --*/
    function editMemberBDsinClave($id){
        $manager = new ManageMember($this->getDataBase());
        return $manager->editMemberSinClave($id);
    }
     /* --- Obtener datos de member --- */
    
    function getMember($id){
        $manager = new ManageMember($this->getDataBase());
        return $manager->getMember($id);
    }
    
    /* --- Cuantos  member --- */
    
    function countMember(){
        $manager = new ManageMember($this->getDataBase());
        return $manager->countMember();
    }
    
    function getAllLimitMember($offset , $rpp){
        $manager = new ManageMember($this->getDataBase());
        return $manager->getAllLimitMember($offset , $rpp);
    }
}