<?php
// =========================================================================
// ARCHIVO: login.php (LOGIN SYSTEM)
// PROPÓSITO: El portero del sistema de "VitalConnection". Toma las contraseñas
// de 'login.html', va al archivo central (DDBB) y checa si el correo y la  
// contraseña coinciden con las guardadas. De ser así, activa las $_SESSIONs. 
// =========================================================================
session_start();
include("../../config/conexion.php");

// 1. Extrae directamente del formulario normal de "views/login.html" (Vía el atributo 'name' del input).
$gmail = $_POST['email'];
$password = $_POST['password'];

// 2. Sentencia lógica crucial. En lenguaje llano: 
// "Buscame en toda la tabla UNA fila donde la columna 'email' sea idéntica al usuario y  
// 'password' idéntica a la insertada". Si no son idénticas ambas, regresa 0 coincidencias.
$sql = "SELECT * FROM usuarios WHERE email = '$gmail' AND password = '$password'";

// Ejecuta búsqueda
$result = $conn->query($sql);

// Si 'num_rows' dio 1 o mayor, significa que sí existía. Hubo match perfecto.
if ($result->num_rows > 0) {
    // 3. Inicio de sesión oficial. Extraemos esa fila perfecta como arreglo.
    $row = $result->fetch_assoc();
    
    // Y empezamos a inyectar las variables supremas "$_SESSION".
    // Estas son "Superglobables", y vivirán volando sobre todas las páginas que visites 
    // hasta que se use la instrucción 'destroy' o cierres el navegador navegador web.
    $_SESSION['id_usuario'] = $row['id_usuario'];
    $_SESSION['username'] = $row['username'];
    $_SESSION['email'] = $gmail;            // Usamos la caja directamente asumiendo que es idéntica
    $_SESSION['password'] = $row['password'];
    $_SESSION['id_rol'] = $row['id_rol'];    // Esta es vital: Si vale 1, eres admin, si 2 eres Paciente.

    // "header(Location)" empuja inmediatamente la página hacia el Menú del paciente.
    header('Location: ../../views/dashboard.php');
} else {
    // Si metiste contraseñas o datos equivocados o inventados:
    echo "inicio de sesion fallida. <a href='../../views/login.html'> Intentar De nuevo</a>";
}
// Fin.
$conn->close();

?>
