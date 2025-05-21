<?php
$servername = "localhost";
$username = "root";  // Cambia según tu configuración
$password = "";      // Cambia según tu configuración
$dbname = "requerimientos_db";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Error de conexión a la base de datos: " . $conn->connect_error);
}

$id = $_GET['id']; // Obtener ID de la URL

$sql = "DELETE FROM requerimientos WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);

if ($stmt->execute()) {
    echo json_encode(["success" => true, "message" => "Registro eliminado con éxito"]);
} else {
    echo json_encode(["success" => false, "message" => "Error al eliminar el registro"]);
}

$stmt->close();
$conn->close();
?>
