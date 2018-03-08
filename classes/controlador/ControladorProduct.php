<?php

class ControladorProduct extends Controlador { 

    function __construct(Modelo $modelo) {
        parent::__construct($modelo);
    }
    
        /* --- plantilla Insertar producto --- */

    function insertarProducto() {
        if($this->isLogged()) {
            $header = file_get_contents("plantilla/_header.html");
            $this->getModel()->setDato('header', $header);
            $footer = file_get_contents("plantilla/_footer.html");
            $this->getModel()->setDato('footer', $footer);
            $this->getModel()->setDato('archivo' , 'producto/_insertar_producto.html');
            $todos = $this->getModel()->getAllFamilies();
            $this->getModel()->setDato('option', $todos);
            
        } else {
            $this->index();
        }
    }
    
    /* --- insertar nuevo producto --- */
    
    function doInsertarProducto() {
        if($this->isLogged()) {
        $producto = new Product();
        $producto->read();
        $resultado = $this->getModel()->insertarProductoBD($producto);
        $this->subirfoto($resultado);
       // header('Location: ?ruta=product&accion=listaProducto');
        header('Location: listaProducto');
        } else{
            $this->index();
        }
    }

     /* --- borrar producto --- */ 
     
    function doborrarProducto() {
          if ($this->isLogged()){
            $id = Request::read('id');
            $res = $this->getModel()->borrarProductoBD($id);
            header('Location: listaProducto');
        } else{
            $this->index();
        }
    }
    
    /* --- plantilla editar producto --- */ 
    
        function editarProducto() {
        $id = Request::read('id');
        if($this->isLogged()) {
            $header = file_get_contents("plantilla/_header.html");
            $this->getModel()->setDato('header', $header);
            $footer = file_get_contents("plantilla/_footer.html");
            $this->getModel()->setDato('footer', $footer);
            $this->getModel()->setDato('archivo' , 'producto/_editar_producto.html');
            $productoEditar = $this->getModel()->getProduct($id);
            $this->getModel()->setDatos($productoEditar->getAttributesValues());
            $todos = $this->getModel()->getAllFamilies();
            $this->getModel()->setDato('option', $todos);
        } else {
            $this->index();
        }
    }
    
    /* -- editar nuevo producto --*/
     
    function doeditarProducto() {
        if($this->isLogged()){
            $producto = new Product();
            $producto->read();
            $idproduct = $producto->getId();
            $this->getModel()->editarProductoBD($producto);
            $this->subirfoto($idproduct);
            header('Location: listaProducto');
           // exit();
        }else{
            $this->index();
        }
    }
    
    

    
    /* --- Lista de producto --- */
    function listaProducto() {
        if($this->isLogged()) {
            $header = file_get_contents("plantilla/_header.html");
            $this->getModel()->setDato('header', $header);
            $footer = file_get_contents("plantilla/_footer.html");
            $this->getModel()->setDato('footer', $footer);
            $this->getModel()->setDato('archivo' , 'producto/_listado_producto.html');
            $page = Request::read('page');
            if($page === null){
                $page = 1;
            }
            $rows = $this->getModel()->countProductos();
            $rpp = 5;
            $pagination = new Pagination($rows , $page , $rpp);
            $productos = $this->getModel()->getAllLimitProductos($pagination->getOffset() , $pagination->getRpp());
            $todo = '';
            
            //$familia = $this->getModel()->getFamilias();
            
            foreach($productos as $indice => $producto) {
                 $r = '<tr data-id="'. $producto->getId() .'" data-product="'. $producto->getProduct() .'" style="text-align:center; font-weight:500;">
                        <td>' . $producto->getProduct() . '</td> 
                        <td>' . $producto->getPrice() . '</td> 
                        <td>' . $producto->getDescription() . '</td> 
                        <td>' . $this->getModel()->getNombreFamilia($producto->getIdfamily())->getFamily() . '</td> 
                        <td><img style="width: 100px;" src="product/viewPhotoAndPhotoDefault&idPhoto=' . $producto->getId() . '.jpg"></td>
                        <td>
                            <a href="product/editarProducto&id=' . $producto->getId() . '"
                            data-toggle="tooltip" title class="btn btn-effect-ripple btn-sm btn-success" data-original-title="Ver más detalle">
                                <i class="fa fa-search"></i> editar
                            </a>
                        </td> 
                        <td id="borrar">
                            <div data-toggle="tooltip" title class="btn btn-effect-ripple btn-sm btn-danger" data-original-title="Eliminar Producto">
                                <i class="fa fa-times"></i> borrar
                            </div>
                        </td> 
                    </tr>';
                $todo .= $r;
            }
            $this->getModel()->setDato('lineasUsuario', $todo);
            //$this->getModel()->setDato('mensaje', $this->getModel()->getNombreFamilia(1));
            
            $clickPaginacion = '<li>
                                    <a title="Primero" href="product/listaProducto&page=' . $pagination->getFirst() . '" class="m-datatable__pager-link m-datatable__pager-link--first">
                                        <i class="la la-angle-double-left"></i></a>
                                </li>
                                <li><a title="Anterior" href="product/listaProducto&page=' . $pagination->getPrevius() . '" class="m-datatable__pager-link m-datatable__pager-link-number">
                                    <i class="la la-angle-left"></i></a></li>
                                </li>';
            $rango = $pagination->getRange();
            foreach ($rango as $pagina) {
                $clickPaginacion .= '<li><a href="product/listaProducto&page=' . $pagina . '" class="m-datatable__pager-link m-datatable__pager-link-number">' . $pagina . '</a></li>';
            }
            $clickPaginacion .= '<li>
                                    <a title="Siguiente" href="product/listaProducto&page=' . $pagination->getNext() . '" class="m-datatable__pager-link m-datatable__pager-link--next">
                                    <i class="la la-angle-right"></i></a></li>
                                 <li>
                                     <a title="Último" href="product/listaProducto&page=' . $pagination->getLast() . '" class="m-datatable__pager-link m-datatable__pager-link--last">
                                        <i class="la la-angle-double-right"></i></a>
                                </li>';
            $this->getModel()->setDato('clickPaginacion', $clickPaginacion);
            
        } else {
            $this->index();
        }
    }
    
    /* Base de dato de producto para Ajax*/
    /*
    function getProducts(){
        if($this->isLogged()){
            $productos = $this->getModel()->getProducts();
            $array = [];
            foreach($productos as $producto){
                $array[]= $producto->getAttributesValues();
            }
            $this->getModel()->setDato('listado' , $array);
        }
    }
    */
    
    /* Base de dato de limitado de producto para Ajax*/
    
    function getLimitProductsAjax(){
        $idfamily = Request::read('idfamily');
        if($this->isLogged()){
            $productos = $this->getModel()->getLimitProductsAjax($idfamily);
            $array = [];
            foreach($productos as $producto){
                $array[]= $producto->getAttributesValues();
            }
            $this->getModel()->setDato('listado' , $array);
        }
    }
    
    function getProductsAjax(){
        if($this->isLogged()){
            $productos = $this->getModel()->getProducts();
            $array = [];
            foreach($productos as $producto){
                $array[]= $producto->getAttributesValues();
            }
            $this->getModel()->setDato('listado' , $array);
        }
    }
    
    
    /* --- subir foto --- */
    
    function subirfoto($idproduct) {
       if($this->isLogged()) {
            $subir = new FileUpload('foto', $idproduct . ".jpg", 'plantilla/img/productos', 2 * 1024 * 1024, FileUpload::SOBREESCRIBIR);
            $r = $subir->upload();
            header('Location: listaProducto');
          //  exit();
            
        } else {
           $this->index();
        }
    }
    
    
    function viewPhotoAndPhotoDefault() {
        if($this->isLogged()) {
            $idPhoto = Request::read('idPhoto');
            header('Content-type: image/*');
            $archivo = 'plantilla/img/productos/' . $idPhoto;
            if(!file_exists($archivo)) {
                $archivo = 'plantilla/img/productos/0.jpg';
            }
            readfile($archivo);
            exit();
        } else {
            $this->index();
        }
    }
    
    
}