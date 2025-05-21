<?php
include 'conexion.php'; // Conexión a la base de datos

session_start(); // Iniciar la sesión

// Verificar si el usuario está logueado
if (!isset($_SESSION['loggedIn']) || $_SESSION['loggedIn'] !== true) {
    // Si no está logueado, redirigir al login
    header("Location: http://localhost/ANTONIO/admin/login.html");
    exit();
}

// Obtener el mes seleccionado desde el formulario, si se envió
$mes = isset($_GET['mes']) ? $_GET['mes'] : date('m'); // Por defecto, el mes actual

// Consulta para obtener los datos del historial de entregas filtrados por mes
$query = "
    SELECT 
        CASE 
            WHEN CAST(SUBSTRING(e.almacen, LENGTH('requerimientos_db') + 1) AS UNSIGNED) = 1 THEN 'Biblioteca'
            WHEN CAST(SUBSTRING(e.almacen, LENGTH('requerimientos_db') + 1) AS UNSIGNED) = 2 THEN 'Computación'
            WHEN CAST(SUBSTRING(e.almacen, LENGTH('requerimientos_db') + 1) AS UNSIGNED) = 3 THEN 'Edu. Fisica'
            WHEN CAST(SUBSTRING(e.almacen, LENGTH('requerimientos_db') + 1) AS UNSIGNED) = 4 THEN 'Limpieza'
            WHEN CAST(SUBSTRING(e.almacen, LENGTH('requerimientos_db') + 1) AS UNSIGNED) = 5 THEN 'Moviliario'
            WHEN CAST(SUBSTRING(e.almacen, LENGTH('requerimientos_db') + 1) AS UNSIGNED) = 6 THEN 'Otros Materiales'
            WHEN CAST(SUBSTRING(e.almacen, LENGTH('requerimientos_db') + 1) AS UNSIGNED) = 7 THEN 'Laboratorio'
            WHEN CAST(SUBSTRING(e.almacen, LENGTH('requerimientos_db') + 1) AS UNSIGNED) = 8 THEN 'Cosmetologia'
            WHEN CAST(SUBSTRING(e.almacen, LENGTH('requerimientos_db') + 1) AS UNSIGNED) = 9 THEN 'Costureria'
            ELSE 'Otro' -- Si el valor no es ni 1,2,3,4,5,6,7,8,9
        END AS almacen,
        e.nombre_persona AS nombre,
        e.dni,
        e.contacto,
        e.cantidad_entregada AS cantidad,
        e.fecha_entrega,
        p.nombre_producto AS nombre_producto,
        e.estado_producto AS estado_producto
    FROM entregas e
    JOIN productos p ON e.producto_id = p.id
    WHERE MONTH(e.fecha_entrega) = $mes
    ORDER BY e.fecha_entrega DESC
";

$resultado = mysqli_query($conn, $query);

if (!$resultado) {
    die("Error en la consulta: " . mysqli_error($conn));
}

// Convertir los resultados a un formato que JavaScript pueda entender
$datos_tabla = [];
while ($fila = mysqli_fetch_assoc($resultado)) {
    $datos_tabla[] = $fila;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Historial de Entregas</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.70/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.70/vfs_fonts.js"></script>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            padding: 20px;
            background-color:rgba(249, 231, 193, 0.8);
        }

        .botones-bar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 10px;
        }

        .volver {
            display: inline-block;
            padding: 10px 20px;
            background-color: #ff9b00;
            color: white;
            text-decoration: none;
            border-radius: 4px;
            font-size: 16.5px;
            font-weight: bold;
        }

        .volver:hover {
            background-color: #df5b00;
        }

        .reporte {
            display: inline-block;
            padding: 10px 20px;
            background-color: #a96321;
            color: white;
            text-decoration: none;
            border-radius: 4px;
            font-size: 16.5px;
            font-weight: bold;
        }

        .reporte:hover {
            background-color: #4d1408;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            border: 1px solid rgb(14, 6, 0);
            padding: 8px;
            text-align: center;
        }

        th {
            background-color:rgb(105, 65, 4);
            color: white;
        }

        tr:nth-child(even) {
            background-color:rgb(255, 255, 255);
        }

        tr:hover {
            background-color: #ddd;
        }

        .title {
            text-align: center;
            margin-bottom: 20px;
        }

        .form-group{
            text-align: center;
            display:flex;
            justify-content: flex-end;
        }

        .form-group form {
            background-color:rgb(255, 255, 255);
            width: 18%;
            padding: 15px 20px;
            border-radius: 8px;
            box-shadow: 0 2px 6px rgba(0,0,0,0.1);
        }

        .form-group label {
            margin-right: 10px;
            font-weight: bold;
            font-family: Arial, sans-serif;
        }

        .form-group select {
            padding: 6px 10px;
            border-radius: 4px;
            border: 1px solid #ccc;
            font-family: Arial, sans-serif;
        }
    </style>
</head>
<body>
    <div class="botones-bar">
        <div class="boton-izquierda">
            <a href="inicio.php" class="volver">Volver</a>
        </div>
        <div class="boton-derecha">
            <a href="javascript:void(0);" class="reporte" onclick="exportarPDF()">Reporte</a>
        </div>
    </div>
    
    <h1 class="title">Historial de Entregas y Devoluciones</h1>

    <!-- Formulario para seleccionar el mes -->
    <div class="form-group">
        <form method="get" action="">
            <label for="mes">Selecciona el mes: </label>
            <select name="mes" id="mes" onchange="this.form.submit()">
                <option value="1" <?php echo ($mes == 1) ? 'selected' : ''; ?>>Enero</option>
                <option value="2" <?php echo ($mes == 2) ? 'selected' : ''; ?>>Febrero</option>
                <option value="3" <?php echo ($mes == 3) ? 'selected' : ''; ?>>Marzo</option>
                <option value="4" <?php echo ($mes == 4) ? 'selected' : ''; ?>>Abril</option>
                <option value="5" <?php echo ($mes == 5) ? 'selected' : ''; ?>>Mayo</option>
                <option value="6" <?php echo ($mes == 6) ? 'selected' : ''; ?>>Junio</option>
                <option value="7" <?php echo ($mes == 7) ? 'selected' : ''; ?>>Julio</option>
                <option value="8" <?php echo ($mes == 8) ? 'selected' : ''; ?>>Agosto</option>
                <option value="9" <?php echo ($mes == 9) ? 'selected' : ''; ?>>Septiembre</option>
                <option value="10" <?php echo ($mes == 10) ? 'selected' : ''; ?>>Octubre</option>
                <option value="11" <?php echo ($mes == 11) ? 'selected' : ''; ?>>Noviembre</option>
                <option value="12" <?php echo ($mes == 12) ? 'selected' : ''; ?>>Diciembre</option>
            </select>
        </form>
    </div>

    <table id="tabla">
        <thead>
            <tr>
                <th>ALMACÉN</th>
                <th>NOMBRE PERSONA</th>
                <th>DNI</th>
                <th>CONTACTO</th>
                <th>PRODUCTO</th>
                <th>CANTIDAD</th>
                <th>FECHA DE ENTREGA</th>
                <th>ESTADO DEL PRODUCTO</th>
            </tr>
        </thead>
        <tbody>
            <?php if (mysqli_num_rows($resultado) > 0): ?>
                <?php foreach ($datos_tabla as $fila): ?>
                    <tr>
                        <td><?php echo $fila['almacen']; ?></td>
                        <td><?php echo $fila['nombre']; ?></td>
                        <td><?php echo $fila['dni']; ?></td>
                        <td><?php echo $fila['contacto']; ?></td>
                        <td><?php echo $fila['nombre_producto']; ?></td>
                        <td><?php echo $fila['cantidad']; ?></td>
                        <td><?php echo $fila['fecha_entrega']; ?></td>
                        <td><?php echo $fila['estado_producto']; ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="8">No hay registros en el historial.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

    <script>
        // Pasar los datos de PHP a JavaScript
        var datos = <?php echo json_encode($datos_tabla); ?>;

        function exportarPDF() {
            var docDefinition = {
                pageOrientation: 'landscape', // Configurar la orientación horizontal (paisaje)
                content: [
                    { 
                        text: 'Historial de Entregas', 
                        style: 'header',
                        alignment: 'center'
                    },
                    {
                        table: {
                            headerRows: 1,
                            widths: ['*', '*', '*', '*', '*', '*', '*', '*'],
                            body: [
                                ['ALMACÉN', 'NOMBRE PERSONA', 'DNI', 'CONTACTO', 'PRODUCTO', 'CANTIDAD', 'FECHA DE ENTREGA', 'ESTADO DEL PRODUCTO'],
                                // Aquí agregamos los datos de la tabla
                                ...datos.map(function(fila) {
                                    return [
                                        fila.almacen,
                                        fila.nombre,
                                        fila.dni,
                                        fila.contacto,
                                        fila.nombre_producto,
                                        fila.cantidad,
                                        fila.fecha_entrega,
                                        fila.estado_producto
                                    ];
                                })
                            ]
                        },
                        layout: 'lightHorizontalLines' // Estilo de tabla con líneas horizontales ligeras
                    }
                ],
                styles: {
                    header: { 
                        fontSize: 18, 
                        bold: true, 
                        alignment: 'center',
                        color: '#2E3B4E',
                        margin: [0, 0, 0, 10]
                    },
                    tableHeader: {
                        fillColor: '#F1C40F',
                        color: '#000000',
                        bold: true,
                        fontSize: 12
                    },
                    tableBody: {
                        fontSize: 10
                    }
                }
            };
            pdfMake.createPdf(docDefinition).download('historial_entregas.pdf');
        }
    </script>
</body>
</html>
