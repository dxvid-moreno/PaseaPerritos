<?php

class PaseoDAO {
    private $id;
    private $perrito;     // idPerrito
    private $paseador;    // idPaseador
    private $estadoPaseo; // idEstadoPaseo
    private $fecha;
    private $hora_inicio;
    private $hora_fin;
    private $factura;     // idFactura (opcional)

    public function __construct($id = 0, $perrito = 0, $paseador = 0, $estadoPaseo = 0, $fecha = "", $hora_inicio = "", $hora_fin = "", $factura = null) {
        $this->id = $id;
        $this->perrito = $perrito;
        $this->paseador = $paseador;
        $this->estadoPaseo = $estadoPaseo;
        $this->fecha = $fecha;
        $this->hora_inicio = $hora_inicio;
        $this->hora_fin = $hora_fin;
        $this->factura = $factura;
    }

    public function consultar() {
        return "SELECT idPerrito, idPaseador, idEstadoPaseo, fecha, hora_inicio, hora_fin, idFactura
                FROM Paseo
                WHERE idPaseo = '" . $this->id . "'";
    }

    public function consultarPorDueno($idDueno) {
        return "SELECT p.idPaseo, p.fecha, p.hora_inicio, p.hora_fin, pa.nombre AS paseador_nombre, tp.valor_hora, ep.nombre AS estado_paseo
                FROM Paseo p
                INNER JOIN Perrito pe ON p.idPerrito = pe.idPerrito
                INNER JOIN Paseador pa ON p.idPaseador = pa.idPaseador
                INNER JOIN TarifaPaseador tp ON tp.idPaseador = pa.idPaseador
                INNER JOIN EstadoPaseo ep ON p.idEstadoPaseo = ep.idEstadoPaseo
                WHERE pe.idDueno = '" . $idDueno . "'
                ORDER BY p.fecha DESC, p.hora_inicio DESC";
    }

    public function consultarPorPaseador($idPaseador) {
        return "SELECT p.idPaseo, p.fecha, p.hora_inicio, p.hora_fin, pe.nombre AS perrito_nombre, d.nombre AS dueno_nombre, tp.valor_hora, ep.nombre AS estado_paseo
                FROM Paseo p
                INNER JOIN Perrito pe ON p.idPerrito = pe.idPerrito
                INNER JOIN Dueno d ON pe.idDueno = d.idDueno
                INNER JOIN TarifaPaseador tp ON tp.idPaseador = p.idPaseador
                INNER JOIN EstadoPaseo ep ON p.idEstadoPaseo = ep.idEstadoPaseo
                WHERE p.idPaseador = '" . $idPaseador . "'
                ORDER BY p.fecha DESC, p.hora_inicio DESC";
    }

    public function insertar() {
        return "INSERT INTO Paseo (idPerrito, idPaseador, idEstadoPaseo, fecha, hora_inicio, hora_fin, idFactura)
                VALUES ('" . $this->perrito . "', '" . $this->paseador . "', '" . $this->estadoPaseo . "', '" . $this->fecha . "', '" . $this->hora_inicio . "', '" . $this->hora_fin . "', " . ($this->factura === null ? "NULL" : "'" . $this->factura . "'") . ")";
    }

    public function actualizar() {
        return "UPDATE Paseo
                SET idPerrito = '" . $this->perrito . "',
                    idPaseador = '" . $this->paseador . "',
                    idEstadoPaseo = '" . $this->estadoPaseo . "',
                    fecha = '" . $this->fecha . "',
                    hora_inicio = '" . $this->hora_inicio . "',
                    hora_fin = '" . $this->hora_fin . "',
                    idFactura = " . ($this->factura === null ? "NULL" : "'" . $this->factura . "'") . "
                WHERE idPaseo = '" . $this->id . "'";
    }

    // Consulta para validar que un paseador no tenga más de 2 paseos simultáneos
    public function consultarPaseosSimultaneos($fecha, $hora_inicio, $hora_fin, $idPaseador) {
        return "SELECT COUNT(*) as cantidad
                FROM Paseo
                WHERE idPaseador = '" . $idPaseador . "'
                AND fecha = '" . $fecha . "'
                AND (
                    (hora_inicio < '" . $hora_fin . "' AND hora_fin > '" . $hora_inicio . "')
                )";
    }
}
?>
