<?php

class catEstadoAI {

    private $id;
    private $nombre;
    private $db;

    function __construct() {
        $this->db = Database::connect();
    }
    
    function getId() {
        return $this->id;
    }

    function getNombre() {
        return $this->nombre;
    }

    function setId($id): void {
        $this->id = $id;
    }

    function setNombre($nombre): void {
        $this->nombre = $nombre;
    }
    
    public function getAll(){
        $query = "SELECT * FROM estado";
        $execute = $this->db->query($query);

        $result = false;
        if($execute){
            $result = $execute;
        }
        
        return $result;
    }
    
    public function getNameById(){
        $query = "SELECT nombre FROM estado WHERE id = {$this->getId()}";
        $execute = $this->db->query($query);

        $result = false;
        if($execute){
            $result = $execute;
        }
        
        return $result;
    }



}
