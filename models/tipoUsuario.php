<?php

class tipoUsuario {

    function __construct() {
        $this->db = Database::connect();
    }
    
    private $id;
    private $nombre;
    private $db;
    
    function getId() {
        return $this->id;
    }

    function getNombre() {
        return $this->nombre;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setNombre($nombre) {
        $this->nombre = $nombre;
    }

    public function getAll(){
        $query = "select * from tipo_usuario";
        $execute = $this->db->query($query);
        
        $result = false;
        if ($execute) {
            $result = $execute;
        }
        
        return $result;
    }

}

