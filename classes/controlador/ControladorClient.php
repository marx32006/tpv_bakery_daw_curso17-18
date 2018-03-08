<?php

class ControladorClient extends Controlador { 
    
    function __construct(Modelo $modelo) {
        parent::__construct($modelo);
    }

    /* ---  plantilla Insertar cliente --- */
    
    function insertarCliente() {
        if($this->isLogged()) {
            $header = file_get_contents("plantilla/_header.html");
            $this->getModel()->setDato('header', $header);
            $footer = file_get_contents("plantilla/_footer.html");
            $this->getModel()->setDato('footer', $footer);
            $this->getModel()->setDato('archivo' , 'cliente/_insertar_cliente.html');
        } else {
            $this->index();
        }
    }
    
    /* --- insertar nuevo cliente --- */
     
    function doinsertarCliente() {
        if($this->isLogged()) {
            $cliente = new Client();
            $cliente->read();
            $resultado = -1;
            //if(Filter::isEmail($cliente->getEmail())){
                $resultado = $this->getModel()->insertarClienteBD($cliente);
                header('Location: listaCliente');
           // {
         } else {
            $this->index();
         }
    }

    
    /* --- Borrar cliente --- */
        
    function doborrarCliente(){
        if($this->isLogged()){
            $cliente = $this->getModel()->getClient(Request::read('id'));
            $r = $this->getModel()->borrarClienteBD($cliente->getId());
            $this->getModel()->setDato('res', $r);
            //header('Location: listaCliente');
        }
        // else{
        //     $this->index();
        // }
    }
    
    /* --- ver ficha y editar cliente --- */
    
    function editarCliente(){
        $id = Request::read('id');
        if($this->isLogged()) {
            $header = file_get_contents("plantilla/_header.html");
            $this->getModel()->setDato('header', $header);
            $footer = file_get_contents("plantilla/_footer.html");
            $this->getModel()->setDato('footer', $footer);
            $this->getModel()->setDato('archivo' , 'cliente/_editar_cliente.html');
            $clientEdit = $this->getModel()->getClient($id);
            $this->getModel()->setDatos($clientEdit->getAttributesValues());
        } else{
            $this->index();
        }
      //  $this->getModel()->setDato('mensaje', $this->getModel()->setDatos($clientEdit->getAttributesValues()));
    }
    
        function doeditarCliente(){
        if($this->isLogged()){
            $cliente = new Client();
            $cliente->read();
            $r = $this->getModel()->editarClienteBD($cliente);
          //  header('Location: ?ruta=client&op=doeditarCliente&res=' . $r);
            header('Location: listaCliente');
            exit();
        }else{
            $this->index();
        }
    }
    
        /* --- Lista de cliente --- */
    
    function listaCliente() {
        if($this->isLogged()) {
            $header = file_get_contents("plantilla/_header.html");
            $this->getModel()->setDato('header', $header);
            $footer = file_get_contents("plantilla/_footer.html");
            $this->getModel()->setDato('footer', $footer);
            $this->getModel()->setDato('archivo' , 'cliente/_listado_cliente.html');
            $linea = '<tr data-id="{{id}}" data-name="{{name}} {{surname}}">
                        <td>{{name}}</td> 
                        <td>{{surname}}</td> 
                        <td>{{tin}}</td> 
                        <td>{{email}}</td> 
                        <td>
                            <a href="client/editarCliente&id={{id}}"
                            data-toggle="tooltip" title class="btn btn-effect-ripple btn-sm btn-success" data-original-title="Ver más detalle">
                                <i class="fa fa-search"></i> 
                                editar
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
            $rows = $this->getModel()->countClientes();
            $rpp = 8;
            $pagination = new Pagination($rows , $page , $rpp);
            $clientes = $this->getModel()->getAllLimitClientes($pagination->getOffset() , $pagination->getRpp());
            $todo = '';
            foreach($clientes as $indice => $cliente) {
                $r = Util::renderText($linea, $cliente->getAttributesValues());
                $todo .= $r;
            }
            $this->getModel()->setDato('lineasUsuario', $todo);
            
            $clickPaginacion = '<li>
                                    <a title="Primero" href="client/listaCliente&page=' . $pagination->getFirst() . '" class="m-datatable__pager-link m-datatable__pager-link--first">
                                    <i class="la la-angle-double-left"></i></a>
                                </li>
                                <li>
                                    <a title="Anterior"  href="client/listaCliente&page=' . $pagination->getPrevius() . '" class="m-datatable__pager-link m-datatable__pager-link--prev">
                                    <i class="la la-angle-left"></i></a></li>
                                </li>';
            $rango = $pagination->getRange();
            foreach ($rango as $pagina) {
                $clickPaginacion .= '<li><a href="client/listaCliente&page=' . $pagina . '" class="m-datatable__pager-link m-datatable__pager-link-number">' . $pagina . '</a></li>';
            }
            $clickPaginacion .= '<li>
                                    <a title="Siguiente" href="client/listaCliente&page=' . $pagination->getNext() . '" class="m-datatable__pager-link m-datatable__pager-link--next">
                                        <i class="la la-angle-right"></i></a>
                                </li>
                                <li>
                                    <a title="Último" href="client/listaCliente&page=' . $pagination->getLast() . '"  class="m-datatable__pager-link m-datatable__pager-link--last" >
                                    <i class="la la-angle-double-right"></i></a>
                                </li>';
            $this->getModel()->setDato('clickPaginacion', $clickPaginacion);
            
            $this->getModel()->setDato('mensaje', $rows);
            
        } else {
            $this->index();
        }
    }
    
   
}    
