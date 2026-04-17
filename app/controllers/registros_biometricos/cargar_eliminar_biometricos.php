<?php
    // =========================================================================
    // ARCHIVO: cargar_eliminar_biometricos.php (CONTROLADOR DELETE)
    // PROPÓSITO: Quitar para siempre un historial de signos basándose en su ID.
    // =========================================================================

    session_start();
    include("../../config/conexion.php");

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        
        // Sacar el número de ID a borrar enviado por AJAX en un objeto data de "id: {x}"
        $id_registro = $_POST['id'];

        // Instrucción pura. 
        $sql = "DELETE FROM registros_biometricos WHERE id_registro = '$id_registro'";
                
        // Destrucción de bloque en DB.        
        $result = $conn->query($sql);

    }

    $conn->close();
    
?>