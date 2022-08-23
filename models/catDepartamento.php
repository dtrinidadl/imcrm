<?php

class catDepartamento {

  private $id;
  private $codIsoPais;
  private $codIso;
  private $nombre;
  private $codigoEnvio;
  private $db;

  function __construct() {
    $this->db = Database::connect();
  }

  function getId() {
    return $this->id;
  }

  function getCodIsoPais() {
    return $this->codIsoPais;
  }

  function getCodIso() {
    return $this->codIso;
  }

  function getNombre() {
    return $this->nombre;
  }

  function getCodigoEnvio() {
    return $this->codigoEnvio;
  }

  function setId($id) {
    $this->id = $id;
  }

  function setCodIsoPais($codIsoPais) {
    $this->codIsoPais = $codIsoPais;
  }

  function setCodIso($codIso) {
    $this->codIso = $codIso;
  }

  function setNombre($nombre) {
    $this->nombre = $nombre;
  }

  function setCodigoEnvio($codigoEnvio) {
    $this->codigoEnvio = $codigoEnvio;
  }

  public function getAll() {
    $query = "Select * From cat_departamento";
    $execute = $this->db->query($query);

    $result = false;
    if ($execute) {
      $result = $execute;
    }

    return $result;
  }

  public function getNameById() {
    $query = "Select nombre From cat_departamento Where codIso = {$this->getCodIso()}";
    $execute = $this->db->query($query);

    $result = false;
    if ($execute) {
      $result = $execute;
    }

    return $result;
  }

  public function getNameCodigoEnvio() {
    $query = "Select codigoEnvio From cat_departamento Where codIso = {$this->getCodIso()}";
    $execute = $this->db->query($query);

    $result = false;
    if ($execute) {
      $result = $execute->fetch_object();
    }

    return $result;
  }

}
