<?php
session_start(); // Iniciar la sesión

// Verificar si el usuario está logueado
if (!isset($_SESSION['loggedIn']) || $_SESSION['loggedIn'] !== true) {
    // Si no está logueado, redirigir a la página de login
    header("Location: http://localhost/ANTONIO/admin/login.html");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Inventario</title>
  <link rel="stylesheet" href="assets/css/styles.css">
</head>
<body>
  <div class="top-bar"></div>
  <!-- Barra menu -->
  <div id="sidebar" class="sidebar">
    <!-- Contenedor del perfil -->
    <div class="profile-section">
      <img src="assets/img/iLogo.jpg" alt="Foto de perfil" class="profile-img">
      <h2 class="profile-name">ADMIN</h2>
      <h4 class="profile-role"></h4>
    </div>
    <!-- Botón de mensajes -->
    <form>
     <div class="menu-section">
      </form>
      <!-- Botón de historial -->
      <form action="historial_entregas.php" method="get">
        <button type="submit" class="menu-button">
          <img src="assets/img/historial.png" alt="Icono de Historial" class="icon2">
           Historial
        </button>

      <!-- Botón de registro -->
      <a href="registros.php" class="menu-button">
        <img src="assets/img/registro.png" alt="Icono de Registros" class="icon2">
          Registrar
      </a>

      </form>
      <!-- Botón de cerrar sesión -->
      <form action="logout.php" method="post"><br><br>
        <button type="submit" class="menu-button">
          <img src="assets/img/logout-icon.png" alt="Icono de cerrar sesión" class="icon">
          Cerrar sesión
        </button>
      </form>
    </div>
  </div>
  <div id="main">
    <button id="toggleBtn" class="openbtn" onclick="toggleNav()">
      <img id="toggleImg" src="assets/img/flecha.png" alt="Flecha" style="width: 100%; height: 100%;">
    </button>
    <div id="main-content">
      <!-- Título de bienvenida debajo del botón de ocultar menú -->
      <div class="welcome-section">
        <h2>¡Bienvenido al Sistema de Almacén de la Institucion CEBA "Fray Isaac Shahuano Murrieta"!</h2>
        <p>Desde aquí, podrás gestionar el inventario de manera ágil y eficiente, asegurando que todos los recursos necesarios para el buen funcionamiento del colegio estén siempre administrados.</p>
      </div>
      <!-- Contenido de los botones en lugar de iconos -->
      <form action="clase.php" method="get">
        <div class="tile-container">
          <button type="submit" name="clase" value="1" class="tile">
            <div class="tile-title">Biblioteca</div>
            <div class="tile-icon">
              <img src="assets/img/biblioteca.png" alt="Biblioteca" class="tile-image">
              <p>1</p>
            </div>
          </button>
          <button type="submit" name="clase" value="2" class="tile">
            <div class="tile-title">Computación</div>
            <div class="tile-icon">
              <img src="assets/img/computacion.png" alt="Computación" class="tile-image">
              <p>2</p>
            </div>
          </button>
          <button type="submit" name="clase" value="3" class="tile">
            <div class="tile-title">E. Física</div>
            <div class="tile-icon">
              <img src="assets/img/deportes.png" alt="E. Física" class="tile-image">
              <p>3</p>
            </div>
          </button>
          <button type="submit" name="clase" value="4" class="tile">
            <div class="tile-title">Limpieza</div>
            <div class="tile-icon">
              <img src="assets/img/limpieza.png" alt="Limpieza" class="tile-image">
              <p>4</p>
            </div>
          </button>
          <button type="submit" name="clase" value="5" class="tile">
            <div class="tile-title">Mobiliario</div>
            <div class="tile-icon">
              <img src="assets/img/mobiliario.png" alt="Mobiliario" class="tile-image">
              <p>5</p>
            </div>
          </button>
          <button type="submit" name="clase" value="6" class="tile">
            <div class="tile-title">Otros Materiales</div>
            <div class="tile-icon">
              <img src="assets/img/otros.png" alt="Otros Materiales" class="tile-image">
              <p>6</p>
            </div>
          </button>
          <button type="submit" name="clase" value="7" class="tile">
            <div class="tile-title">Laboratorio</div>
            <div class="tile-icon">
              <img src="assets/img/laborat.png" alt="Laboratorio" class="tile-image">
              <p>7</p>
            </div>
          </button>
          <button type="submit" name="clase" value="8" class="tile">
            <div class="tile-title">Cosmetologia</div>
            <div class="tile-icon">
              <img src="assets/img/cosmetologia.png" alt="Cosmetologia" class="tile-image">
              <p>8</p>
            </div>
          </button>
          <button type="submit" name="clase" value="9" class="tile">
            <div class="tile-title">Costureria</div>
            <div class="tile-icon">
              <img src="assets/img/costurer.png" alt="Costureria" class="tile-image">
              <p>9</p>
            </div>
          </button>
        </div>
      </form>
    </div>
  </div>
  <script src="assets/js/scrip.js"></script>
</body>
</html>
