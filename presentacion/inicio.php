<?php
$rol = $_SESSION["rol"] ?? null;
$nombre = "Invitado";

if (isset($_SESSION["id"])) {
    if ($rol == "Administrador") {
        $admin = new Admin($_SESSION["id"]);
        $admin->consultar();
        $nombre = $admin->getNombre();
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

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Paseadores de Perros - Inicio</title>
    <style>
        /* Reset y básicos */
        * {
            margin: 0; padding: 0; box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        body {
            background: #e9f5ee;
            color: #222;
            line-height: 1.5;
        }
        
        header h1 {
            font-size: 1.2rem;
            letter-spacing: 1px;
            cursor: default;
        }
        header {
            margin-top: 60px;
            background-color: #2e7d32;
            color: white;
            padding: 5px 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: sticky;
            top: 0;
            z-index: 100;
        }
        
        nav ul {
            margin-top: 15px;
            list-style: none;
            display: flex;
            align-items: center; /* centrado vertical */
            gap: 15px; /* reduce espacio horizontal */
            font-weight: 600;
        }
        
        nav ul li a {
            text-decoration: none;
            color: white;
            padding: 6px 10px;
            border-radius: 4px;
            transition: background-color 0.3s ease;
            display: flex;
            align-items: center; /* centrado ícono + texto */
            font-size: 0.95rem;
        }
        
        nav ul li a:hover {
            background-color: #1b4d20;
        }

        main {
            max-width: 1100px;
            margin: 60px auto;
            padding: 0 20px;
        }
        .hero {
            background: url('https://images.unsplash.com/photo-1506744038136-46273834b3fb?auto=format&fit=crop&w=1350&q=80') no-repeat center center/cover;
            height: 420px;
            border-radius: 15px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
            color: white;
            text-shadow: 2px 2px 12px rgba(0,0,0,0.75);
        }
        .hero h2 {
            font-size: 3.2rem;
        }
        .hero p {
            font-size: 1.3rem;
            max-width: 720px;
        }
        .btn-primary {
            background-color: #43a047;
            color: white;
            padding: 16px 40px;
            font-weight: 700;
            border: none;
            border-radius: 30px;
            font-size: 1.1rem;
            cursor: pointer;
            text-decoration: none;
            transition: background-color 0.3s ease;
        }
        .btn-primary:hover {
            background-color: #2e7d32;
        }
        .features {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 28px;
            margin-top: 60px;
        }
        .feature-card {
            background: white;
            padding: 30px 25px;
            border-radius: 15px;
            box-shadow: 0 8px 18px rgba(0,0,0,0.1);
            transition: transform 0.25s ease;
            cursor: default;
        }
        .feature-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 18px 35px rgba(0,0,0,0.15);
        }
        .feature-card h3 {
            color: #388e3c;
            font-size: 1.4rem;
            font-weight: 700;
        }
        .feature-card p {
            font-size: 1rem;
            color: #555;
            line-height: 1.4;
        }
        footer {
            margin-top: 80px;
            background-color: #2e7d32;
            color: white;
            text-align: center;
            padding: 22px 0;
            font-weight: 500;
        }
        @media (max-width: 600px) {
            header {
                flex-direction: column;
                gap: 10px;
            }
            .hero h2 {
                font-size: 2.2rem;
            }
            .hero p {
                font-size: 1rem;
                max-width: 90%;
            }
        }
    </style>
</head>
<body>

<header>
    <h1>Pasea Perritos</h1>
    <nav>
        <ul>
            <li><a href="index.php">Inicio</a></li>
            <?php if ($rol): ?>
                <li><a href="perfil.php">Hola, <?= htmlspecialchars($nombre) ?></a></li>
                <li><a class="dropdown-item" href="?pid=<?php echo base64_encode("presentacion/autenticar.php")?>&sesion=false">Cerrar Sesion</a></li>
            <?php else: ?>
                <li><a class="dropdown-item" href="?pid=<?php echo base64_encode("presentacion/autenticar.php")?>">Iniciar Sesión</a></li>
                <li><a class="dropdown-item" href="?pid=<?php echo base64_encode("presentacion/nuevoUsuario.php")?>">Registrarse</a></li>
            <?php endif; ?>
        </ul>
    </nav>
</header>

<main>
    <section class="hero">
        <h2>Conecta con los mejores paseadores para tus perritos</h2>
        <p>Plataforma confiable para dueños y paseadores. Reserva paseos, administra perfiles y disfruta la tranquilidad que mereces.</p>
        <?php if (!$rol): ?>
            <a href="registro.php" class="btn-primary" title="Comienza ahora">¡Comienza ahora!</a>
        <?php endif; ?>
    </section>

    <section class="features" aria-label="Características principales">
        <article class="feature-card">
            <h3>Fácil Registro</h3>
            <p>Regístrate en segundos como dueño o paseador y accede a todas las funcionalidades.</p>
        </article>
        <article class="feature-card">
            <h3>Reservas Seguras</h3>
            <p>Agenda paseos confiables, con validación para que paseadores no tengan sobrecarga.</p>
        </article>
        <article class="feature-card">
            <h3>Gestión de Perritos</h3>
            <p>Mantén el perfil de tus perritos siempre actualizado y a la mano.</p>
        </article>
        <article class="feature-card">
            <h3>Facturación con Código QR</h3>
            <p>Genera facturas digitales fáciles de verificar y conservar.</p>
        </article>
        <article class="feature-card">
            <h3>Reportes y Estadísticas</h3>
            <p>Los administradores pueden analizar la actividad y tomar decisiones acertadas.</p>
        </article>
    </section>
</main>

<footer>
    &copy; <?= date('Y') ?> Paseadores de Perros. Todos los derechos reservados.
</footer>

</body>
</html>
