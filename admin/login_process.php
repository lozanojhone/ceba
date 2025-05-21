<?php
session_start(); // Iniciar la sesión

// Verifica si ya está logueado y redirige si es necesario
if (isset($_SESSION['loggedIn']) && $_SESSION['loggedIn'] === true) {
    header("Location: http://localhost/ANTONIO/sistema/inicio.php"); // Redirige al inicio si ya está logueado
    exit();
}

// Conexión a la base de datos
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "requerimientos_db"; // Cambia esto con tu nombre de base de datos

$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Si se enviaron los datos del formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener los datos del formulario
    $user_name = $_POST['login-name'];
    $password = $_POST['login-pass'];

    // Verificar si el nombre de usuario existe en la base de datos
    $checkUserQuery = "SELECT * FROM usuarios WHERE user_name = ?";
    $stmt = $conn->prepare($checkUserQuery);
    $stmt->bind_param("s", $user_name);
    $stmt->execute();
    $result = $stmt->get_result();

    // Si el usuario existe
    if ($result->num_rows > 0) {
        // Obtener los datos del usuario
        $user = $result->fetch_assoc();

        // Verificar la contraseña
        if (password_verify($password, $user['password'])) {
            // Iniciar sesión correctamente
            $_SESSION['loggedIn'] = true;
            $_SESSION['user_name'] = $user['user_name']; // Almacenar el nombre del usuario en la sesión
            $_SESSION['role_u'] = $user['role_u']; // Almacenar el rol del usuario

            // Redirigir al inicio
            header("Location: http://localhost/ANTONIO/sistema/inicio.php");
            exit();
        } else {
            // Si la contraseña es incorrecta
            echo "<script>alert('Nombre de usuario o contraseña incorrecta'); window.location.href='login.html';</script>";
        }
    } else {
        // Si el usuario no existe
        echo "<script>alert('Nombre de usuario o contraseña incorrecta'); window.location.href='login.html';</script>";
    }

    // Cerrar la conexión y el statement
    $stmt->close();
    $conn->close();
}
?>