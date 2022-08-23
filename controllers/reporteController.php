<?php

class reporteController {

  public function index() {
    #Validar que este loggeado
    utils::isIdentity();

    require_once 'views/reporte/read-reporte.php';
  }

}