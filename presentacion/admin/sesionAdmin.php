<?php 
include ("presentacion/encabezado.php");

$rol = isset($_SESSION["rol"]) ? $_SESSION["rol"] : null;
$nombre = "";

if (isset($_SESSION["id"])) {
    if ($rol == "admin") {
        $admin = new Admin($_SESSION["id"]);
        $admin->consultar();
        $nombre = $admin->getNombre();
    } elseif ($rol == "dueno") {
        $dueno = new Dueno($_SESSION["id"]);
        $dueno->consultar();
        $nombre = $dueno->getNombre();
    } elseif ($rol == "paseador") {
        $paseador = new Paseador($_SESSION["id"]);
        $paseador->consultar();
        $nombre = $paseador->getNombre();
    }
}
?>
<div class="container mt-5">
    <div class="card shadow">
        <div class="card-body">
            <h3 class="card-title">¡Bienvenido, <?php echo htmlspecialchars($nombre); ?>!</h3>
            <p class="card-text">
                <?php if ($rol == "admin"): ?>
                    Has iniciado sesión como <strong>Administrador</strong>. Desde aquí puedes gestionar usuarios, ver estadísticas y administrar el sistema.
                <?php elseif ($rol == "dueno"): ?>
                    Has iniciado sesión como <strong>Dueño</strong>. Puedes reservar paseos para tu perrito, ver sus facturas y consultar su historial.
                <?php elseif ($rol == "paseador"): ?>
                    Has iniciado sesión como <strong>Paseador</strong>. Revisa tus paseos asignados, horarios y detalles de tus recorridos.
                <?php else: ?>
                    Bienvenido al sistema de DogGo.
                <?php endif; ?>
            </p>
        </div>
    </div>
</div>