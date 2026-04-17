<?php
// =========================================================================
// ARCHIVO: register_usuarios.php 
// PROPÓSITO: Archivo de alta de Usuario dedicado específicamente para 
// cuando un ADMINISTRADOR agrega a alguien vía visual en "crud_usuarios.php" .
// =========================================================================

session_start();
include("../../config/conexion.php");

// Verificamos si alguien disparó el botón Añadir del modal "Agregar Usuario" (Método POST de envío clásico HTML sin ajax).
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Recuperamos los registros escritos en las líneas
    $username = $_POST["username"];
    $email = $_POST["email"];
    $password = $_POST["password"];

    // Comando Base para crear un paciente nuevo. Nótese que el Rol se pone automáticamente a 2 (Normal) si en BD está así predefinido o en caso contrario se auto asume default por la DDBB .
    $sqlinsert = "INSERT INTO usuarios (username, email, password) VALUES ('$username', '$email', '$password')";

    $result = $conn->query($sqlinsert);
    // Ya creado fisicamente, lo rebotamos (header Location)  inmediatamente de regreso a "crud_usuarios.php".
    // El usuario "Administrador" observará un parpadeo en la pantalla nomás porque entra, ejecuta rápido y regresa.
    header("Location: ../../models/crud_usuarios.php");
}
$conn->close();
?>
