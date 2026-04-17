<?php
    // =========================================================================
    // ARCHIVO: cargar_biometricos.php (CONTROLADOR READ)
    // PROPÓSITO: Se conecta a la base de datos "por detrás", selecciona a TODOS
    // los registros biométricos, elabora código HTML con ellos (en forma de filas de tabla <tr>),
    // y devuelve todo este texto por AJAX para construir la tabla dinámica visual.
    // =========================================================================

    session_start();
    include("../../config/conexion.php");

    // =========================================================
    // CONSULTA A MYSQL PARA OBTENER REGISTROS DE SIGNOS VITALES
    // =========================================================
    // Ejecuta petición de conseguir o leer toda (*) la data de la tabla.
    $sql = "SELECT * FROM registros_biometricos";

    // Enviamos petición por la vía de '$conn' guardando lo que sea que nos devuelva en '$result'.
    $result = $conn->query($sql);  
    
    // ".num_rows" es la cantidad de filas que encontró. Si es mayor a 0, hubo datos.
    if ($result->num_rows > 0) {
        // Un bucle iterativo que cicla "fila por fila" y la enpaqueta en la matriz '$row' (Array).
        while ($row = $result->fetch_assoc()) {
                // Genera la etiqueta HTML 'tr' (table row o fila de tabla) conteniendo a su vez las celdas 'td'
                echo    "<tr>
                        <td>{$row['id_registro']}</td>
                        <td>{$row['id_usuario']}</td>
                        <td>{$row['id_dispositivos']}</td>
                        <td>{$row['ritmo_cardiaco']}</td>
                        <td>{$row['oxigeno']}</td>
                        <td>{$row['temperatura']}</td>
                        <td>{$row['presion_sistolica']}</td>
                        <td>{$row['presion_diastolica']}</td>
                        <td>{$row['fecha_registro']}</td>
                        
                        <!-- Columna especializada para agrupar en cascada los botones de manipulación -->
                        <td>
                            <!-- BOTÓN DE EDITAR: Inyectamos todo el arreglo de datos correspondientes de esta fila
                                 dentro de la llamada JS 'mostrarEditarBiometricos(...)'.-->
                            <button onclick=\"mostrarEditarBiometricos(
                            {$row['id_registro']}, 
                            {$row['id_usuario']}, 
                            {$row['id_dispositivos']}, 
                            {$row['ritmo_cardiaco']}, 
                            {$row['oxigeno']}, 
                            {$row['temperatura']}, 
                            {$row['presion_sistolica']}, 
                            {$row['presion_diastolica']},
                            '{$row['fecha_registro']}'
                            )\">Editar</button>

                            <!-- BOTÓN DE ELIMINAR: Igualmente se lleva su id_registro individual e irrepetible -->
                            <button onclick=\"mostrarEliminarBiometricos(
                            {$row['id_registro']}
                            )\">Eliminar</button>

                        </td><br><br>
                    </tr>";
        }
    } else {
        // En caso de fallar o estar limpia la BD, muestra solo un mensaje ocupando todo el ancho horizontal. 
        echo "<tr><td colspan='7'>No hay registros biometricos</td></tr>" ;
    }
    // Liberar memoria o puerto MySQL. 
    $conn->close();
?>