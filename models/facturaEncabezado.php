<?php

class facturaEncabezado {

    private $id;
    private $serie;
    private $noFactura;
    private $idComercio;
    private $idCliente;
    private $subTotal;
    private $impuesto;
    private $montoTotal;
    private $fFacturacion;
    private $fAnulacion;
    private $idEstado;
    private $autorizacion;
    private $db;

    function __construct() {
        $this->db = Database::connect();
    }
    
    function getAutorizacion() {
        return $this->autorizacion;
    }

    function setAutorizacion($autorizacion): void {
        $this->autorizacion = $autorizacion;
    }
    
    function getSerie() {
        return $this->serie;
    }

    function getNoFactura() {
        return $this->noFactura;
    }

    function setSerie($serie): void {
        $this->serie = $serie;
    }

    function setNoFactura($noFactura): void {
        $this->noFactura = $noFactura;
    }

    
    function getId() {
        return $this->id;
    }

    function getIdComercio() {
        return $this->idComercio;
    }

    function getIdCliente() {
        return $this->idCliente;
    }

    function getSubTotal() {
        return $this->subTotal;
    }

    function getImpuesto() {
        return $this->impuesto;
    }

    function getMontoTotal() {
        return $this->montoTotal;
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

    function setIdComercio($idComercio): void {
        $this->idComercio = $idComercio;
    }

    function setIdCliente($idCliente): void {
        $this->idCliente = $idCliente;
    }

    function setSubTotal($subTotal): void {
        $this->subTotal = $subTotal;
    }

    function setImpuesto($impuesto): void {
        $this->impuesto = $impuesto;
    }

    function setMontoTotal($montoTotal): void {
        $this->montoTotal = $montoTotal;
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

    public function getAll($id_comercio) {
        $query = "SELECT c.nombre AS nombreCliente, c.nit AS nitCliente, f.*, e.nombre AS nombreEstado " 
                ." FROM factura_encabezado f "
                ." INNER JOIN cliente c ON c.id = f.idCliente "
                ." INNER JOIN estado e ON e.id = f.idEstado "
                ." WHERE idComercio = $id_comercio";
        $execute = $this->db->query($query);

        $result = false;
        if ($execute) {
            $result = $execute;
        }
        return $result;
    }
    
     public function getOneById() {
         $query = "SELECT c.nombre AS nombreCliente, c.nit AS nitCliente, c.domicilio AS domicilioCliente, "
                 . "c.email, c.telefono, DATE_FORMAT(f.fFacturacion, '%d/%m/%Y - %h:%i %p') as 'fecha',"
                 . " f.* " 
                ." FROM factura_encabezado f  "
                ." INNER JOIN cliente c ON c.id = f.idCliente  "
                ." WHERE f.serie = '{$this->getSerie()}' AND f.noFactura = {$this->getNoFactura()};";
        //print   $query; die();      
        $execute = $this->db->query($query);
        
        $result = false;
        if ($execute) {
            $result = $execute;
        }
        return $result;
     }
     
     public function save() {
        $query = "INSERT INTO factura_encabezado "
                . "(noFactura, serie, idComercio, idCliente, montoTotal, impuesto, subTotal, autorizacion, fFacturacion, idEstado)  "
                . "VALUES ({$this->getNoFactura()}, '{$this->getSerie()}', {$this->getIdComercio()}, {$this->getIdCliente()}, "
                . "{$this->getMontoTotal()}, {$this->getImpuesto()}, {$this->getSubTotal()}, '{$this->getAutorizacion()}',   "
                . "CURTIME(), 1);";
                
               
                
        $execute = $this->db->query($query);
               
        $result = false;
        if ($execute) {
            $result = $execute;
        }
        return $result;
     }
    

}
