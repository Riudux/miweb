<?php
// =========================================================================
// ARCHIVO: register.php (PUBLIC REGISTER SYSTEM)
// PROPÓSITO: Este archivo es idéntico a register_usuarios.php, PEEERO está  
// pensado para el formulario público de "Registrarse" o "Crear cuenta propia", 
// aquel donde cualquier visitante civil se inscribe sin ser administrador (views/register.html).
// =========================================================================
session_start();
include("../../config/conexion.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Recepción desde views/register.html form publico. 
    $username = $_POST["username"];
    $email = $_POST["email"];
    // *Importante recordar: Las contraseñas en PHP puro en MySQL deberían cifrarse ('password_hash')
    // por buenas prácticas, pero aquí se mandan limpias.
    $password = $_POST["password"];

    // Inscripción oficial del novato usuario a la Base.
    $sqlinsert = "INSERT INTO usuarios (username, email, password) VALUES ('$username', '$email', '$password')";

    $result = $conn->query($sqlinsert);
    
    // A diferencia del archivo hermano (register_usuarios) que te mandaba de vuelta al panel Admin...
    // Aquí, como el usuario civil apenas fue aceptado e inscrito.. ¡Se le manda de vuelta a "views/login.html"! 
    // Para que proceda a iniciar sesión con esas recien estrenadas credenciales por primera vez.
    header("Location: ../../views/login.html");
    exit();
}
$conn->close();

?>
