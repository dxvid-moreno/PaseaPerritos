<?php
require_once(__DIR__ . "/../persistencia/Conexion.php");
require_once(__DIR__ . "/../persistencia/PerritoDAO.php");


class Perrito {
    private $id;
    private $nombre;
    private $raza;
    private $foto_perfil;
    private $dueno;

    public function __construct($id = "", $nombre = "", $raza = "", $foto_perfil = "", $dueno = null) {
        $this->id = $id;
        $this->nombre = $nombre;
        $this->raza = $raza;
        $this->foto_perfil = $foto_perfil;
        $this->dueno = $dueno;
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

    public function getFotoPerfil() {
        return $this->foto_perfil;
    }

    public function getDueno() {
        return $this->dueno;
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
}
?>
