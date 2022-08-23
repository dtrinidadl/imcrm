<?php

class homeController {

    public function index() {
        #Validar que este loggeado
        utils::isIdentity();

        $id_comercio = $_SESSION['identity-imfel']->idComercio;

        /*$inventario = new inventario();
        $inventario->setIdEmpresa($id_empresa);
        $listado_alertas = $inventario->getAlertas();
        */
        require_once 'views/home/home.php';
    }

}
