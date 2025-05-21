<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "requerimientos_db";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

$id = $_GET['id'];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = $_POST['nombre'];
    $email = $_POST['email'];
    $telefono = $_POST['telefono'];
    $cargo = $_POST['cargo'];
    $descripcion = $_POST['descripcion'];
    $cantidad = $_POST['cantidad'];
    $estado = $_POST['estado'];

    $sql = "UPDATE requerimientos SET nombre=?, email=?, telefono=?, cargo=?, descripcion=?, cantidad=?, estado=? WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssissssi", $nombre, $email, $telefono, $cargo, $descripcion, $cantidad, $estado, $id);

    if ($stmt->execute()) {
        echo "<script>alert('Registro actualizado con éxito.'); window.location.href='ver_registros.php';</script>";
        exit;
    } else {
        $error = "Error al actualizar el registro.";
    }
} else {
    $sql = "SELECT * FROM requerimientos WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Registro</title>
    <link rel="stylesheet" href="styles2.css"> <!-- Archivo CSS externo -->
</head>
<body>

<div class="container">
    <h1>Editar Registro</h1>
    <?php if (isset($error)) echo "<p class='error'>$error</p>"; ?>
    <form method="POST">
        <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
        <label for="nombre">Nombre</label>
        <input type="text" id="nombre" name="nombre" value="<?php echo htmlspecialchars($row['nombre']); ?>" required>

        <label for="email">Email</label>
        <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($row['email']); ?>" required>

        <label for="telefono">Teléfono</label>
        <input type="text" id="telefono" name="telefono" value="<?php echo htmlspecialchars($row['telefono']); ?>" required>

        <label for="cargo">Cargo</label>
        <input type="text" id="cargo" name="cargo" value="<?php echo htmlspecialchars($row['cargo']); ?>" required>

        <label for="descripcion">Descripción</label>
        <textarea id="descripcion" name="descripcion" rows="4" required><?php echo htmlspecialchars($row['descripcion']); ?></textarea>

        <label for="cantidad">Cantidad</label>
        <input type="number" id="cantidad" name="cantidad" value="<?php echo $row['cantidad']; ?>" required>

        <label for="estado">Estado</label>
        <input type="text" id="estado" name="estado" value="<?php echo htmlspecialchars($row['estado']); ?>" required>

        <button type="submit">Guardar Cambios</button>
    </form>
</div>

</body>
</html>

<?php
$stmt->close();
$conn->close();
?>
