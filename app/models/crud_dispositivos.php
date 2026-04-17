<?php
    // =========================================================================
    // ARCHIVO: crud_dispositivos.php
    // PROPÓSITO: Provee una Interfaz (vista de administración) para visualizar,
    // añadir, editar y eliminar dispostivios asignados a algún paciente. 
    // Es el equivalente idéntico al CRUD Biométrico, pero con tablas de Dispositivos.
    // =========================================================================

    // Se inicia sesión para asegurar que ciertas funcionalidades dependan del estado del usuario (como que esté loggeado en la PC o revisar su idrol).
    session_start();
    // Requerimos que todo este código pueda hablar por MySQL cargando el script 'conexion.php'.
    include("../config/conexion.php");
?>

<!DOCTYPE html>
<html lang="es"> <!-- 'es' es código ISO que indica que el contenido estará en español -->
    <head>
        <meta charset="utf-8"> <!-- UTF-8 asegura que símbolos como "ñ" u "ó" funcionen correctamente y no muestren caracteres extraños -->
        <meta http-equiv="X-UA-Compatible" content="IE=edge"> 
        <meta name="viewport" content="width=device-width, initial-scale=1"> 
        <title>Crud Dispositivos</title>

        <!-- ========================================== -->
        <!-- USO DE FRAMEWORKS PARA ESTILIZACIÓN AUTOMATIZADA -->
        <!-- Bootstrap 3: Descargamos vía web un archivo CSS inmenso "pre-hecho". 
             Gracias a esto, podemos poner una clase <table class="table"> y 
             directamente nos crea una tabla bonita, en lugar de horas programando el CSS. -->
        <!-- ========================================== -->
        <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">

        <!-- Cargamos a 'jQuery'. Es un atajo para escribir funciones en Javascript. 
             Su regla maestra es el símbolo `$` o signo de peso. Todo lo que empieza por '$' usa jQuery. -->
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    </head>
    <body>
        <h1 class="text-center">Crud es el acronimo para create, read, update, delete</h1>
        
        <!-- Botón para añadir un DISPOSITIVO a la base de datos.
             Llama a la lógica Javascript detallada después del 'body' en este documento enviando de dato "modalAgregarDispositivo"  -->
        <button onclick="mostrarAgregarDispositivo('modalAgregarDispositivo')">Agregar dispositivo</button>
        
        <!-- LA ESTRUCTURA VACÍA AL USUARIO. 
             La tabla inicialmente en lenguaje estático ("<table id='..'></table>") carece de datos reales de la DDBB -->
        <table id="dispositivosTable" border="1">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Modelo</th>
                    <th>Numero de serie</th>
                    <th>ID Usuario</th>
                    <th>Fecha Registro</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <!-- Justamente este TBODY será alimentado dinamicamente con código extraído al pedirle al controlador (cargar_dispositivos.php) desde JS -->
            <tbody>
                
            </tbody>
        </table>

        <!-- ===================================================== -->
        <!-- LAS PANTALLAS MODALES OCULTAS (DISPLAY:NONE) POR DEFECTO -->
        <!-- ===================================================== -->
        
        <!-- Modal que aparece para sobreescribir (editar) la información capturada -->
        <div id="modalEditar" style="display:none";>
            <h3>Editar Dispositivo</h3>
            <form id="mostrarEditarDispositivo">
                ID : <span id="editID"></span><br>
                Nombre : <input type="text" id="editNombre"><br>
                Modelo : <input type="text" id="editModelo"><br>
                Numero de serie : <input type="text" id="editNumeroSerie"><br>
                ID Usuario : <input type="text" id="editIdUsuario"><br>
                Fecha Registro : <input type="text" id="editFechaRegistro"><br>
                Estado : <input type="text" id="editEstado"><br>
                
                <button type="button" onclick="guardarEdicion()"> Guardar</button>
            </form>
        </div>

        <!-- Modal que nos solicita verificar un posible borrado (ya que en CRUD no hay "CTRL + Z" o forma rápida de regresar lo eliminado) -->
        <div id="modalEliminar" style="display:none";>
            <h3>Confirmar Eliminacion</h3>
                ID: <span id="id"></span><br>
            <p>¿Estas seguro de que quieres eliminar este dispositivo?</p>
            <form id="mostrarEliminarDispositivo">
                <button type="button" onclick="eliminarDispositivo()">Eliminar</button>
            </form>
        </div>

        <!-- Modal que agrega a un nuevo miembro / dispositivo al sistema en forma oficial redirigiendo la acción "POST". -->
        <div id="modalAgregarDispositivo" style="display:none";>
            <h3>Agregar Dispositivo</h3>
            <!-- "action": le dice Hacia DONDE van a viajar estos nuevos datos empaquetados ("register_dispositivo.php"). -->
            <!-- "method": le advierte de usar el "protocolo" POST (empaquetado e inyectado invisible en el request, super seguro, en vez de GET). -->
            <form action="../controllers/dispositivos/register_dispositivo.php" id="nuevoDispositivo" method="post">
                <label for="nombre">Nombre:</label>
                <!-- Recuerda, el tag en PHP va a leer aquello que tu nombras con "name". Por ejemplo $nomb=$_POST["nombre"]. -->
                <input type="text" id="nombre" name="nombre" required> <br><br>

                <label for="modelo">Modelo:</label>
                <input type="text" id="modelo" name="modelo" required> <br><br>

                <label for="numeroSerie">Numero de serie:</label>
                <input type="text" id="numeroSerie" name="numero_serie" required> <br><br>

                <label for="idUsuario">ID Usuario:</label>
                <input type="text" id="idUsuario" name="id_usuario" required> <br><br>

                <button type="submit" name="accion" value="agregar">Añadir</button>
            </form>
        </div>

        <!-- LOGICA ASINCRONA DE COMUNICACION JAVASCRIPT-AJAX-PHP -->
        <script>
            // aqui manda a llamar un document, lo pone en estado "listo" sin interrumpir la creación de nuestra página, y despues llama la funcion interna
            $(document).ready(function () {
                // El ajax es la forma vital utilizada para solicitar el bloque gigante oculto (las Filas HTML) a nuestro controlador.
                $.ajax({
                    // este es el documento php puro que construimos aparte a cargar, ese doc generó el html con 'Echos' a la DDBB..
                    url: '../controllers/dispositivos/cargar_dispositivos.php',
                    // este es el metodo que va a tener, en este caso get es para traer datos
                    type: 'GET',
                    success:function(response){
                        // al concluir con éxito (traerlo de vuelta a nuestra página inicial), le pedimos que inyecte 
                        // absolutamente todo el 'response' dentro del cuerpo de la tabla.
                        $('#dispositivosTable tbody').html(response);
                    }
                });
            });

            // Función al presionar 'Agregar Dispositivos' (Cambiamos el display a "block" o sea, un bloque visual solido)
            function mostrarAgregarDispositivo(elementId){
                var element = document.getElementById(elementId);
                if(element) {
                    element.style.display = 'block';
                }
            }

            // Función llamada por cada botón de "Editar", alojado al final de las filas mágicamente obtenidas desde el PHP
            function mostrarEditarDispositivo(id, nombre, modelo, numeroSerie, idUsuario, fechaRegistro, estado){
                // Rellenar visualmente las cajas Input (<input ..>) del recuadro escondido (modalEditar) usando las ID.
                document.getElementById('editID').innerText = id;
                document.getElementById('editNombre').value = nombre;
                document.getElementById('editModelo').value = modelo;
                document.getElementById('editNumeroSerie').value = numeroSerie;
                document.getElementById('editIdUsuario').value = idUsuario;
                document.getElementById('editFechaRegistro').value = fechaRegistro;
                document.getElementById('editEstado').value = estado;

                // Visualiza de nuevo toda esa caja mágica ya llena del dato correspondiente al presionado
                var modal = document.getElementById('modalEditar').style.display = 'block';
            }

            // Guardar o Confirmar una Edición dentro del Modal
            function guardarEdicion(){
                // Guardar la información alterada en nuestras cajas a través de las variables propias
                var id = document.getElementById('editID').innerText
                var nombre = document.getElementById('editNombre').value
                var modelo = document.getElementById('editModelo').value
                var numeroSerie = document.getElementById('editNumeroSerie').value
                var idUsuario = document.getElementById('editIdUsuario').value
                var fechaRegistro = document.getElementById('editFechaRegistro').value
                var estado = document.getElementById('editEstado').value
                
                // Realizar una operación de tipo POST invisible al archivo final
                $.ajax({
                    url: '../controllers/dispositivos/cargar_editar_dispositivos.php',
                    type: 'POST',
                    // El paquete "data" (equivalente al "name" html en PHP directo) para que el archivo los cace con $_POST[]
                    data: {
                        editID: id,
                        editNombre: nombre,
                        editModelo: modelo,
                        editNumeroSerie: numeroSerie,
                        editIdUsuario: idUsuario,
                        editFechaRegistro: fechaRegistro,
                        editEstado: estado
                    },
                    // Al dar Success significó que el controlador PHP si pudo escribir o editar en la MySQL
                    success:function(response){
                        alert('Dispositivo actualizado correctamente');
                        
                        // Y volvemos hacer el "Refresco de Tabla Inteligente" volviendo a preguntar y traer toda la tabla a mano con AJAX.
                        $.ajax({
                            url: '../controllers/dispositivos/cargar_dispositivos.php',
                            type: 'GET',
                            success:function(response){
                                // Reemplazar la tabla visual por la nueva.
                                $('#dispositivosTable tbody').html(response);
                            }
                        });
                        // Por último cerramos toda la ventana modal gigantezca que ocupaba toda la pantalla.
                        document.getElementById('modalEditar').style.display = 'none';
                    }
                });
            }

            // Muestra en pequeño modal de seguridad un Identificador de eliminación 
            function mostrarEliminarDispositivo(id_dispositivo){
                document.getElementById('id').innerText = id_dispositivo;
                var modal = document.getElementById('modalEliminar').style.display = 'block';
            }

            // Confirmación letal de eliminación en Base de Datos
            function eliminarDispositivo(id_dispositivo){
                var id_dispositivo = document.getElementById('id').innerText;

                // Empieza una petición del motor para asesinar el dato asícronamente en DB.
                $.ajax({
                    url: '../controllers/dispositivos/cargar_eliminar_dispositivos.php',
                    type: 'POST',
                    data: {
                        id: id_dispositivo
                    },
                    success:function(response){
                        alert('Dispositivo eliminado correctamente');
                        
                        // Recargamos el cuadro
                        $.ajax({
                            url: '../controllers/dispositivos/cargar_dispositivos.php',
                            // Usamos comando normal de atrapar "Get" o solo visualizar. ¡Pero ahora ya no aparecerá ese dispositivo!
                            type: 'GET',
                            success:function(response){
                                // Inyección visual del cuadro
                                $('#dispositivosTable tbody').html(response);

                            }
                        });
                        // Cerramos el popup (modal)
                        document.getElementById('modalEliminar').style.display = 'none';               
                    }
                    
                });
            }

        </script>
        
        <!-- Script necesario e indispensable para efectos o diseño del sistema de grilla de Boostrap (.js) -->
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    </body>
</html>
