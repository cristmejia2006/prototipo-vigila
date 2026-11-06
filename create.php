<?php
require_once __DIR__ . '/helpers.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $camaras = leer_camaras();

    $imagenNombre = '';
    if (!empty($_FILES['imagen']['name'])) {
        $ext = strtolower(pathinfo($_FILES['imagen']['name'], PATHINFO_EXTENSION));
        $permitidas = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
        if ($_FILES['imagen']['error'] === UPLOAD_ERR_OK && in_array($ext, $permitidas, true)) {
            $imagenNombre = uniqid('cam_') . '.' . $ext;
            move_uploaded_file($_FILES['imagen']['tmp_name'], UPLOAD_DIR . $imagenNombre);
        }
    }

    $camaras[] = [
        'nombre'         => $_POST['nombre'] ?? '',
        'zona'           => $_POST['zona'] ?? '',
        'almacenamiento' => $_POST['almacenamiento'] ?? '',
        'estado'         => $_POST['estado'] ?? '',
        'notas'          => $_POST['notas'] ?? '',
        'imagen'         => $imagenNombre,
        'prioritaria'    => isset($_POST['prioritaria']),
        'fecha'          => date('Y-m-d H:i:s'),
    ];

    guardar_camaras($camaras);
    header('Location: index.php?creado=1');
    exit;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Registrar Cámara - VIGILA</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <header>
        <h1>🎥 VIGILA — Panel de Videovigilancia</h1>
        <p>Prototipo de infraestructura optimizada en AWS · EC2 + S3/Glacier + Seguridad</p>
    </header>

    <div class="container">
        <h2>+ Registrar Nueva Cámara</h2>
        <form method="POST" enctype="multipart/form-data">
            <label for="nombre">Nombre / Código de cámara</label>
            <input type="text" id="nombre" name="nombre" required>

            <label for="zona">Zona / Ubicación</label>
            <input type="text" id="zona" name="zona" required>

            <label for="almacenamiento">Almacenamiento de grabaciones</label>
            <select id="almacenamiento" name="almacenamiento">
                <option>Amazon S3</option>
                <option>S3 Glacier</option>
                <option>Amazon EBS</option>
            </select>

            <label for="estado">Estado</label>
            <select id="estado" name="estado">
                <option>Activa</option>
                <option>Inactiva</option>
                <option>Mantenimiento</option>
            </select>

            <label for="notas">Notas</label>
            <textarea id="notas" name="notas" rows="4"></textarea>

            <label for="imagen">Imagen referencial</label>
            <input type="file" id="imagen" name="imagen" accept="image/*">

            <div class="checkbox-row">
                <input type="checkbox" id="prioritaria" name="prioritaria">
                <label for="prioritaria" style="margin:0;">Marcar como prioritaria</label>
            </div>

            <div class="actions">
                <a href="index.php" class="btn btn-secondary">← Volver</a>
                <button type="submit" class="btn btn-primary">💾 Registrar Cámara</button>
            </div>
        </form>
    </div>
</body>
</html>
