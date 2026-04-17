<?php
    // =========================================================================
    // ARCHIVO: cargar_editar_usuario.php (CONTROLADOR UPDATE)
    // PROPÓSITO: Actuar por detrás de escena para tomar los datos corregidos de 
    // la tabla de usuarios gráficos, interceptarlos vía 'POST' y actualizar MySQL.
    // =========================================================================
    session_start();
    include("../../config/conexion.php");


    // Candado para que la página no se active si alguien teclea la URL en blanco. (Protección de protocolo GET)
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        
        // Se sacan de la paquetería invisible 'POST' los valores enviados desde AJAX.
        $id_usuario = $_POST['editID'];
        $username = $_POST['editUsername'];
        $email = $_POST['editEmail'];
        $fecha_registro = $_POST['editFecha'];
        $id_rol = $_POST['editIdRol']; // El Rol define si eres admin (1) o paciente (2).

        // Comando SQL literal que dictamina "Haz un UPDATE en la tabla usuarios SET (configurando) el username=... 
        // y correo... SOLAMENTE DONDE el ID sea idéntico al solicitado".
        $sql = "UPDATE usuarios SET id_usuario = '$id_usuario', username = '$username', email = '$email', fecha_registro = '$fecha_registro', id_rol = $id_rol WHERE id_usuario = $id_usuario";
        
        // Activación del borrado.
        $result = $conn->query($sql);
    }
    
    $conn->close();

?>