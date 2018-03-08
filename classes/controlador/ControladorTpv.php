<?php

class ControladorTpv extends Controlador{
    
    // function index(){
    //     if($this->isLogged()){
    //         $header = file_get_contents("plantilla/_header.html");
    //         $this->getModel()->setDato('header', $header);
    //         $footer = file_get_contents("plantilla/_footer.html");
    //         $this->getModel()->setDato('footer', $footer);
    //         $this->getModel()->setDato('archivo' , 'tpv/_tpv.html');
    //     }else{
    //         header('Location: index.php');
    //     }
    // }
    
     /* --- Apuntar ticket cliente --- */
    //     function listaClienteRegisterTicket() {
    //     if($this->isLogged()) {
    //         $header = file_get_contents("plantilla/_header.html");
    //         $this->getModel()->setDato('header', $header);
    //         $footer = file_get_contents("plantilla/_footer.html");
    //         $this->getModel()->setDato('footer', $footer);
    //         $this->getModel()->setDato('archivo' , 'tpv/_tpv.html');
    //         $linea = '<tr data-idclient="{{id}}">
    //                     <td>{{name}}</td> 
    //                     <td>{{surname}}</td> 
    //                     <td>{{tin}}</td> 
    //                     <td>{{email}}</td> 
    //                     <td>
    //                         <!--<a href="?ruta=client&accion=editarCliente&id={{id}}" data-toggle="tooltip" title class="btn btn-effect-ripple btn-sm btn-success" data-original-title="Apuntar Ticket">-->
    //                             <i class="fa fa-search"></i>Apuntar ticket
    //                       <!-- </a>-->
    //                     </td> 
    //                 </tr>';
    //         //$usuarios = $this->getModel()->getUsuarios();
    //         $page = Request::read('page');
    //         if($page === null){
    //             $page = 1;
    //         }
    //         $rows = $this->getModel()->countClientes();
    //         $rpp = 3;
    //         $pagination = new Pagination($rows , $page , $rpp);
    //         $clientes = $this->getModel()->getAllLimitClientes($pagination->getOffset() , $pagination->getRpp());
    //         $todo = '';
    //         foreach($clientes as $indice => $cliente) {
    //             $r = Util::renderText($linea, $cliente->getAttributesValues());
    //             $todo .= $r;
    //         }
    //         $this->getModel()->setDato('lineasUsuario', $todo);
            
    //         $clickPaginacion = '<ul class="pagination" id="pagination">
    //                             <li ><a href="?ruta=tpv&ruta=tpv&accion=listaClienteRegisterTicket&page=' . $pagination->getFirst() . '"><i class="fa fa-chevron-left "></i><i class="fa fa-chevron-left"></i></a></li>
    //                             <li><a href="?accion=listaClienteRegisterTicket&page=' . $pagination->getPrevius() . '"><i class="fa fa-chevron-left "></i></a></li>';
    //         $rango = $pagination->getRange();
    //         foreach ($rango as $pagina) {
    //             $clickPaginacion .= '<li><a href="?ruta=tpv&accion=listaClienteRegisterTicket&page=' . $pagina . '">' . $pagina . '</a></li>';
    //         }
    //         $clickPaginacion .= '<li><a href="?ruta=tpv&accion=listaClienteRegisterTicket&page=' . $pagination->getNext() . '"><i class="fa fa-chevron-right "></i></a></li>
    //                              <li><a href="?ruta=tpv&accion=listaClienteRegisterTicket&page=' . $pagination->getLast() . '"><i class="fa fa-chevron-right"></i><i class="fa fa-chevron-right"></i></a></li>
    //                             </ul>';
    //         $this->getModel()->setDato('clickPaginacion', $clickPaginacion);
            
    //         $this->getModel()->setDato('mensaje', $rows);
            
    //     } else {
    //         $this->index();
    //     }
    // }
    
    function listaClienteRegisterTicket() {
        if($this->isLogged()) {
            $header = file_get_contents("plantilla/_header.html");
            $this->getModel()->setDato('header', $header);
            $footer = file_get_contents("plantilla/_footer.html");
            $this->getModel()->setDato('footer', $footer);
            $this->getModel()->setDato('archivo' , 'tpv/_tpv.html');
            $linea = '<tr data-idclient="{{id}}" data-name="{{name}}">
                        <td>{{name}}</td> 
                        <td>{{surname}}</td> 
                        <td>{{tin}}</td> 
                        <td>{{email}}</td> 
                        <td>
                                <i class="fa fa-search"></i>Apuntar ticket
                        </td> 
                    </tr>';
            $clientes = $this->getModel()->getAllClientes();
            $todo = '';
            foreach($clientes as $indice => $cliente) {
                $r = Util::renderText($linea, $cliente->getAttributesValues());
                $todo .= $r;
            }
            $this->getModel()->setDato('lineasClientes', $todo);
            
            
        } else {
            $this->index();
        }
    }

    
    
    
    // function getProductPorId(){
    //     $id = Request::read('idproduct');
    //     if($this->isLogged()){
    //         $familias = $this->getModel()->getProductPorId($id);
    //         $array = [];
    //         foreach($familias as $familia){
    //             $array[]= $familia->getAttributesValues();
    //         }
    //         $this->getModel()->setDato('producto' , $array);
    //     }
    // }
}