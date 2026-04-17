<?php
    // =========================================================================
    // ARCHIVO: crud_biometricos.php
    // PROPÓSITO: Esta es la interfaz o "Página de Administración" (CRUD) para que  
    // un Administrador pueda visualizar, crear, modificar o borrar Registros Biométricos. 
    // CRUD significa Create, Read, Update, Delete (Crear, Leer, Actualizar, Borrar).
    // =========================================================================

    // Inicializamos la sesión de PHP. Es vital para saber quién está navegando.
    session_start();
    
    // Incluir la conexión a la base de datos para poder realizar peticiones (como extraer los registros)
    include("../config/conexion.php");
?>

<!DOCTYPE html>
<!-- Definimos el idioma principal de la página como Español ("es") -->
<html lang="es">
    <head>
        <meta charset="utf-8">
        <!-- Hace que Internet Explorer use su motor de renderizado más moderno -->
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <!-- Permite que la página se vea bien sin importar del tamaño de la pantalla, es decir, lo hace "Responsive" (adaptable) para celulares. -->
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Crud Biometricos</title>
        
        <link rel="stylesheet" href="../assets/styles/crud_biometricos.css">
        <link rel="stylesheet" href="../assets/styles/navbar.css">
        <link rel="stylesheet" href="../assets/styles/body.css">
        
        <!-- ========================================== -->
        <!-- IMPORTACIÓN DE ESTILOS (BOOTSTRAP 3)       -->
        <!-- ========================================== -->
        <!-- Bootstrap CSS: Es un framework de CSS pre-construido. Se importa para tener 
             diseño, tipos de letra alineados y componentes (como las tablas y los botones modales) 
             totalmente funcionales sin tener que escribir todo el CSS nosotros mismos. -->
        <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">

        <!-- ========================================== -->
        <!-- IMPORTACIÓN DE LIBRERIAS JAVASCRIPT        -->
        <!-- ========================================== -->
        <!-- jQuery: Una librería rápida y pequeña de JavaScript. Simplifica muchísimo
             las animaciones HTML, el manejo de eventos y, LO MÁS IMPORTANTE, el AJAX, que 
             usamos para conectar con el backend (controlator) sin recargar la página. -->
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    </head>
    <body>

        <!-- BARRA NAVEGACIÓN PERFIL -->
        <nav class="navbar">
            <a href="dashboard.php"><img class="logo" src="../assets/imagenes/logo_nav.png" alt="Vital Connection Logo"></a>
            <input type="checkbox" id="menu-toggle">

            <label for="menu-toggle" class="hamburguesa">
                <span></span>
                <span></span>
                <span></span>
            </label>

            <div class="botones">
                <a href="dashboard.php" class="botones_nav"><span class="glyphicon glyphicon-home"></span> Panel</a>
                <a href="perfil.php" class="botones_nav active-nav"><span class="glyphicon glyphicon-user"></span> Mi Perfil</a>
                
                <!-- Botón de desincorporación -->
                <a href="../controllers/usuarios/logout.php" class="boton_register btn-logout"><span class="glyphicon glyphicon-log-out"></span> Cerrar Sesión</a>
            </div>
        </nav>
        <!-- Título principal centrado ("text-center" es una clase que nos regala Bootstrap 3 para centrar fácilmente texto) -->
        <h1 class="text-center">Crud es el acronimo para create, read, update, delete</h1>
        
        <!-- Botón principal de la página que dice "Agregar Registro Biométrico". 
             Al darle click ("onclick") ejecuta la función JavaScript "mostrarAgregarBiometricos". 
             Le mandamos como parámetro el nombre del cuadro flotante (modal) 'modalAgregarBiometricos' para que sepa qué debe mostrar. -->
        <button onclick="mostrarAgregarBiometricos('modalAgregarBiometricos')">Agregar Registro Biometrico</button>
        
        
        <!-- ESTA ES LA TABLA PRINCIPAL. ID "biometricosTable".
             Aquí es donde insertaremos de forma mágica y asíncrona todos los datos traídos desde PHP. -->
        <table id="biometricosTable" border="1">
            <thead>
                <tr>
                    <!-- Cabeceras de la tabla: Estas columnas describen sobre qué información trata la tabla. -->
                    <th>ID RB</th>
                    <th>ID Usuario</th>
                    <th>ID Dispositivo</th>
                    <th>Ritmo Cardiaco</th>
                    <th>Oxigeno</th>
                    <th>Temperatura</th>
                    <th>Presion Sistolica</th>
                    <th>Presion Diastolica</th>
                    <th>Fecha Registro</th>
                </tr>
            </thead>
            <!-- El cuerpo ("tbody") está VACÍO. La razón es que el contenido (los datos) 
                 no se imprime directamente aquí por PHP al cargar, sino que usamos JavaScript (Ajax) 
                 que consulta otra url e inserta los resultados justo aquí automáticamente. -->
            <tbody>
                
            </tbody>
        </table>

        <!-- ========================================================================= -->
        <!-- SECCIÓN DE VENTANAS MODALES (VENTANAS INVISIBLES / FLOTANTES)               -->
        <!-- Estos "<div>" por defecto tienen un estilo "display:none", es decir, 
             no existen visualmente en la pantalla hasta que un script (al presionar un botón) los vuelve visibles cambiándolos a "display:block".-->
        <!-- ========================================================================= -->

        <!-- MODAL 1: EDITAR REGISTRO -->
        <div id="modalEditar" style="display:none";>
            <h3>Editar Registro Biometrico</h3>
            <form id="mostrarEditarBiometricos">
                <!-- Usamos 'span' con identificadores (IDs) únicos para ubicar dinámicamente sus valores después usando código JavaScript. -->
                ID Registro Biometrico : <span id="editID"></span><br>
                <!-- Usamos cajas de texto (<input>) y les damos una identificador estricto para recuperar lo que el usuario ponga en ellas -->
                ID Usuario : <input type="text" id="editIdUsuario"><br>
                ID Dispositivo : <input type="text" id="editIdDispositivo"><br>
                Ritmo Cardiaco : <input type="text" id="editRitmoCardiaco"><br>
                Oxigeno : <input type="text" id="editOxigeno"><br>
                Temperatura : <input type="text" id="editTemperatura"><br>
                Presion Sistolica : <input type="text" id="editPresionSistolica"><br>
                Presion Diastolica : <input type="text" id="editPresionDiastolica"><br>
                Fecha Registro : <span type="text" id="editFechaRegistro"></span><br>      

                <!-- Botón manual ("type=button"): Note que no es un "submit", sino un simple botón 
                     que activa la función JavaScript 'guardarEdicion()' para hacer magia (AJAX). -->
                <button type="button" onclick="guardarEdicion()"> Guardar</button>
            </form>
        </div>

        <!-- MODAL 2: CONFIRMAR ELIMINACIÓN -->
        <div id="modalEliminar" style="display:none";>
            <h3>Confirmar Eliminacion</h3>
                <!-- Aquí colocaremos el ID de lo que borramos, se verá como "ID: 41" -->
                ID: <span id="id"></span><br>
            <p>¿Estas seguro de que quieres eliminar estos Registros Biometricos?</p>
            <form id="mostrarEliminarBiometricos">
                <!-- Cuando le den click, se lanza la función eliminarBiometricos() -->
                <button type="button" onclick="eliminarBiometricos()">Eliminar</button>
            </form>
        </div>

        <!-- MODAL 3: AGREGAR REGISTRO NUEVO -->
        <div id="modalAgregarBiometricos" style="display:none";>
            <h3>Agregar Registro Biometrico</h3>
            <!-- Este formulario SI es tradicional. Al enviarlo ("type='submit'"), redirige e 
                 invía la data (post) a "../controllers/registros_biometricos/register_biometricos.php", donde la base de datos lo almacenará de verdad. -->
            <form action="../controllers/registros_biometricos/register_biometricos.php" id="nuevoDispositivo" method="post">
                <label for="idUsuario">ID Usuario:</label>
                <!-- Atributo 'name' define el título con el que la data le llegará a PHP via "$_POST['id_usuario']" -->
                <!-- Atributo 'required' significa que no se puede enviar vacío. -->
                <input type="text" id="idUsuario" name="id_usuario" required> <br><br>

                <label for="idDispositivo">ID Dispositivo:</label>
                <input type="text" id="idDispositivo" name="id_dispositivo" required> <br><br>

                <label for="ritmoCardiaco">Ritmo Cardiaco:</label>
                <input type="text" id="ritmoCardiaco" name="ritmo_cardiaco" required> <br><br>

                <label for="oxigeno">Oxigeno:</label>
                <input type="text" id="oxigeno" name="oxigeno" required> <br><br>

                <label for="temperatura">Temperatura:</label>
                <input type="text" id="temperatura" name="temperatura" required> <br><br>

                <label for="presionSistolica">Presion Sistolica:</label>
                <input type="text" id="presionSistolica" name="presion_sistolica" required> <br><br>

                <label for="presionDiastolica">Presion Diastolica:</label>
                <input type="text" id="presionDiastolica" name="presion_diastolica" required> <br><br>

                <!-- El valor "accion"="agregar" es atrapado por PHP para saber qué botón apretaste -->
                <button type="submit" name="accion" value="agregar">Añadir</button>
            </form>
        </div>

        <!-- ============================================== -->
        <!-- PIE ESTANDAR HTML                                -->
        <!-- ============================================== -->
        <footer>
            <div class="foot_col_izq" izquierda>
                <img id="foot_col_izq_img" src="../assets/imagenes/logo_nav.png" alt="Logo nav">
                <p>
                    Tu salud conectada con <br>
                    monitoreo inteligente
                </p>

                <div class="foot_col_izq_iconos">
                    <a href="www.instagram.com"><img src="../assets/imagenes/ig-icon.png" alt="instagram" width="20px"></a>
                    <a href="www.facebook.com"><img src="../assets/imagenes/fb-icon.png" alt="facebook" width="20px"></a>
                    <a href="www.linkedin.com"><img src="../assets/imagenes/Linkedin.png" alt="LinkedIn" width="20px"></a>
                    <a href="www.x.com"><img src="../assets/imagenes/x.png" alt="x" width="20px"></a>

                </div>
            </div>

            <div class="foot_col_centro_der">
                <h1 id="foot_col_centro_der_h1">Legal</h1>
                <ul>
                    <li><a href="#" class="foot_col_centro_der_enlaces">Términos y condiciones</a></li>
                    <li><a href="#" class="foot_col_centro_der_enlaces">Política de privacidad</a></li>
                    <li><a href="#" class="foot_col_centro_der_enlaces">Aviso legal</a></li>
                </ul>
            </div>
            <div class="foot_col_der" derecha>
                <h1 id="foot_col_der_h1">Contacto</h1>
                <ul>
                    <li>
                        <p class="foot_col_der_contacto">Email: vitalconnection@vital.com</p>
                    </li>
                    <li>
                        <p class="foot_col_der_contacto">telefono: +52 618 234 2619</p>
                    </li>
                    <li>
                        <p class="foot_col_der_contacto">Direccion: UNIPOLI Durango, dgo</p>
                    </li>
                </ul>
            </div>

        </footer>

        <!-- ========================================================================= -->
        <!-- ZONA DE LÓGICA (JAVASCRIPT / JQUERY)                                        -->
        <!-- Aquí están todas las funciones que definimos arriba en los "onclick"        -->
        <!-- ========================================================================= -->

        <script>
            // $(document).ready() es una función especial de "jQuery". Significa: 
            // "espera a que el navegador haya terminado de leer totalmente (estar listo) 
            // el código visual HTML, y luego ejecuta el código interior."
            $(document).ready(function () {
                // AJAX (Asynchronous JavaScript and XML)
                // Es una técnica que sirve para pedir información al servidor sin que 
                // la página deba recargarse ("pantalla en blanco"). Simulando ser muy veloz.
                $.ajax({
                    // url a la cual va a buscar información en el servidor (en los controladores)
                    url: '../controllers/registros_biometricos/cargar_biometricos.php',
                    // Método utilizado, 'GET' normalmente se usa para obtener datos, 'POST' manda datos.
                    type: 'GET',
                    // Si el archivo en la URL tuvo éxito y no dió error, esa página responderá (dará todo su contenido) 
                    // en texto HTML y lo meterá de forma automática dentro del parámetro (response).
                    success:function(response){
                        // Seleccionamos mediante su ID la etiqueta "tbody" de nuestra tabla (vacía) de la línea 42...
                        // Y con la lógica '.html(response)' sobrescribiremos totalmente esa celda por
                        // el contenido HTML gigante de las filas traídas desde el archivo de controladores.
                        $('#biometricosTable tbody').html(response);
                    }
                });
            });

            // Función disparada por el botón "Agregar Registro Biometrico" de hasta arriba
            function mostrarAgregarBiometricos(elementId){
                // elementId será 'modalAgregarBiometricos'. Con JS clásico buscamos ese Div en nuestro HTML.
                var element = document.getElementById(elementId);
                
                // Si el div existe...
                if(element) {
                    // Quitamos la orden "display:none" por "display:block", haciendo que aparezca y lo vea el usuario.
                    element.style.display = 'block';
                }
            }

            // Esta función será llamada por los botones pequeñitos dentro de cada fila que generó PHP.
            // Recibe como parámetros toda la data de la fila a punto de ser editada.
            function mostrarEditarBiometricos(id, idUsuario, idDispositivo, ritmoCardiaco, oxigeno, temperatura, presionSistolica, presionDiastolica, fechaRegistro){
                // Extrae los datos recibidos mediante los parámetros desde el botón, y 
                // busca las cajas "inputs" del formulario oculto 'Editar' para Rellenarlas.
                document.getElementById('editID').innerText = id;
                document.getElementById('editIdUsuario').value = idUsuario;
                document.getElementById('editIdDispositivo').value = idDispositivo;
                document.getElementById('editRitmoCardiaco').value = ritmoCardiaco;
                document.getElementById('editOxigeno').value = oxigeno;
                document.getElementById('editTemperatura').value = temperatura;
                document.getElementById('editPresionSistolica').value = presionSistolica;
                document.getElementById('editPresionDiastolica').value = presionDiastolica;
                document.getElementById('editFechaRegistro').innerText = fechaRegistro;

                // Después de rellenar las cajitas de texto con la información de la fila, abre el Modal.
                var modal = document.getElementById('modalEditar').style.display = 'block';
            }

            // Una vez teniendo la pantallita (modal) lista para editar con todo rellenado... 
            // El usuario podrá modificar lo que quiera, y al darle al botón 'Guardar', llega a esta función:
            function guardarEdicion(){
                // Sacamos todo el contenido escrito por el usuario en esos inputs mediante '.value'
                var id = document.getElementById('editID').innerText
                var idUsuario = document.getElementById('editIdUsuario').value
                var idDispositivo = document.getElementById('editIdDispositivo').value
                var ritmoCardiaco = document.getElementById('editRitmoCardiaco').value
                var oxigeno = document.getElementById('editOxigeno').value
                var temperatura = document.getElementById('editTemperatura').value
                var presionSistolica = document.getElementById('editPresionSistolica').value
                var presionDiastolica = document.getElementById('editPresionDiastolica').value
                
                // Volvemos a hacer uso de la técnica increíble "AJAX"
                $.ajax({
                    // Esta vez mandamos todo hacia la inteligencia(controlador) que sabe actualizar la base de datos
                    url: '../controllers/registros_biometricos/cargar_editar_biometricos.php',
                    // Y esta vez en vez de 'GET' usamos 'POST', que es más seguro para transportar datos en la ruta
                    type: 'POST',
                    // Le empaquetamos (serializamos a un "objeto" de datos en JS) todas nuestras variables previas
                    // a la ruta. Quedan viajando como variables POST silenciosas por dentro.
                    data: {
                        editID: id,
                        editIdUsuario: idUsuario,
                        editIdDispositivo: idDispositivo,
                        editRitmoCardiaco: ritmoCardiaco,
                        editOxigeno: oxigeno,
                        editTemperatura: temperatura,
                        editPresionSistolica: presionSistolica,
                        editPresionDiastolica: presionDiastolica,
                    },
                    // Cuando nos confirme el servidor que "Actualizó el registro con éxito" y haya cargado todo..
                    success:function(response){
                        // Creamos una alerta nativa del navegador para avisarlo 
                        alert('Registro biometrico actualizado correctamente');;
                        
                        // Y para no recargar la página entera y ver los cambios visuales nuevos... 
                        // hacemos otro chiquito AJAX dentro de AJAX, que vuelva a TRAER TODOS LOS REGISTROS PARA MOSTRARLOS (actualizados esta vez!)
                        $.ajax({
                            // Pedimos la lista nuevamente
                            url: '../controllers/registros_biometricos/cargar_biometricos.php',
                            type: 'GET',
                            success:function(response){
                                // Y sustituimos "sobrescribiendo" la tabla vieja por la nueva. Una proeza visual.
                                $('#biometricosTable tbody').html(response);
                            }
                        });
                        // Cerramos el modal emergente visual (el cuadro de en medio) cambiando a "none".
                        document.getElementById('modalEditar').style.display = 'none';
                    }
                });
            }


            // Lo mismo que editar, pero más fácil: sólo toma el ID seleccionado de la fila de la tabla y lo pasa al título.
            function mostrarEliminarBiometricos(id){
                document.getElementById('id').innerText = id;
                // Abre el modal de "¿Estás seguro de eliminar?"
                var modal = document.getElementById('modalEliminar').style.display = 'block';
            }

            // Si el Administrador pulsó en el modal que "SI" quiere borrar de verdad, ejecuta esto...
            function eliminarBiometricos(id){
                // Agarra ese ID escondido en el "span" del modal
                var id = document.getElementById('id').innerText;

                $.ajax({
                    // Envia ese "ID" a la muerte (a cargar_eliminar_biometricos.php)
                    url: '../controllers/registros_biometricos/cargar_eliminar_biometricos.php',
                    type: 'POST',
                    data: {
                        id: id
                    },
                    // Se conectará al controlador, ejecutará la instrucción DELETE sql de la base de datos, y nos regresa al exito 'success'.
                    success:function(response){
                        alert('Registro biometrico eliminado correctamente');
                        
                        // Y hacemos exactamente la misma obra maestra AJAX:
                        // Recargamos silenciosamente los registros de manera visual para que ese registro ya se vea desaparecido!
                        $.ajax({
                            // Cargar la lista entera desde atrás, ahora sin lo que eliminamos
                            url: '../controllers/registros_biometricos/cargar_biometricos.php',
                            type: 'GET',
                            success:function(response){
                                // Sobrescribir toda la tabla sin recargar página
                                $('#biometricosTable tbody').html(response);
                            }
                        });
                        // Ocultamos el modal que todavía estaba abierto diciendo "¿estas seguro?".
                        document.getElementById('modalEliminar').style.display = 'none';
                    }
                    
                });
            }

        </script>
        
        <!-- Y finalmente, al lado de la librería jQuery, colocamos la funcionalidad extra... -->
        <!-- Archivo JavaScript oficial de Bootstrap: Permite que los menús móviles, botones especiales 
             o comportamientos que dependen del teclado funcionen bien, dándole vida al diseño (CSS). -->
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    </body>
</html>
