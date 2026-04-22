<?php
    // =========================================================================
// Este archivo se encarga de establecer la conexión entre nuestra 
    // aplicación en PHP y el motor de base de datos MySQL. 
    // Es uno de los archivos más importantes porque se incluye en los demás archivos 
    // del sistema cada vez que se requiere hacer algo en la base de datos.
    // =========================================================================

    // 1. Declaración de variables para la conexión.
    // Aquí guardamos en variables los credenciales y la ubicación de nuestra base de datos.
    $name = 'localhost'; // El servidor de la base de datos. Como usamos XAMPP en nuestra propia computadora, el servidor somos nosotros mismos ('localhost').
    $user = 'root';      // El nombre del usuario de la base de datos. 'root' es el usuario maestro por defecto en entornos de desarrollo locales.
    $pass = 'server1';          // La contraseña de ese usuario. Por defecto, XAMPP no le pone contraseña a 'root', por eso la dejamos vacía.
    $db = 'vitalconnection'; // El nombre asignado a la base de datos que creamos en nuestro gestor (como phpMyAdmin).


    // 2. Ejecutar la conexión a la base de datos.
    // 'new mysqli' es un comando nativo de PHP que abre una nueva conexión con el servidor MySQL.
    // Le pasamos las 4 variables que acabamos de definir en el orden exacto que requiere PHP.
    $conn = new mysqli($name, $user, $pass, $db);

    // 3. Comprobar si la conexión fue exitosa.
    // Evaluamos una propiedad llamada "connect_error" que guarda el motivo del error si algo falla.
    if ($conn->connect_error) {
        die('Error de conexión: ' . $conn->connect_error);
    }
    // Si el código llega hasta aquí significa que la conexión fue exitosa.
    // A partir de ahora, cualquier archivo que incluya 'conexion.php' podrá usar la variable
    // '$conn' para enviar sentencias y extraer datos.
?>