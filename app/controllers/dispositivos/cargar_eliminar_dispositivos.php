<?php
    // =========================================================================
    // ARCHIVO: cargar_eliminar_dispositivos.php (CONTROLADOR DELETE)
    // PROPÓSITO: Recibe una solicitud con método seguro POST para realizar 
    // una erradicación (DELETE) contundente de un Dispositivo usando solamente su ID.
    // =========================================================================

    session_start();
    include("../../config/conexion.php");

    // Igual que el anterior, checamos estrictamente evitar curiosos que quieran cargar el link y borrar algo manualmente escribiendo la URL (GET).
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        
        // Este nombre 'id' vino desde AJAX (data: { id: id_dispositivo }). Lo sacamos de la caja "POST".
        $id_dispositivo = $_POST['id'];

        // Instrucción directa a MySQL: BÓRRAME de la tabla dispositivos "DONDE" la celda "id_dispositivo" sea igual a mi variable.
        $sql = "DELETE FROM dispositivos WHERE id_dispositivo = '$id_dispositivo'";
        
        // Efectúa la destrucción.
        $result = $conn->query($sql);

    }

    // Cortar canal.
    $conn->close();

?>