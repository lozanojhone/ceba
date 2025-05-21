function toggleNav() {
  var sidebar = document.getElementById("sidebar");
  var mainContent = document.getElementById("main-content");
  var toggleBtn = document.getElementById("toggleBtn");
  var toggleImage = document.getElementById("toggleImg"); // Obtener la imagen del botón

  if (sidebar.classList.contains("sidebar-hidden")) {
    // Mostrar la barra lateral
    sidebar.classList.remove("sidebar-hidden");
    mainContent.classList.remove("expanded"); // Vuelve a mover el contenido a la derecha
    toggleBtn.style.left = "270px"; // Mueve el botón hacia su posición inicial
    toggleImage.src = "assets/img/flecha.png"; // Cambia el ícono del botón
  } else {
    // Ocultar la barra lateral
    sidebar.classList.add("sidebar-hidden");
    mainContent.classList.add("expanded"); // Expande el contenido para que ocupe todo el ancho
    toggleBtn.style.left = "20px"; // Mueve el botón hacia la izquierda
    toggleImage.src = "assets/img/menu-icon.png"; // Cambia el ícono del botón
  }
}

// Código para el modal de confirmación de cierre de sesión

// Referencias a los elementos del modal
const logoutButton = document.querySelector('.logout-button');
const logoutModal = document.getElementById('logoutModal');
const confirmLogout = document.getElementById('confirmLogout');
const cancelLogout = document.getElementById('cancelLogout');

// Muestra el modal cuando se hace clic en "Cerrar Sesión"
logoutButton.addEventListener('click', (event) => {
  event.preventDefault(); // Evita que se redireccione inmediatamente
  logoutModal.style.display = 'flex'; // Muestra el modal
});

// Cierra sesión cuando se hace clic en "Sí"
confirmLogout.addEventListener('click', () => {
  // Deshabilitar la función de retroceso antes de redirigir
  history.pushState(null, "0", location.href); 
  history.back();
  history.forward();

  // Redirige a la página de login
  window.location.replace('http://localhost/ANTONIO/admin/login.html'); 
  
  // Recarga la página después de 1 segundo
  setTimeout(() => {
    location.reload(); // Recarga la página después de 1 segundo
  }, 1000); // Tiempo en milisegundos
});

// Oculta el modal cuando se hace clic en "No"
cancelLogout.addEventListener('click', () => {
  logoutModal.style.display = 'none'; // Oculta el modal
});