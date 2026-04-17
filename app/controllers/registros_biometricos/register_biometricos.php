<?php
// =========================================================================
// ARCHIVO: register_biometricos.php (CONTROLADOR CREATE)
// PROPÓSITO: Actúa de receptor directo de un formulario HTML normal '<form>' 
// que requiere enviar variables (A través de 'POST') para ingresar nuevos 
// exámenes (pulsaciones, temperatura, etc). A base de datos ('INSERT').
// =========================================================================
session_start();
include("../../config/conexion.php");

// Verificación estricta de envío formal por botón
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Extraer individualmente las llaves de nuestro array "$_POST" basándose en el "name" que tenían las cajas Input.
    $id_usuario = $_POST["id_usuario"];
    $id_dispositivo = $_POST["id_dispositivo"];
    $ritmo_cardiaco = $_POST["ritmo_cardiaco"];
    $oxigeno = $_POST["oxigeno"];
    $temperatura = $_POST["temperatura"];
    $presion_sistolica = $_POST["presion_sistolica"];
    $presion_diastolica = $_POST["presion_diastolica"];

    // Usamos el signo apóstrofe de inclinación opuesta ` ` que MySQL utiliza para distinguir que es una Ccolumna y no variables o comandos SQL.
    $sqlinsert = "INSERT INTO `registros_biometricos`(`id_usuario`, `id_dispositivos`, 
        `ritmo_cardiaco`, `oxigeno`, `temperatura`, `presion_sistolica`, `presion_diastolica`) 
        VALUES 
        ('$id_usuario','$id_dispositivo','$ritmo_cardiaco','$oxigeno','$temperatura',
        '$presion_sistolica','$presion_diastolica')";

    // Se efectúa el inyectado. De ser exitoso se queda la página colgada en el aire (Recomendación a futuro colocar 'header()' o cambiarlo a Ajax puro.
    $result = $conn->query($sqlinsert);
}
$conn->close();
?>
