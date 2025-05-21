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

// Capturar la clase desde la URL
if (isset($_GET['clase'])) {
    $clase = $_GET['clase'];
} else {
    die("Clase no definida.");
}

// Mensaje de Devolucion Exitosa
$mensaje = '';
$nivel = '';
if (isset($_GET['msg'])) {
    $mensaje = urldecode($_GET['msg']); // Decodifica el mensaje
    $nivel = ($_GET['nivel'] ?? 'exito') === 'error' ? 'error' : 'exito';
}

// Definir la imagen de fondo de acuerdo a la clase
$imagen_fondo = '';
switch ($clase) {
    case 1:
        $imagen_fondo = 'images/Bibliotecas.jpg'; // Ruta de la imagen para Biblioteca
        break;
    case 2:
        $imagen_fondo = 'images/computacion.jpg'; // Ruta de la imagen para Computación
        break;
    case 3:
        $imagen_fondo = 'images/deportes.jpg'; // Ruta de la imagen para Deportes
        break;
    case 4:
        $imagen_fondo = 'images/limpieza.jpg'; // Ruta de la imagen para Limpieza
        break;
    case 5:
        $imagen_fondo = 'images/mobiliario.jpg'; // Ruta de la imagen para Mobiliario
        break;
    case 6:
        $imagen_fondo = 'images/otros.jpg'; // Ruta de la imagen para Otros Materiales
        break;
    case 7:
        $imagen_fondo = 'images/laborat.jpg'; // Ruta de la imagen para Laboratorio
        break;
    case 8:
        $imagen_fondo = 'images/cosmetologia.jpg'; // Ruta de la imagen para Cosmetología
        break;
    case 9:
        $imagen_fondo = 'images/costureria.jpg'; // Ruta de la imagen para Costurería
        break;
    default:
        $imagen_fondo = 'images/default.jpg'; // Imagen por defecto si no se encuentra la clase
        break;
    }
    
// Campo donde se modelaran los productos
function mostrarProductos($conn, $clase) {
    $sql = "SELECT * FROM productos
            WHERE clase_producto = ?
            ORDER BY id DESC";   // ↓ id descendente ⇒ últimos arriba

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $clase);

    if ($stmt->execute()) {
        $result = $stmt->get_result();    

        echo "<h2 style='text-align: center; margin-bottom: 20px;'>Productos en esta clase:</h2>";
        if ($result->num_rows > 0) {
            echo "<table border='1' style='width: 1000px; margin: auto; text-align: center; border-collapse: collapse;'>";
            echo "<colgroup>
                    <col style='width: 8%; padding: 10px; border: 2px solid black;'> <!-- ID -->
                    <col style='width: 30%; padding: 10px; border: 2px solid black;'> <!-- NOMBRE -->
                    <col style='width: 20%; padding: 10px; border: 2px solid black;'> <!-- DESCRIPCION -->
                    <col style='width: 10%; padding: 10px; border: 2px solid black;'> <!-- CANTIDAD -->
                    <col style='width: 30%; padding: 10px; border: 2px solid black;'> <!-- ACCIONES -->
                  </colgroup>";
            echo "<tr><th>ID</th><th>NOMBRE</th><th>DESCRIPCION</th><th>CANTIDAD</th><th>ACCIONES</th></tr>";
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td style='padding: 10px; border: 2px solid black;'>" . $row['id'] . "</td>";
                echo "<td style='padding: 10px; border: 2px solid black;'>" . $row['nombre_producto'] . "</td>";
                echo '<td style="padding: 10px; border: 2px solid black;">
                    <a href="ver.php?id=' . $row['id'] . '&clase=' . $clase . '" class="btn-azul">Ver</a> </td>';
                echo "<td style='padding: 10px; border: 2px solid black;'>" . $row['cantidad'] . "</td>";
                echo "<td style='padding: 10px; border: 2px solid black;'>
                        <a href='editar_producto.php?id=" . $row['id'] . "&clase=" . $clase . "'>
                            <button class='btn-azul'>Editar</button>
                        </a>
                        <a href='devolver_producto.php?id=" . $row['id'] . "&clase=" . $clase . "'>
                            <button class='btn-azul'>Devolver</button>
                        </a>
                      </td>";
                echo "</tr>";
            }
            echo "</table>";
        } else {
            echo "No hay productos en esta clase.";
        }
    } else {
        echo "Error al mostrar los productos: " . $conn->error;
    }

}

// Lógica para eliminar productos
if (isset($_POST['eliminar'])) {
    $id = $_POST['id'];
    $cantidad_a_eliminar = $_POST['cantidad_a_eliminar']; // Cantidad a eliminar

    // Obtenemos la cantidad actual del producto
    $sql = "SELECT cantidad FROM productos WHERE id=? AND clase_producto=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("is", $id, $clase);
    $stmt->execute();
    $stmt->bind_result($cantidad_actual);
    $stmt->fetch();
    $stmt->close();

    if ($cantidad_actual >= $cantidad_a_eliminar) {
        $nueva_cantidad = $cantidad_actual - $cantidad_a_eliminar;

        if ($nueva_cantidad > 0) {
            // Si la cantidad no es cero, actualizamos la cantidad
            $sql = "UPDATE productos SET cantidad=? WHERE id=? AND clase_producto=?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("iis", $nueva_cantidad, $id, $clase);
            $stmt->execute();
            echo "<div class='mensaje-exito'>Se eliminaron $cantidad_a_eliminar unidades. Cantidad restante: $nueva_cantidad.</div>";
        } else {
            // Si la cantidad es cero, eliminamos el producto
            $sql = "DELETE FROM productos WHERE id=? AND clase_producto=?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("is", $id, $clase);
            $stmt->execute();
            echo "<div class='mensaje-exito'>Producto eliminado completamente.</div>";
        }
    } else {
        echo "<div class='mensaje-exito' style='background-color: #f8d7da; color: #721c24; border-color: #f5c6cb;'>Error: La cantidad a eliminar es mayor que la cantidad disponible.</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Clase <?php echo $clase; ?></title>
    <style>
        /* Estilos generales para el fondo de la página */
        body {
            font-family: Arial, sans-serif;
            background-image: url('<?php echo $imagen_fondo; ?>'); /* Ruta de la imagen de fondo */
            background-size: contain; /* La imagen se ajusta al contenedor sin distorsionar */
            background-position: center center; /* Centra la imagen */
            background-attachment: fixed; /* Hace que el fondo permanezca fijo al hacer scroll */
            margin: 0;
            padding: 0;
        }

        .modal {
            display: none; /* Inicia oculto */
            position: fixed; /* Se posiciona de forma fija */
            z-index: 1; /* Asegura que el modal esté encima del contenido */
            left: 0;
            top: 0;
            width: 100%; /* Ocupa toda la pantalla */
            height: 100%; /* Ocupa toda la pantalla */
            overflow: auto; /* Si el contenido es muy grande, puede desplazarse */
            background-color: rgba(0, 0, 0, 0.5); /* Fondo semitransparente */
            text-align: center;
        }

        /* Estilos del contenido del modal */
        .modal-content {
            background-color: <?php echo ($nivel === 'error') ? '#f8d7da' : '#d4edda'; ?>;
            color: <?php echo ($nivel === 'error') ? '#721c24' : '#155724'; ?>;
            padding: 20px;
            border-radius: 8px;
            width: 50%;
            margin: 15% auto; /* Centra el modal vertical y horizontalmente */
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            font-size: 18px;
            font-weight: bold;
        }

        /* Estilos para el botón de cerrar */
        .close {
            color: <?php echo ($nivel === 'error') ? '#721c24' : '#155724'; ?>;
            font-size: 25px;
            font-weight: bold;
            float: right;
            cursor: pointer;
        }

        /* Contenedor principal con fondo blanco para los datos */
        .content-container {
            background-color: rgba(249, 231, 193, 0.8); /* Fondo blanco con opacidad */
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            width: 90%;
            max-width: 1200px; /* Establece un ancho máximo */
            margin: 50px auto; /* Centra el contenedor */
        }

        /* Clase para el mensaje de éxito */
        .mensaje-exito {
            background-color: #d4edda; /* Fondo verde claro */
            color: #155724; /* Texto verde oscuro */
            border: 1px solid #c3e6cb; /* Borde verde */
            border-radius: 5px; /* Bordes redondeados */
            padding: 15px; /* Espaciado interno */
            width: 50%; /* Ancho ajustado */
            margin: 20px auto; /* Centrado */
            text-align: center; /* Texto centrado */
            font-weight: bold; /* Texto en negrita */
        }

        /* Estilos para los botones personalizados */
        .btn-azul {
            background-color: #995033; /* Color marron */
            color: white; /* Letras blancas */
            font-size: 18px; /* Tamaño de letra más grande */
            padding: 15px 30px; /* Aumentar el espacio dentro del botón */
            border: none; /* Sin bordes */
            border-radius: 5px; /* Bordes redondeados */
            cursor: pointer; /* Cursor de mano al pasar sobre el botón */
            transition: background-color 0.3s; /* Efecto suave al cambiar de color */
        }

        /* Cambia el color del botón cuando se pasa el ratón por encima */
        .btn-azul:hover {
            background-color: #4d1408; /* Color azul más oscuro al pasar el ratón */
        }

        /* Opcional: centra los botones si es necesario */
        .btn-container {
            display: flex;
            justify-content: center;
            gap: 20px; /* Espacio entre los botones */
            margin-bottom: 20px; /* Espaciado debajo de los botones */
        }

        /* Estilo para la imagen y el texto dinámico en la parte superior izquierda */
        .almacen {
            position: absolute;
            top: 20px;
            left: 20px;
        }

        .almacen img {
            width: 100px; /* Ajusta el tamaño de la imagen */
            height: auto;
        }

        .almacen-texto {
            font-size: 20px;
            font-weight: bold;
        }

        /* Estilo para posicionar el logo en la esquina superior derecha */
        .logo {
            position: absolute;
            top: 1px;
            right: 20px;
            width: 200px; /* Ajusta el tamaño del logo */
        }

        /* Estilo para centrar el título */
        .titulo {
            text-align: center;
            font-size: 33px;
            margin-bottom: 25px;
        }

        /* Estilo para centrar las secciones de eliminar y buscar producto */
        .seccion {
            text-align: center;
            margin-bottom: 30px;
        }

        /* Estilo para el botón "Volver" en la esquina superior izquierda */
        .btn-volver {
            position: absolute;
            top: 20px;
            left: 20px;
        }

        /* Solo para los enlaces Ver dentro de la tabla */
        a.btn-azul {
            text-decoration: none;
        }

        .mensaje-exito, .mensaje-error {
        width: 80%;
        max-width: 800px;
        margin: 20px auto;
        padding: 15px;
        border-radius: 5px;
        font-weight: bold;
        text-align: center;
        }

        .mensaje-exito {
        background: #d4edda;   /* verde claro */
        color: #155724;        /* verde oscuro */
        border: 1px solid #c3e6cb;
        }

        .mensaje-error {
        background: #f8d7da;   /* rojo claro */
        color: #721c24;        /* rojo oscuro */
        border: 1px solid #f5c6cb;
        }
        
    </style>
</head>
<body>

    <!-- Modal (ventana emergente) -->
    <?php if ($mensaje): ?>
    <div class="modal" id="myModal">
        <div class="modal-content">
            <span class="close" id="closeModal">&times;</span>
            <p><?php echo $mensaje; ?></p>
        </div>
    </div>
    <?php endif; ?>
    <!-- Aquí va el resto de tu contenido HTML, incluyendo productos, formularios, etc. -->

    <script>
        // JavaScript para mostrar el modal cuando haya un mensaje
        var modal = document.getElementById("myModal");
        var closeModal = document.getElementById("closeModal");

        // Mostrar el modal si hay un mensaje
        <?php if ($mensaje): ?>
            modal.style.display = "block";
        <?php endif; ?>

        // Cerrar el modal cuando se haga clic en el botón de cerrar
        closeModal.onclick = function() {
            modal.style.display = "none";
        }

        // Cerrar el modal si se hace clic fuera del modal
        window.onclick = function(event) {
            if (event.target === modal) {
                modal.style.display = "none";
            }
        }
    </script>


    <!-- Imagen y texto en la esquina superior izquierda según la clase -->
    <div class="almacen">
        <?php
        if ($clase == 1) {
            echo '<img src="images/biblioteca.png" alt="Almacén 1">';
            echo '<p class="almacen-texto">Biblioteca</p>';
        } elseif ($clase == 2) {
            echo '<img src="images/computacion.png" alt="Almacén 2">';
            echo '<p class="almacen-texto">Computacion</p>';
        } elseif ($clase == 3) {
            echo '<img src="images/deportes.png" alt="Almacén 3">';
            echo '<p class="almacen-texto">Edu. Fisica</p>';
        } elseif ($clase == 4) {
            echo '<img src="images/limpieza.png" alt="Almacén 4">';
            echo '<p class="almacen-texto">Limpieza</p>';
        } elseif ($clase == 5) {
            echo '<img src="images/mobiliario.png" alt="Almacén 5">';
            echo '<p class="almacen-texto">Moviliario</p>';
        } elseif ($clase == 6) {
            echo '<img src="images/otros.png" alt="Almacén 6">';
            echo '<p class="almacen-texto">Otros Materiales</p>';
        } elseif ($clase == 7) {
            echo '<img src="images/laborat.png" alt="Almacén 7">';
            echo '<p class="almacen-texto">Laboratorio</p>';
        } elseif ($clase == 8) {
            echo '<img src="images/cosmetologia.png" alt="Almacén 8">';
            echo '<p class="almacen-texto">Cosmetologia</p>';
        } elseif ($clase == 9) {
            echo '<img src="images/costurer.png" alt="Almacén 9">';
            echo '<p class="almacen-texto">Costureria</p>';
        }
        ?>
    </div>

    <!-- Logo en la esquina superior derecha -->
    <img src="images/logo.png" alt="Logo" class="logo">

    <!-- Botón para volver a la página principal -->
    <div class="btn-volver">
        <br><br><br><br><br><br><br><br><br>
        <a href="inicio.php"><button class="btn-azul">Volver</button></a>
    </div>

    <!-- Contenedor principal con fondo blanco -->
    <div class="content-container">
        <!-- Título centrado -->
        <h1 class="titulo">Gestión de Productos para la Clase <?php echo $clase; ?></h1>

        <!-- Contenedor para centrar los botones y aplicarles estilo -->
        <div class="btn-container">
            <a href="agregar_producto.php?clase=<?php echo $clase; ?>"><button class="btn-azul">Agregar Producto</button></a>
            <a href="entregar_producto.php?clase=<?php echo $clase; ?>"><button class="btn-azul">Entrega de Producto</button></a>
        </div>

        <!-- Sección para eliminar producto -->
        <div class="seccion">
            <h2>Eliminar Producto</h2>
            <form method="post" action="">
                <input type="number" name="id" placeholder="ID del producto" required>
                <input type="number" name="cantidad_a_eliminar" placeholder="Cantidad a eliminar" required>
                <button type="submit" name="eliminar" class="btn-azul">Eliminar</button>
            </form>
        </div>

        <!-- Lógica para buscar productos -->
        <div class="seccion">
            <h2>Buscar Producto</h2>
            <form method="post" action="">
                <input type="text" name="busqueda" placeholder="Nombre o ID del producto" required>
                <button type="submit" name="buscar" class="btn-azul">Buscar</button>
            </form>
        </div>

        <?php
        // Lógica para realizar la búsqueda
        if (isset($_POST['buscar'])) {
            $busqueda = $_POST['busqueda'];

            // Ejecutar la búsqueda
            $sql = "SELECT * FROM productos WHERE (nombre_producto LIKE ? OR id=?) AND clase_producto=?";
            $stmt = $conn->prepare($sql);
            $param_busqueda = "%$busqueda%"; // Para búsqueda por nombre
            $stmt->bind_param("ssi", $param_busqueda, $busqueda, $clase);
            $stmt->execute();
            $result = $stmt->get_result();

            echo "<h2 style='text-align: center; margin-bottom: 20px;'>Resultados de búsqueda:</h2>";
            if ($result->num_rows > 0) {
                echo "<table border='1' style='width: 1000px; margin: auto; text-align: center; border-collapse: collapse;'>";
                echo "<colgroup>
                        <col style='width: 8%; padding: 10px; border: 2px solid black;'> <!-- ID -->
                    <col style='width: 30%; padding: 10px; border: 2px solid black;'> <!-- Nombre -->
                    <col style='width: 20%; padding: 10px; border: 2px solid black;'> <!-- Descripcion -->
                    <col style='width: 10%; padding: 10px; border: 2px solid black;'> <!-- Cantidad -->
                    <col style='width: 30%; padding: 10px; border: 2px solid black;'> <!-- Acciones -->
                      </colgroup>";
                echo "<tr><th>ID</th><th>Nombre</th><th>Descripcion</th><th>Cantidad</th><th>Acciones</th></tr>";
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td style='padding: 10px; border: 2px solid black;'>" . $row['id'] . "</td>";
                    echo "<td style='padding: 10px; border: 2px solid black;'>" . $row['nombre_producto'] . "</td>";
                    echo '<td style="padding: 10px; border: 2px solid black;">
                        <a href="ver.php?id=' . $row['id'] . '&clase=' . $clase . '" class="btn-azul">Ver</a> </td>';
                    echo "<td style='padding: 10px; border: 2px solid black;'>" . $row['cantidad'] . "</td>";
                    echo "<td style='padding: 10px; border: 2px solid black;'>
                            <a href='editar_producto.php?id=" . $row['id'] . "&clase=" . $clase . "'>
                                <button class='btn-azul'>Editar</button>
                            </a>
                            <a href='devolver_producto.php?id=" . $row['id'] . "&clase=" . $clase . "'>
                            <button class='btn-azul'>Devolver</button>
                            </a>
                          </td>";
                    echo "</tr>";
                } 
                echo "</table>";
            } else {
                echo "<div class='mensaje-exito' style='background-color: #f8d7da; color: #721c24; border-color: #f5c6cb;'>No se encontraron productos.</div>";
            }
        }
        ?>
        <!-- Sección para mostrar productos -->
        <div class="seccion">
            <?php mostrarProductos($conn, $clase); ?>
        </div>
    </div>
</body>
</html>