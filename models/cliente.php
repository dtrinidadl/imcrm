<?php

class cliente {
    
    private $id;
    private $nombre;
    private $nit;
    private $telefono;
    private $domicilio;
    private $codDepartamento;
    private $codMunicipio;
    private $fCreacion;
    private $fModificacion;
    private $fEliminacion;
    private $idEstado;
    private $db;
    
     public function __construct() {
        $this->db = Database::connect();
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

    function getDomicilio() {
        return $this->domicilio;
    }

    function getCodDepartamento() {
        return $this->codDepartamento;
    }

    function getCodMunicipio() {
        return $this->codMunicipio;
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

    function setId($id) {
        $this->id = $id;
    }

    function setNombre($nombre) {
        $this->nombre = $nombre;
    }

    function setNit($nit) {
        $this->nit = $nit;
    }

    function setTelefono($telefono) {
        $this->telefono = $telefono;
    }

    function setDomicilio($domicilio) {
        $this->domicilio = $domicilio;
    }

    function setCodDepartamento($codDepartamento) {
        $this->codDepartamento = $codDepartamento;
    }

    function setCodMunicipio($codMunicipio) {
        $this->codMunicipio = $codMunicipio;
    }

    function setFCreacion($fCreacion) {
        $this->fCreacion = $fCreacion;
    }

    function setFModificacion($fModificacion) {
        $this->fModificacion = $fModificacion;
    }

    function setFEliminacion($fEliminacion) {
        $this->fEliminacion = $fEliminacion;
    }

    function setIdEstado($idEstado) {
        $this->idEstado = $idEstado;
    }

    public function getAll() {
        $query = "select c.* , e.nombre as  nombreEstado, cd.nombre as nombreDepartamento, "
                . "cm.nombre as nombreMunicipio from cliente as c inner join estado as e on e.id = c.idEstado "
                . "inner join cat_departamento as cd on cd.codIso = c.codDepartamento "
                . "inner join cat_municipio as cm on cm.codMunicipio = c.codMunicipio;";
        $execute = $this->db->query($query);

        $result = false;
        if ($execute) {
            $result = $execute;
        }
        return $result;
    }
    
    public function getOne() {
        $query = "Select * From cliente Where id = {$this->getId()};";
        $execute = $this->db->query($query);

        $result = false;
        if ($execute) {
            $result = $execute;
        }

        return $result;
    }
    
    public function save() {
        $insert = "insert into cliente values(null, "
                . "'{$this->getNombre()}', "
                . "'{$this->getNit()}', "
                . "'{$this->getTelefono()}', "
                . "'{$this->getDomicilio()}', "
                . "'{$this->getCodDepartamento()}', "
                . "'{$this->getCodMunicipio()}', "
                . "curdate(), "
                . "null, "
                . "null, "
                . "{$this->getIdEstado()});";
        $execute = $this->db->query($insert);

        $result = false;
        if ($execute) {
            $result = $execute;
        }
        return $result;
    }
    
    public function update() {
         $update = "update cliente set nombre = '{$this->getNombre()}' ,"
                . " nit = '{$this->getNit()}' ,"
                . "telefono = '{$this->getTelefono()}', "
                . "domicilio = '{$this->getDomicilio()}' , "
                . "codDepartamento = '{$this->getCodDepartamento()}' , "
                . "codMunicipio = '{$this->getCodMunicipio()}', "
                . "idEstado = {$this->getIdEstado()}, "
                . "fModificacion = curdate() where id = {$this->getId()} ;";
                
        $execute = $this->db->query($update);

        $result = false;
        if ($execute) {
            $result = true;
        }

        return $result;
    }
    
   public function activate() {
        $update = "Update cliente Set idEstado = 1, fModificacion = curdate(), fEliminacion = null "
                . "Where id = {$this->getId()};";
        $execute = $this->db->query($update);

        $result = false;
        if ($execute) {
            $result = true;
        }

        return $result;
    }

    public function inactivate() {
        $update = "Update cliente Set idEstado = 2, fEliminacion = curdate() "
                . "Where id = {$this->getId()};";
        $execute = $this->db->query($update);

        $result = false;
        if ($execute) {
            $result = true;
        }

        return $result;
    }
    
    //Buscar Cliente por el Nit
    public function getClienteByNit() {
        $query = "SELECT * FROM cliente WHERE nit LIKE '%{$this->getNit()}%';";
        $execute = $this->db->query($query);
//        utils::drawDebug($execute);
        
        $result = false;
        if ($execute) {
            $result = $execute;
        }

        return $result;
    }
}



 ?>

