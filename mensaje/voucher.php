<?php
$servername = "localhost";
$username = "root";  // Cambia según tu configuración
$password = "";      // Cambia según tu configuración
$dbname = "requerimientos_db";

// Conectar a la base de datos
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

// Verificar y obtener el ID
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = $_GET['id'];
} else {
    die("ID inválido.");
}

$sql = "SELECT * FROM requerimientos WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

// Verificar si hay resultados
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
} else {
    die("No se encontró el requerimiento con el ID proporcionado.");
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>ANTONIO RAIMONDI</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            padding: 20px;
            background-color: #f8f8f8;
        }
        .voucher {
            background-color: #fff;
            border-radius: 8px;
            padding: 20px;
            width: 90%; /* Ampliamos el contenedor para más espacio */
            margin: auto;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            font-size: 14px;
            color: #333;
        }
        .header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 20px;
        }
        .header img {
            width: 100px; /* Ajusta el tamaño del logo */
            margin-right: 20px;
        }
        .header h2 {
            flex-grow: 1;
            font-weight: bold;
            color: #6b6b6b;
            text-align: center;
            margin: 0;
        }
        .info-table {
            width: 100%; /* Asegura que la tabla ocupe el 100% del espacio */
            border-collapse: collapse;
            margin-top: 10px;
            font-size: 12px; /* Ajuste de tamaño de la fuente */
        }
        .info-table th, .info-table td {
            padding: 12px; /* Aumentamos el padding para que haya más espacio */
            text-align: left;
            border: 1px solid #ddd;
        }
        .info-table th {
            background-color: #f2f2f2;
            color: #333;
            font-weight: bold;
        }
        .info-table td {
            background-color: #fff;
        }
        .footer {
            margin-top: 20px;
            font-size: 13px;
            color: #555;
            text-align: center;
        }
        .footer .contact-info {
            display: flex;
            justify-content: center;
            gap: 20px;
            margin-top: 10px;
        }
        .footer .contact-info div {
            text-align: left;
        }
        .footer .contact-info div p {
            margin: 3px 0;
        }
    </style>
</head>
<body>

<div class="voucher">
    <div class="header">
        <img src="../imagenes/logo1.png" alt="Logo"> <!-- Asegúrate de que el logo esté en el mismo directorio o ajusta la ruta -->
        <h2>Voucher de Requerimiento</h2>
    </div>

    <table class="info-table">
        <tr>
            <th>ID</th>
            <td><?php echo $row['id']; ?></td>
        </tr>
        <tr>
            <th>Nombre</th>
            <td><?php echo $row['nombre']; ?></td>
        </tr>
        <tr>
            <th>Email</th>
            <td><?php echo $row['email']; ?></td>
        </tr>
        <tr>
            <th>Teléfono</th>
            <td><?php echo $row['telefono']; ?></td>
        </tr>
        <tr>
            <th>Cargo</th>
            <td><?php echo $row['cargo']; ?></td>
        </tr>
        <tr>
            <th>Descripción</th>
            <td><?php echo $row['descripcion']; ?></td>
        </tr>
        <tr>
            <th>Cantidad</th>
            <td><?php echo $row['cantidad']; ?></td>
        </tr>
        <tr>
            <th>Estado</th>
            <td><?php echo $row['estado']; ?></td>
        </tr>
        <tr>
            <th>Fecha</th>
            <td><?php echo $row['fecha']; ?></td>
        </tr>
    </table>

    <div class="footer">
        <p>Total: <?php echo $row['cantidad']; ?></p>
        <p>Gracias por su solicitud.</p>
        <div class="contact-info">
            <div>
                <p><strong>Correo Electrónico:</strong></p>
                <p>secretaria@ar.edu.pe</p>
            </div>
            <div>
                <p><strong>Teléfono:</strong></p>
                <p>973 264 935</p>
            </div>
            <div>
                <p><strong>Dirección:</strong></p>
                <p>Av Vía de Evitamiento Nte 300</p>
                <p>Cajamarca 06001</p>
            </div>
        </div>

<script>
    window.onload = function() {
        window.print(); // Imprime la página al cargar
    }
</script>

</body>
</html>

<?php
$stmt->close();
$conn->close();
?>
