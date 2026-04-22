<?php
// =========================================================================
// El portero del sistema de "VitalConnection". Toma las contraseñas
// de 'login.html', va al archivo central (DB) y checa si el correo y la  
// contraseña coinciden con las guardadas. De ser así, activa las $_SESSIONs. 
// =========================================================================
session_start();
include("../../config/conexion.php");

// 1. Extrae directamente del formulario normal de "views/login.html" (Vía el atributo 'name' del input).
$gmail = $_POST['email'];
$password = $_POST['password'];

// 2. Sentencia lógica crucial. En lenguaje llano: 
// "Buscame en toda la tabla UNA fila donde la columna 'email' sea idéntica al usuario".
$sql = "SELECT * FROM usuarios WHERE email = '$gmail'";

// Ejecuta búsqueda
$result = $conn->query($sql);

// Si 'num_rows' dio 1 o mayor, significa que sí existe el correo en la base de datos.
if ($result->num_rows > 0) {
    // 3. Inicio de sesión oficial. Extraemos esa fila perfecta como arreglo.
    $row = $result->fetch_assoc();
    
    // Aquí es donde entra la magia de seguridad: password_verify desencripta internamente 
    // y compara si lo que escribiste concuerda con lo guardado
    if (password_verify($password, $row['password'])) {
        
        // Y empezamos a inyectar las variables supremas "$_SESSION".
        $_SESSION['id_usuario'] = $row['id_usuario'];
        $_SESSION['username'] = $row['username'];
        $_SESSION['email'] = $gmail;            // Usamos la caja directamente asumiendo que es idéntica
        $_SESSION['password'] = $row['password'];
        $_SESSION['id_rol'] = $row['id_rol'];    // Esta es vital: Si vale 1, eres admin, si 2 eres Paciente.

        // "header(Location)" empuja inmediatamente la página hacia el Menú del paciente.
        header('Location: ../../views/dashboard.php');
        exit(); // Terminamos la ejecución para que se complete el redireccionamiento
    } else {
        // La contraseña es incorrecta
        echo "Contraseña incorrecta. <a href='../../views/login.html'> Intentar De nuevo</a>";
    }
} else {
    // El correo no existía
    echo "El correo no existe. <a href='../../views/login.html'> Intentar De nuevo</a>";
}
// Fin.
$conn->close();

?>
