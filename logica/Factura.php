<?php
require_once(__DIR__ . "/../persistencia/Conexion.php");
require_once(__DIR__ . "/../persistencia/FacturaDAO.php");
require_once(__DIR__ . "/../libs/phpqrcode/qrlib.php");


class Factura {
    private $id;
    private $codigo_qr;
    private $fecha_emision;
    private $total;
    private $id_paseo;
    private $url_pdf;
    
    public function __construct($id = "", $codigo_qr = "", $fecha_emision = "", $total = "", $id_paseo = "",$url_pdf="") {
        $this->id = $id;
        $this->codigo_qr = $codigo_qr;
        $this->fecha_emision = $fecha_emision;
        $this->total = $total;
        $this->id_paseo = $id_paseo;
        $this->url_pdf = $url_pdf;
    }
    
    public function getUrlPdf() {
        return $this->url_pdf;
    }
    
    public function setUrlPdf($url_pdf) {
        $this->url_pdf = $url_pdf;
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
    
    public function generarQRCode($contenido) {
        require_once(__DIR__ . '/../libs/phpqrcode/qrlib.php');
        
        $nombreArchivo = uniqid("qr_") . ".png";
        $ruta = __DIR__ . '/../archivos_qr/' . $nombreArchivo;
        
        if (!file_exists(dirname($ruta))) {
            mkdir(dirname($ruta), 0777, true);
        }
        
        \QRcode::png($contenido, $ruta, QR_ECLEVEL_L, 4);
        
        // Guardar solo la ruta relativa
        $this->codigo_qr = "archivos_qr/" . $nombreArchivo;
    }
    
    public function consultarPorDueno($idDueno) {
        $dao = new FacturaDAO();
        $conexion = new Conexion();
        $conexion->abrir();
        $conexion->ejecutar($dao->consultarPorDueno($idDueno));
        
        $facturas = [];
        while ($registro = $conexion->registro()) {
            $factura = new Factura();
            $factura->setId($registro[0]);
            $factura->setFechaEmision($registro[1]);
            $factura->setTotal($registro[2]);
            $factura->setCodigoQR($registro[3]);
            $factura->setUrlPdf($registro[4]); // NUEVO
            
            $factura->datos["fecha_paseo"] = $registro[5];
            $factura->datos["hora_inicio"] = $registro[6];
            $factura->datos["nombre_perrito"] = $registro[7];
            
            $facturas[] = $factura;
        }
        $conexion->cerrar();
        return $facturas;
    }
    
    
}
?>
