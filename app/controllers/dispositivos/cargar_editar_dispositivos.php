<?php
    // =========================================================================
    // ARCHIVO: cargar_editar_dispositivos.php (CONTROLADOR UPDATE)
    // PROPÓSITO: Actuar puramente sin interfaz gráfica. Recibe por el interior (POST) 
    // la petición de "editar un dispositivo", saca los datos ingresados desde las 
    // variables inyectadas de Ajax, y ejecuta el SQL gigante de actualización.
    // =========================================================================
    
    session_start();
    include("../../config/conexion.php");

    // Validamos estrictamente que la página intentando comunicarse con esta utilice el protocolo de seguridad "POST".
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        
        // Asignamos las variables enviadas por "$_POST". Estas variables fueron etiquetadas ("editID", "editNombre", etc.)
        // desde "data: { editID: id ... }" en la petición original AJAX de nuestro modelo visual.
        $id_dispositivos = $_POST['editID'];
        $nombre = $_POST["editNombre"];
        $modelo = $_POST["editModelo"];
        $numero_serie = $_POST["editNumeroSerie"];
        $id_usuario = $_POST["editIdUsuario"];
        $fecha_registro = $_POST['editFechaRegistro'];
        $estado = $_POST['editEstado'];

        // Construimos pacientemente la instrucción SQL completa de 'UPDATE'.
        // Aquí decimos: "ACTUALIZA la tabla dispositivos, CONFIGURANDO 'nombre' como la variable nueva '$nombre' ... 
        // DONDE (WHERE) el ID original de la fila en la tabla sea idéntico a '$id_dispositivos'".
        $sql = "UPDATE `dispositivos` 
        SET `id_dispositivo`='$id_dispositivos',`nombre`='$nombre',
        `modelo`='$modelo',`numero_serie`='$numero_serie',
        `id_usuario`='$id_usuario',`fecha_registro`='$fecha_registro',
        `estado`='$estado' WHERE id_dispositivo = '$id_dispositivos'"; // <-- Notar la correcion: Había un pequeño fallo lógico en tu código que documenté ahora. originalemente decía 'WHERE $id_dispositivos;'

        // Ejecutar sentencia
        $result = $conn->query($sql);
    }

    // Cerramos la vía y terminamos el archivo. Al terminar (no hay echos), responde a JS con un status 200 (Success).
    $conn->close();

?>