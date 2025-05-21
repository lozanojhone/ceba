<?php
include 'conexion.php'; // Asegúrate de que la conexión a la base de datos sea correcta

session_start(); // Iniciar la sesión

// Verificar si el usuario está logueado
if (!isset($_SESSION['loggedIn']) || $_SESSION['loggedIn'] !== true) {
    // Si no está logueado, redirigir al login
    header("Location: http://localhost/ANTONIO/admin/login.html");
    exit();
}

$mensaje = ""; // Variable para almacenar el mensaje
$clase = isset($_GET['clase']) ? $_GET['clase'] : ''; // Capturamos la clase de manera segura

// Aseguramos que la variable $almacen esté definida
if (!empty($clase)) {
    $almacen = "requerimientos_db" . $clase; // Nombre del almacén basado en la clase
} else {
    $almacen = 'Desconocido'; // Valor predeterminado en caso de que no se haya definido 'clase'
}

// Definir las imágenes según la clase seleccionada
$imagenes_clase = [
    '1' => 'images/biblioteca.png',
    '2' => 'images/computacion.png',
    '3' => 'images/deportes.png',
    '4' => 'images/limpieza.png',
    '5' => 'images/mobiliario.png',
    '6' => 'images/otros.png',
    '7' => 'images/laborat.png',
    '8' => 'images/cosmetologia.png',
    '9' => 'images/costurer.png'
];

// Texto visible según la clase
$nombres_clase = [
    '1' => 'Biblioteca',
    '2' => 'Computación',
    '3' => 'Edu. Física',
    '4' => 'Limpieza',
    '5' => 'Mobiliario',
    '6' => 'Otros Materiales',
    '7' => 'Laboratorio',
    '8' => 'Cosmetologia',
    '9' => 'Costureria'
];


// Obtener recursos según la clase
$imagen_logo1   = $imagenes_clase[$clase]   ?? 'images/logo1_default.png';
$nombre_almacen = $nombres_clase[$clase]    ?? 'Almacén';

if (isset($_POST['entregar'])) {
    $nombre_producto = mysqli_real_escape_string($conn, $_POST['nombre_producto']);
    $nombre = mysqli_real_escape_string($conn, $_POST['nombre']);
    $dni = mysqli_real_escape_string($conn, $_POST['dni']);
    $contacto = mysqli_real_escape_string($conn, $_POST['contacto']);
    $cantidad = intval($_POST['cantidad']);

    // Comprobamos si el producto existe y la cantidad disponible es suficiente
    $query_verificar = "SELECT id, cantidad FROM productos WHERE nombre_producto = '$nombre_producto' AND clase_producto = '$clase'";
    $resultado_verificar = mysqli_query($conn, $query_verificar);
    
    if (mysqli_num_rows($resultado_verificar) > 0) {
        $fila = mysqli_fetch_assoc($resultado_verificar);
        $producto_id = $fila['id']; // Obtén el ID del producto
        $cantidad_actual = $fila['cantidad'];

        // Verificar si hay suficiente cantidad para entregar
        if ($cantidad <= $cantidad_actual) {
            // Restar la cantidad entregada
            $nueva_cantidad = $cantidad_actual - $cantidad;

            // Actualizar solo la cantidad en la tabla productos
            $query_actualizar = "UPDATE productos SET cantidad = '$nueva_cantidad' WHERE id = '$producto_id'";
            if (!mysqli_query($conn, $query_actualizar)) {
                die("Error al actualizar la cantidad: " . mysqli_error($conn));
            }

            // Definir el estado a insertar en entregas
            $estado_producto = "Cantidad entregada: $cantidad - Entregado";

            // Insertar en entregas incluyendo estado_producto
            $query_insertar = "INSERT INTO entregas (nombre_persona, contacto, dni, cantidad_entregada, fecha_entrega, producto_id, almacen, producto_nombre, estado) 
                VALUES ('$nombre', '$contacto', '$dni', '$cantidad', NOW(), '$producto_id', '$almacen', '$nombre_producto', '$estado_producto')";
            if (!mysqli_query($conn, $query_insertar)) {
                die("Error al registrar la entrega: " . mysqli_error($conn));
            }
            $ultimo_id = mysqli_insert_id($conn);
            $query_actualizar_estado = "UPDATE entregas SET estado_producto = 'Entregado' WHERE id = '$ultimo_id'";
            if (!mysqli_query($conn, $query_actualizar_estado)) {
                die("Error al actualizar estado_producto: " . mysqli_error($conn));
            }

            $mensaje = "Producto entregado exitosamente.";
        } else {
            $mensaje = "Error: La cantidad a entregar excede la cantidad disponible.";
        }
    } else {
        $mensaje = "Error: El producto no existe.";
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Entrega de Producto</title>
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
            width: 95%;
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

        .logos {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
        }

        .logo1 {
            text-align: center;
            padding: 22px;
            border-radius: 4px;
        }

        .logo2 {
            text-align: center;
            padding: 0px;
            border-radius: 4px;
        }

        .logo1 img {
            width: 50px; /* Ajusta este valor para cambiar el tamaño de las imágenes */
        }
        .logo2 img{
            width: 120px; 
        }

        /* Estilos para mostrar el nombre del almacén */
        .almacen-nombre {
            text-align: center;
            font-size: 18px;
            margin-top: 10px;
            color: #333;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="logos">
            <div class="logo1">
                <!-- Mostrar la imagen del logo1 según la clase seleccionada -->
                <img src="<?php echo $imagen_logo1; ?>" alt="Logo Almacén">
                <div class="almacen-nombre"><?php echo $nombre_almacen; ?></div> <!-- Mostrar el nombre del almacén -->
            </div>
            <div class="logo2">
                <img src="images/logo.png" alt="Logo 2">
            </div>
        </div>
        <h1>Entrega de Producto</h1>
        <form method="POST">
            <input type="hidden" name="clase" value="<?php echo $_GET['clase']; ?>"> <!-- Captura de clase -->
            <input type="text" name="nombre_producto" placeholder="Nombre del Producto" required>
            <input type="text" name="nombre" placeholder="Nombre de la Persona" required>
            <input type="text" name="dni" placeholder="DNI de la Persona" required maxlength="8">
            <input type="text" name="contacto" placeholder="Contacto de la Persona" required>
            <input type="number" name="cantidad" placeholder="Cantidad a entregar" required min="1">
            <button type="submit" name="entregar">Entregar Producto</button>
        </form>
        <button class="button-volver" onclick="window.location.href='clase.php?clase=<?php echo $_GET['clase']; ?>'">Volver</button>
        
        <!-- Mensaje de confirmación -->
        <?php if (!empty($mensaje)): ?>
            <div class="message success"><?php echo $mensaje; ?></div>
        <?php endif; ?>
    </div>
</body>
</html>