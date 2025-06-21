<?php

class PerritoDAO {
    private $id;
    private $nombre;
    private $raza;
    private $foto_url;
    private $edad;
    private $dueno;
    
    public function __construct($id = 0, $nombre = "", $raza = "", $foto_url = "", $edad = "", $dueno = null) {
        $this->id = $id;
        $this->nombre = $nombre;
        $this->raza = $raza;
        $this->foto_url = $foto_url;
        $this->edad = $edad;
        $this->dueno = $dueno;
    }
    
    public function consultar() {
        return "SELECT nombre, raza, foto_url, edad, idDueno
                FROM Perrito
                WHERE idPerrito = '" . $this->id . "'";
    }
    
    public function consultarPorDueno() {
        return "SELECT idPerrito, nombre, raza, foto_url, edad
                FROM Perrito
                WHERE idDueno = '" . $this->dueno . "'";
    }
    
    public function insertar() {
        return "INSERT INTO Perrito (nombre, raza, foto_url, edad, idDueno)
                VALUES (
                    '" . $this->nombre . "',
                    '" . $this->raza . "',
                    '" . $this->foto_url . "',
                    '" . $this->edad . "',
                    '" . $this->dueno . "'
                )";
    }
    
    public function actualizar() {
        return "UPDATE Perrito
                SET nombre = '" . $this->nombre . "',
                    raza = '" . $this->raza . "',
                    foto_url = '" . $this->foto_url . "',
                    edad = '" . $this->edad . "',
                    idDueno = '" . $this->dueno . "'
                WHERE idPerrito = '" . $this->id . "'";
    }
}
?>
