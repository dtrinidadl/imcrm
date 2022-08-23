<?php

class facturaDescripcion {
    
    private $id;
    private $noFactura;
    private $serie;
    private $descripcion;
    private $cantidad;
    private $precioUnidad;
    private $total;
    private $fFacturacion;
    private $fAnulacion;
    private $idEstado;
    private $db;
    
    function __Construct () {
        $this->db = Database::connect();
    }
    function getNoFactura() {
        return $this->noFactura;
    }

    function getSerie() {
        return $this->serie;
    }

    function setNoFactura($noFactura): void {
        $this->noFactura = $noFactura;
    }

    function setSerie($serie): void {
        $this->serie = $serie;
    }

        function getId() {
        return $this->id;
    }

    function getDescripcion() {
        return $this->descripcion;
    }

    function getCantidad() {
        return $this->cantidad;
    }

    function getPrecioUnidad() {
        return $this->precioUnidad;
    }

    function getTotal() {
        return $this->total;
    }

    function getFFacturacion() {
        return $this->fFacturacion;
    }

    function getFAnulacion() {
        return $this->fAnulacion;
    }

    function getIdEstado() {
        return $this->idEstado;
    }

    function setId($id): void {
        $this->id = $id;
    }

    function setDescripcion($descripcion): void {
        $this->descripcion = $descripcion;
    }

    function setCantidad($cantidad): void {
        $this->cantidad = $cantidad;
    }

    function setPrecioUnidad($precioUnidad): void {
        $this->precioUnidad = $precioUnidad;
    }

    function setTotal($total): void {
        $this->total = $total;
    }

    function setFFacturacion($fFacturacion): void {
        $this->fFacturacion = $fFacturacion;
    }

    function setFAnulacion($fAnulacion): void {
        $this->fAnulacion = $fAnulacion;
    }

    function setIdEstado($idEstado): void {
        $this->idEstado = $idEstado;
    }

    
    
    public function getAllById() {
        //$query = "SELECT * FROM factura_descripcion WHERE idFactura = {$this->getIdFactura()};";  
        $query = "SELECT * FROM factura_descripcion WHERE noFactura = {$this->getNoFactura()} AND serie = '{$this->getSerie()}'";  
        $execute = $this->db->query($query);
        
        $result = false;
        if ($execute) {
            $result = $execute;
        }
        return $result;
     }
     
     public function save() {
        $query = "INSERT INTO factura_descripcion "
                . "(noFactura, serie, descripcion, cantidad, precioUnidad, total, fFacturacion, idEstado) "
                . "VALUES ({$this->getNoFactura()}, '{$this->getSerie()}', '{$this->getDescripcion()}', "
                . "{$this->getCantidad()}, {$this->getPrecioUnidad()}, "
                . "({$this->getCantidad()} * {$this->getPrecioUnidad()}), "
                . "CURTIME(), 1);";
        $execute = $this->db->query($query);
        
        $result = false;
        if ($execute) {
            $result = $execute;
        }
        return $result;
     }
    
    
}