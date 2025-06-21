<?php
require_once(__DIR__ . "/../persistencia/Conexion.php");
require_once(__DIR__ . "/../persistencia/PaseoDAO.php");
require_once(__DIR__ . "/../logica/Factura.php");

class Paseo {
    private $id;
    private $fecha;
    private $hora_inicio;
    private $hora_fin;
    private $duracion;
    private $perrito;
    private $dueno;
    private $paseador;
    private $estadoPaseo;
    private $tarifa;
    
    public function __construct($id = "", $fecha = "", $hora_inicio = "", $duracion = "", $perrito = null, $dueno = null, $paseador = null, $estadoPaseo = null, $tarifa = "",$hora_fin="") {
        $this->id = $id;
        $this->fecha = $fecha;
        $this->hora_inicio = $hora_inicio;
        $this->duracion = $duracion;
        $this->perrito = $perrito;
        $this->dueno = $dueno;
        $this->paseador = $paseador;
        $this->estadoPaseo = $estadoPaseo;
        $this->tarifa = $tarifa;
        $this->hora_fin = $hora_fin;
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
    
    public function getFactura() {
        return $this->factura;
    }
    
    public function getTarifa() {
        return $this->tarifa;
    }
    
    public function getHoraFin() {
        return $this->hora_fin;
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
    public function setHoraFin($hora_fin) {
        $this->hora_fin = $hora_fin;
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
    
    public function insertarConValidacion() {
        $conexion = new Conexion();
        $conexion->abrir();
        
        // 1. Obtener tarifa actual del paseador
        $tarifaObj = new TarifaPaseador("", $this->paseador);
        $tarifaObj->consultarActualPorPaseador();
        $idTarifa = $tarifaObj->getId();
        $valorHora = (float) $tarifaObj->getValorHora();
        $precioTotal = ((int)$this->duracion / 60) * $valorHora;
        
        $this->precio = $precioTotal;
        $this->setTarifa($idTarifa);
        
        // 2. Validar simultaneidad
        $dao = new PaseoDAO(
            0,
            $this->perrito,
            $this->paseador,
            $this->estadoPaseo,
            $this->fecha,
            $this->hora_inicio,
            $this->calcularHoraFin(),
            $idTarifa,
            null, // aún no tenemos factura
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
        
        // 3. Insertar el paseo primero
        $conexion->ejecutar($dao->insertar());
        $idPaseo = $conexion->obtenerUltimoId(); // ahora sí lo tienes
        $this->id = $idPaseo;
        
        // 4. Crear e insertar la factura
        $factura = new Factura("", "", date("Y-m-d"), $precioTotal);
        $factura->generarQRCode();
        
        $conexion->ejecutar(
            (new FacturaDAO(0, $factura->getFechaEmision(), $factura->getTotal(), $factura->getCodigoQR(), $idPaseo))->insertar()
            );
        
        $idFactura = $conexion->obtenerUltimoId();
        $this->factura = $idFactura;
        
        $conexion->cerrar();
        return ["ok" => true, "mensaje" => "¡Paseo reservado exitosamente!"];
    }
    
    
    private function calcularHoraFin() {
        $inicio = strtotime($this->hora_inicio);
        $fin = $inicio + ((int)$this->duracion * 60);
        return date("H:i:s", $fin);
    }
    
    public function consultarTodosPorRol($rol, $usuarioId) {
        $dao = new PaseoDAO();
        $conexion = new Conexion();
        $conexion->abrir();
        $conexion->ejecutar($dao->consultarTodosPorRol($rol, $usuarioId));
        
        $paseos = [];
        while ($registro = $conexion->registro()) {
            $paseo = new Paseo();
            $paseo->setId($registro[0]);
            $paseo->setFecha($registro[1]);
            $paseo->setHoraInicio($registro[2]);
            $paseo->setHoraFin($registro[3]);
            
            $perrito = new Perrito();
            $perrito->setNombre($registro[4]);
            $paseo->setPerrito($perrito);
            
            $dueno = new Dueno();
            $dueno->setNombre($registro[5]);
            $paseo->setDueno($dueno);
            
            $paseador = new Paseador();
            $paseador->setNombre($registro[6]);
            $paseo->setPaseador($paseador);
            
            $estado = new EstadoPaseo();
            $estado->setNombre($registro[7]);
            $paseo->setEstadoPaseo($estado);
            
            $paseo->setTarifa($registro[8]);
            
            $paseos[] = $paseo;
        }
        $conexion->cerrar();
        return $paseos;
    }
    
    
    public function consultarPorEstado($estadoId, $rol, $usuarioId) {
        $dao = new PaseoDAO();
        $conexion = new Conexion();
        $conexion->abrir();
        $conexion->ejecutar($dao->consultarPorEstado($estadoId, $rol, $usuarioId));
        
        $paseos = [];
        while ($registro = $conexion->registro()) {
            $paseo = new Paseo();
            $paseo->setId($registro[0]);
            $paseo->setFecha($registro[1]);
            $paseo->setHoraInicio($registro[2]); 
            $paseo->setHoraFin($registro[3]);
            $perrito = new Perrito();
            $perrito->setNombre($registro[4]);
            $paseo->setPerrito($perrito);
            
            $dueno = new Dueno();
            $dueno->setNombre($registro[5]);
            $paseo->setDueno($dueno);
            
            $paseador = new Paseador();
            $paseador->setNombre($registro[6]);
            $paseo->setPaseador($paseador);
            
            $estado = new EstadoPaseo();
            $estado->setNombre($registro[7]);
            $paseo->setEstadoPaseo($estado);
            
            $paseo->setTarifa($registro[8]);
            
            $paseos[] = $paseo;
        }
        
        $conexion->cerrar();
        return $paseos;
    }
    
}
