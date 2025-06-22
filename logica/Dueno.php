<?php
require_once(__DIR__ . "/../persistencia/Conexion.php");
require_once(__DIR__ . "/../persistencia/DuenoDAO.php");
require_once(__DIR__ . "/../logica/Persona.php");

class Dueno extends Persona {

    public function __construct($id = "", $nombre = "", $correo = "", $clave = "") {
        parent::__construct($id, $nombre, $correo, $clave);
    }

    public function autenticar() {
        $conexion = new Conexion();
        $duenoDAO = new DuenoDAO("", "", $this->correo, $this->clave);
        $conexion->abrir();
        $conexion->ejecutar($duenoDAO->autenticar());
        if ($conexion->filas() == 1) {
            $this->id = $conexion->registro()[0];
            $conexion->cerrar();
            return true;
        } else {
            $conexion->cerrar();
            return false;
        }
    }
    
    public function insertar() {
        $conexion = new Conexion();
        $dao = new DuenoDAO(0, $this->nombre, $this->correo, $this->clave);
        $conexion->abrir();
        $conexion->ejecutar($dao->insertar());
        $conexion->cerrar();
    }
    
    public function consultar() {
        $conexion = new Conexion();
        $duenoDAO = new DuenoDAO($this->id);
        $conexion->abrir();
        $conexion->ejecutar($duenoDAO->consultar());
        $datos = $conexion->registro();
        $this->nombre = $datos[0];
        $this->correo = $datos[1];
        $conexion->cerrar();
    }
    
    public function existeCorreo() {
        $conexion = new Conexion();
        $dao = new DuenoDAO();
        $conexion->abrir();
        $sql = $dao->consultarPorCorreo($this->correo);
        $conexion->ejecutar($sql);
        $datos = $conexion->registro();
        $conexion->cerrar();
        return ($datos != null);
    }
    
    public function actualizar() {
        $conexion = new Conexion();
        $dao = new DuenoDAO($this->id, $this->nombre, $this->correo, $this->clave);
        $conexion->abrir();
        $conexion->ejecutar($dao->actualizar());
        $conexion->cerrar();
    }
    
}
?>
