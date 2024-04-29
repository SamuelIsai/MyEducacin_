<?php
// Archivo de configuración de la base de datos (Config.php) y otras configuraciones necesarias
include "../private/Config.php";

// Iniciar sesión
session_start();

// Verificar si se ha hecho clic en el enlace "Cerrar Sesión"
if (isset($_GET['logout'])) {
    // Cerrar sesión
    cerrarSesion();
    // Redireccionar a la página de inicio de sesión u otra página deseada
    redirigir("login.php");
    exit();
}

// Función para cerrar la sesión
function cerrarSesion() {
    // Limpiar todas las variables de sesión
    $_SESSION = array();
    // Destruir la sesión
    session_destroy();
}

// Función para redireccionar a una página específica
$url = "http://localhost:8080/MyEducacin/MyEducacin/templates/login.php";

function redirigir($url) {
    header("Location: $url");
    exit();
}
?>