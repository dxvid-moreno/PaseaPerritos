<?php
require_once("persistencia/Conexion.php");
require_once("persistencia/PaseoDAO.php");

class Paseo {
    private $id;
    private $fecha;
    private $hora_inicio;
    private $duracion;
    private $perrito; 
    private $dueno;        
    private $paseador;     
    private $estadoPaseo;  
    private $precio;
    private $factura;     

    public function __construct($id = "", $fecha = "", $hora_inicio = "", $duracion = "", $perrito = null, $dueno = null, $paseador = null, $estadoPaseo = null, $precio = "", $factura = null) {
        $this->id = $id;
        $this->fecha = $fecha;
        $this->hora_inicio = $hora_inicio;
        $this->duracion = $duracion;
        $this->perrito = $perrito;
        $this->dueno = $dueno;
        $this->paseador = $paseador;
        $this->estadoPaseo = $estadoPaseo;
        $this->precio = $precio;
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

    public function getPrecio() {
        return $this->precio;
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

    public function setPrecio($precio) {
        $this->precio = $precio;
    }

    public function setFactura($factura) {
        $this->factura = $factura;
    }
    
    public function consultarPorEstado($estadoId, $rol, $usuarioId) {
        
        $conexion = new Conexion();
        $conexion->abrir();
        
        $paseoDAO = new PaseoDAO();
        $sql = $paseoDAO->consultarPorEstado($estadoId, $rol, $usuarioId);
        
        $conexion->ejecutar($sql);
        
        $paseos = [];
        while (($registro = $conexion->registro())) {
            $paseo = new Paseo();
            $paseo->setId($registro[0]);
            $paseo->setFecha($registro[1]);
            $paseo->setHoraInicio($registro[2]);
            $paseo->setDuracion($registro[3]);
            $paseo->setPaseador(new Paseador("", $registro[6])); 
            $paseo->setPrecio($registro[8]); 
            $paseo->setEstadoPaseo(new EstadoPaseo("", $registro[7]));
            $paseos[] = $paseo;
        }
        
        $conexion->cerrar();
        return $paseos;
    }
    
    public function consultarTodosPorRol($rol, $usuarioId) {
        $conexion = new Conexion();
        $conexion->abrir();
        
        $paseoDAO = new PaseoDAO();
        $sql = $paseoDAO->consultarTodosPorRol($rol, $usuarioId);
        
        $conexion->ejecutar($sql);
        
        $paseos = [];
        while (($registro = $conexion->registro())) {
            $paseo = new Paseo();
            $paseo->setId($registro[0]);
            $paseo->setFecha($registro[1]);
            $paseo->setHoraInicio($registro[2]);
            $paseo->setDuracion($registro[3]);
            $paseo->setPaseador(new Paseador("", $registro[6])); // nombre del paseador
            $paseo->setPrecio($registro[8]); // valor hora
            $paseo->setEstadoPaseo(new EstadoPaseo("", $registro[7])); // nombre del estado
            $paseos[] = $paseo;
        }
        
        $conexion->cerrar();
        return $paseos;
    }
    
}
?>
