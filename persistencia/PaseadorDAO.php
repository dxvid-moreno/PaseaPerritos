<?php

class PaseadorDAO {
    private $id;
    private $nombre;
    private $correo;
    private $clave;
    private $foto_perfil;

    public function __construct($id = 0, $nombre = "", $correo = "", $clave = "", $foto_perfil = "") {
        $this->id = $id;
        $this->nombre = $nombre;
        $this->correo = $correo;
        $this->clave = $clave;
        $this->foto_perfil = $foto_perfil;
    }

    public function autenticar() {
        return "SELECT idPaseador
                FROM Paseador
                WHERE correo = '" . $this->correo . "' AND clave = '" . md5($this->clave) . "'";
    }

    public function consultar() {
        return "SELECT nombre, correo, foto_perfil
                FROM Paseador
                WHERE idPaseador = '" . $this->id . "'";
    }

    public function insertar() {
        return "INSERT INTO Paseador (nombre, correo, clave, foto_perfil)
                VALUES ('" . $this->nombre . "', '" . $this->correo . "', '" . md5($this->clave) . "', '" . $this->foto_perfil . "')";
    }

    public function actualizar() {
        return "UPDATE Paseador
                SET nombre = '" . $this->nombre . "',
                    correo = '" . $this->correo . "',
                    clave = '" . md5($this->clave) . "',
                    foto_perfil = '" . $this->foto_perfil . "'
                WHERE idPaseador = '" . $this->id . "'";
    }
}
?>
