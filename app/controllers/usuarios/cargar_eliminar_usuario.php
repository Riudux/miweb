<?php
    // =========================================================================
    // ARCHIVO: cargar_eliminar_usuario.php (CONTROLADOR DELETE)
    // PROPÓSITO: Recepcionar el ID del usuario al que se le dio "Eliminar" e 
    // infundir la inyección destructiva SQL para darlo de baja permanente.
    // =========================================================================
    session_start();
    include("../../config/conexion.php");

    // Verificar petición POST de AJAX.
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        
        // Empacar variable numérica del ID.
        $id_usuario = $_POST['id'];

        // Estructura DELETE, borra fila íntegra de la tabla "usuarios" cuando haya coincidencia exacta.
        $sql = "DELETE FROM usuarios WHERE id_usuario = '$id_usuario'";
        $result = $conn->query($sql);
    }

    $conn->close();

    
?>