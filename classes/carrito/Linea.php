<?php

class Linea {
    
    private $id, $item, $cantidad;
    
    function __construct($id, $item = null, $cantidad = 1) {
        $this->id = $id;
        $this->item = $item;//es un objeto que tiene su propio getAttributesValues()
        $this->cantidad = $cantidad;
    }
    
    function getId() {
        return $this->id;
    }

    function getItem() {
        return $this->item;
    }

    function getCantidad() {
        return $this->cantidad;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setItem($item) {
        $this->item = $item;
    }

    function setCantidad($cantidad) {
        $this->cantidad = $cantidad;
    }

    // function getAttributesValues() {
    //     $valoresCompletos = [];
    //     foreach($this as $atributo => $valor) {
    //         if($atributo === 'item') {
    //             $valoresCompletos[$atributo] = $valor->getAttributesValues();
    //         } else {
    //             $valoresCompletos[$atributo] = $valor;
    //         }
    //     }
    //     $valoresCompletos['totalLinea'] = $this->getCantidad() * $this->getItem()->getPrecio();
    //     return $valoresCompletos;
    // }
    
    function getAttributesValues(){
        $valoresCompletos = [];
        foreach($this as $atributo => $valor){
            $valoresCompletos[$atributo] = $valor;
        }
        return $valoresCompletos;
    }
    
    // function getAttributesValues() {
    //     $valoresCompletos = [];
    //     foreach($this as $atributo => $valor) {
    //         $valoresCompletos[$atributo] = $valor;
    //     }
    //     return array('total' => $this->getTotal(), 'carrito' => $valoresCompletos);
    // }
    
    // function getTotal() {
    //     $total = 0;
    //     foreach($this as $atributo => $valor) {
    //         $total += $valor->getCantidad() * $valor->getItem()->getPrecio();
    //     }
    //     return $total;
    // }
}