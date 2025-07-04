<?php
$host = "localhost";       // O la IP del servidor MySQL
$usuario = "root";         // Usuario de MySQL
$contrasena = "ste2012STE";          // Contraseña de MySQL (vacía por defecto en XAMPP)
$base_de_datos = "eventos_adversos"; // Nombre de la base de datos

// Crear conexión
$conn = new mysqli($host, $usuario, $contrasena, $base_de_datos);

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}
?>
