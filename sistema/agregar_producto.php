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

$mensaje = ""; // Variable para almacenar el mensaje
$clase = $_GET['clase']; // Clase seleccionada
$almacen = "requerimientos_db" . $clase; // Nombre del almacén basado en la clase

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

// Obtener la imagen correspondiente a la clase o una imagen por defecto
$imagen_logo1 = isset($imagenes_clase[$clase]) ? $imagenes_clase[$clase] : 'images/logo1_default.png';

// Definir los nombres de las clases
$nombres_clase = [
    '1' => 'Biblioteca',
    '2' => 'Computación',
    '3' => 'Fútbol',
    '4' => 'Limpieza',
    '5' => 'Mobiliario',
    '6' => 'Otros Materiales',
    '7' => 'Laboratorio',
    '8' => 'Cosmetologia',
    '9' => 'Costureria'
];

$nombre_clase = isset($nombres_clase[$clase]) ? $nombres_clase[$clase] : 'Clase Desconocida';

if (isset($_POST['agregar'])) {
    $nombre_producto = $_POST['nombre_producto'];
    $descripcion_producto = $_POST['descripcion_producto'];
    $cantidad = $_POST['cantidad'];

    // Asegúrate de que la columna 'almacen' esté incluida en la consulta
    $sql = "INSERT INTO productos (nombre_producto, clase_producto, descripcion_producto, cantidad, almacen) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssis", $nombre_producto, $_POST['clase'], $descripcion_producto, $cantidad, $almacen);

    if ($stmt->execute()) {
        $mensaje = "Producto agregado exitosamente."; // Mensaje de éxito
    } else {
        $mensaje = "Error al agregar el producto: " . $stmt->error; // Mensaje de error
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agregar Producto</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-image: url('images/IMG.jpg');
            background-size: cover;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .container {
            background-color: rgba(249, 231, 193, 0.8);
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
            margin-bottom: 10px;
        }

        button:hover {
            background-color: #4d1408;
        }

        .button-volver {
            background-color: #ff9b00;
        }

        .button-volver:hover {
            background-color: #df5b00;
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
            margin-bottom: 5px;
        }

        .logo1 {
            text-align: center;
            padding: 28px;
            border-radius: 4px;
        }

        .logo2 {
            text-align: center;
            padding: 2px;
            border-radius: 4px;
        }

        .logo1 img{
            width: 50px;
        }

        .logo2 img{
            width: 120px;
        }

        .class-name {
            font-size: 16.5px;
            font-weight: bold;
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
                <div class="class-name"><?php echo $nombre_clase; ?></div>
            </div>
            <div class="logo2">
                <img src="images/logo.png" alt="Logo">
            </div>
        </div>
        <h1>Agregar Producto</h1>
        <form method="POST">
            <input type="hidden" name="clase" value="<?php echo $_GET['clase']; ?>">
            <input type="text" name="nombre_producto" placeholder="Nombre del Producto" required>
            <input type="text" name="descripcion_producto" placeholder="Descripcion del Producto" required>
            <input type="number" name="cantidad" placeholder="Cantidad" required min="1">
            <button type="submit" name="agregar">Agregar Producto</button>
        </form>
        <button class="button-volver" onclick="window.location.href='clase.php?clase=<?php echo $_GET['clase']; ?>'">Volver</button>
        
        <!-- Mensaje de confirmación -->
        <?php if (!empty($mensaje)): ?>
            <div class="message <?php echo strpos($mensaje, 'Error') !== false ? 'error' : 'success'; ?>"><?php echo $mensaje; ?></div>
        <?php endif; ?>
    </div>
</body>
</html>