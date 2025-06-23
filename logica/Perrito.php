<?php
require_once(__DIR__ . "/../persistencia/Conexion.php");
require_once(__DIR__ . "/../persistencia/PerritoDAO.php");


class Perrito {
    private $id;
    private $nombre;
    private $raza;
    private $foto_url;
    private $edad;
    private $dueno;

    public function __construct($id = "", $nombre = "", $raza = "", $foto_url = "",$edad="", $dueno = null) {
        $this->id = $id;
        $this->nombre = $nombre;
        $this->raza = $raza;
        $this->foto_url = $foto_url;
        $this->dueno = $dueno;
        $this->edad = $edad;
    }

    public function getId() {
        return $this->id;
    }

    public function getNombre() {
        return $this->nombre;
    }

    public function getRaza() {
        return $this->raza;
    }

    public function getFotoUrl() {
        return $this->foto_url;
    }

    public function getDueno() {
        return $this->dueno;
    }
    public function getEdad() {
        return $this->edad;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function setNombre($nombre) {
        $this->nombre = $nombre;
    }

    public function setRaza($raza) {
        $this->raza = $raza;
    }

    public function setFotoPerfil($foto_perfil) {
        $this->foto_perfil = $foto_perfil;
    }

    public function setDueno($dueno) {
        $this->dueno = $dueno;
    }
    
    public function consultarPorDueno() {
        $conexion = new Conexion();
        $PerritoDAO = new PerritoDAO("", "", "", "", "", $this->dueno);
        $conexion->abrir();
        $conexion->ejecutar($PerritoDAO->consultarPorDueno());
        
        $perritos = array();
        while ($registro = $conexion->registro()) {
            $perrito = new Perrito($registro[0], $registro[1], $registro[2],$registro[3],$registro[4]);
            $perritos[] = $perrito; 
        }
        
        $conexion->cerrar();
        return $perritos;
    }
    
    public function consultar() {
        $conexion = new Conexion();
        $PerritoDAO = new PerritoDAO($this->id);
        $conexion->abrir();
        $conexion->ejecutar($PerritoDAO->consultar());
        
        if ($registro = $conexion->registro()) {
            $this->nombre = $registro[0]; // nombre
            $this->raza = $registro[1];
            $this->foto_url = $registro[2]; // si la usas
            $this->edad = $registro[3];
            
            // Cargar el dueño
            $dueno = new Dueno($registro[4]);
            $dueno->consultar(); // Debe existir en clase Dueno
            $this->dueno = $dueno;
        }
        
        $conexion->cerrar();
    }
    
    
       
}
?>
