<?php
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

<nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow">
    <div class="container-fluid">
        <!-- Logo y marca -->
        <a class="navbar-brand d-flex align-items-center" href="?pid=<?php echo base64_encode("presentacion/inicio.php") ?>">
            <img src="https://img.icons8.com/ios-filled/100/ffffff/dog-training.png" alt="Registro" width="40" height="40" class="me-2" />
            <span class="fw-bold">DogGo</span>
        </a>

        <!-- Botón para colapsar menú en dispositivos pequeños -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Ítems de navegación -->
        <div class="collapse navbar-collapse justify-content-between" id="navbarNav">
            <!-- Opciones por rol -->
            <ul class="navbar-nav">

                <?php if ($rol === "admin"): ?>
                    <li class="nav-item">
                        <a class="nav-link" href="?pid=<?php echo base64_encode("presentacion/admin/administrar_paseadores.php"); ?>">Administrar Paseadores</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="?pid=<?php echo base64_encode("presentacion/admin/administrar_dueno.php"); ?>">Administrar Dueños</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="?pid=<?php echo base64_encode("presentacion/admin/administrar_perrito.php"); ?>">Administrar Perritos</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="?pid=<?php echo base64_encode("presentacion/admin/estadisticas.php"); ?>">Estadísticas</a>
                    </li>
                <?php elseif ($rol === "dueno"): ?>
                    <li class="nav-item">
                        <a class="nav-link" href="?pid=<?php echo base64_encode("presentacion/dueno/consultarPaseos.php"); ?>">Consultar Paseos</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="?pid=<?php echo base64_encode("presentacion/dueno/misPerritos.php"); ?>">Mis Perritos</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="?pid=<?php echo base64_encode("presentacion/dueno/reservarPaseo.php"); ?>">Reservar Paseo</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="facturas.php">Facturas</a>
                    </li>
                <?php elseif ($rol === "paseador"): ?>
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
            </ul>

            <!-- Usuario y cerrar sesión -->
            <ul class="navbar-nav d-flex align-items-center">
                <?php if (!empty($rol) && !empty($nombre)): ?>
                    <li class="nav-item me-3">
                        <span class="text-white">
                            <?php echo ucfirst($rol) . ": " . htmlspecialchars($nombre); ?>
                        </span>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="?pid=<?php echo base64_encode("presentacion/autenticar.php") ?>&sesion=false">Cerrar Sesión</a>
                    </li>
                <?php endif; ?>
            </ul>



        </div>
    </div>
</nav>
