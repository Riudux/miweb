<?php
    // =========================================================================
    // ARCHIVO: cargar_editar_biometricos.php (CONTROLADOR UPDATE)
    // PROPÓSITO: Actualiza los indicadores como Ritmo Cardiaco, o presiones en MySQL.
    // Recibe variables por POST enviados a través del Ajax de jQuery. 
    // =========================================================================

    session_start();
    include("../../config/conexion.php");

    // Restricción de paso solo por POST.
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        
        // Empaquetando en variables convencionales todos los valores ocultos. 
        $id_registro = $_POST['editID'];
        $id_usuario = $_POST["editIdUsuario"];
        $id_dispositivos = $_POST['editIdDispositivo'];
        $ritmo_cardiaco = $_POST['editRitmoCardiaco'];
        $oxigeno = $_POST['editOxigeno'];
        $temperatura = $_POST['editTemperatura'];
        $presion_sistolica = $_POST['editPresionSistolica'];
        $presion_diastolica = $_POST['editPresionDiastolica'];

        // Actualización "UPDATE" SQL masiva para ese id_registro en específico modificado.
        $sql = "UPDATE `registros_biometricos` SET 
        `id_usuario`='$id_usuario',
        `id_dispositivos`='$id_dispositivos',
        `ritmo_cardiaco`='$ritmo_cardiaco',
        `oxigeno`='$oxigeno',
        `temperatura`='$temperatura',
        `presion_sistolica`='$presion_sistolica',
        `presion_diastolica`='$presion_diastolica'
        WHERE `id_registro` = '$id_registro'";
        
        // Efectuar.
        $result = $conn->query($sql);
    }

    $conn->close();

?>