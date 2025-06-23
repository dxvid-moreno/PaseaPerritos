<?php

class FacturaDAO {
    private $id;
    private $fecha_emision;
    private $total;
    private $qr_code_url;
    private $id_paseo;
    private $url_pdf;
    
    public function __construct($id = 0, $fecha_emision = "", $total = "", $qr_code_url = "", $id_paseo = "",$url_pdf="") {
        $this->id = $id;
        $this->fecha_emision = $fecha_emision;
        $this->total = $total;
        $this->qr_code_url = $qr_code_url;
        $this->id_paseo = $id_paseo;
        $this->url_pdf = $url_pdf;
    }
    
    public function consultar() {
        return "SELECT fecha_emision, total, qr_code_url, id_paseo
                FROM Factura
                WHERE idFactura = '" . $this->id . "'";
    }
    
    public function insertar() {
        return "INSERT INTO Factura (fecha_emision, total, qr_code_url, id_paseo,url_pdf)
                VALUES (
                    '" . $this->fecha_emision . "',
                    '" . $this->total . "',
                    '" . $this->qr_code_url . "',
                    '" . $this->id_paseo . "', '".$this->url_pdf."'
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
    
    public function consultarPorDueno($idDueno) {
        return "SELECT f.id_factura, f.fecha_emision, f.total, f.qr_code_url, f.url_pdf, p.fecha, p.hora_inicio, pe.nombre
            FROM Factura f
            INNER JOIN Paseo p ON f.id_paseo = p.idPaseo
            INNER JOIN Perrito pe ON p.idPerrito = pe.idPerrito
            WHERE pe.idDueno = '$idDueno'
            ORDER BY f.fecha_emision DESC";
    }
    
    
}
?>
