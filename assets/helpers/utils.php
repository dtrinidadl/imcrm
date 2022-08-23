<?php

require_once 'models/catDepartamento.php';
require_once 'models/catMunicipio.php';
require_once 'models/comercio.php';
require_once 'models/usuario.php';


class utils {
    
    /*     * ******** Validar Login ********* */
    public static function isIdentity() {
        if (!isset($_SESSION['identity-imfel'])) {
            header("Location:" . base_url);
        } else {
            return true;
        }
    }
    
    /*     * ******** Metodo para eliminar sesion ********* */
    public static function deleteSession($name) {
        if (isset($_SESSION[$name])) {
            $_SESSION[$name] = null;
            unset($_SESSION[$name]);
        }

        return $name;
    }
    /*     * ******** Metodos para validar identificación y roles ********* */
    
    public static function adminCompanies() {
        $identity = $_SESSION['identity-imfel'];

        $usuario = new usuario();
        $usuario->setId($identity->id);
        $result = $usuario->getComercioByUserAdmin();
        $count = $result->num_rows;

        $response = false;
        if ($count > 0) {
            $response = $result;
        }

        return $response;
    }
    
    /*     * ******** Metodo para obtener Roles ********* */
    public static function getAccesoById($id_acceso) {
        $acceso = new catAcceso();
        $acceso->setId($id_acceso);
        $nombre_acceso = $acceso->getOneById();
        $nombre_acceso = $nombre_acceso->fetch_object();

        return $nombre_acceso->nombre;
    }
    
      public static function getPerfilById($id_perfil) {
        $perfil = new Perfil();
        $perfil->setId($id_perfil);
        $nombre_perfil = $perfil->getOneById();
        $nombre_perfil = $nombre_perfil->fetch_object();

        return $nombre_perfil->nombre;
    }
    
    
    /*     * ******** Metodos para encontrar nombres por medio de id's ********* */

    public static function getDepartamentoById($cod_iso) {
        $departamento = new catDepartamento();
        $departamento->setCodIso($cod_iso);
        $nombre_depto = $departamento->getNameById();

        $nombre_depto = $nombre_depto->fetch_object();

        return $nombre_depto->nombre;
    }

    public static function getMunicipioById($cod_iso_departamento, $cod_municipio) {
        $municipio = new catMunicipio();
        $municipio->setCodIsoDepartamento($cod_iso_departamento);
        $municipio->setCodMunicipio($cod_municipio);
        $nombre_municipio = $municipio->getNameById();

        $nombre_municipio = $nombre_municipio->fetch_object();

        return $nombre_municipio->nombre;
    }

    /*     * ******** Metodo para obtener comercios ********* */

    public static function getComercioById($id_comercio) {
        $id_comercio = intval($id_comercio);
        
        if( $id_comercio ){
            $comercio = new comercio();
            $comercio->setId($id_comercio);
            $_comercio = $comercio->getComercioById();
            $_comercio = $_comercio->fetch_object();
            //echo $_comercio; die();
            //return $_comercio;
            return $_comercio->nombre;
        }
        else{
            return "";
        }
        
    }

    /*     * ******** Metodo para obtener estados ********* */

    public static function getEstadoAIById($id_estado) {
        $estado = new catEstadoAI();
        $estado->setId($id_estado);
        $nombre_estado = $estado->getNameById();
        $nombre_estado = $nombre_estado->fetch_object();

        return $nombre_estado->nombre;
    }
    
    /*     * ******** Metodos recurrentes para guardar o buscar información ************* */

    /*     * ******** Metodos para validar identificación y roles ********* */

    /*     * ***********Metodo para formatear fechas ******************* */

    /*     * ******** Metodo para validar caracteristicas del sistema ********** */

    /*     * ******** Metodo pintar array's con estilo ********** */
    public static function drawDebug($strContent = ""){
        
        if($strContent == "" || $strContent == null || $strContent == false){
            var_dump($strContent);
        }
        else{
            print_r("<pre style='text-align: left!important; direction:ltr;'>\r\r");
            print_r($strContent);
            print_r("\r\r</pre>");
        }    
    }
    
    }
