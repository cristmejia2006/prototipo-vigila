<?php
require_once __DIR__ . '/helpers.php';
$camaras = array_reverse(leer_camaras());

$total = count($camaras);
$activas = count(array_filter($camaras, fn($c) => ($c['estado'] ?? '') === 'Activa'));
$glacier = count(array_filter($camaras, fn($c) => ($c['almacenamiento'] ?? '') === 'S3 Glacier'));
$prioritarias = count(array_filter($camaras, fn($c) => !empty($c['prioritaria'])));
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>VIGILA - Panel de Videovigilancia</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <header>
        <h1>🎥 VIGILA — Panel de Videovigilancia</h1>
        <p>Prototipo de infraestructura optimizada en AWS · EC2 + S3/Glacier + Seguridad</p>
    </header>

    <div class="container">
        <?php if (isset($_GET['creado'])): ?>
            <div class="alert">✅ Cámara registrada correctamente.</div>
        <?php endif; ?>

        <div class="cards">
            <div class="card"><span><?= $total ?></span>Cámaras registradas</div>
            <div class="card"><span><?= $activas ?></span>Cámaras activas</div>
            <div class="card"><span><?= $prioritarias ?></span>Prioritarias</div>
            <div class="card"><span><?= $glacier ?></span>En archivo (Glacier)</div>
        </div>

        <div class="top-bar">
            <h2>Cámaras de videovigilancia</h2>
            <a href="create.php" class="btn btn-primary">+ Registrar Cámara</a>
        </div>

        <?php if (empty($camaras)): ?>
            <p class="empty">Aún no hay cámaras registradas. Registra la primera con el botón de arriba.</p>
        <?php else: ?>
            <table>
                <tr>
                    <th>Cámara</th>
                    <th>Zona</th>
                    <th>Almacenamiento</th>
                    <th>Estado</th>
                    <th>Prioridad</th>
                </tr>
                <?php foreach ($camaras as $c): ?>
                    <tr>
                        <td><?= e($c['nombre']) ?></td>
                        <td><?= e($c['zona']) ?></td>
                        <td><?= e($c['almacenamiento']) ?></td>
                        <td><?= e($c['estado']) ?></td>
                        <td><?= !empty($c['prioritaria']) ? '<span class="badge">Prioritaria</span>' : '—' ?></td>
                    </tr>
                <?php endforeach; ?>
            </table>
        <?php endif; ?>

        <div class="note">
            <strong>Propuesta de optimización:</strong> las grabaciones recientes se guardan en <em>Amazon S3</em>;
            las antiguas pasan a <em>S3 Glacier</em> para reducir costos. El acceso está protegido con
            grupos de seguridad y HTTPS.
        </div>
    </div>
</body>
</html>
