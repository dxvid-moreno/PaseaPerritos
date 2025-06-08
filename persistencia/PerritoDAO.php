<?php

class PerritoDAO {
    private $id;
    private $nombre;
    private $foto_perfil;
    private $dueno; // idDueno

    public function __construct($id = 0, $nombre = "", $foto_perfil = "", $dueno = 0) {
        $this->id = $id;
        $this->nombre = $nombre;
        $this->foto_perfil = $foto_perfil;
        $this->dueno = $dueno;
    }

    public function consultar() {
        return "SELECT nombre, foto_perfil, idDueno
                FROM Perrito
                WHERE idPerrito = '" . $this->id . "'";
    }

    public function consultarPorDueno() {
        return "SELECT idPerrito, nombre, foto_perfil
                FROM Perrito
                WHERE idDueno = '" . $this->dueno . "'";
    }

    public function insertar() {
        return "INSERT INTO Perrito (nombre, foto_perfil, idDueno)
                VALUES ('" . $this->nombre . "', '" . $this->foto_perfil . "', '" . $this->dueno . "')";
    }

    public function actualizar() {
        return "UPDATE Perrito
                SET nombre = '" . $this->nombre . "',
                    foto_perfil = '" . $this->foto_perfil . "',
                    idDueno = '" . $this->dueno . "'
                WHERE idPerrito = '" . $this->id . "'";
    }
}
?>
