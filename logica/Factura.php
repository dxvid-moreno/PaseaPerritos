<?php
require_once(__DIR__ . "/../persistencia/Conexion.php");
require_once(__DIR__ . "/../persistencia/FacturaDAO.php");

// Asegúrate de que este archivo exista:
//require_once(__DIR__ . "/../librerias/phpqrcode/qrlib.php");

class Factura {
    private $id;
    private $codigo_qr;
    private $fecha_emision;
    private $total;
    private $id_paseo;
    
    public function __construct($id = "", $codigo_qr = "", $fecha_emision = "", $total = "", $id_paseo = "") {
        $this->id = $id;
        $this->codigo_qr = $codigo_qr;
        $this->fecha_emision = $fecha_emision;
        $this->total = $total;
        $this->id_paseo = $id_paseo;
    }
    
    public function getId() {
        return $this->id;
    }
    
    public function getCodigoQR() {
        return $this->codigo_qr;
    }
    
    public function getFechaEmision() {
        return $this->fecha_emision;
    }
    
    public function getTotal() {
        return $this->total;
    }
    
    public function getIdPaseo() {
        return $this->id_paseo;
    }
    
    public function setId($id) {
        $this->id = $id;
    }
    
    public function setCodigoQR($codigo_qr) {
        $this->codigo_qr = $codigo_qr;
    }
    
    public function setFechaEmision($fecha_emision) {
        $this->fecha_emision = $fecha_emision;
    }
    
    public function setTotal($total) {
        $this->total = $total;
    }
    
    public function setIdPaseo($id_paseo) {
        $this->id_paseo = $id_paseo;
    }
    
    public function generarQRCode() {
        $contenido = "Factura por: $" . $this->total . " - Fecha: " . $this->fecha_emision;
        $nombreArchivo = uniqid("qr_") . ".png";
        $ruta = __DIR__ . "/../archivos_qr/" . $nombreArchivo;
        
        // Crear carpeta si no existe
        if (!file_exists(dirname($ruta))) {
            mkdir(dirname($ruta), 0777, true);
        }
        
        QRcode::png($contenido, $ruta, QR_ECLEVEL_L, 4);
        $this->codigo_qr = "archivos_qr/" . $nombreArchivo;
    }
}
?>
