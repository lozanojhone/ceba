<?php
$servername = "localhost";
$username = "root"; // Ajusta según tu configuración
$password = ""; // Ajusta según tu configuración
$dbname = "requerimientos_db";

// Conexión a la base de datos
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("Error en la conexión: " . $conn->connect_error);
}

// Consulta para obtener los registros en orden descendente
$sql = "SELECT * FROM requerimientos ORDER BY id DESC"; // Los más recientes aparecen primero
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registros de Requerimientos</title>
    <link rel="stylesheet" href="styles1.css">
</head>
<body>
<div class="container">
    <h1>Registros de Requerimientos</h1>
    <!-- Contenedor de búsqueda y botones -->
    <div class="search-container">
        <input type="text" id="searchInput" placeholder="Buscar por nombre..." onkeyup="buscarRegistro()">
        <!-- Botones Menú -->
        <a href="http://localhost/ANTONIO/sistema/inicio.php"><button>Menú</button></a>
    </div>

    <!-- Tabla de registros -->
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Email</th>
                    <th>Teléfono</th>
                    <th>Cargo</th>
                    <th>Descripción</th>
                    <th>Fecha</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody id="tabla-registros">
                <?php
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr id='fila-" . $row["id"] . "'>";
                        echo "<td>" . htmlspecialchars($row["id"]) . "</td>";
                        echo "<td>" . htmlspecialchars($row["nombre"]) . "</td>";
                        echo "<td class='email'>" . htmlspecialchars($row["email"]) . "</td>";
                        echo "<td>" . htmlspecialchars($row["telefono"]) . "</td>";
                        echo "<td>" . htmlspecialchars($row["cargo"]) . "</td>";
                        // Mostrar solo el botón "Ver" en la columna Descripción
                        echo "<td class='descripcion'>
                            <a href='ver_detalles.php?id=" . $row["id"] . "'><button class='ver-descripcion'>Ver</button></a>
                                </td>";
                        echo "<td>" . htmlspecialchars($row["fecha"]) . "</td>";
                        echo "<td>
                                <button class='editar' onclick='editarRegistro(" . $row["id"] . ")'>Editar</button>
                                <button class='eliminar' onclick='eliminarRegistro(" . $row["id"] . ")'>Eliminar</button>
                                <button class='imprimir' onclick='imprimirVoucher(" . $row["id"] . ")'>Imprimir</button>
                              </td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='8'>No hay registros disponibles</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</div>

<script>
// Función para buscar registros
function buscarRegistro() {
    let input = document.getElementById('searchInput').value.toUpperCase();
    let table = document.querySelector("table tbody");
    let tr = table.getElementsByTagName('tr');

    for (let i = 0; i < tr.length; i++) {
        let td = tr[i].getElementsByTagName('td')[1];
        if (td) {
            let txtValue = td.textContent || td.innerText;
            tr[i].style.display = txtValue.toUpperCase().indexOf(input) > -1 ? "" : "none";
        }
    }
}

// Función para editar un registro
function editarRegistro(id) {
    window.location.href = `editar_registro.php?id=${id}`;
}

// Función para eliminar un registro
function eliminarRegistro(id) {
    if (confirm('¿Estás seguro de eliminar este registro?')) {
        fetch(`eliminar_registro.php?id=${id}`, {
            method: 'GET',
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                document.getElementById(`fila-${id}`).remove();
                alert('Registro eliminado correctamente.');
            } else {
                alert('Error al eliminar el registro: ' + data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Hubo un problema al intentar eliminar el registro.');
        });
    }
}

// Función para imprimir un voucher
function imprimirVoucher(id) {
    window.open(`voucher.php?id=${id}`, '_blank');
}
</script>
</body>
</html>

<?php
$conn->close();
?>