<?php

class Vista {
    
    private $modelo;
    
    function __construct(Modelo $modelo) {
        $this->modelo = $modelo;
    }

    function getModel(){
        return $this->modelo;
    }

    private function index() {
        //los datos que hay en el modelo sirven para mostrarlos o incluso para saber el archivo que estoy procesando
        $datos = $this->getModel()->getDatos();
        //echo Util::varDump($datos);
        //echo $datos['archivo'];
        //$header = $datos['header'];
        //$header = Util::renderText($header, $datos);
        //$datos['header'] = $header;
        //$archivo = 'plantilla/' . $datos['archivo'];
        
        $header = 'plantilla/_header.html';
        $archivo = 'plantilla/' . $datos['archivo'];
        $footer = 'plantilla/_footer.html';
        
        $archivoHeader = file_get_contents($header);
        $archivoMitad = file_get_contents($archivo);
        $archivoFooter = file_get_contents($footer);
        
        $todo = $archivoHeader . $archivoMitad . $archivoFooter;
        
        return Util::renderText($todo, $datos);
        //return Util::renderTemplate($archivo, $datos);
    }

    function render($accion) {
        if(!method_exists(get_class(), $accion)) {
            $accion = 'index';
        }
        return $this->$accion();
    }
}