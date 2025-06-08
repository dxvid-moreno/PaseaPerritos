<?php
require_once("persistencia/Conexion.php");
require_once("persistencia/TarifaPaseadorDAO.php");

class TarifaPaseador {
    private $id;
    private $paseador;
    private $valor_hora;
    private $fecha_inicio;
    private $fecha_fin;

    public function __construct($id = "", $paseador = null, $valor_hora = "", $fecha_inicio = "", $fecha_fin = "") {
        $this->id = $id;
        $this->paseador = $paseador;
        $this->valor_hora = $valor_hora;
        $this->fecha_inicio = $fecha_inicio;
        $this->fecha_fin = $fecha_fin;
    }

    public function getId() {
        return $this->id;
    }

    public function getPaseador() {
        return $this->paseador;
    }

    public function getValorHora() {
        return $this->valor_hora;
    }

    public function getFechaInicio() {
        return $this->fecha_inicio;
    }

    public function getFechaFin() {
        return $this->fecha_fin;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function setPaseador($paseador) {
        $this->paseador = $paseador;
    }

    public function setValorHora($valor_hora) {
        $this->valor_hora = $valor_hora;
    }

    public function setFechaInicio($fecha_inicio) {
        $this->fecha_inicio = $fecha_inicio;
    }

    public function setFechaFin($fecha_fin) {
        $this->fecha_fin = $fecha_fin;
    }
}
?>
