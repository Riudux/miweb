<?php
    // =========================================================================
    // ARCHIVO: cargar_dispositivos.php (CONTROLADOR)
    // PROPÓSITO: Se conecta a la base de datos "por detrás", selecciona a TODOS
    // los dispositivos, elabora código HTML con ellos (en forma de filas de tabla <tr>),
    // y lo imprime (Devolviéndolo directo a quien lo invocó asincronamente).
    // =========================================================================

    // 1. Iniciamos sesión para permitir ejecución bajo protocolos loggeados
    session_start();
    // 2. Cargamos nuestra extensión maestra que tiene la llave e instancia de conexión MySQL ($conn)
    include("../../config/conexion.php");

    // =========================================================
    // CONSULTA PARA EXTRAER LA INFORMACIÓN DE DISPOSITIVOS
    // (Operación 'Read' del CRUD)
    // =========================================================
    // Creamos en un String el SQL necesario. Aquí el asterisco "*" equivale a traer todas las columnas. 
    $sql = "SELECT * FROM dispositivos";

    // Disparamos verdaderamente el comando en nuestra Base de Datos conectada ($conn).
    $result = $conn->query($sql);  
    
    // Verificamos si la respuesta (result) trajo más de 0 filas (Es decir, sabemos que la base no está vacía)
    if ($result->num_rows > 0) {
        
        // El bucle "while" junto con "fetch_assoc()" extraen poco a poquito registro por registro, 
        // fila por fila de la memoria y lo asignan a la variable temporal "$row" convertida en Array.
        while ($row = $result->fetch_assoc()) {
            
                // La instrucción "echo" imprimirá gigantes bloques HTML como texto simple hacia la red.
                // Como este controlador fue solicitado por "AJAX" (desde crud_dispositivos.php), 
                // entonces AJAX tomará todo este texto HTML literal y lo meterá en nuestro <tbody>.
                echo "<tr>
                        <!-- Colocamos el valor de las columnas de MySQL directamente mezclado en HTML. -->
                        <td>{$row['id_dispositivo']}</td>
                        <td>{$row['nombre']}</td>
                        <td>{$row['modelo']}</td>
                        <td>{$row['numero_serie']}</td>
                        <td>{$row['id_usuario']}</td>
                        <td>{$row['fecha_registro']}</td>
                        <td>{$row['estado']}</td>
                        
                        <!-- Columna final para los motores (Botones) de nuestra Interfaz. -->
                        <td>
                            <!-- BOTÓN EDITAR: Este botón tiene inyectado en su atributo un 'onclick'. 
                                 Al usar \\\" logramos escapar las comillas especiales y poner de texto exacto 
                                 el comando JS envíandole todas estas propiedades como Argumentos. -->
                            <button onclick=\"mostrarEditarDispositivo(
                            {$row['id_dispositivo']}, 
                            '{$row['nombre']}', 
                            '{$row['modelo']}', 
                            '{$row['numero_serie']}', 
                            {$row['id_usuario']}, 
                            '{$row['fecha_registro']}', 
                            '{$row['estado']}'
                            )\">Editar</button>

                            <!-- BOTÓN ELIMINAR: Igualmente pre-carga su ID propio que viene desde la BD en el botón de eliminar. -->
                            <button onclick=\"mostrarEliminarDispositivo(
                            {$row['id_dispositivo']}
                            )\">Eliminar</button>
                        </td><br><br>
                    </tr>";
        }
    } else {
        // En caso de que la tabla 'dispositivos' este en blanco (0 filas), mandará esta pequeña celosía consoladora expandida colspan='7'. 
        echo "<tr><td colspan='7'>No hay dispositivos</td></tr>" ;
    }
    
    // Finalmente, cerramos la conexión por que el trabajo del controlador de consulta ha finalizado.
    $conn->close();

?>