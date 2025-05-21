<?php
session_start(); // Iniciar la sesión

// Eliminar todas las variables de sesión
session_unset();

// Si se desea destruir la sesión completamente, también se borra la cookie de sesión
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000, 
        $params["path"], $params["domain"], 
        $params["secure"], $params["httponly"]
    );
}

// Destruir la sesión
session_destroy();

// Redirigir al login
header("Location: http://localhost/ANTONIO/admin/login.html");
exit();
?>
Explicación