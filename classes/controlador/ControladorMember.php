<?php

class ControladorMember extends Controlador { 
    
    /*function __construct(Modelo $modelo) {
        parent::__construct($modelo);
    }*/

 function index() {
        if($this->isLogged()) {
             if($this->getUser()->getLogin() == 'admin'){
                 $this->getModel()->setDato('archivo', '_index_logueado_admin.html');
                 //$member = '<a href="?ruta=member&accion=listMember"><i class="fa fa-user fa-lg"></i> Miembros </a>';
                 $this->getModel()->setDato('btnmember', '<a href="=member/listMember"><i class="fa fa-user fa-lg"></i> Miembros </a> | ');
             }else{
                 $this->getModel()->setDato('archivo', '_index_logueado.html');
                 //$this->getModel()->setDato('btnmember', $member);
             }
        } else {
            $this->getModel()->setDato('archivo', '_index_nologueado.html');
        }
    }
    
    /* --- acceso member --- */
    
    function login(){
        $member = Request::read('member');
        $clave = Request::read('clave');
        $usuarioDB = $this->getModel()->loginNombreUsuario($member);
        if($usuarioDB !== null) {
            if(Util::verificarClave($clave , $usuarioDB->getClave())){
                    $this->getSesion()->login($usuarioDB);
                    $this->getModel()->setDato('login' , $this->getSesion()->getUser()->getLogin());
            } else {
                $this->getModel()->setDato('mensaje', 'Las contraseña no es correcta.');
            } 
            
        } else {
            $this->getModel()->setDato('mensaje', 'No estás registrado.');
        }
        $this->index();
    }
    
    /* --- plantilla de insertar de member --- */
    function insertMember() {
        if($this->isLogged()) {
            if($this->getUser()->getLogin() == 'admin'){
            $header = file_get_contents("plantilla/_header.html");
            $this->getModel()->setDato('header', $header);
            $footer = file_get_contents("plantilla/_footer.html");
            $this->getModel()->setDato('footer', $footer);
            $this->getModel()->setDato('archivo' , 'miembro/_insert_member.html');
            }else{
                 $this->index();
            }
        } else {
            $this->index();
        }
    }
    
    /* --- insertar nuevo member --- */
     
    function doinsertMember() {
        if($this->isLogged()) {
            if($this->getUser()->getLogin() == 'admin'){
                $member = new Member();
                $member->read();
                $repetidaClave = Request::read('claveRepeat');
                if($member->getClave() === $repetidaClave){
                    $this->getModel()->insertMemberBD($member);
                  //  $this->getModel()->setDato('archivo' , 'miembro/_list_member.html');
                    header('Location: listMember');
                    echo 'NOOO he llegado aqui';
                    exit;
                    
                } else {
                    $this->getModel()->setDato('mensaje', 'error, no coinciden contraseñas');
                    $this->index();
                }
            } else {
                $this->index();
            }
        }else{
            $this->index();
        }
        header('Location: listMember');
    }
    
    /*--- borrar miembro --*/
    function doremoveMember(){
        if($this->isLogged()){
            $cliente = $this->getModel()->getMember(Request::read('id'));
            $r = $this->getModel()->removeMemberBD($cliente->getId());
            header('Location: listMember');
        }else{
            $this->index();
        }
    }
    
    /* --- lista  member --- */
    function listMember() {
        if($this->isLogged()) {
            if($this->getUser()->getLogin() == 'admin'){
            $header = file_get_contents("plantilla/_header.html");
            $this->getModel()->setDato('header', $header);
            $footer = file_get_contents("plantilla/_footer.html");
            $this->getModel()->setDato('footer', $footer);
            $this->getModel()->setDato('archivo' , 'miembro/_list_member.html');
                        $linea = '<tr data-id="{{id}}"  data-login="{{login}}" id="tableMember">
                        <td>{{id}}</td> 
                        <td>{{login}}</td>
                        <td>
                            <a href="member/editMember&id={{id}}"
                            data-toggle="tooltip" title class="btn btn-effect-ripple btn-sm btn-success" data-original-title="Ver más detalle">
                                <i class="fa fa-search"></i> editar
                            </a>
                        </td> 
                        <td id="borrar">
                            <div data-toggle="tooltip" title class="btn btn-effect-ripple btn-sm btn-danger" data-original-title="Eliminar usuario">
                                <i class="fa fa-times"></i> borrar
                            </div>
                        </td> 
                    </tr>';
            //$usuarios = $this->getModel()->getUsuarios();
            $page = Request::read('page');
            if($page === null){
                $page = 1;
            }
            $rows = $this->getModel()->countMember();
            $rpp = 4;
            $pagination = new Pagination($rows , $page , $rpp);
            $members = $this->getModel()->getAllLimitMember($pagination->getOffset() , $pagination->getRpp());
            $todo = '';
            foreach($members as $indice => $member) {
                $r = Util::renderText($linea, $member->getAttributesValues());
                $todo .= $r;
            }
            $this->getModel()->setDato('lineMember', $todo);
            
            $clickPaginacion = '<li>
                                    <a title="Primero" href="member/listMember&page=' . $pagination->getFirst() . '" class="m-datatable__pager-link m-datatable__pager-link--first">
                                    <i class="la la-angle-double-left"></i></a>
                                </li>
                                <li>
                                    <a title="Anterior" href="member/listMember&page=' . $pagination->getPrevius() . '" class="m-datatable__pager-link m-datatable__pager-link--prev">
                                    <i class="la la-angle-left"></i></a></li>
                                </li>';
            $rango = $pagination->getRange();
            foreach ($rango as $pagina) {
                $clickPaginacion .= '<li>
                                        <a href="member/listMember&page=' . $pagina . '" class="m-datatable__pager-link m-datatable__pager-link-number">' . $pagina . '</a>
                                    </li>';
            }
            $clickPaginacion .= '<li>
                                    <a title="Siguiente" href="member/listMember&page=' . $pagination->getNext() . '" class="m-datatable__pager-link m-datatable__pager-link--next">
                                    <i class="la la-angle-right"></i></a>
                                </li>
                                 <li>
                                    <a title="Último" href="member/listMember&page=' . $pagination->getLast() . '" class="m-datatable__pager-link m-datatable__pager-link--last">
                                    <i class="la la-angle-double-right"></i></a>
                                </li>';
            $this->getModel()->setDato('clickPaginacion', $clickPaginacion);
            
            $this->getModel()->setDato('mensaje', $rows);
            }else{
                 $this->index();
            }
        } else {
            $this->index();
        }
    }
    
    /* --- ver ficha y editar miembro --- */
    
    function editMember(){
        $id = Request::read('id');
        if($this->isLogged()) {
             if($this->getUser()->getLogin() == 'admin'){
            $header = file_get_contents("plantilla/_header.html");
            $this->getModel()->setDato('header', $header);
            $footer = file_get_contents("plantilla/_footer.html");
            $this->getModel()->setDato('footer', $footer);
            $this->getModel()->setDato('archivo' , 'miembro/_edit_member.html');
            $memberEdit = $this->getModel()->getMember($id);
            $this->getModel()->setDatos($memberEdit->getAttributesValues());
        } else{
            $this->index();
        }
        }else{
            $this->index();
        }
        $this->getModel()->setDato('mensaje', $this->getModel()->setDatos($memberEdit->getAttributesValues()));
    }
    
     function doeditMember(){
        $member = new Member();
        $member->read();
        if($this->isLogged()){
            if($this->getUser()->getLogin() == 'admin'){
                if($member->getClave() === null) {
                    $this->getModel()->editMemberBDsinClave($member);
                } else {
                    $this->getModel()->editMemberBD($member);
                }
               $this->getModel()->setDato('archivo' , 'miembro/_list_member.html');
                header('Location: listMember');
               exit;
            } else {
               $this->index(); 
           }
        }else{
            $this->index();
           
        }
    }
    
    
    function cerrarsesion() {
        $this->getSesion()->close();
        header('Location: index');
        //exit();
    }
    
}