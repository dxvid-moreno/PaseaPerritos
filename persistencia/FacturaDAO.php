<?php

class FacturaDAO {
    private $id;
    private $fecha_emision;
    private $total;
    private $qr_code;

    public function __construct($id = 0, $fecha_emision = "", $total = "", $qr_code = "") {
        $this->id = $id;
        $this->fecha_emision = $fecha_emision;
        $this->total = $total;
        $this->qr_code = $qr_code;
    }

    public function consultar() {
        return "SELECT fecha_emision, total, qr_code
                FROM Factura
                WHERE idFactura = '" . $this->id . "'";
    }

    public function insertar() {
        return "INSERT INTO Factura (fecha_emision, total, qr_code)
                VALUES ('" . $this->fecha_emision . "', '" . $this->total . "', '" . $this->qr_code . "')";
    }

    public function actualizar() {
        return "UPDATE Factura
                SET fecha_emision = '" . $this->fecha_emision . "',
                    total = '" . $this->total . "',
                    qr_code = '" . $this->qr_code . "'
                WHERE idFactura = '" . $this->id . "'";
    }
}
?>
