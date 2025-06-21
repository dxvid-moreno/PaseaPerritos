<?php

class FacturaDAO {
    private $id;
    private $fecha_emision;
    private $total;
    private $qr_code_url;
    private $id_paseo;
    
    public function __construct($id = 0, $fecha_emision = "", $total = "", $qr_code_url = "", $id_paseo = "") {
        $this->id = $id;
        $this->fecha_emision = $fecha_emision;
        $this->total = $total;
        $this->qr_code_url = $qr_code_url;
        $this->id_paseo = $id_paseo;
    }
    
    public function consultar() {
        return "SELECT fecha_emision, total, qr_code_url, id_paseo
                FROM Factura
                WHERE idFactura = '" . $this->id . "'";
    }
    
    public function insertar() {
        return "INSERT INTO Factura (fecha_emision, total, qr_code_url, id_paseo)
                VALUES (
                    '" . $this->fecha_emision . "',
                    '" . $this->total . "',
                    '" . $this->qr_code_url . "',
                    '" . $this->id_paseo . "'
                )";
    }
    
    public function actualizar() {
        return "UPDATE Factura
                SET fecha_emision = '" . $this->fecha_emision . "',
                    total = '" . $this->total . "',
                    qr_code_url = '" . $this->qr_code_url . "',
                    id_paseo = '" . $this->id_paseo . "'
                WHERE idFactura = '" . $this->id . "'";
    }
}
?>
