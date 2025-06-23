<?php
require_once(__DIR__ . "/../persistencia/Conexion.php");
require_once(__DIR__ . "/../persistencia/PaseoDAO.php");
require_once(__DIR__ . "/../logica/Factura.php");

class Paseo {
    private $id;
    private $fecha;
    private $hora_inicio;
    private $hora_fin;
    private $duracion;
    private $perrito;
    private $dueno;
    private $paseador;
    private $estadoPaseo;
    private $tarifa;
    
    private $precio;
    
    public function __construct($id = "", $fecha = "", $hora_inicio = "", $duracion = "", $perrito = null, $dueno = null, $paseador = null, $estadoPaseo = null, $tarifa = "", $hora_fin = "", $precio = 0) {
        $this->id = $id;
        $this->fecha = $fecha;
        $this->hora_inicio = $hora_inicio;
        $this->duracion = $duracion;
        $this->perrito = $perrito;
        $this->dueno = $dueno;
        $this->paseador = $paseador;
        $this->estadoPaseo = $estadoPaseo;
        $this->tarifa = $tarifa;
        $this->hora_fin = $hora_fin;
        $this->precio = $precio;
    }
    
    
    public function getId() {
        return $this->id;
    }
    
    public function getFecha() {
        return $this->fecha;
    }
    
    public function getHoraInicio() {
        return $this->hora_inicio;
    }
    
    public function getDuracion() {
        return $this->duracion;
    }
    
    public function getPerrito() {
        return $this->perrito;
    }
    
    public function getDueno() {
        return $this->dueno;
    }
    
    public function getPaseador() {
        return $this->paseador;
    }
    
    public function getEstadoPaseo() {
        return $this->estadoPaseo;
    }
    
    public function getFactura() {
        return $this->factura;
    }
    
    public function getTarifa() {
        return $this->tarifa;
    }
    
    public function getHoraFin() {
        return $this->hora_fin;
    }
    
    public function getPrecio() {
        return $this->precio;
    }
    
    public function setPrecio($precio) {
        $this->precio = $precio;
    }
    
    public function setId($id) {
        $this->id = $id;
    }
    
    public function setFecha($fecha) {
        $this->fecha = $fecha;
    }
    
    public function setHoraInicio($hora_inicio) {
        $this->hora_inicio = $hora_inicio;
    }
    public function setHoraFin($hora_fin) {
        $this->hora_fin = $hora_fin;
    }
    
    public function setDuracion($duracion) {
        $this->duracion = $duracion;
    }
    
    public function setPerrito($perrito) {
        $this->perrito = $perrito;
    }
    
    public function setDueno($dueno) {
        $this->dueno = $dueno;
    }
    
    public function setPaseador($paseador) {
        $this->paseador = $paseador;
    }
    
    public function setEstadoPaseo($estadoPaseo) {
        $this->estadoPaseo = $estadoPaseo;
    }
    
    public function setTarifa($tarifa) {
        $this->tarifa = $tarifa;
    }
    
    public function insertarConValidacion() {
        $conexion = new Conexion();
        $conexion->abrir();
        
        // 1. Obtener tarifa actual del paseador
        $tarifaObj = new TarifaPaseador("", $this->paseador);
        $tarifaObj->consultarActualPorPaseador();
        $idTarifa = $tarifaObj->getId();
        $valorHora = (float) $tarifaObj->getValorHora();
        $precioTotal = ((int)$this->duracion / 60) * $valorHora;
        
        $this->precio = $precioTotal;
        $this->setTarifa($idTarifa);
        
        // 2. Validar simultaneidad
        $dao = new PaseoDAO(
            0,
            $this->perrito,
            $this->paseador,
            $this->estadoPaseo,
            $this->fecha,
            $this->hora_inicio,
            $this->calcularHoraFin(),
            $idTarifa,
            $this->precio,
            $this->duracion
            );
        
        $sqlSimultaneo = $dao->consultarPaseosSimultaneos(
            $this->fecha,
            $this->hora_inicio,
            $this->calcularHoraFin(),
            $this->paseador
            );
        $conexion->ejecutar($sqlSimultaneo);
        $cantidad = $conexion->registro()[0];
        
        if ($cantidad >= 2) {
            $conexion->cerrar();
            return ["ok" => false, "mensaje" => "Este paseador ya tiene 2 paseos en ese horario."];
        }
        
        // 3. Insertar el paseo primero
        $conexion->ejecutar($dao->insertar());
        $idPaseo = $conexion->obtenerUltimoId();
        $this->id = $idPaseo;
        
        // 4. Validar objetos completos
        if (!is_object($this->paseador)) {
            $paseadorObj = new Paseador($this->paseador);
            $paseadorObj->consultar();
            $this->paseador = $paseadorObj;
        }
        
        if (!is_object($this->perrito)) {
            $perritoObj = new Perrito($this->perrito);
            $perritoObj->consultar();
            $this->perrito = $perritoObj;
        }
        
        // 1. Preparar nombre del PDF y URL pública
        $rutaCarpeta = __DIR__ . "/../facturas";
        if (!file_exists($rutaCarpeta)) {
            mkdir($rutaCarpeta, 0755, true);
        }
        $nombrePDF = "factura_" . $idPaseo . "_" . time() . ".pdf";
        $rutaPDF = $rutaCarpeta . "/" . $nombrePDF;
        $baseUrl = "http://localhost/paseaPerritos/facturas";
        $urlFactura = $baseUrl . "/" . $nombrePDF;
        
        // 2. Crear QR con esa URL (antes del PDF)
        $factura = new Factura("", "", date("Y-m-d"), $precioTotal);
        $factura->generarQRCode($urlFactura);
        $factura->setUrlPdf($urlFactura);
        
        // 3. Crear el PDF con el QR
        require_once(__DIR__ . "/../libs/fpdf186/fpdf.php");
        
        $pdf = new FPDF();
        $pdf->AddPage();
        $pdf->SetFont('Arial','B',16);
        
        $pdf->Cell(0, 10, 'Detalle del Paseo', 0, 1, 'C');
        $pdf->Ln(10);
        $pdf->SetFont('Arial','',12);
        $pdf->Cell(0, 10, 'Fecha: ' . $this->fecha, 0, 1);
        $pdf->Cell(0, 10, 'Hora Inicio: ' . $this->hora_inicio, 0, 1);
        $pdf->Cell(0, 10, 'Hora Fin: ' . $this->calcularHoraFin(), 0, 1);
        $pdf->Cell(0, 10, utf8_decode('Duración: ' . $this->duracion . ' minutos'), 0, 1);
        $pdf->Cell(0, 10, utf8_decode('Precio: $' . number_format($precioTotal, 0, ',', '.')), 0, 1);
        $pdf->Cell(0, 10, utf8_decode('Perrito: ' . $this->perrito->getNombre()), 0, 1);
        $pdf->Cell(0, 10, utf8_decode('Paseador: ' . $this->paseador->getNombre()), 0, 1);
        
        
        // Insertar QR generado
        $qrPath = $factura->getCodigoQR(); // ej: archivos_qr/qr_xxx.png
        $qrPathCompleto = __DIR__ . "/../" . $qrPath;
        if (file_exists($qrPathCompleto)) {
            $pdf->Image($qrPathCompleto, 80, $pdf->GetY() + 10, 50, 50);
            $pdf->Ln(60);
        }
        
        // 4. Guardar el PDF
        $pdf->Output('F', $rutaPDF);
        
        // 5. Insertar la factura en la BD
        $conexion->ejecutar(
            (new FacturaDAO(
                0,
                $factura->getFechaEmision(),
                $factura->getTotal(),
                $factura->getCodigoQR(),  // archivo QR
                $idPaseo,
                $factura->getUrlPdf()     // URL pública al PDF
                ))->insertar()
            );
        
        $idFactura = $conexion->obtenerUltimoId();
        $this->factura = $idFactura;
        
        $conexion->cerrar();
        return ["ok" => true, "mensaje" => "¡Paseo reservado exitosamente!"];
    }

    private function calcularHoraFin() {
        $inicio = strtotime($this->hora_inicio);
        $fin = $inicio + ((int)$this->duracion * 60);
        return date("H:i:s", $fin);
    }
    
    public function consultarTodosPorRol($rol, $usuarioId) {
        $dao = new PaseoDAO();
        $conexion = new Conexion();
        $conexion->abrir();
        $conexion->ejecutar($dao->consultarTodosPorRol($rol, $usuarioId));
        
        $paseos = [];
        while ($registro = $conexion->registro()) {
            $paseo = new Paseo();
            $paseo->setId($registro[0]);
            $paseo->setFecha($registro[1]);
            $paseo->setHoraInicio($registro[2]);
            $paseo->setHoraFin($registro[3]);
            
            $perrito = new Perrito();
            $perrito->setNombre($registro[4]);
            $paseo->setPerrito($perrito);
            
            $dueno = new Dueno();
            $dueno->setNombre($registro[5]);
            $paseo->setDueno($dueno);
            
            $paseador = new Paseador();
            $paseador->setNombre($registro[6]);
            $paseo->setPaseador($paseador);
            
            $estado = new EstadoPaseo();
            $estado->setId($registro[7]);
            $estado->setNombre($registro[8]);
            $paseo->setEstadoPaseo($estado);
            
            $paseo->setTarifa($registro[9]);
            
            $paseos[] = $paseo;
        }
        $conexion->cerrar();
        return $paseos;
    }
    
    
    public function consultarPorEstado($estadoId, $rol, $usuarioId) {
        $dao = new PaseoDAO();
        $conexion = new Conexion();
        $conexion->abrir();
        $conexion->ejecutar($dao->consultarPorEstado($estadoId, $rol, $usuarioId));
        
        $paseos = [];
        while ($registro = $conexion->registro()) {
            $paseo = new Paseo();
            $paseo->setId($registro[0]);
            $paseo->setFecha($registro[1]);
            $paseo->setHoraInicio($registro[2]); 
            $paseo->setHoraFin($registro[3]);
            $perrito = new Perrito();
            $perrito->setNombre($registro[4]);
            $paseo->setPerrito($perrito);
            
            $dueno = new Dueno();
            $dueno->setNombre($registro[5]);
            $paseo->setDueno($dueno);
            
            $paseador = new Paseador();
            $paseador->setNombre($registro[6]);
            $paseo->setPaseador($paseador);
            
            $estado = new EstadoPaseo();
            $estado->setId($registro[7]);
            $estado->setNombre($registro[8]); 
            $paseo->setEstadoPaseo($estado);
            
            
            $paseo->setTarifa($registro[9]);
            
            $paseos[] = $paseo;
        }
        
        $conexion->cerrar();
        return $paseos;
    }
    
    public function cambiarEstado($nuevoEstado) {
        $this->estadoPaseo = new EstadoPaseo($nuevoEstado);
        $dao = new PaseoDAO(
            $this->id,
            null, null, $this->estadoPaseo
            );
        $conexion = new Conexion();
        $conexion->abrir();
        $conexion->ejecutar($dao->actualizarEstado());
        $conexion->cerrar();
    }
    
    public function obtenerEstadisticas() {
        $dao = new PaseoDAO();
        $conexion = new Conexion();
        $conexion->abrir();
        
        // Resumen general
        $conexion->ejecutar($dao->obtenerResumenEstadisticas());
        $resumen = $conexion->registro();
        
        // Paseos por paseador
        $conexion->ejecutar($dao->paseosPorPaseador());
        $paseadores = [];
        while ($registro = $conexion->registro()) {
            $paseadores[] = $registro;
        }
        
        // Paseos por estado
        // Paseos por estado
        $conexion->ejecutar($dao->paseosPorEstado());
        $porEstado = [];
        while ($registro = $conexion->registro()) {
            $porEstado[] = [
                "estado" => $registro[0],
                "cantidad" => $registro[1]
            ];
        }
        
        
        $conexion->cerrar();
        
        return [
            "resumen" => $resumen,
            "porPaseador" => $paseadores,
            "porEstado" => $porEstado
        ];
    }
    
    public function obtenerDistribucionPorEstado() {
        $dao = new PaseoDAO();
        $conexion = new Conexion();
        $conexion->abrir();
        $conexion->ejecutar($dao->obtenerDistribucionPorEstado());
        
        $distribucion = [];
        while ($registro = $conexion->registro()) {
            $distribucion[] = [
                "estado" => $registro[0],
                "cantidad" => $registro[1]
            ];
        }
        
        $conexion->cerrar();
        return $distribucion;
    }
    
    
}
