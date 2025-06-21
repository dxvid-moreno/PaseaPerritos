<?php
require_once(__DIR__ . "/../persistencia/Conexion.php");
require_once(__DIR__ . "/../persistencia/PaseoDAO.php");
require_once(__DIR__ . "/../logica/Factura.php");

class Paseo {
    private $id;
    private $fecha;
    private $hora_inicio;
    private $duracion;
    private $perrito;
    private $dueno;
    private $paseador;
    private $estadoPaseo;
    private $tarifa;
    private $factura;
    
    public function __construct($id = "", $fecha = "", $hora_inicio = "", $duracion = "", $perrito = null, $dueno = null, $paseador = null, $estadoPaseo = null, $tarifa = "", $factura = null) {
        $this->id = $id;
        $this->fecha = $fecha;
        $this->hora_inicio = $hora_inicio;
        $this->duracion = $duracion;
        $this->perrito = $perrito;
        $this->dueno = $dueno;
        $this->paseador = $paseador;
        $this->estadoPaseo = $estadoPaseo;
        $this->tarifa = $tarifa;
        $this->factura = $factura;
    }
    
    public function getId() {
        return $this->id;
    }
    
    public function getFecha() {
        return $this->fecha;
    }
    
    public function getHoraInicio() {
        return $this->hora_inicio;
    }
    
    public function getDuracion() {
        return $this->duracion;
    }
    
    public function getPerrito() {
        return $this->perrito;
    }
    
    public function getDueno() {
        return $this->dueno;
    }
    
    public function getPaseador() {
        return $this->paseador;
    }
    
    public function getEstadoPaseo() {
        return $this->estadoPaseo;
    }
    
    public function getTarifa() {
        return $this->tarifa;
    }
    
    public function getFactura() {
        return $this->factura;
    }
    
    public function setId($id) {
        $this->id = $id;
    }
    
    public function setFecha($fecha) {
        $this->fecha = $fecha;
    }
    
    public function setHoraInicio($hora_inicio) {
        $this->hora_inicio = $hora_inicio;
    }
    
    public function setDuracion($duracion) {
        $this->duracion = $duracion;
    }
    
    public function setPerrito($perrito) {
        $this->perrito = $perrito;
    }
    
    public function setDueno($dueno) {
        $this->dueno = $dueno;
    }
    
    public function setPaseador($paseador) {
        $this->paseador = $paseador;
    }
    
    public function setEstadoPaseo($estadoPaseo) {
        $this->estadoPaseo = $estadoPaseo;
    }
    
    public function setTarifa($tarifa) {
        $this->tarifa = $tarifa;
    }
    
    public function setFactura($factura) {
        $this->factura = $factura;
    }
    
    
    
    public function insertarConValidacion() {
        $conexion = new Conexion();
        $conexion->abrir();
        
        $tarifaObj = new TarifaPaseador("", $this->paseador);
        $tarifaObj->consultarActualPorPaseador();
        $idTarifa= $tarifaObj->getId();
        $valorHora = (float) $tarifaObj->getValorHora();
        $precioTotal = ((int)$this->duracion / 60) * $valorHora;
        
        $this->precio = $precioTotal;
        $this->setTarifa($tarifaObj->getId());
        
        
        // 3. Validar simultaneidad
        $dao = new PaseoDAO(
            0,
            $this->perrito,
            $this->paseador,
            $this->estadoPaseo,
            $this->fecha,
            $this->hora_inicio,
            $this->calcularHoraFin(),
            $idTarifa,
            $this->factura,
            $this->duracion
            );
        
        $sqlSimultaneo = $dao->consultarPaseosSimultaneos(
            $this->fecha,
            $this->hora_inicio,
            $this->calcularHoraFin(),
            $this->paseador
            );
        $conexion->ejecutar($sqlSimultaneo);
        $cantidad = $conexion->registro()[0];
        
        if ($cantidad >= 2) {
            $conexion->cerrar();
            return ["ok" => false, "mensaje" => "Este paseador ya tiene 2 paseos en ese horario."];
        }
        
        // 4. Insertar el paseo
        $conexion->ejecutar($dao->insertar());
        $conexion->cerrar();
        return ["ok" => true, "mensaje" => "¡Paseo reservado exitosamente!"];
    }
    
    private function calcularHoraFin() {
        $inicio = strtotime($this->hora_inicio);
        $fin = $inicio + ((int)$this->duracion * 60);
        return date("H:i:s", $fin);
    }
}
