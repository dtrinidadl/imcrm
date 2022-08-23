<?php
class catAcceso {

    private  $id;
    private  $nombre;
    private  $db;
            
    function __construct() {
        $this->db = Database::connect();
    }
    
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

    public function getAll() {
        $strQuey = "select * from cat_acceso;";
        $execute = $this->db->query($strQuey);
        
        $result = FALSE;
        if ($execute) {
            $result = $execute;
        }
        return $result;
    }
    
    public function getOneById() {
        $strQuery = "select * from cat_acceso where id = {$this->getId()};";
        $execute = $this->db->query($strQuery);
        
        $result = false;
        if ($execute) {
            $result = $execute;
        }
        return $result;
    }
    

}
?>

