<?php

require_once 'models/perfil.php';
require_once 'models/acceso.php';
//require_once 'models/catRol.php';
require_once 'models/catEstadoAI.php';
require_once 'models/comercio.php';
require_once 'models/perfil_acceso.php';
require_once 'models/catAcceso.php';
require_once 'views/perfil/perfil_view.php';
require_once 'views/perfil/viewComercio.php';
require_once 'views/perfil/view_acceso.php';
require_once 'views/perfil/view_accesoPerfil.php';


class perfilController {

    var $objView;
    var $objViewAcc;
    var $objViewAccPer;

    public function __construct() {

        $this->objView = new perfil_view();
        $this->objViewAcc = new view_acceso();
        $this->objViewAccPer = new view_accesoPerfil();
    }

    public function getAjax() {
        if (isset($_GET["getAddArray"])) {
            $int_key = isset($_GET["key"]) ? intval($_GET["key"]) : 0;

            switch ($int_key) {
                case 1:

                    $nombre_comercio = isset($_GET["nombreEmpresa"]) ? trim($_GET["nombreEmpresa"]) : null;

                    $comercio = new comercio();
                    $comercio->setNombre($nombre_comercio);
                    $lista_comercios = $comercio->getAllByName();
                    
                    $objArrayView = new viewComercio();
                    $objArrayView->drawListaComercio($lista_comercios);

                    break;
                case 2:
                    $id = isset($_GET["id"]) ? intval($_GET["id"]) : 0;
                    $nombre_comercio = isset($_GET["nombreComercio"]) ? trim($_GET["nombreComercio"]) : null;

                    $objArrayView = new viewComercio();
                    $objArrayView->drawComercioByCodigo($id, $nombre_comercio);
                  //$objArrayView->drawComercioByCodigo($id, $nombre_empresa);

                    break;
                default:
                    break;
            }

            die();
        }
        
        if (isset($_GET["drawContenidoModalPerfil"])) {
            
            // $intPerfil
            $id_perfil = isset($_GET['perfil']) ? intval($_GET['perfil']) : 0;

            #Intancia objeto perfil#
            // $objPerfil
            $perfil = new Perfil();
            $perfil->setId($id_perfil);
            $_perfil = $perfil->getOneById();

            // $arrPerfil
            $_perfil = $_perfil->fetch_object();

            #Lista estados#
            $estado = new catEstadoAI();
            $lista_estados = $estado->getAll();

            // $strUrl
            $url = isset($_perfil) ? 'perfil/save&idPerfil=' . $_perfil->id_perfil : 'perfil/save';

            $this->objView->drawContenidoModalPerfil($id_perfil, $_perfil, $lista_estados, $url);

            die();
        }
        if (isset($_GET["drawContenidoModalAcceso"])) {

            // $intAcceso
            $id_acceso = isset($_GET['acceso']) ? intval($_GET['acceso']) : 0;

            #Intancia objeto acceso#
            $acceso = new Acceso();
            $acceso->setId_acceso($id_acceso);
            $_acceso = $acceso->getOneById();
            //listado accesos
            $lista_accesos = $acceso->getAll();
            // $arrAcceso
            $_acceso = $_acceso->fetch_object();

            #Lista catalogo accesos#
            $accesos = new catAcceso();
            $_accesos = $accesos->getAll();

            // $strUrl
            $urlA = isset($_acceso) ? 'perfil/saveAcceso&idAcceso=' . $_acceso->id_acceso : 'perfil/saveAcceso';

            $this->objViewAcc->drawContenidoModalAcceso($id_acceso, $_acceso, $urlA, $lista_accesos, $_accesos);

            die();
        }
        if (isset($_GET["drawContenidoModalAccesoPerfil"])) {

            // $intAcceso
            $id_perfil = isset($_GET['perfil']) ? intval($_GET['perfil']) : 0;
            #Instancia objeto acceso#
            $acceso = new Acceso();
            $acceso->getAll();
            #instancia objeto perfil#
            $perfil = new Perfil();
            $perfil->setId($id_perfil);
            $_perfil = $perfil->getOneById();

            #instancia perfil_acccesos#
            $perfilAcceso = new perfil_acceso();
            $perfilAcceso->setId_perfil($id_perfil);
            $_perfilAcc = $perfilAcceso->getByPerfilId();
            $_noAcceso = $perfilAcceso->getNoAccesos();
//            utils::drawDebug($_perfilAcc);
//            die();
//            
            $_perfil = $_perfil->fetch_object();
            //listado accesos
            $accesos = array(); //Accesos en Perfil
            while ($row = $_perfilAcc->fetch_object()) {
                $accesos[] = $row;
            }
//            utils::drawDebug($accesos);
//            die();

            $noAccesos = array(); // No accesos
            while ($row = $_noAcceso->fetch_object()) {
                $noAccesos[] = $row;
            }
            // $strUrl
            $urlA = 'perfil/saveAccesoPerfil&idPerfil=' . $_perfil->id_perfil;

            $this->objViewAccPer->drawContenidoModalAccesoPerfil($id_perfil, $_perfil, $urlA, $noAccesos, $accesos);

            die();
        }
    }

    public function index() {
        #Validar que este loggeado
        utils::isIdentity();
        
        #Objetos Perfil#
        $perfil = new Perfil();
        $lista_perfiles = $perfil->getAll();
        #Objeto Acceso#
        $acceso = new Acceso();
        $lista_accesos = $acceso->getAll();
        #Objeto Estado#
        $estado = new catEstadoAI();
        $lista_estados = $estado->getAll();

        require_once 'views/perfil/crud-perfil.php';
    }

    public function edit() {
        #Validar que este loggeado
        utils::isIdentity();
        
        if ($_GET) {
            $id_perfil = isset($_GET['idPerfil']) ? $_GET['idPerfil'] : 0;

            #Intancia objeto perfil#
            $perfil = new Perfil();
            $perfil->setId($id_perfil);
            $_perfil = $perfil->getOneById();
            $_perfil = $_perfil->fetch_object();
            #Objetos Perfil#
            $perfil = new Perfil();
            $lista_perfiles = $perfil->getAll();
            #Objeto Estado#
            $estado = new catEstadoAI();
            $lista_estados = $estado->getAll();

            require_once 'views/perfil/crud-perfil.php';
        } else {
            $_SESSION['noti_tipo'] = "danger";
            $_SESSION['noti_mensaje'] = "Error al capturar IdPerfil";
            header('Location:' . base_url . 'perfil/index');
        }
    } 
    
    public function save() {
        if ($_POST) {
            #validacion de get idPerfil#
            //utils::drawDebug($_POST);
            $id_perfil = isset($_GET['idPerfil']) ? $_GET['idPerfil'] : 0;
            #Validacion de datos#
            $id_comercio = isset($_POST['id_comercio']) ? intval($_POST['id_comercio']) : 0;
            $nombrePerfil = isset($_POST['txt_perfil']) ? strval(trim($_POST['txt_perfil'])) : '';
            $estado = isset($_POST['opt_estado']) ? intval($_POST['opt_estado']) : null;
            $predeterminado = isset($_POST['chkPredeterminado']) ? $_POST['chkPredeterminado'] : 'off';

            #Instancia objeto perfil#
            $perfil = new Perfil();
            $perfil->setIdComercio($id_comercio);
            $perfil->setNombre($nombrePerfil);
            $perfil->setEstado($estado);
            $perfil->setPredeterminado($predeterminado);

            #validar si es update o save#
            if ($id_perfil > 0) {
                $perfil->setId($id_perfil);
                $perfil->setEstado($estado);
                $perfil->setPredeterminado($predeterminado);
                //utils::drawDebug($perfil); die();
                $result = $perfil->update();
            } else {
                $result = $perfil->save();
            }
//            var_dump($result);
//            die();
            if ($result) {
                $_SESSION['noti_tipo'] = "success";
                $_SESSION['noti_mensaje'] = "Perfil Guardado con Exito!";
                header('Location:' . base_url . 'perfil/index');
            } else {
                $_SESSION['noti_tipo'] = 'warning';
                $_SESSION['noti_mensaje'] = 'Se produjo un error al guardar perfil';
                header('Location:' . base_url . 'perfil/index');
            }
        } else {
            $_SESSION['noti_tipo'] = 'danger';
            $_SESSION['noti_mensaje'] = 'Error al mandar datos por POST';
            header('Location:' . base_url . 'perfil/index');
        }
    }

    public function saveAcceso() {
        if ($_POST) {
            #validacion de get idAcceso#
            $id_acceso = isset($_GET['idAcceso']) ? $_GET['idAcceso'] : 0;
            #Validacion de datos#
            $codAcceso = isset($_POST['txt_codigo_acceso']) ? strval(trim($_POST['txt_codigo_acceso'])) : '';
            $tipoAcceso = isset($_POST['opt_acceso']) ? intval($_POST['opt_acceso']) : '';

            #Instancia objeto perfil#
            $acceso = new Acceso();
            $acceso->setCodigo_acceso($codAcceso);
            $acceso->setTipo_acceso($tipoAcceso);
            
            #validar si es update o save#
            if ($id_acceso > 0) {
                $acceso->setId_acceso($id_acceso);
                $acceso->setCodigo_acceso($codAcceso);
                $acceso->setTipo_acceso($tipoAcceso);
                $result = $acceso->update();
            } else {
                $result = $acceso->save();
            }
//            var_dump($result);
//            die();
            if ($result) {
                $_SESSION['noti_tipo'] = "success";
                $_SESSION['noti_mensaje'] = "Acceso Guardado con Exito!";
                header('Location:' . base_url . 'perfil/index');
            } else {
                $_SESSION['noti_tipo'] = 'warning';
                $_SESSION['noti_mensaje'] = 'Se produjo un error al guardar acceso';
                header('Location:' . base_url . 'perfil/index');
            }
        } else {
            $_SESSION['noti_tipo'] = 'danger';
            $_SESSION['noti_mensaje'] = 'Error al mandar datos por POST';
            header('Location:' . base_url . 'perfil/index');
        }
    }

    public function saveAccesoPerfil() {
        if ($_GET) {
            #validacion de get accesos y idPerfil#
            $id_perfil = isset($_GET['idPerfil']) ? $_GET['idPerfil'] : 0;
            $id_accesos = isset($_GET['accesos']) ? $_GET['accesos'] : 0;

            #Instancia objeto perfil#
            $accesos_perfil = new perfil_acceso();
            $accesos_perfil->setId_perfil($id_perfil);

            $accesos = explode(',', $id_accesos);

            $count = count($accesos);

            $accesos_perfil->clearAccess();
            //echo 'saveAccesosPerfil'; die();
            for ($i = 0; $i < $count; $i++) {
                $accesos_perfil->setId_acceso($accesos[$i]);
                $result = $accesos_perfil->save();
            }
            
            if ($result) {
                $_SESSION['noti_tipo'] = "success";
                $_SESSION['noti_mensaje'] = "Acceso Guardado con Exito!";
                header('Location:' . base_url . 'perfil/index');
            } else {
                $_SESSION['noti_tipo'] = 'warning';
                $_SESSION['noti_mensaje'] = 'Se produjo un error al guardar acceso';
                header('Location:' . base_url . 'perfil/index');
            }
        } else {
            $_SESSION['noti_tipo'] = 'danger';
            $_SESSION['noti_mensaje'] = 'Error al mandar datos por POST';
            header('Location:' . base_url . 'perfil/index');
        }
    }

}

?>
