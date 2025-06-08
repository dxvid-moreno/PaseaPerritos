<?php

class DuenoDAO {
    private $id;
    private $nombre;
    private $correo;
    private $clave;

    public function __construct($id = 0, $nombre = "", $correo = "", $clave = "") {
        $this->id = $id;
        $this->nombre = $nombre;
        $this->correo = $correo;
        $this->clave = $clave;
    }

    public function autenticar() {
        return "SELECT idDueno
                FROM Dueno
                WHERE correo = '" . $this->correo . "' AND clave = '" . md5($this->clave) . "'";
    }

    public function consultar() {
        return "SELECT nombre, correo
                FROM Dueno
                WHERE idDueno = '" . $this->id . "'";
    }

    public function insertar() {
        return "INSERT INTO Dueno (nombre, correo, clave)
                VALUES ('" . $this->nombre . "', '" . $this->correo . "', '" . md5($this->clave) . "')";
    }

    public function actualizar() {
        return "UPDATE Dueno
                SET nombre = '" . $this->nombre . "',
                    correo = '" . $this->correo . "',
                    clave = '" . md5($this->clave) . "'
                WHERE idDueno = '" . $this->id . "'";
    }
    public function consultarPorCorreo() {
        return "SELECT nombre, correo FROM Dueno WHERE correo = '$this->correo'";
    }
}
?>
