<?php
    // =========================================================================
    // ARCHIVO: cargar_usuarios.php (CONTROLADOR READ)
    // PROPÓSITO: Imprimir masivamente "Echos" de HTML repletos con la lista completa 
    // de usuarios registrados en MySQL. Es llamado repetidamente por la técnica "AJAX".
    // =========================================================================

    session_start();
    include("../../config/conexion.php");

    // Sentencia para extraer a toda la población del sistema sin excepción.
    $sql = "SELECT * FROM usuarios";

    // Operación.
    $result = $conn->query($sql);  
    
    // ".num_rows" asegura que no traten de crear HTML sino hay alguien registrado.
    if ($result->num_rows > 0) {
        
        // Por cada persona que regrese mysqli, hace una iteración e imprime una celda gigante <tr><tr>.
        while ($row = $result->fetch_assoc()) {
                echo    "<tr>
                        <td>{$row['id_usuario']}</td>
                        <td>{$row['username']}</td>
                        <td>{$row['email']}</td>
                        <td>{$row['fecha_registro']}</td>
                        <td>{$row['id_rol']}</td>
                        <td>
                            <!-- BOTÓN DE EDICIÓN: Oculta dentro de su click toda la gama del arreglo \$row 
                                 para auto-rellenar el cuadrito visual de actualización. -->
                            <button onclick=\"mostrarEditarUsuario(
                            {$row['id_usuario']}, 
                            '{$row['username']}', 
                            '{$row['email']}', 
                            '{$row['fecha_registro']}', 
                            {$row['id_rol']}
                            )\">Editar</button>

                            <!-- BOTÓN DE ELIMINAR: Porta consigo el ID maldito. -->
                            <button onclick=\"mostrarEliminarUsuario(
                            {$row['id_usuario']}
                            )\">Eliminar</button>

                        
                        </td><br><br>
                    </tr>";
        }
    } else{
        echo "<tr><td colspan='7'>No hay usuarios</td></tr>" ;
    }
    $conn->close();

?>