<?php
include("presentacion/encabezado.php");
$id = $_SESSION["id"];
$perrito = new Perrito("", "", "", "","", $id);
$lista = $perrito->consultarPorDueno();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Mis Perritos</title>
    <style>
        .perritos-container {
            max-width: 800px;
            margin: 40px auto;
        }

        .perrito-card {
            display: flex;
            align-items: center;
            background: #fff;
            padding: 20px;
            border-radius: 12px;
            margin-bottom: 20px;
            box-shadow: 0 5px 10px rgba(0,0,0,0.1);
        }

        .foto img {
            width: 100px;
            height: 100px;
            object-fit: cover;
            border-radius: 50%;
            border: 2px solid #ccc;
        }

        .info {
            flex: 1;
            margin-left: 20px;
        }

        h2 {
            text-align: center;
            color: #2e7d32;
        }
    </style>
</head>
<body>

<h2>Mis Perritos Registrados</h2>

<div class="perritos-container">
    <?php if (count($lista) === 0): ?>
        <p style="text-align:center;">No tienes perritos registrados aún.</p>
    <?php else: ?>
        <?php foreach ($lista as $p): ?>
            <div class="perrito-card">
                <div class="foto">
                    <img src="<?= htmlspecialchars($p->getFotoUrl()) ?>" alt="Foto de <?= htmlspecialchars($p->getNombre()) ?>">
                </div>
                <div class="info">
                    <h3><?= htmlspecialchars($p->getNombre()) ?></h3>
                    <p><strong>Raza:</strong> <?= htmlspecialchars($p->getRaza()) ?></p>
                    <p><strong>Edad:</strong> <?= htmlspecialchars($p->getEdad()) ?> años</p>
                    <p><strong>ID:</strong> <?= htmlspecialchars($p->getId()) ?></p>
                </div>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>

</body>
</html>
