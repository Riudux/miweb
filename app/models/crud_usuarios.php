<?php
    session_start();
    if (isset($_SESSION['email']) && isset($_SESSION['username'])) {

    $username = $_SESSION['username'];
    $email = $_SESSION['email'];
    $elide = $_SESSION['id_usuario'];
    $lacontra = $_SESSION['password'];
    $idrol = $_SESSION['id_rol'];

    } else {
        header("Location: ../views/login.html");
        exit();
    }
?>

<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <!-- Establece el ancho correcto para celulares (Responsive Design) -->
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Crud Usuarios</title>

        <link rel="stylesheet" href="../assets/styles/crud_biometricos.css">
        <link rel="stylesheet" href="../assets/styles/navbar.css">
        <link rel="stylesheet" href="../assets/styles/body.css">
        

        <!-- ============================================== -->
        <!-- OBTENCIÓN DE HOJAS DE ESTILOS (BOOTSTRAP 3)    -->
        <!-- ============================================== -->
        <!-- Mediante la etiqueta 'link' y apuntando a 'bootstrapcdn' usamos los estilos de Bootstrap 3 sin descargar los archivos a nuestro servidor local. -->
        <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">

        <!-- Agregamos jQuery. Obligatorio cargarlo *antes* de finalizar el head, ya que Bootstrap 3 requiere de este para funcionar. -->
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    </head>

    <body>

        <!-- BARRA NAVEGACIÓN PERFIL -->
        <nav class="navbar">
            <a href="../views/dashboard.php"><img class="logo" src="../assets/imagenes/logo_nav.png" alt="Vital Connection Logo"></a>
            <input type="checkbox" id="menu-toggle">

            <label for="menu-toggle" class="hamburguesa">
                <span></span>
                <span></span>
                <span></span>
            </label>

            <div class="botones">
                <a href="../views/dashboard.php" class="botones_nav"><span class="glyphicon glyphicon-home"></span> Panel</a>
                <a href="../views/perfil.php" class="botones_nav active-nav"><span class="glyphicon glyphicon-user"></span> Mi Perfil</a>
                
                <!-- Botón de desincorporación -->
                <a href="../controllers/usuarios/logout.php" class="boton_register btn-logout"><span class="glyphicon glyphicon-log-out"></span> Cerrar Sesión</a>
            </div>
        </nav>

        <section>
            <h1 class="text-center">Crud Usuarios</h1>
            
            <!-- Botón que activa la función JavaScript descrita al final de esta página para mostrar el cuadro "Añadir Usuario" -->
            <button id="btnAgregarBiometrico" onclick="mostrarAgregarUsuario('modalAgregarUsuario')">Agregar usuario</button>

            <!-- ============================================== -->
            <!-- LA ESTRUCTURA TABULAR FRONTAL (ESQUELETO)      -->
            <!-- ============================================== -->
            <table id="usuariosTable" class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Username</th>
                        <th>Email</th>
                        <th>Fecha_Registro</th>
                        <th>ID Rol</th>
                        <!-- Cabecera de Acciones (para contener botones Editar y Eliminar) -->
                        <th>Acciones</th>
                    </tr>
                </thead>
                <!-- El contenido dinámico rellenará esta etiqueta desde Javascript -->
                <tbody>

                </tbody>
            </table>

            <!-- ========================================================= -->
            <!-- RECINTOS MODALES (PANTALLAS EMERGENTES TIPO 'POP-UP')     -->
            <!-- Estarán invisibles (display:none) hasta que JavaScript actúe -->
            <!-- ========================================================= -->

            <!-- MODAL DE EDICIÓN -->
            <div id="modalEditar" style="display:none" ;>
                <h3>Editar Usuario</h3>
                <form id="mostrarEditarUsuario">
                    ID : <span id="editID"></span><br>
                    Username : <input type="text" id="editUsername"><br>
                    Email : <input type="text" id="editEmail"><br>
                    Fecha_Registro : <input type="text" id="editFecha"><br>
                    Rol : <input type="text" id="editIdRol"><br>
                    <!-- Ojo: Tipo Botón, NO "Submit", ya que usaremos Ajax manualmente. -->
                    <button type="button" onclick="guardarEdicion()"> Guardar</button>
                </form>
            </div>

            <!-- MODAL DE ELIMINAR -->
            <div id="modalEliminar" style="display:none" ;>
                <h3>Confirmar Eliminacion</h3>
                ID: <span id="id"></span><br>
                <p>¿Estas seguro de que quieres eliminar este usuario?</p>
                <form id="mostrarEliminarUsuario">
                    <button type="button" onclick="eliminarUsuario()">Eliminar</button>
                </form>
            </div>

            <!-- MODAL DE CREACIÓN -->
            <div id="modalAgregarUsuario" style="display:none" ;>
                <h3>Agregar Usuario</h3>
                <!-- Este Modal sí se ejecuta clásico con "POST" apuntando al registro directo y reseteándose -->
                <form action="../controllers/usuarios/register_usuarios.php" id="nuevoUsuario" method="post">
                    <label for="username">Nombre de usuario:</label>
                    <input type="text" id="username" name="username" required> <br><br>

                    <label for="email">Correo:</label>
                    <input type="text" id="email" name="email" required> <br><br>

                    <label for="password">Contraseña:</label>
                    <!-- La contraseña se enmascara con "type=password" -->
                    <input type="password" id="password" name="password" required> <br><br>

                    <!-- Botón de Envío forzado -->
                    <button type="submit" name="accion" value="agregar">Añadir</button>
                </form>
            </div>

        </section>

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

        <!-- ============================================== -->
        <!-- LÓGICA DE INTERACCIÓN DEL CLIENTE (SCRIPTS)    -->
        <!-- ============================================== -->
        <script>
            // El document ready () previene que se lance JavaScript antes de que toda la imagen o tabla esté formada
            $(document).ready(function() {
                // Hacemos una petición rápida silenciosa para auto-llenar el 'tbody' con la información de los usuarios usando "cargar_usuarios"
                $.ajax({
                    url: '../controllers/usuarios/cargar_usuarios.php',
                    type: 'GET', // Usamos GET solo para "traer y leer"
                    success: function(response) {
                        $('#usuariosTable tbody').html(response);
                    }
                });
            });

            // Función disparada por el botón verde inicial, ubica el Div y lo aparece sustituyendo el atributo css de ocultamiento.
            function mostrarAgregarUsuario(elementId) {
                var element = document.getElementById(elementId);
                if (element) {
                    element.style.display = 'block';
                }
            }

            // Una función que inyecta cada columna específica de la fila que acabas de presionar en las cajas blancas del Modal Editar.
            function mostrarEditarUsuario(id_usuario, username, email, fechaRegistro, idRol) {
                document.getElementById('editID').innerText = id_usuario;
                document.getElementById('editUsername').value = username;
                document.getElementById('editEmail').value = email;
                document.getElementById('editFecha').value = fechaRegistro;
                document.getElementById('editIdRol').value = idRol;

                var modal = document.getElementById('modalEditar').style.display = 'block';
            }

            // Se dispara con el botoncito chiquito gris "Guardar" y empaqueta lo que escribiste mandándolo al controlador que actualiza.
            function guardarEdicion() {
                var id = document.getElementById('editID').innerText
                var username = document.getElementById('editUsername').value
                var email = document.getElementById('editEmail').value
                var fechaRegistro = document.getElementById('editFecha').value
                var idRol = document.getElementById('editIdRol').value
                
                // Iniciando paquete POST para actualizar
                $.ajax({
                    url: '../controllers/usuarios/cargar_editar_usuario.php',
                    type: 'POST', // Usamos POST para mayor privacidad y longitud en modificación
                    data: {
                        editID: id,
                        editUsername: username,
                        editEmail: email,
                        editFecha: fechaRegistro,
                        editIdRol: idRol
                    },
                    success: function(response) {
                        alert('Usuario actualizado correctamente');
                        
                        // Recargar todo el registro para visualizar que el usuario cambió los campos
                        $.ajax({
                            url: '../controllers/usuarios/cargar_usuarios.php',
                            type: 'GET',
                            success: function(response) {
                                $('#usuariosTable tbody').html(response);
                            }
                        });
                        // Mandar dormir el recuadro
                        document.getElementById('modalEditar').style.display = 'none';
                    }
                });
            }

            // Poner el ID para confirmar borrado visualmente.
            function mostrarEliminarUsuario(id_usuario) {
                document.getElementById('id').innerText = id_usuario;
                var modal = document.getElementById('modalEliminar').style.display = 'block';
            }

            // Realiza la matanza de usuario de base de datos
            function eliminarUsuario(id_usuario) {
                var id_usuario = document.getElementById('id').innerText;

                $.ajax({
                    url: '../controllers/usuarios/cargar_eliminar_usuario.php',
                    type: 'POST',
                    data: {
                        id: id_usuario
                    },
                    success: function(response) {
                        alert('Usuario eliminado correctamente');
                        
                        // Recargar visual sin cambiar de página la matriz
                        $.ajax({
                            url: '../controllers/usuarios/cargar_usuarios.php',
                            type: 'GET',
                            success: function(response) {
                                $('#usuariosTable tbody').html(response);
                            }
                        });
                        // Cierra el cuadro
                        document.getElementById('modalEliminar').style.display = 'none'
                    }

                });
            }
        </script>


        <!-- Librerías clásicas JS alojadas en CDN para Bootstrap3, requeridas finalizando el ciclo 'body' -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
        <!-- Permite funcionar a Dropdowns, Collapses, Menus responsivos -->
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    </body>

</html>