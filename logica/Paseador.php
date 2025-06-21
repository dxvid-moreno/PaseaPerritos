<?php
require_once(__DIR__ . "/../persistencia/Conexion.php");
require_once(__DIR__ . "/../persistencia/PaseadorDAO.php");
require_once(__DIR__ . "/../logica/Persona.php");

class Paseador extends Persona {
    private $foto_url;
    private $descripcion;

    public function __construct($id = "", $nombre = "", $correo = "", $clave = "", $foto_url = "", $descripcion="") {
        parent::__construct($id, $nombre, $correo, $clave);
        $this->foto_url = $foto_url;
        $this->descripcion = $descripcion;
    }

    public function getFotoUrl() {
        return $this->foto_url;
    }
    public function getDescripcion() {
        return $this->descripcion;
    }

    public function setFotoPerfil($foto_perfil) {
        $this->foto_perfil = $foto_perfil;
    }
    
    public function setDescripcion($descripcion) {
        $this->descripcion = $descripcion;
    }
    
    public function insertar() {
        $conexion = new Conexion();
        $dao = new PaseadorDAO(0, $this->nombre, $this->correo, $this->clave, $this->foto_url, $this->descripcion);
        $conexion->abrir();
        $conexion->ejecutar($dao->insertar());
        $conexion->cerrar();
    }
    
    public function autenticar() {
        $conexion = new Conexion();
        $paseadorDAO = new PaseadorDAO("", "", $this->correo, $this->clave);
        $conexion->abrir();
        $conexion->ejecutar($paseadorDAO->autenticar());
        if ($conexion->filas() == 1) {
            $this->id = $conexion->registro()[0];
            $conexion->cerrar();
            return true;
        } else {
            $conexion->cerrar();
            return false;
        }
    }

    public function consultar() {
        $conexion = new Conexion();
        $paseadorDAO = new PaseadorDAO($this->id);
        $conexion->abrir();
        $conexion->ejecutar($paseadorDAO->consultar());
        $datos = $conexion->registro();
        $this->nombre = $datos[0];
        $this->correo = $datos[1];
        $this->foto_url = $datos[2];
        $conexion->cerrar();
    }
    
    public function existeCorreo() {
        $conexion = new Conexion();
        $dao = new PaseadorDAO();
        $conexion->abrir();
        $sql = $dao->consultarPorCorreo($this->correo);
        $conexion->ejecutar($sql);
        $datos = $conexion->registro();
        $conexion->cerrar();
        return ($datos != null);
    }
    
    public function consultarTodos() {
        $conexion = new Conexion();
        $dao = new PaseadorDAO();
        $conexion->abrir();
        $conexion->ejecutar($dao->consultarTodos());
        
        $resultado = array();
        while ($registro = $conexion->registro()) {
            $paseador = new Paseador($registro[0], $registro[1], $registro[2], "", $registro[3], $registro[4]);
            $tarifa = new TarifaPaseador("","",$registro[5]);
            $resultado[] = [
                "paseador" => $paseador,
                "tarifa" => $tarifa
            ];
        }
        
        $conexion->cerrar();
        return $resultado;
    }
    
    public function obtenerUltimoId() {
        $conexion = new Conexion();
        $dao = new PaseadorDAO();
        $conexion->abrir();
        $conexion->ejecutar($dao->obtenerUltimoId());
        
        $id = 0;
        if ($registro = $conexion->registro()) {
            $id = $registro[0];
        }
        
        $conexion->cerrar();
        return $id;
    }
    
    
}
?>
