<?php

require_once 'models/cliente.php';
require_once 'views/reusable/view-municipio.php';
require_once 'views/facturacion/factura_view.php';
require_once 'views/facturacion/cliente_view.php';
require_once 'models/catDepartamento.php';
require_once 'models/catMunicipio.php';
require_once 'models/catEstadoAI.php';

class clienteController {

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

        //Buscar Cliente con Nit
        if (isset($_GET['getCliente'])) {
            $nit = isset($_GET['txt_nit']) ? trim($_GET['txt_nit']) : null;

            $cliente = new cliente();
            $cliente->setNit($nit);
            $result = $cliente->getClienteByNit();

            $array_datos = [];
            if ($result) {
                $array_datos = $result->fetch_object();
            }
            $obj_view = new cliente_view();
            $obj_view->drawInfoCliente($array_datos, $nit);
            
            //$this->objView->drawContenidoModalFactura($_comercio, $_facturaE, $_facturaD);

            die();
        }
    }

    public function index() {
        #Validar que este loggeado
        utils::isIdentity();

        $cliente = new cliente();
        $lista_clientes = $cliente->getAll();

        # Instaciar el objeto departamento
        $departamento = new catDepartamento();
        $lista_departamentos = $departamento->getAll();

        #Listado de Estados#
        $estado = new catEstadoAI();
        $lista_estados = $estado->getAll();

        require_once 'views/cliente/crud-cliente.php';
    }

    public function edit() {
        #Validar que este loggeado
        utils::isIdentity();

        if ($_GET) {

            $id_cliente = isset($_GET['id_cliente']) ? intval($_GET['id_cliente']) : null;

            if ($id_cliente == null) {

                header("Location:" . base_url . "cliente/index");
            } else {
                # Instaciar el objeto departamento
                $departamento = new catDepartamento();
                $lista_departamentos = $departamento->getAll();

                # Instaciar el objeto municipio
                $municipio = new catMunicipio();
                $lista_municipios = $municipio->getAll();

                # Instancia del objeto comercio
                $cliente = new cliente();
                $cliente->setId($id_cliente);
                $_cliente = $cliente->getOne()->fetch_object();
                $lista_clientes = $cliente->getAll();
                #Listado de Estados#
                $estado = new catEstadoAI();
                $lista_estados = $estado->getAll();

                require_once 'views/cliente/crud-cliente.php';
            }
        } else {
            header("Location:" . base_url . "cliente/index");
        }
    }

    public function save() {
        if ($_POST) {
            # Asignar variables
            $nombre = isset($_POST['txt_nombre']) ? trim(strval($_POST['txt_nombre'])) : null;
            $nit = isset($_POST['txt_nit']) ? trim(strval($_POST['txt_nit'])) : null;
            $telefono = isset($_POST['txt_telefono']) ? trim(strval($_POST['txt_telefono'])) : null;
            $domicilio = isset($_POST['txt_domicilio']) ? trim(strval($_POST['txt_domicilio'])) : null;
            $departamento = isset($_POST['opt_departamento']) ? trim(strval($_POST['opt_departamento'])) : null;
            $municipio = isset($_POST['opt_municipio']) ? trim(strval($_POST['opt_municipio'])) : null;
            $id_estado = isset($_POST['opt_estado']) ? trim(strval($_POST['opt_estado'])) : null;

            # Intancia de modelo
            $cliente = new cliente();
            $cliente->setNombre($nombre);
            $cliente->setNit($nit);
            $cliente->setTelefono($telefono);
            $cliente->setDomicilio($domicilio);
            $cliente->setCodDepartamento($departamento);
            $cliente->setCodMunicipio($municipio);
            $cliente->setIdEstado($id_estado);

//            var_dump($comercio);
//            die();
            if (isset($_GET['id_cliente'])) {
                $cliente->setId($_GET['id_cliente']);
                $result = $cliente->update();
            } else {
                $result = $cliente->save();
            }

            if ($result) {
                $_SESSION['type-imfel'] = "success";
                $_SESSION['message-imfel'] = "El registro se realizo con exito";
                header("Location:" . base_url . "cliente/index");
            } else {
                $_SESSION['type-imfel'] = "warning";
                $_SESSION['message-imfel'] = "El registro no se realizo con exito";
                header("Location:" . base_url . "cliente/index");
            }
        } else {
            $_SESSION['type-imfel'] = "danger";
            $_SESSION['message-imfel'] = "No se enviaron datos por POST";
            header("Location:" . base_url . "cliente/index");
        }
    }

    public function action() {
        if ($_GET) {

            $id_cliente = isset($_GET['id_cliente']) ? intval($_GET['id_cliente']) : null;
            $id_option = isset($_GET['id_option']) ? intval($_GET['id_option']) : null;

            if ($id_cliente == null) {

                header("Location:" . base_url . "cliente/index");
            } else {

                # Instancia del objeto cliente
                $cliente = new cliente();
                $cliente->setId($id_cliente);

                if ($id_option == 1) {
                    $result = $cliente->activate();
                } else {
                    $result = $cliente->inactivate();
                }

                if ($result) {

                    header("Location:" . base_url . "cliente/index");
                } else {

                    header("Location:" . base_url . "cliente/index");
                }
            }
        } else {

            header("Location:" . base_url . "cliente/index");
        }
    }

}
