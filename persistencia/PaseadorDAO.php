<?php

class PaseadorDAO {
    private $id;
    private $nombre;
    private $correo;
    private $clave;
    private $foto_url;

    public function __construct($id = 0, $nombre = "", $correo = "", $clave = "", $foto_url = "") {
        $this->id = $id;
        $this->nombre = $nombre;
        $this->correo = $correo;
        $this->clave = $clave;
        $this->foto_url = $foto_url;
    }

    public function autenticar() {
        return "SELECT idPaseador
                FROM Paseador
                WHERE correo = '" . $this->correo . "' AND clave = '" . md5($this->clave) . "'";
    }

    public function consultar() {
        return "SELECT nombre, correo, foto_url
                FROM Paseador
                WHERE idPaseador = '" . $this->id . "'";
    }

    public function insertar() {
        return "INSERT INTO Paseador (nombre, correo, clave, foto_url)
                VALUES ('" . $this->nombre . "', '" . $this->correo . "', '" . md5($this->clave) . "', '" . $this->foto_url . "')";
    }

    public function actualizar() {
        return "UPDATE Paseador
                SET nombre = '" . $this->nombre . "',
                    correo = '" . $this->correo . "',
                    clave = '" . md5($this->clave) . "',
                    foto_url = '" . $this->foto_url . "'
                WHERE idPaseador = '" . $this->id . "'";
    }
    
    public function consultarPorCorreo() {
        return "SELECT nombre, correo FROM Paseador WHERE correo = '$this->correo'";
    }
}
?>
