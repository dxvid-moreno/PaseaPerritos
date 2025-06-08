<?php
$rol = isset($_SESSION["rol"]) ? $_SESSION["rol"] : null;
$nombre = ""; // Suponiendo que tienes el nombre del usuario en sesión o lo traes desde la DB
if (isset($_SESSION["id"])) {
    // Traes el nombre del usuario según el rol
    if ($rol == "Administrador") {
        $admin = new Admin($_SESSION["id"]);
        $admin->consultar();
        $nombre = $admin->getNombre(); // método ejemplo
    } elseif ($rol == "Dueño") {
        $dueno = new Dueno($_SESSION["id"]);
        $dueno->consultar();
        $nombre = $dueno->getNombre();
    } elseif ($rol == "Paseador") {
        $paseador = new Paseador($_SESSION["id"]);
        $paseador->consultar();
        $nombre = $paseador->getNombre();
    }
}
?>

<header>
    <nav>
        <ul>
            <li><a href="inicio.php">Inicio</a></li>

            <?php if ($rol == "Administrador"): ?>
                <li><a href="admin_paseadores.php">Administrar Paseadores</a></li>
                <li><a href="estadisticas.php">Estadísticas</a></li>
                <li><a href="logs.php">Seguridad y Logs</a></li>
            <?php endif; ?>

            <?php if ($rol == "Dueño"): ?>
                <li><a href="mis_paseos.php">Mis Paseos</a></li>
                <li><a href="mis_perritos.php">Mis Perritos</a></li>
                <li><a href="reservar_paseo.php">Reservar Paseo</a></li>
                <li><a href="facturas.php">Facturas</a></li>
            <?php endif; ?>

            <?php if ($rol == "Paseador"): ?>
                <li><a href="mis_paseos_paseador.php">Mis Paseos</a></li>
                <li><a href="perfil_paseador.php">Perfil</a></li>
                <li><a href="facturas.php">Facturas</a></li>
            <?php endif; ?>

            <li><a class="dropdown-item" href="?pid=<?php echo base64_encode("presentacion/autenticar.php")?>&sesion=false">Cerrar Sesion</a></li>
        </ul>
    </nav>
</header>
