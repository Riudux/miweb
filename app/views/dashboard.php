<?php
// =========================================================================
// ARCHIVO: dashboard.php (VISTA MATRIZ TIPO PANEL PACIENTE / ADMIN)
// PROPÓSITO: La página frontal, protegida y segura. Es el "Lobby" adonde 
// entra un usuario logueado exitosamente, cargando sus credenciales desde memoria.
// Si no hay memoria, lo bota. Mostrando opciones personalizadas.
// =========================================================================

// Paso 1. Reiniciar o engancharnos al costal temporal de sesion '$_SESSION' que viaja en el servidor
session_start();

// Validamos rigurosamente si el pase 'email' y el 'username' se encuentran definidos adentro. 
if (isset($_SESSION['email']) && isset($_SESSION['username'])) {

    // Si existen, procedemos a "Desempacar" esas bolsas en Variables de uso fácil local.
    $username = $_SESSION['username'];
    $email = $_SESSION['email'];
    $elide = $_SESSION['id_usuario'];
    $lacontra = $_SESSION['password'];
    $idrol = $_SESSION['id_rol']; // Importantísimo: Guarda "1" (Admin) o "2" (Regular).

} else {
    // Si algún intruso quiso entrar tipeando en Google 'dashboard.php' sin iniciar sesión,  
    // el código falla en el `if`, lo interceptamos, y lo mandamos volando a 'login.html' para obligarlo a validarse.
    header("Location : login.html");
    exit();
}

?>


<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dashboard</title>

    <!-- Bootstrap 3 Framework -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/styles/body.css">
    <link rel="stylesheet" href="../assets/styles/navbar.css">
    <link rel="stylesheet" href="../assets/styles/dashboard.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">


</head>

<body>

    <nav class="navbar">
        <a href="dashboard.php"><img class="logo" src="../assets/imagenes/logo_nav.png" alt="Logo nav" height="50px"></a>
        <input type="checkbox" id="menu-toggle">

        <label for="menu-toggle" class="hamburguesa">
            <span></span>
            <span></span>
            <span></span>
        </label>

        <!-- A diferencia del Nav público, este ya oculta secciones "Sobre nosotros" para darle 
             funcionalidades personales operativas como su perfil y la salida oficial. -->
        <div class="botones">
            <!-- AQUÍ ESTÁ EL TRUCO DE ÍCONOS DE BOOTSTRAP: Al usar <span class="glyphicon glyphicon-user"></span> 
                 estamos invocando una tipografía empaquetada que convierte ese texto en un dibujo de monito. -->
            <a href="perfil.php" class="botones_nav"><span class="glyphicon glyphicon-user"></span> Mi Perfil</a>

            <!-- Mandar destruir su rastro al momento de presionar Cierre -->
            <a href="../controllers/usuarios/logout.php" class="boton_register"><span class="glyphicon glyphicon-log-out"></span> Cerrar Sesión</a>
        </div>
    </nav>


    <!-- La clase contenedor (.container) la otorga Bootstrap para centrar en pantalla bonita. -->
    <div class="container dashboard-container">

        <div class="dashboard-header text-center">
            <!-- Imprimimos o inyectamos (con echo) al html el nombre de usuario previamente desempacado en las primeras lineas de PHP superior. -->
            <h1>Hola, <strong><?php echo $username; ?></strong></h1>
            <p>Bienvenido al dashboard de VitalConnection.</p>
        </div>

        <!-- .row en Bootstrap crea una cuadrícula flexible dividiendo la pantalla en 12 columnas. -->
        <div class="row">

            <!-- "col-md-4 col-sm-6" designa la proporción. Significa: En monitores grandes (MD), ocupamé 4 bloques (cabrían 3 tarjetas formadas). En celulares (SM) ocupa 6 bloques (cabrían solo 2 tarjetas). -->
            <div class="col-md-4 col-sm-6">
                <!-- Una tarjeta de paciente simulada -->
                <div class="dash-card">
                    <div class="dash-icon-wrapper">
                        <!-- Corazón proveniente de los íconos Gliphicons de Bootrap 3 -->
                        <span class="glyphicon glyphicon-heart dash-icon"></span>
                    </div>
                    <h3>Ritmo Cardiaco</h3>
                    <p>Pulsaciones por minuto actuales y promedio diario.</p>
                    <a href="historial_cardiaco.html" class="btn btn-custom">Ver Reporte</a>
                </div>
            </div>

            <!-- Otra Tarjeta -->
            <div class="col-md-4 col-sm-6">
                <div class="dash-card">
                    <div class="dash-icon-wrapper">
                        <!-- Gota proveniente de BS3 -->
                        <span class="glyphicon glyphicon-tint dash-icon"></span>
                    </div>
                    <h3>Oxígeno en Sangre</h3>
                    <p>Niveles de saturación y variaciones detectadas.</p>
                    <a href="historial_oxigeno.html" class="btn btn-custom">Ver Niveles</a>
                </div>
            </div>

            <!-- Otra Tarjeta -->
            <div class="col-md-4 col-sm-6">
                <div class="dash-card">
                    <div class="dash-icon-wrapper">
                        <span class="glyphicon glyphicon-eye-open dash-icon"></span>
                    </div>
                    <h3>Calidad de Sueño</h3>
                    <p>Análisis de horas de descanso profundo y ligero.</p>
                    <a href="analisis_sueno.html" class="btn btn-custom">Ver Análisis</a>
                </div>
            </div>
        </div>

        <!-- ============================================== -->
        <!--  LÓGICA CONDICIONAL DE ADMINISTRADORES           -->
        <!-- ============================================== -->
        <!-- Justo en medio de HTML, volvemos a abrir las etiquetas PHP.
             Evaluamos si TU propio rol ($idrol) desempacado arriba tiene el número Maestro '1' (Código Admin).  -->
        <?php if ($idrol == 1): ?>

            <!-- SI SE CUMPLÍO ESTA CONDICIÓN (ERAS ADMIN), TODO ESTE HTML POSTERIOR SÍ SE INYECTARÁ AL RESULTADO, SINO DESAPARECERÁ -->
            <div class="row admin-section"> <!-- Sección dedicada en grande -->
                <!-- col-md-12 significa que utilizará TODON el ancho visual -->
                <div class="col-md-12">
                    <div class="dash-card admin-card text-center">
                        <div class="dash-icon-wrapper admin-icon">
                            <!-- Engrane especial de configuraciones en Bootstrap (Glyphicon) -->
                            <span class="glyphicon glyphicon-cog dash-icon"></span>
                        </div>
                        <h3>Panel de Administración General</h3>
                        <p>Acceso de Admin para poder controlar los cruds de las tablas de base de datos.</p>

                        <div class="admin-buttons">
                            <!-- ACCESO A LAS RUTAS CRUD QUE HEMOS DOCUMENTADO ANTES -->
                            <a href="../models/crud_usuarios.php" class="btn btn-admin"><span class="glyphicon glyphicon-user"></span> Gestionar Usuarios</a>
                            <!-- El del telefono por que son "Dispositivos mobiles o pulseras" -->
                            <a href="../models/crud_dispositivos.php" class="btn btn-admin"><span class="glyphicon glyphicon-phone"></span> Gestionar Dispositivos</a>
                            <a href="../models/crud_biometricos.php" class="btn btn-admin"><span class="glyphicon glyphicon-heart"></span> Gestionar Biometricos</a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Cierre de bloque IF. Nadie más verá esta maravilla debajo. -->
        <?php endif; ?>

    </div>

    <!-- Footer general con redes sacados de imágenes directas. -->
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

    <!-- LIBRERIAS FINALES INYECTADAS DESDE LA NUBE -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</body>

</html>