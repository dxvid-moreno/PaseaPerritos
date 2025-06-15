<?php
require_once(__DIR__ . "/../persistencia/Conexion.php");
require_once(__DIR__ . "/../persistencia/PaseadorDAO.php");
require_once(__DIR__ . "/../logica/Persona.php");


class Paseador extends Persona {
    private $foto_url;

    public function __construct($id = "", $nombre = "", $correo = "", $clave = "", $foto_url = "") {
        parent::__construct($id, $nombre, $correo, $clave);
        $this->foto_url = $foto_url;
    }

    public function getFotoPerfil() {
        return $this->foto_perfil;
    }

    public function setFotoPerfil($foto_perfil) {
        $this->foto_perfil = $foto_perfil;
    }
    
    public function insertar() {
        $conexion = new Conexion();
        $dao = new PaseadorDAO(0, $this->nombre, $this->correo, $this->clave);
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
        $this->foto_perfil = $datos[2];
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
}
?>
