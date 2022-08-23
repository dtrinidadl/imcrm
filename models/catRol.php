<?php

class catRol {
    private $id;
    private $nombreRol;
    private $db;
    
    function __construct() {
        $this->db = Database::connect();
    }
    
    function getId() {
        return $this->id;
    }

    function getNombreRol() {
        return $this->nombreRol;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setNombreRol($nombreRol) {
        $this->nombreRol = $nombreRol;
    }

    public function getAll(){
        $query = "Select * From cat_rol";
        $execute =  $this->db->query($query);
        
        $result = false;
        if($execute){
            $result = $execute;
        }
        
        return $result;
    }
    
    public function getRolById(){
        $query = "Select nombreRol From cat_rol Where id = {$this->getId()}";
        $execute =  $this->db->query($query);
        
        $result = false;
        if($execute){
            $result = $execute;
        }
        
        return $result;
    }
}