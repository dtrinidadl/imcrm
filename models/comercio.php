<?php

class comercio {

    private $id;
    private $idAgente;
    private $nombre;
    private $domicilio;
    private $zona;
    private $codDepartamento;
    private $codMunicipio;
    private $representante;
    private $DPIRepresentante;
    private $telefono;
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

        
    function getId() {
        return $this->id;
    }

    function getIdAgente() {
        return $this->idAgente;
    }

    function getNombre() {
        return $this->nombre;
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

    function getRepresentante() {
        return $this->representante;
    }

    function getDPIRepresentante() {
        return $this->DPIRepresentante;
    }

    function getTelefono() {
        return $this->telefono;
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

    function setIdAgente($idAgente) {
        $this->idAgente = $idAgente;
    }

    function setNombre($nombre) {
        $this->nombre = $nombre;
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

    function setRepresentante($representante) {
        $this->representante = $representante;
    }

    function setDPIRepresentante($DPIRepresentante) {
        $this->DPIRepresentante = $DPIRepresentante;
    }

    function setTelefono($telefono) {
        $this->telefono = $telefono;
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
                . "cm.nombre as nombreMunicipio from comercio as c inner join estado as e on e.id = c.idEstado "
                . "inner join cat_departamento as cd on cd.codIso = c.codDepartamento "
                . "inner join cat_municipio as cm on cm.codMunicipio = c.codMunicipio;";
        $execute = $this->db->query($query);

        $result = false;
        if ($execute) {
            $result = $execute;
        }
        return $result;
    }
    
    public function getComercioById() {
        //Query se cambio "Select c.* From comercio Where id = {$this->getId()}"
        $query = "Select c.*, cd.nombre as nombreDepartamento, cm.nombre as nombreMunicipio "
                . "FROM comercio AS c "
                . "INNER JOIN  cat_departamento as cd on cd.codIso = c.codDepartamento  "
                . "INNER JOIN  cat_municipio as cm on cm.codMunicipio = c.codMunicipio "
                . "Where c.id = {$this->getId()}";     
        $execute = $this->db->query($query);
        
        $result = false;
        if ($execute) {
            $result = $execute;
        }

        return $result;
    }
    
    public function getAllByName() {
        $query = "SELECT * FROM comercio WHERE nombre like '%{$this->getNombre()}%'";
        $execute = $this->db->query($query);
        
        $result = false;
        if ($execute) {
            $result = $execute;
        }

        return $result;
    }
    

    public function getOne() {
        $query = "Select * From comercio Where id = {$this->getId()};";
        $execute = $this->db->query($query);

        $result = false;
        if ($execute) {
            $result = $execute;
        }

        return $result;
    }

    public function save() {
        $insert = "insert into comercio values(null, "
                . "{$this->getIdAgente()}, "
                . "'{$this->getNombre()}', "
                . "'{$this->getDomicilio()}', "
                . "'{$this->getZona()}', "
                . "'{$this->getCodDepartamento()}', "
                . "'{$this->getCodMunicipio()}', "
                . "'{$this->getRepresentante()}', "
                . "'{$this->getDPIRepresentante()}', "
                . "'{$this->getTelefono()}', "
                . "curdate(), "
                . "null, "
                . "null, "
                . "{$this->getIdEstado()});";
        $execute = $this->db->query($insert);
//        var_dump($insert);
//        die();
        $result = false;
        if ($execute) {
            $result = $execute;
        }
        return $result;
    }

    public function update() {
        $update = "update comercio set nombre = '{$this->getNombre()}' ,"
                . " domicilio = '{$this->getDomicilio()}' ,"
                . " zona = '{$this->getZona()}' ,"
                . "codDepartamento = '{$this->getCodDepartamento()}', "
                . "codMunicipio = '{$this->getCodMunicipio()}' , "
                . "representante = '{$this->getRepresentante()}' , "
                . "DPIRepresentante = '{$this->getDPIRepresentante()}', "
                . "telefono = '{$this->getTelefono()}', "
                . "idEstado = '{$this->getIdEstado()}', "
                . "fModificacion = curdate() "
                . "where id = {$this->getId()} ;";
        $execute = $this->db->query($update);

        $result = false;
        if ($execute) {
            $result = true;
        }

        return $result;
    }

    public function activate() {
        $update = "Update comercio Set idEstado = 1, fModificacion = curdate(), fEliminacion = null "
                . "Where id = {$this->getId()};";
        $execute = $this->db->query($update);
        
        $result = false;
        if ($execute) {
            $result = true;
        }

        return $result;
    }

    public function inactivate() {
        $update = "Update comercio Set idEstado = 2, fEliminacion = curdate() "
                . "Where id = {$this->getId()};";
        $execute = $this->db->query($update);

        $result = false;
        if ($execute) {
            $result = true;
        }

        return $result;
    }

}
