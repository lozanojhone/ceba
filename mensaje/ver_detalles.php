<?php
$servername = "localhost";
$username = "root"; 
$password = ""; 
$dbname = "requerimientos_db";

// Conexión a la base de datos
$conn = new mysqli($servername, $username, $password, $dbname);

// Verifica la conexión
if ($conn->connect_error) {
    die("Error en la conexión: " . $conn->connect_error);
}

// Obtener el ID del requerimiento
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Inicializar mensaje
$message = '';

// Obtener el registro del requerimiento
$sql = "SELECT nombre, telefono, cargo, descripcion, cantidad, estado FROM requerimientos WHERE id = $id";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $descripcion = $row['descripcion'];
    $cantidadRequerida = $row['cantidad'];

    // Manejar la acción de entrega
    if (isset($_POST['entregar'])) {
        // Buscar en la tabla productos
        $sql_producto = "SELECT id, cantidad, almacen, nombre_producto FROM productos WHERE nombre_producto = '$descripcion'";
        $result_producto = $conn->query($sql_producto);

        if ($result_producto->num_rows > 0) {
            $producto = $result_producto->fetch_assoc();
            $idProducto = $producto['id'];
            $cantidadProducto = $producto['cantidad'];
            $almacen = $producto['almacen']; // Obtener el almacén
            $productoNombre = $producto['nombre_producto']; // Obtener el nombre del producto

            // Depurar: Verificar que el valor de 'almacen' y 'producto_nombre' se obtienen correctamente
            //   echo "Almacén: " . $almacen . " | Producto: " . $productoNombre; // Muestra el valor del almacén y el producto

            if ($cantidadProducto >= $cantidadRequerida) {
                // Actualizar la cantidad del producto
                $nuevaCantidad = $cantidadProducto - $cantidadRequerida;
                $update_producto = "UPDATE productos SET cantidad = $nuevaCantidad WHERE id = $idProducto";

                if ($conn->query($update_producto) === TRUE) {
                    // Crear la consulta INSERT para registrar la entrega
                    $insert_entrega = "INSERT INTO entregas (producto_id, cantidad_entregada, nombre_persona, contacto, almacen, producto_nombre) 
                        VALUES ($idProducto, $cantidadRequerida, 
                               '" . $conn->real_escape_string($row['nombre']) . "', 
                               '" . $conn->real_escape_string($row['telefono']) . "',
                               '" . $conn->real_escape_string($almacen) . "', 
                               '" . $conn->real_escape_string($productoNombre) . "')";
                               
                    // Depurar: Muestra la consulta SQL para verificar que está bien formada
                    //  echo "<br><br>Consulta SQL: " . $insert_entrega; // Muestra la consulta SQL

                    if ($conn->query($insert_entrega) === TRUE) {
                        $message = "Entrega realizada con éxito.";
                    } else {
                        $message = "Error al registrar la entrega: " . $conn->error;
                    }
                } else {
                    $message = "Error al actualizar el producto: " . $conn->error;
                }
            } else {
                $message = "Stock insuficiente para realizar la entrega.";
            }
        } else {
            $message = "Producto no encontrado en la tabla productos.";
        }
    }
} else {
    $message = "Requerimiento no encontrado.";
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalles del Registro</title>
    <style>
        body {
            background: url('../imagenes/fondo25.jpg') no-repeat center center fixed;
            background-size: cover;
            font-family: Arial, sans-serif;
            color: BLACK;
            text-align: center;
        }
        .container {
            background: rgba(255, 255, 255, 0.8); /* Fondo semitransparente blanco */
            padding: 30px;
            margin: 100px auto;
            width: 50%;
            border-radius: 10px;
        }
        .btn-entrega {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            margin: 5px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }
        .btn-entrega:hover {
            background-color: #45a049;
        }
        .btn {
            background-color: #4a90e2;
            color: white;
            padding: 10px 20px;
            margin: 5px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }
        .btn:hover {
            background-color: #0a6ddf;
        }
        .message, .error {
            padding: 10px;
            border-radius: 5px;
            margin-top: 20px;
            width: 90%;
            margin-left: auto;
            margin-right: auto;
            text-align: center;
        }
        .message {
            background-color: #d4edda; /* Verde claro */
            border: 1px solid #c3e6cb; /* Borde verde */
            color: #155724; /* Texto verde oscuro */
        }
        .error {
            background-color: #f8d7da; /* Rojo claro */
            border: 1px solid #f5c6cb; /* Borde rojo */
            color: #721c24; /* Texto rojo oscuro */
        }
    </style>
</head>
<body>
<div class="container">
    <h1>Detalles del Registro</h1>
    <p><strong>Nombre Solicitante:</strong> <?php echo htmlspecialchars($row['nombre']); ?></p>
    <p><strong>Telefono:</strong> <?php echo htmlspecialchars($row['telefono']); ?></p>
    <p><strong>Cargo:</strong> <?php echo htmlspecialchars($row['cargo']); ?></p>
    <p><strong>Producto Solicitado:</strong> <?php echo htmlspecialchars($row['descripcion']); ?></p>
    <p><strong>Cantidad:</strong> <?php echo htmlspecialchars($row['cantidad']); ?></p>
    <p><strong>Escificacion:</strong> <?php echo htmlspecialchars($row['estado']); ?></p>
    <!-- Formulario para enviar la acción de entrega -->
    <form method="POST" action="">
        <button class="btn-entrega" type="submit" name="entregar">Entregar</button>
    </form>

    <button class="btn" onclick="window.location.href='ver_registros.php'">Volver</button>
    
    <!-- Mostrar mensaje de éxito o error debajo del formulario -->
    <?php if ($message): ?>
        <div class="<?php echo strpos($message, 'éxito') !== false ? 'message' : 'error'; ?>">
            <?php echo $message; ?>
        </div>
    <?php endif; ?>
</div>
</body>
</html>