<?php

class agente {

    private $id;
    private $nombre;
    private $nit;
    private $telefono;
    private $codDepartamento;
    private $codMunicipio;
    private $domicilio;
    private $zona;
    private $nombreContacto;
    private $telefonoContacto;
    private $mailContacto;
    private $fCreacion;
    private $fModificacion;
    private $fEliminacion;
    private $idEstado;
    private $db;

    public function __construct() {
        $this->db = Database::connect();
    }
    
    function getZona() {
        return $this->zona;
    }

    function setZona($zona): void {
        $this->zona = $zona;
    }

        
    function getDomicilio() {
        return $this->domicilio;
    }

    function setDomicilio($domicilio): void {
        $this->domicilio = $domicilio;
    }

        
    function getCodDepartamento() {
        return $this->codDepartamento;
    }

    function getCodMunicipio() {
        return $this->codMunicipio;
    }

    function setCodDepartamento($codDepartamento): void {
        $this->codDepartamento = $codDepartamento;
    }

    function setCodMunicipio($codMunicipio): void {
        $this->codMunicipio = $codMunicipio;
    }

        
    function getId() {
        return $this->id;
    }

    function getNombre() {
        return $this->nombre;
    }

    function getNit() {
        return $this->nit;
    }

    function getTelefono() {
        return $this->telefono;
    }

    function getNombreContacto() {
        return $this->nombreContacto;
    }

    function getTelefonoContacto() {
        return $this->telefonoContacto;
    }

    function getMailContacto() {
        return $this->mailContacto;
    }

    function getFCreacion() {
        return $this->fCreacion;
    }

    function getFModificacion() {
        return $this->fModificacion;
    }

    function getFEliminacion() {
        return $this->fEliminacion;
    }

    function getIdEstado() {
        return $this->idEstado;
    }

    function setId($id): void {
        $this->id = $id;
    }

    function setNombre($nombre): void {
        $this->nombre = $nombre;
    }

    function setNit($nit): void {
        $this->nit = $nit;
    }

    function setTelefono($telefono): void {
        $this->telefono = $telefono;
    }

    function setNombreContacto($nombreContacto): void {
        $this->nombreContacto = $nombreContacto;
    }

    function setTelefonoContacto($telefonoContacto): void {
        $this->telefonoContacto = $telefonoContacto;
    }

    function setMailContacto($mailContacto): void {
        $this->mailContacto = $mailContacto;
    }

    function setFCreacion($fCreacion): void {
        $this->fCreacion = $fCreacion;
    }

    function setFModificacion($fModificacion): void {
        $this->fModificacion = $fModificacion;
    }

    function setFEliminacion($fEliminacion): void {
        $this->fEliminacion = $fEliminacion;
    }

    function setIdEstado($idEstado): void {
        $this->idEstado = $idEstado;
    }

        
    public function getAll() {
        $query = "Select a.*, e.nombre As nombreEstado From agente As a "
                . "Inner Join estado As e On e.id = a.idEstado;";
        $execute = $this->db->query($query);

        $result = false;
        if ($execute) {
            $result = $execute;
        }

        return $result;
    }

    public function getOne() {
        $query = "Select * From agente Where id = {$this->getId()};";
        $execute = $this->db->query($query);

        $result = false;
        if ($execute) {
            $result = $execute;
        }

        return $result;
    }

    public function save() {
        $insert = "Insert Into agente "
                . "Values (null, "
                . "'{$this->getNombre()}', "
                . "'{$this->getNit()}', "
                . "'{$this->getTelefono()}', "
                . "'{$this->getCodDepartamento()}', "
                . "'{$this->getCodMunicipio()}', "
                . "'{$this->getDomicilio()}', "
                . "'{$this->getZona()}', "
                . "'{$this->getNombreContacto()}', "
                . "'{$this->getTelefonoContacto()}', "
                . "'{$this->getMailContacto()}', "
                . "curdate(), "
                . "null, "
                . "null, "
                . "{$this->getIdEstado()});";
        $execute = $this->db->query($insert);
        //print $insert.'<br>'; 
        //print $this->db->error; die();
        $result = false;
        if ($execute) {
            $result = true;
        }

        return $result;
    }

    public function update() {
        $update = "Update agente Set nombre = '{$this->getNombre()}', "
                . "nit = '{$this->getNit()}', "
                . "domicilio = '{$this->getDomicilio()}', "
                . "codDepartamento = {$this->getCodDepartamento()}, "
                . "codMunicipio = '{$this->getCodMunicipio()}', "
                . "zona = '{$this->getZona()}', "
                . "telefono = '{$this->getTelefono()}', "
                . "nombreContacto = '{$this->getNombreContacto()}', "
                . "mailContacto = '{$this->getMailContacto()}', "
                . "telefonoContacto = '{$this->getTelefonoContacto()}', "
                . "fModificacion = curdate(), "
                . "idEstado = {$this->getIdEstado()} "
                . "Where id = {$this->getId()};";
        $execute = $this->db->query($update);
        //print $update.'<br>'; 
        //print $this->db->error; die();
        
        $result = false;
        if ($execute) {
            $result = true;
        }

        return $result;
    }

    public function activate() {
        $update = "Update agente Set idEstado = 1, fModificacion = curdate(), fEliminacion = null "
                . "Where id = {$this->getId()};";
        $execute = $this->db->query($update);

        $result = false;
        if ($execute) {
            $result = true;
        }

        return $result;
    }

    public function inactivate() {
        $update = "Update agente Set idEstado = 2, fEliminacion = curdate() "
                . "Where id = {$this->getId()};";
        $execute = $this->db->query($update);

        $result = false;
        if ($execute) {
            $result = true;
        }

        return $result;
    }

}
