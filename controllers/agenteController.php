<?php

require_once 'views/reusable/view-municipio.php';
require_once 'models/catDepartamento.php';
require_once 'models/catMunicipio.php';
require_once 'models/catEstadoAI.php';
require_once 'models/agente.php';

class agenteController {

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
        
        # Instaciar el objeto departamento
        $departamento = new catDepartamento();
        $lista_departamentos = $departamento->getAll();

        # Instanciar el objeto Agente
        $agente = new agente();
        $lista_agentes = $agente->getAll();
        
        #Listado de Estados#
        $estado = new catEstadoAI();
        $lista_estados = $estado->getAll();

        require_once 'views/agente/crud-agente.php';
    }

    public function edit() {
        #Validar que este loggeado
        utils::isIdentity();
        
        if ($_GET) {

            $id_agente = isset($_GET['id_agente']) ? intval($_GET['id_agente']) : null;

            if ($id_agente == null) {

                header("Location:" . base_url . "agente/index");
            } else {
                # Instaciar el objeto departamento
                $departamento = new catDepartamento();
                $lista_departamentos = $departamento->getAll();
                
                # Instaciar el objeto municipio
                $municipio = new catMunicipio();
                $lista_municipios = $municipio->getAll();

                # Instanciar el objeto Agente
                $agente = new agente();
                $agente->setId($id_agente);
                $_agente = $agente->getOne()->fetch_object();
                $lista_agentes = $agente->getAll();

                #Listado de Estados#
                $estado = new catEstadoAI();
                $lista_estados = $estado->getAll();
                
                require_once 'views/agente/crud-agente.php';
            }
        } else {
            header("Location:" . base_url . "agente/index");
        }
    }

    public function save() {
        if ($_POST) {
            # Asignar variables
            $nombre_agente = isset($_POST['txt_nombreAgente']) ? trim(strval($_POST['txt_nombreAgente'])) : null;
            $nit = isset($_POST['txt_nit']) ? trim(strval($_POST['txt_nit'])) : null;
            $domicilio = isset($_POST['txt_domicilio']) ? trim(strval($_POST['txt_domicilio'])) : null;
            $codDepartamento = isset($_POST['opt_departamento']) ? intval($_POST['opt_departamento']) : null;
            $codMunicipio = isset($_POST['opt_municipio']) ? trim(strval($_POST['opt_municipio'])) : null;
            $zona = isset($_POST['txt_zona']) ? trim(strval($_POST['txt_zona'])) : null;
            $telefono_agente = isset($_POST['txt_telefono']) ? trim(strval($_POST['txt_telefono'])) : null;
            $nombre_contacto = isset($_POST['txt_nombreContacto']) ? trim(strval($_POST['txt_nombreContacto'])) : null;
            $mail_contacto = isset($_POST['txt_mailContacto']) ? trim(strval($_POST['txt_mailContacto'])) : null;
            $telefono_contacto = isset($_POST['txt_telefonoContacto']) ? trim(strval($_POST['txt_telefonoContacto'])) : null;
            $estado = isset($_POST['opt_estado']) ? trim(strval($_POST['opt_estado'])) : null;
            
            # Intancia de modelo
            $agente = new agente();
            $agente->setNombre($nombre_agente);
            $agente->setNit($nit);
            $agente->setDomicilio($domicilio);
            $agente->setCodDepartamento($codDepartamento);
            $agente->setCodMunicipio($codMunicipio);
            $agente->setZona($zona);
            $agente->setTelefono($telefono_agente);
            $agente->setNombreContacto($nombre_contacto);
            $agente->setMailContacto($mail_contacto);
            $agente->setTelefonoContacto($telefono_contacto);
            $agente->setIdEstado($estado);

            if (isset($_GET['id_agente'])) {
                $agente->setId($_GET['id_agente']);
                $result = $agente->update();
            } else {
                $result = $agente->save();
            }

            if ($result) {

                $_SESSION['type-imfel'] = "success";
                $_SESSION['message-imfel'] = "El registro se almaceno correctamente!";
                header("Location:" . base_url . "agente/index");
            } else {

                $_SESSION['type-imfel'] = "warning";
                $_SESSION['message-imfel'] = "Existio un error al guardar el registro";
                header("Location:" . base_url . "agente/index");
            }
        } else {

            $_SESSION['type-imfel'] = "danger";
            $_SESSION['message-imfel'] = "ERROR: No se envio información por POST";
            header("Location:" . base_url . "agente/index");
        }
    }

    public function action() {
        if ($_GET) {

            $id_agente = isset($_GET['id_agente']) ? intval($_GET['id_agente']) : null;
            $id_option = isset($_GET['id_option']) ? intval($_GET['id_option']) : null;

            if ($id_agente == null) {

                header("Location:" . base_url . "agente/index");
            } else {

                # Instancia del objeto agente
                $agente = new agente();
                $agente->setId($id_agente);

                if ($id_option == 1) {
                    $result = $agente->activate();
                } else {
                    $result = $agente->inactivate();
                }

                if ($result) {

                    header("Location:" . base_url . "agente/index");
                } else {

                    header("Location:" . base_url . "agente/index");
                }
            }
        } else {

            header("Location:" . base_url . "agente/index");
        }
    }

}
