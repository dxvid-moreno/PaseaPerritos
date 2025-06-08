<?php
$rol = isset($_SESSION["rol"]) ? $_SESSION["rol"] : null;
$nombre = ""; // Suponiendo que tienes el nombre del usuario en sesión o lo traes desde la DB
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

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
        <a class="navbar-brand" href="?pid=<?php echo base64_encode("presentacion/inicio.php") ?>">
            <img width="60" height="60" src="https://img.icons8.com/ios-filled/100/ffffff/dog-training.png" alt="Registro" />
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link" href="inicio.php">Inicio</a>
                </li>

                <?php if ($rol == "admin"): ?>
                    <li class="nav-item">
                        <a class="nav-link" href="admin_paseadores.php">Administrar Paseadores</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="estadisticas.php">Estadísticas</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="logs.php">Seguridad y Logs</a>
                    </li>
                <?php endif; ?>

                <?php if ($rol == "dueno"): ?>
                    <li class="nav-item">
                        <a class="nav-link" href="mis_paseos.php">Mis Paseos</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="mis_perritos.php">Mis Perritos</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="reservar_paseo.php">Reservar Paseo</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="facturas.php">Facturas</a>
                    </li>
                <?php endif; ?>

                <?php if ($rol == "paseador"): ?>
                    <li class="nav-item">
                        <a class="nav-link" href="mis_paseos_paseador.php">Mis Paseos</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="perfil_paseador.php">Perfil</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="facturas.php">Facturas</a>
                    </li>
                <?php endif; ?>

                <li class="nav-item">
                    <a class="nav-link" href="?pid=<?php echo base64_encode("presentacion/autenticar.php") ?>&sesion=false">Cerrar Sesión</a>
                </li>
            </ul>
        </div>
    </div>
</nav>
