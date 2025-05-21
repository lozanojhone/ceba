<?php
include 'conexion.php';

session_start(); // Iniciar la sesión

// Verificar si el usuario está logueado
if (!isset($_SESSION['loggedIn']) || $_SESSION['loggedIn'] !== true) {
    // Si no está logueado, redirigir al login
    header("Location: http://localhost/ANTONIO/admin/login.html");
    exit();
}

/* helper ----------------------------------------- */
function redirigir_con_msg($clase, $texto, $nivel = 'exito') {
    $m = urlencode($texto);  // codifica el mensaje para URL
    $n = urlencode($nivel);  // codifica el nivel (éxito o error)
    header("Location: clase.php?clase=$clase&msg=$m&nivel=$n");  // redirige con el mensaje y nivel
    exit;
}

/* validación ------------------------------------- */
if (!isset($_GET['id'], $_GET['clase'])) {
    redirigir_con_msg($_GET['clase'] ?? 1, 'ID de producto no proporcionado.', 'error');
}

$producto_id = $_GET['id'];
$clase       = $_GET['clase'];

/* consulta --------------------------------------- */
$sql = "SELECT * FROM entregas WHERE producto_id=? ORDER BY fecha_entrega DESC LIMIT 1";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $producto_id);
$stmt->execute();
$res = $stmt->get_result();

if ($res->num_rows === 0) {
    redirigir_con_msg($clase, '⚠️ No se encontró ningún registro para este producto.', 'error');
}

$fila = $res->fetch_assoc();

if ($fila['estado_producto'] !== 'Entregado') {
    redirigir_con_msg($clase,
        '⚠️ El producto ya fue devuelto o no está en estado "Entregado".', 'error');
}

/* registrar devolución --------------------------- */
$sql_ins = "INSERT INTO entregas (producto_id, almacen, nombre_persona, dni, contacto,
                                  cantidad_entregada, estado_producto, fecha_entrega)
            VALUES (?, ?, ?, ?, ?, ?, 'Devuelto', NOW())";
$ins = $conn->prepare($sql_ins);
$ins->bind_param("issssi",
                 $producto_id, $fila['almacen'], $fila['nombre_persona'], $fila['dni'],
                 $fila['contacto'], $fila['cantidad_entregada']);

if (!$ins->execute()) {
    redirigir_con_msg($clase, 'Error al devolver el producto.', 'error');
}

/* actualizar stock ------------------------------- */
$cant = $fila['cantidad_entregada'];
$upd  = $conn->prepare("UPDATE productos SET cantidad = cantidad + ? WHERE id = ?");
$upd->bind_param("ii", $cant, $producto_id);
$upd->execute();

/* éxito ------------------------------------------ */
redirigir_con_msg($clase, 'Material devuelto exitosamente.', 'exito');
?>