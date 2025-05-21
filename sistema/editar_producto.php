<?php
// EN LA INTERFAZ REEMPLAZE "ESTADO" POR "DESCRIPCION"
include 'conexion.php';

session_start(); // Iniciar la sesión

// Verificar si el usuario está logueado
if (!isset($_SESSION['loggedIn']) || $_SESSION['loggedIn'] !== true) {
    // Si no está logueado, redirigir al login
    header("Location: http://localhost/ANTONIO/admin/login.html");
    exit();
}

// Verificamos si el ID del producto y la clase están definidos
if (isset($_GET['id']) && isset($_GET['clase'])) {
    $id = $_GET['id'];
    $clase = $_GET['clase'];

    // Consultamos los datos actuales del producto
    $sql = "SELECT * FROM productos WHERE id=? AND clase_producto=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("is", $id, $clase);
    $stmt->execute();
    $result = $stmt->get_result();
    $producto = $result->fetch_assoc();
} else {
    die("Producto no encontrado.");
}

// Procesamos el formulario de edición
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST['nombre'];
    $estado = $_POST['estado'];
    $cantidad = $_POST['cantidad'];

    // Actualizamos el producto en la base de datos
    $sql = "UPDATE productos SET nombre_producto=?, descripcion_producto=?, cantidad=? WHERE id=? AND clase_producto=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssiis", $nombre, $estado, $cantidad, $id, $clase);

    if ($stmt->execute()) {
        $mensaje = "Producto actualizado correctamente.";
    } else {
        $mensaje = "Error al actualizar el producto: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Producto</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-image: url('images/IMG.jpg'); /* Cambia la ruta a tu imagen de fondo */
            background-size: cover;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .container {
            background-color: rgba(249, 231, 193, 0.8); /* Fondo blanco con opacidad */
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            width: 300px;
            text-align: center;
        }

        h1 {
            font-size: 24px;
            margin-bottom: 20px;
            color: #333;
        }

        input[type="text"],
        input[type="number"] {
            width: 90%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ddd;
            border-radius: 4px;
        }

        button {
            background-color: #a96321;
            color: white;
            padding: 10px;
            border: none;
            border-radius: 4px;
            width: 100%;
            cursor: pointer;
            margin-bottom: 10px; /* Espacio entre los botones */
        }

        button:hover {
            background-color: #4d1408;
        }

        .button-volver {
            background-color: #ff9b00; /* Color azul para el botón volver */
        }

        .button-volver:hover {
            background-color: #df5b00; /* Color azul más oscuro al pasar el mouse */
        }

        .message {
            margin-top: 20px;
            padding: 10px;
            border-radius: 4px;
        }

        .message.success {
            background-color: #d4edda;
            color: #155724;
        }

        .message.error {
            background-color: #f8d7da;
            color: #721c24;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Editar Producto</h1>
        <form method="post">
            <label>Nombre del Producto:</label>
            <input type="text" name="nombre" value="<?php echo $producto['nombre_producto']; ?>" required>
            <br><br>

            <label>Descripcion del Producto:</label>
            <input type="text" name="estado" value="<?php echo $producto['descripcion_producto']; ?>" required>
            <br><br>

            <label>Cantidad:</label>
            <input type="number" name="cantidad" value="<?php echo $producto['cantidad']; ?>" required>

            <button type="submit">Guardar Cambios</button>
        </form>
        <!-- Botón Volver -->
        <button class="button-volver" onclick="window.location.href='clase.php?clase=<?php echo $clase; ?>'">Volver</button>

        <!-- Mensaje de confirmación debajo del botón Volver -->
        <?php if (!empty($mensaje)): ?>
            <div class="message <?php echo strpos($mensaje, 'Error') === false ? 'success' : 'error'; ?>">
                <?php echo $mensaje; ?>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>