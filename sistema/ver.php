<?php
// ver.php : muestra la descripción (y otros datos) de un producto
include 'conexion.php';

session_start(); // Iniciar la sesión

// Verificar si el usuario está logueado
if (!isset($_SESSION['loggedIn']) || $_SESSION['loggedIn'] !== true) {
    // Si no está logueado, redirigir al login
    header("Location: http://localhost/ANTONIO/admin/login.html");
    exit();
}

if (!isset($_GET['id']) || !isset($_GET['clase'])) {
    die('Parámetros faltantes.');
}

$id    = $_GET['id'];
$clase = $_GET['clase'];

/*
 |--------------------------------------------------------------
 | LEFT JOIN: trae el producto aunque no exista entrega.
 |--------------------------------------------------------------
*/
$sql = "SELECT  p.nombre_producto,
                p.descripcion_producto,
                p.cantidad,
                e.estado,
                e.nombre_persona,
                e.dni,
                e.contacto
        FROM productos AS p
        LEFT JOIN entregas AS e          -- ← LEFT JOIN
               ON e.producto_id = p.id
        WHERE p.id = ?
          AND p.clase_producto = ?
        ORDER BY e.id DESC               -- entrega más reciente (si la hay)
        LIMIT 1";

$stmt = $conn->prepare($sql);
if (!$stmt) {
    die('Error al preparar la consulta: ' . $conn->error);
}

$stmt->bind_param('is', $id, $clase);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {           // ya no debería ocurrir
    die('Producto no encontrado.');
}

$producto = $result->fetch_assoc();

/* Si no hay entrega, estado será NULL ⇒ asumimos “Disponible” */
$estado = $producto['estado'] ?? 'Disponible';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Descripción del producto</title>
    <style>
        body{
            font-family: Arial, sans-serif;
            background:url('images/IMG.jpg');
            margin:0;
            padding:0;
        }
        .card{
            background:rgba(249, 231, 193, 0.8);
            max-width:600px;
            margin:60px auto;
            border-radius:8px;
            box-shadow:0 4px 12px rgba(0,0,0,.15);
            padding:30px;
        }
        h1{margin-top:0;text-align:center}
        .btn{
            display:inline-block;
            background: #ff9b00;
            color: #fff;
            padding:12px 24px;
            border-radius:5px;
            text-decoration:none;
            margin-top:25px;
        }
        .btn:hover{background: #df5b00}
        .label{font-weight:bold}
        p{margin:10px 0}
    </style>
</head>
<body>
    <div class="card">
        <h1><?php echo htmlspecialchars($producto['nombre_producto']); ?></h1>

        <p><span class="label">Descripción:</span>
           <?php echo nl2br(htmlspecialchars($producto['descripcion_producto'])); ?>
        </p>

        <p><span class="label">Cantidad disponible:</span>
           <?php echo $producto['cantidad']; ?>
        </p>

        <p><span class="label">Estado del Producto:</span>
           <?php echo htmlspecialchars($estado); ?>
        </p>

        <?php if (strcasecmp($estado, 'Disponible') !== 0): ?>
            <p><span class="label">Entregado a:</span>
               <?php echo htmlspecialchars($producto['nombre_persona']); ?>
            </p>

            <p><span class="label">DNI:</span>
               <?php echo htmlspecialchars($producto['dni']); ?>
            </p>

            <p><span class="label">Contacto:</span>
               <?php echo htmlspecialchars($producto['contacto']); ?>
            </p>
        <?php endif; ?>

        <a href="clase.php?clase=<?php echo htmlspecialchars($clase); ?>" class="btn">Volver</a>
    </div>
</body>
</html>