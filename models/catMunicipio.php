<?php

class catMunicipio {

  private $id;
  private $codIsoPais;
  private $codIsoDepartamento;
  private $codMunicipio;
  private $nombre;
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

  function getCodIsoDepartamento() {
    return $this->codIsoDepartamento;
  }

  function getCodMunicipio() {
    return $this->codMunicipio;
  }

  function getNombre() {
    return $this->nombre;
  }

  function setId($id) {
    $this->id = $id;
  }

  function setCodIsoPais($codIsoPais) {
    $this->codIsoPais = $codIsoPais;
  }

  function setCodIsoDepartamento($codIsoDepartamento) {
    $this->codIsoDepartamento = $codIsoDepartamento;
  }

  function setCodMunicipio($codMunicipio) {
    $this->codMunicipio = $codMunicipio;
  }

  function setNombre($nombre) {
    $this->nombre = $nombre;
  }

  public function getAll() {
    $query = "Select * From cat_municipio";
    $execute = $this->db->query($query);

    $result = false;
    if ($execute) {
      $result = $execute;
    }

    return $result;
  }

  public function getAllByIdDepartamento() {
    $query = "Select * From cat_municipio Where codIsoDepartamento = {$this->getCodIsoDepartamento()}";
    $execute = $this->db->query($query);

    $result = false;
    if ($execute) {
      $result = $execute;
    }

    return $result;
  }

  public function getNameById() {
    $query = "Select nombre From cat_municipio Where codIsoDepartamento = {$this->getCodIsoDepartamento()} "
            . "And codMunicipio = {$this->getCodMunicipio()}";
    $execute = $this->db->query($query);

    $result = false;
    if ($execute) {
      $result = $execute;
    }

    return $result;
  }

}
