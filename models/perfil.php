<?php

class Perfil {

    private $id;
    private $idComercio;
    private $nombre;
    private $estado;
    private $predeterminado;
    private $fechaAlta;
    private $fechaModificacion;
    private $fechaBaja;
    private $db;

    function __construct() {
        $this->db = Database::connect();
    }

    function getId() {
        return $this->id;
    }

    function getIdComercio() {
        return $this->idComercio;
    }

    function getNombre() {
        return $this->nombre;
    }

    function getEstado() {
        return $this->estado;
    }

    function getPredeterminado() {
        return $this->predeterminado;
    }

    function getFechaAlta() {
        return $this->fechaAlta;
    }

    function getFechaModificacion() {
        return $this->fechaModificacion;
    }

    function getFechaBaja() {
        return $this->fechaBaja;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setIdComercio($idComercio) {
        $this->idComercio = $idComercio;
    }

    function setNombre($nombre) {
        $this->nombre = $nombre;
    }

    function setEstado($estado) {
        $this->estado = $estado;
    }

    function setPredeterminado($predeterminado) {
        $this->predeterminado = $predeterminado;
    }

    function setFechaAlta($fechaAlta) {
        $this->fechaAlta = $fechaAlta;
    }

    function setFechaModificacion($fechaModificacion) {
        $this->fechaModificacion = $fechaModificacion;
    }

    function setFechaBaja($fechaBaja) {
        $this->fechaBaja = $fechaBaja;
    }

    public function getAll() {
        $strQuery = "select * from perfil;";

        $execute = $this->db->query($strQuery);

        $result = false;
        if ($execute) {
            $result = $execute;
        }

        return $result;
    }

    public function getOneById() {
        $strQuery = "select * from perfil where id_perfil= {$this->getId()};";
        $execute = $this->db->query($strQuery);
//        utils::drawDebug($strQuery);
//        die();

        $result = false;
        if ($execute) {
            $result = $execute;
        }

        return $result;
    }

    public function save() {
        $strInsert = "insert into perfil values (
                      null, 
                      {$this->getIdComercio()},
                      '{$this->getNombre()}',    
                      {$this->getEstado()} ,
                      '{$this->getPredeterminado()}',
                      curdate(), 
                      null , 
                      null);";
        $execute = $this->db->query($strInsert);
//        utils::drawDebug($strInsert);
//        die();
        $result = FALSE;
        if ($execute) {
            $result = $execute;
        }
        return $result;
    }

    public function update() {
        $strUpdate = "update perfil 
                      set nombre = '{$this->getNombre()}', 
                      predeterminado = '{$this->getPredeterminado()}',
                      fechaModificacion = curdate()";
                   
        #delete or inactivate#
        if ($this->getEstado() == 2) {
            $strUpdate .= ", fechaBaja = curdate() , estado = 2 ";
        } elseif ($this->getEstado() == 1) {
            $strUpdate .= ", fechaBaja= null, estado = 1 ";
        }
        $strUpdate .= "where id_perfil = {$this->getId()};";
        
        $execute = $this->db->query($strUpdate);
        //echo $strUpdate; die();
        //$this->db->error; die();
        //utils::drawDebug($strUpdate);die();
        $result = false;
        if ($execute) {
            $result = $execute;
        }
        return $result;
    }

}
?>

