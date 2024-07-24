<?php
// Configuración de la base de datos
$host = 'localhost';     // Cambia 'localhost' si estás usando un servidor remoto
$db = 'usuarios_db';     // Nombre de la base de datos
$user = 'root';          // Nombre de usuario para la base de datos
$pass = '';              // Contraseña para la base de datos

// Crear conexión
$conn = new mysqli($host, $user, $pass, $db);

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Otros parámetros de configuración globales se pueden añadir aquí
// Ejemplo:
// $app_name = 'Mi Aplicación';
// $app_version = '1.0.0';
?>
