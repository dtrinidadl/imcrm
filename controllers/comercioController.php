<?php

require_once 'views/reusable/view-municipio.php';
require_once 'models/comercio.php';
require_once 'models/agente.php';
require_once 'models/catDepartamento.php';
require_once 'models/catMunicipio.php';
require_once 'models/catEstadoAI.php';

class comercioController {

    public function getAjax() {
        if (isset($_GET['getMunicipio'])) {
            $codIso_departamento = isset($_GET['opt_departamento']) ? intval($_GET['opt_departamento']) : null;

            # Instanciar el obejto municipio
            $municipio = new catMunicipio();
            $municipio->setCodIsoDepartamento($codIso_departamento);
            $lista_municipios = $municipio->getAllByIdDepartamento();

            # Instanciar la vista a mostrar
            $obj_view = new viewMunicipio();
            $obj_view->drawMunicipios($lista_municipios);

            die();
        }
    }

    public function index() {
        #Validar que este loggeado
        utils::isIdentity();
        
        # Lista de agentes
        $agente = new agente();
        $lista_agentes = $agente->getAll();

        # Lista de comercios
        $comercio = new comercio();
        $lista_comercios = $comercio->getAll();

        # Instaciar el objeto departamento
        $departamento = new catDepartamento();
        $lista_departamentos = $departamento->getAll();
        
        #Listado de Estados#
        $estado = new catEstadoAI();
        $lista_estados = $estado->getAll();
        
        //utils::drawDebug($lista_estados); die();

        require_once 'views/comercio/crud-comercio.php';
    }

    public function edit() {
        #Validar que este loggeado
        utils::isIdentity();
        
        if ($_GET) {

            $id_comercio = isset($_GET['id_comercio']) ? intval($_GET['id_comercio']) : null;

            if ($id_comercio == null) {

                header("Location:" . base_url . "comercio/index");
            } else {

                # Instaciar el objeto departamento
                $departamento = new catDepartamento();
                $lista_departamentos = $departamento->getAll();
                
                # Instaciar el objeto municipio
                $municipio = new catMunicipio();
                $lista_municipios = $municipio->getAll();

                # Instancia del objeto comercio
                $comercio = new comercio();
                $comercio->setId($id_comercio);
                $_comercio = $comercio->getOne()->fetch_object();
                $lista_comercios = $comercio->getAll();
                #Listado de Estados#
                $estado = new catEstadoAI();
                $lista_estados = $estado->getAll();
                #Listado de Agentes#
                $agente = new agente();
                $lista_agentes = $agente->getAll();

                require_once 'views/comercio/crud-comercio.php';
            }
        } else {
            header("Location:" . base_url . "comercio/index");
        }
    }

    public function save() {
        if ($_POST) {
            # Asignar variables
            $id_agente = isset($_POST['id_agente']) ? intval(trim($_POST['id_agente'])) : null;
            $nombre = isset($_POST['txt_nombre']) ? trim(strval($_POST['txt_nombre'])) : null;
            $domicilio = isset($_POST['txt_domicilio']) ? trim(strval($_POST['txt_domicilio'])) : null;
            $zona = isset($_POST['txt_zona']) ? trim(strval($_POST['txt_zona'])) : null;
            $departamento = isset($_POST['opt_departamento']) ? trim(strval($_POST['opt_departamento'])) : null;
            $municipio = isset($_POST['opt_municipio']) ? trim(strval($_POST['opt_municipio'])) : null;
            $nombre_representante = isset($_POST['txt_nombreRepresentante']) ? trim(strval($_POST['txt_nombreRepresentante'])) : null;
            $dpi_representante = isset($_POST['txt_dpiRepresentante']) ? trim(strval($_POST['txt_dpiRepresentante'])) : null;
            $telefono_representante = isset($_POST['txt_telefono']) ? trim(strval($_POST['txt_telefono'])) : null;
            $id_estado = isset($_POST['opt_estado']) ? trim(strval($_POST['opt_estado'])) : null;

            # Intancia de modelo
            $comercio = new comercio();
            $comercio->setIdAgente($id_agente);
            $comercio->setNombre($nombre);
            $comercio->setDomicilio($domicilio);
            $comercio->setZona($zona);
            $comercio->setCodDepartamento($departamento);
            $comercio->setCodMunicipio($municipio);
            $comercio->setRepresentante($nombre_representante);
            $comercio->setDPIRepresentante($dpi_representante);
            $comercio->setTelefono($telefono_representante);
            $comercio->setIdEstado($id_estado);
//            var_dump($comercio);
//            die();

            if (isset($_GET['id_comercio'])) {
                $comercio->setId($_GET['id_comercio']);                
                $result = $comercio->update();
            } else {
                $result = $comercio->save();
            }

            if ($result) {
                $_SESSION['type-imfel'] = "success";
                $_SESSION['message-imfel'] = "El registro se almaceno correctamente";
                header("Location:" . base_url . "comercio/index");
            } else {
                $_SESSION['type-imfel'] = "warning";
                $_SESSION['message-imfel'] = "El registro no se almaceno correctamente";
                header("Location:" . base_url . "comercio/index");
            }
        } else {
            $_SESSION['type-imfel'] = "danger";
            $_SESSION['message-imfel'] = "No se envio ningun dato por POST";
            header("Location:" . base_url . "comercio/index");
        }
    }

    public function action() {
        if ($_GET) {

            $id_comercio = isset($_GET['id_comercio']) ? intval($_GET['id_comercio']) : null;
            $id_option = isset($_GET['id_option']) ? intval($_GET['id_option']) : null;

            if ($id_comercio == null) {

                header("Location:" . base_url . "comercio/index");
            } else {

                # Instancia del objeto comercio
                $comercio = new comercio();
                $comercio->setId($id_comercio);

                if ($id_option == 1) {
                    $result = $comercio->activate();
                } else {
                    $result = $comercio->inactivate();
                }

                if ($result) {

                    header("Location:" . base_url . "comercio/index");
                } else {

                    header("Location:" . base_url . "comercio/index");
                }
            }
        } else {

            header("Location:" . base_url . "comercio/index");
        }
    }

}
