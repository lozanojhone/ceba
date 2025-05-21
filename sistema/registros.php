<?php
// Mostrar errores de PHP (solo en desarrollo)
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Conexión a la base de datos
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "requerimientos_db"; // Cambia esto con tu nombre de base de datos

$conn = new mysqli($servername, $username, $password, $dbname);

session_start(); // Iniciar la sesión

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Verificar si el usuario está logueado
if (!isset($_SESSION['loggedIn']) || $_SESSION['loggedIn'] !== true) {
    // Si no está logueado, redirigir al login
    header("Location: http://localhost/ANTONIO/admin/login.html");
    exit();
}

// Verificar si el formulario fue enviado
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Obtener los datos del formulario
    $user_name = $_POST['user_name'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Encriptamos la contraseña
    $role_u = $_POST['rol_u'];
    $fecha_creacion = date('Y-m-d H:i:s'); // Fecha y hora actuales

    // Verificar si el nombre de usuario ya existe
    $checkUserQuery = "SELECT * FROM usuarios WHERE user_name = ?";
    $stmt = $conn->prepare($checkUserQuery);
    $stmt->bind_param("s", $user_name);
    $stmt->execute();
    $result = $stmt->get_result();

    // Si el nombre de usuario ya existe, mostrar mensaje de error
    if ($result->num_rows > 0) {
        echo "<div class='error-message'>El nombre de usuario ya está registrado. Por favor, elige otro.</div>";
    } else {
        // Si el nombre de usuario no existe, proceder con la inserción
        $insertQuery = "INSERT INTO usuarios (user_name, password, role_u, fecha_creacion) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($insertQuery);
        $stmt->bind_param("ssss", $user_name, $password, $role_u, $fecha_creacion);

        // Ejecutar la inserción
if ($stmt->execute()) {
    // Mensaje de éxito
    echo "<div class='success-message'>Registro exitoso. Ahora el usuario puede iniciar sesión.</div>";
    } else {
        echo "<div class='error-message'>Error de inserción: " . $stmt->error . "</div>";
    }
    }

    // Cerrar la conexión y el statement
    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro - Sistema de Almacén</title>
    <!-- Estilos internos -->
    <style>
        body {
            font-family: Arial, sans-serif;
            background-image: url('images/IMG.jpg');
            background-size: cover;
            background-position: center;
            background-attachment: fixed; 
            margin: 0;
            padding: 0;
        }

        .container {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .register-box {
            background-color: rgba(249, 231, 193, 0.8);
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0px 4px 12px rgba(0, 0, 0, 0.1);
            width: 300px;
        }

        .header h1 {
            text-align: center;
            margin-bottom: 20px;
        }

        label {
            font-weight: bold;
            margin-bottom: 5px;
            display: block;
        }

        input, select {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ddd;
            border-radius: 5px;
        }

        .register-button {
            background-color:rgb(145, 83, 2);
            color: white;
            font-size: 16px;
            border: none;
            cursor: pointer;
        }

        .register-button:hover {
            background-color:rgb(78, 44, 0);
        }

        .menu-button {
            background-color: rgb(253, 114, 0); 
            color: white;
            font-size: 16px;
            padding: 10px 50px; 
            border: none; 
            border-radius: 5px; 
            cursor: pointer; 
            width: 100%; 
            text-align: center; 
            margin-top: 10px; 
        }

        .menu-button:hover {
            background-color:rgb(255, 141, 65);
        }
        
        .success-message {
        background-color:rgb(109, 175, 125);  /* Verde */
        color: white;
        padding: 20px;
        text-align: center;
        border-radius: 5px;
        margin: 20px 0;
        font-weight: bold;
        width: 80%; /* Ajusta el tamaño */
        max-width: 500px; /* Tamaño máximo */
        margin-left: auto;
        margin-right: auto;
        }

        .error-message {
        background-color:rgb(197, 85, 77);  /* Rojo */
        color: white;
        padding: 20px;
        text-align: center;
        border-radius: 5px;
        margin: 20px 0;
        font-weight: bold;
        width: 80%; /* Ajusta el tamaño */
        max-width: 600px; /* Tamaño máximo */
        margin-left: auto;
        margin-right: auto;
        }

    </style>
</head>
<body>
    <div class="container">
        <div class="register-box">
            <div class="header">
                <h1>Registro de Usuario</h1>
            </div>

            <form id="register-form" action="registros.php" method="POST">
                <label for="user_name">Nombre de Usuario</label>
                <input type="text" id="user_name" name="user_name" placeholder="Nombre de Usuario" required>

                <label for="password">Contraseña</label>
                <input type="password" id="password" name="password" placeholder="************" required>

                <label for="rol_u">Rol</label>
                <select id="rol_u" name="rol_u" required>
                    <option value="user">Usuario</option>
                    <option value="admin">Administrador</option>
                </select>

                <input type="submit" value="Registrar" class="register-button">

                <button type="button" class="menu-button" onclick="window.location.href='inicio.php';">
                    Volver
                </button>
                
            </form>

        </div>
    </div>
</body>
</html>