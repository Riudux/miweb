<?php
    // =========================================================================
    // ARCHIVO: register_dispositivo.php (CONTROLADOR CREATE)
    // PROPÓSITO: Recibe formularios normales (No AJAX) provenientes del Modal "Añadir".
    // Toma variables POST (como 'nombre', 'modelo', etc.), y ejecuta un comando 
    // "INSERT" para guardar a fuego la información de nuevo registro en la Base de Datos.
    // =========================================================================

    session_start();
    include("../../config/conexion.php");

    // Si efectivamente hemos ingresado a la página haciendo click en el botón tipo 'submit'
    // del <form> en la tabla gráfica que mandó 'método POST', entonces:
    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        // Se sacan todas las variables alojadas en "$_POST". Estas variables fueron etiquetadas por 
        // el parámetro 'name' en el archivo maestro HTML ("name='nombre'").
        $nombre = $_POST["nombre"];
        $modelo = $_POST["modelo"];
        $numero_serie = $_POST["numero_serie"];
        $id_usuario = $_POST["id_usuario"];


        // Sentencia de registro de Base Datos. "INSERT INTO" escoge la tabla de registro. (Se omiten IDs o Fechas Automáticas aquí).
        // Y en "VALUES" colocamos con apóstrofes (') aquello que MySQL recibe como texto o palabras, y 
        // dejamos sin ellos lo que sea un número abstracto ($id_usuario presumiblemente es número).
        $sqlinsert = "INSERT INTO dispositivos (nombre, modelo, numero_serie, id_usuario) 
        VALUES ('$nombre', '$modelo', '$numero_serie', $id_usuario)";

        // Ejecutamos el envío a base conectada.
        $result = $conn->query($sqlinsert);
        
        // IMPORTANTE: Al ser este un <form> convencional y no de tipo AJAX invisible... el navegador
        // se redirigió físicamente y se quedó congelado en una "pantalla super en blanco" viéndose la URL.  
        // Normalmente para evitar eso se hace un 'header(Location: ... )' para regresar a la tabla. El desarrollador original obvió esto pero así funciona esto a nivel arquitectura. 
    } 
    $conn->close();
?>