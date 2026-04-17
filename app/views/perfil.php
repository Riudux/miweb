<?php
// =========================================================================
// ARCHIVO: perfil.php (PÁGINA DEDICADA AL USUARIO AUTENTICADO)
// PROPÓSITO: Similar al dashboard, pero enfocado puramente a una "Tarjeta" de identidad
// informándote cosas que el sistema guarda sobre ti. 
// =========================================================================

// Levantamos bolsas de $_SESSION para verificar
session_start();

// Verifica integridad (Evita que el intruso ponga "perfil.php" directo)
if (isset($_SESSION['email']) && isset($_SESSION['username'])) {
    
    // Obtenemos todos los datos desde el empaquetado inicial (login.php)
    $username = $_SESSION['username'];
    $email = $_SESSION['email'];
    $elide = $_SESSION['id_usuario'];
    $idrol = $_SESSION['id_rol'];

} else {
    // Te patea de vuelta hacia login en caso corrupto
    header("Location: ../app/views/login.html");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Mi Perfil</title>

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../assets/styles/css/bootstrap.min.css">
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/styles/body.css">
    <link rel="stylesheet" href="../assets/styles/navbar.css">
    <link rel="stylesheet" href="../assets/styles/perfil.css">

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

    <!-- ÁREA DE INFORMACIÓN DEL PROPIO USUARIO -->
    <div class="container perfil-container">
        <div class="row">
            <!-- offset se saltea columnas para dejar en blanco a la redonda y forzar el centrado -->
            <div class="col-md-8 col-md-offset-2 col-sm-10 col-sm-offset-1 col-xs-12">

                <!-- Tarjeta contenedora principal  -->
                <div class="perfil-card">
                    <div class="perfil-header">
                        <div class="perfil-avatar-wrapper">
                            <span class="glyphicon glyphicon-user avatar-icon"></span>
                        </div>
                        <!-- Inyección: Muestra en grandote el Nombre en la parte superior del círculo -->
                        <h2><?php echo $username; ?></h2>
                    </div>

                    <div class="perfil-body">
                        <h3 class="section-title">Información de la Cuenta</h3>
                        
                        <div class="row info-row">
                            <!-- Filas subdivididas de la tarjeta -->
                            <div class="col-sm-6 info-box">
                                <label>Nombre de Usuario:</label>
                                <!-- Inyección del nombre -->
                                <p><?php echo $username; ?></p>
                            </div>

                            <div class="col-sm-6 info-box">
                                <label>Correo Electrónico:</label>
                                <!-- Inyección del correo -->
                                <p><?php echo $email; ?></p>
                            </div>

                            <div class="col-sm-6 info-box">
                                <label>ID de Usuario (Token personal):</label>
                                <!-- Inyectar identificador con el que funciona internamente el usuario -->
                                <p><?php echo $elide; ?></p>
                            </div>
                        </div>

                    </div>
                </div>

            </div>
        </div>
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

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</body>

</html>