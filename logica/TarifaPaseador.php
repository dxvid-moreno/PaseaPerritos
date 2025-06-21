<?php
require_once(__DIR__ . "/../persistencia/Conexion.php");
require_once(__DIR__ . "/../persistencia/TarifaPaseadorDAO.php");

class TarifaPaseador {
    private $id;
    private $paseador;
    private $valor_hora;
    private $fecha_inicio;
    private $fecha_fin;
    
    public function __construct($id = "", $paseador = "", $valor_hora = "", $fecha_inicio = "", $fecha_fin = "") {
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
    
    public function insertar() {
        $conexion = new Conexion();
        $dao = new TarifaPaseadorDAO(
            $this->id,
            $this->paseador,
            $this->valor_hora,
            $this->fecha_inicio,
            $this->fecha_fin
            );
        
        $conexion->abrir();
        $conexion->ejecutar($dao->insertar());
        $conexion->cerrar();
    }
    
    public function consultarActualPorPaseador() {
        $conexion = new Conexion();
        $dao = new TarifaPaseadorDAO("", $this->paseador);
        
        $conexion->abrir();
        $conexion->ejecutar($dao->consultarActualPorPaseador());
        
        if ($registro = $conexion->registro()) {
            $this->id = $registro[0];
            $this->valor_hora = $registro[1];  
        }
        
        $conexion->cerrar();
    }
    
}
?>
