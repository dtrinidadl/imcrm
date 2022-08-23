<?php

class usuario {

    private $id;
    private $idComercio;
    private $idRol;
    private $dpi;
    private $nombre;
    private $usuario;
    private $email;
    private $contrasena;
    private $telefono;
    private $fCreacion;
    private $fModificacion;
    private $fEliminacion;
    private $idEstado;
    private $db;

    // private $userCode;
    // private $userName;
    // private $userPassword;
    // private $userCreatedDate;
    // private $userUpdatedDate;
    // private $userDeletedDate;
    // private $userStatus;
    // private $userDeleted;


    function __construct() {
        $this->db = Database::connect();
    }
    
    function getDpi() {
        return $this->dpi;
    }

    function setDpi($dpi): void {
        $this->dpi = $dpi;
    }

    
    function getUsuario() {
        return $this->usuario;
    }

    function getTelefono() {
        return $this->telefono;
    }

    function setUsuario($usuario): void {
        $this->usuario = $usuario;
    }

    function setTelefono($telefono): void {
        $this->telefono = $telefono;
    }

    function getId() {
        return $this->id;
    }

    function getIdComercio() {
        return $this->idComercio;
    }

    function getIdRol() {
        return $this->idRol;
    }

    function getNombre() {
        return $this->nombre;
    }

    function getEmail() {
        return $this->email;
    }

    function getContrasena() {
        //return $this->contrasena;
        return password_hash($this->db->real_escape_string($this->contrasena), PASSWORD_BCRYPT, ['cost' => 4]);
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

    function setIdComercio($idComercio) {
        $this->idComercio = $idComercio;
    }

    function setIdRol($idRol) {
        $this->idRol = $idRol;
    }

    function setNombre($nombre) {
        $this->nombre = $nombre;
    }

    function setEmail($email) {
        $this->email = $email;
    }

    function setContrasena($contrasena) {
        $this->contrasena = $contrasena;
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
    
    public function login() {
        $result = false;
        $_usuario = $this->usuario;
        $_contrasena = $this->contrasena;

        // Comprobar si existe el usuario
        $sql = "Select * From usuario Where usuario = '{$_usuario}' "
                . "And idEstado = 1;";                        
        
        $login = $this->db->query($sql);

        // utils::drawDebug($login->fetch_object());
        // die();
        
        $usuario_ = $login->fetch_object();
        $result = $usuario_;

        utils::drawDebug($result);
        // if ($login && $login->num_rows == 1) {
        //     $usuario_ = $login->fetch_object();
            
        //     // Verficacion de contraseña
        //     $verify = password_verify($_contrasena, $usuario_->contrasena);

        //     if ($verify) {
        //         $result = $usuario_;
        //     }
        // }
        
        return $result;
    }

    public function getAll() {
        $query = "Select u.* ,e.nombre as nombreEstado, em.nombre as nombreEmpresa , r.nombreRol as Rol "
                . "From usuario as u "
                . "inner join estado as e on e.id = u.idEstado "
                . "inner join comercio as em on u.idComercio = em.id  "
                . "inner join cat_rol as r on r.id= u.idRol;";
        $execute = $this->db->query($query);

        $result = false;
        if ($execute) {
            $result = $execute;
        }

        return $result;
    }

    public function getOne() {
        $query = "Select * From usuario Where id = {$this->getId()}";
        $execute = $this->db->query($query);

        $result = false;
        if ($execute) {
            $result = $execute;
        }

        return $result;
    }

    public function save() {
        $insert = "Insert Into usuario Values(null, "
                . "{$this->getIdComercio()}, "
                . "{$this->getIdRol()}, "
                . "'{$this->getDpi()}', "
                . "'{$this->getNombre()}', "
                . "'{$this->getUsuario()}', "
                . "'{$this->getEmail()}', "
                . "'{$this->getContrasena()}', "
                . "'{$this->getTelefono()}', "
                . "CURDATE(), null, null, {$this->getIdEstado()})";
        $execute = $this->db->query($insert);
        
        $result = false;
        if ($execute) {
            $result = $execute;
        }

        return $result;
    }

    public function update() {
        $update = "Update usuario set idComercio = {$this->getIdComercio()}, "
                . "idRol = {$this->getIdRol()}, "
                . "nombre = '{$this->getNombre()}', "
                . "email = '{$this->getEmail()}', "
                . "contrasena = '{$this->getContrasena()}', "
                ."telefono = '{$this->getTelefono()}', "
                . "idEstado = {$this->getIdEstado()}, "
                . "fModificacion = Curdate() "
                . "where id = {$this->getId()};";      
        $execute = $this->db->query($update);

        $result = false;
        if ($execute) {
            $result = $execute;
        }

        return $result;
    }

    public function activate() {
        $update = "Update usuario Set idEstado = 1, fModificacion = curdate(), fEliminacion = null "
                . "Where id = {$this->getId()};";
        $execute = $this->db->query($update);

        $result = false;
        if ($execute) {
            $result = true;
        }

        return $result;
    }

    public function inactivate() {
        $update = "Update usuario Set idEstado = 2, fEliminacion = curdate() "
                . "Where id = {$this->getId()};";
        $execute = $this->db->query($update);

        $result = false;
        if ($execute) {
            $result = true;
        }

        return $result;
    }

    public function getEquals() {
        $query = "Select Count(*) cantidad From usuario "
                . "Where usuario = '{$this->getUsuario()}' And idEstado = 1;";
        $execute = $this->db->query($query);

        $execute = $execute->fetch_object();

        $result = 0;
        if ($execute) {
            $result = $execute->cantidad;
        }

        return $result;
    }

    public function getEqualsDPI() {
        $query = "Select Count(*) cantidad From usuario "
                . "Where dpi = '{$this->getDpi()}' And idEstado = 1;";
        $execute = $this->db->query($query);

        $execute = $execute->fetch_object();

        $result = 0;
        if ($execute) {
            $result = $execute->cantidad;
        }

        return $result;
    }

    public function getEqualsCorreo() {
        $query = "Select Count(*) cantidad From usuario "
                . "Where email = '{$this->getEmail()}' And idEstado = 1;";
        $execute = $this->db->query($query);

        $execute = $execute->fetch_object();

        $result = 0;
        if ($execute) {
            $result = $execute->cantidad;
        }

        return $result;
    }

    public function updateClave() {
    $update = "Update usuario Set contrasena = '{$this->getContrasena()}' Where id = {$this->getId()}";
    $execute = $this->db->query($update);

    $result = false;
    if ($execute) {
      $result = $execute;
    }

    return $result;
  }
  
   public function getComercioByUserAdmin() {
    $query = "SELECT c.id, c.nombre "
            . "FROM comercio c INNER JOIN usuario_comercio uc ON uc.idComercio = c.id "
            . "WHERE uc.idUsuario = {$this->getId()}  ORDER BY 2;";
    $execute = $this->db->query($query);
    
//    print $query;
//    print $this->db->error;
//    die();
    
    $result = false;
    if ($execute) {
      $result = $execute;
    }

    return $result;
  }
  
}
