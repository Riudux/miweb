<?php
// =========================================================================
// La página frontal, protegida y segura. Es el "Lobby" adonde 
// entra un usuario logueado exitosamente, cargando sus credenciales desde memoria.
// Si no hay memoria, lo bota. Mostrando opciones personalizadas.
// =========================================================================

session_start();

if (isset($_SESSION['email']) && isset($_SESSION['username'])) {

    $username = $_SESSION['username'];
    $email = $_SESSION['email'];
    $elide = $_SESSION['id_usuario'];
    $lacontra = $_SESSION['password'];
    $idrol = $_SESSION['id_rol'];

} else {
    header("Location: login.html");
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
                <!-- Al dar clic en toda la tarjeta, te envía a la página detallada -->
                <div class="dash-card" style="cursor: pointer;" onclick="window.location.href='ritmo_cardiaco.php'">
                    <div class="dash-icon-wrapper">
                        <span class="glyphicon glyphicon-heart dash-icon"></span>
                    </div>
                    <h3>Ritmo Cardiaco</h3>
                    <p>Tendencia de los últimos 7 días</p>
                    <!-- Contenedor donde ApexCharts dibujará el mini-gráfico -->
                    <div id="mini-chart-ritmo"></div>
                    <a href="ritmo_cardiaco.php" class="btn btn-custom">Ver Detalles</a>
                </div>
            </div>

            <!-- Otra Tarjeta -->
            <div class="col-md-4 col-sm-6">
                <div class="dash-card" style="cursor: pointer;" onclick="window.location.href='oxigeno.php'">
                    <div class="dash-icon-wrapper">
                        <span class="glyphicon glyphicon-tint dash-icon"></span>
                    </div>
                    <h3>Oxígeno en Sangre</h3>
                    <p>Tendencia de los últimos 7 días</p>
                    <div id="mini-chart-oxigeno"></div>
                    <a href="oxigeno.php" class="btn btn-custom">Ver Detalles</a>
                </div>
            </div>

            <!-- Otra Tarjeta (Cambiamos Sueño por Temperatura porque es lo que hay en BD) -->
            <div class="col-md-4 col-sm-6">
                <div class="dash-card" style="cursor: pointer;" onclick="window.location.href='temperatura.php'">
                    <div class="dash-icon-wrapper">
                        <span class="glyphicon glyphicon-fire dash-icon"></span>
                    </div>
                    <h3>Temperatura Corporal</h3>
                    <p>Tendencia de los últimos 7 días</p>
                    <div id="mini-chart-temperatura"></div>
                    <a href="temperatura.php" class="btn btn-custom">Ver Detalles</a>
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
    
    <!-- Incluimos ApexCharts desde su CDN oficial para generar las gráficas -->
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

    <script>
        // Cuando la página termine de cargar visualmente, ejecutamos esta lógica
        $(document).ready(function() {
            // Hacemos una petición AJAX para traer los datos de los últimos 7 días
            $.ajax({
                url: '../controllers/registros_biometricos/estadisticas_json.php?last_week=true',
                type: 'GET',
                dataType: 'json',
                success: function(data) {
                    if (data.error) {
                        console.error("Error obteniendo datos: ", data.error);
                        return;
                    }

                    // Preparamos unos arreglos (arrays) vacíos donde iremos metiendo 
                    // los datos desempacados que vengan del servidor
                    let fechas = [];
                    let datosRitmo = [];
                    let datosOxigeno = [];
                    let datosTemp = [];

                    // Iteramos o recorremos cada uno de los registros que nos devolvió PHP
                    data.forEach(function(registro) {
                        // Extraemos y guardamos la fecha para el eje horizontal (eje X)
                        // Para que se vea bonito, solo tomamos la parte de la fecha o podemos formatearla
                        fechas.push(registro.fecha_registro.substring(0, 10)); // Solo el YYYY-MM-DD
                        
                        // Parseamos o forzamos los valores numéricos de cada columna de la base de datos
                        datosRitmo.push(parseFloat(registro.ritmo_cardiaco));
                        datosOxigeno.push(parseFloat(registro.oxigeno));
                        datosTemp.push(parseFloat(registro.temperatura));
                    });

                    // ==========================================
                    // 1. CONFIGURACIÓN MINI GRÁFICA RITMO CARDIACO
                    // ==========================================
                    // Creamos un "objeto" con las reglas visuales para ApexCharts
                    var opcionesRitmo = {
                        series: [{
                            name: 'Ritmo Cardiaco',
                            data: datosRitmo // Le metemos nuestro array lleno de los datos de la DDBB
                        }],
                        chart: {
                            type: 'area', // Tipo 'area' dibuja una línea y rellena debajo con color
                            height: 100, // Al ser "mini", la hacemos chaparrita
                            sparkline: {
                                enabled: true // Sparkline significa gráfica compacta, oculta los números y ejes a los lados
                            }
                        },
                        stroke: { curve: 'smooth' }, // Línea suavizada (curveada) en lugar de picos agudos
                        colors: ['#FF4560'], // Color rojo/rosa para el corazón
                        tooltip: { // Al poner el mouse encima
                            fixed: { enabled: false },
                            x: { show: false },
                            y: { title: { formatter: function (seriesName) { return 'LPM' } } }, // Latidos Por Minuto
                            marker: { show: false }
                        }
                    };
                    // Renderizamos o "pintamos" físicamente la gráfica dentro del <div> 'mini-chart-ritmo'
                    var chartRitmo = new ApexCharts(document.querySelector("#mini-chart-ritmo"), opcionesRitmo);
                    chartRitmo.render();


                    // ==========================================
                    // 2. CONFIGURACIÓN MINI GRÁFICA OXÍGENO
                    // ==========================================
                    var opcionesOxigeno = {
                        series: [{
                            name: 'Oxígeno',
                            data: datosOxigeno
                        }],
                        chart: {
                            type: 'area',
                            height: 100,
                            sparkline: { enabled: true }
                        },
                        stroke: { curve: 'smooth' },
                        colors: ['#00E396'], // Color verde/azul para el oxígeno
                        tooltip: {
                            fixed: { enabled: false },
                            x: { show: false },
                            y: { title: { formatter: function (seriesName) { return '%' } } },
                            marker: { show: false }
                        }
                    };
                    var chartOxigeno = new ApexCharts(document.querySelector("#mini-chart-oxigeno"), opcionesOxigeno);
                    chartOxigeno.render();


                    // ==========================================
                    // 3. CONFIGURACIÓN MINI GRÁFICA TEMPERATURA
                    // ==========================================
                    var opcionesTemp = {
                        series: [{
                            name: 'Temperatura',
                            data: datosTemp
                        }],
                        chart: {
                            type: 'area',
                            height: 100,
                            sparkline: { enabled: true }
                        },
                        stroke: { curve: 'smooth' },
                        colors: ['#FEB019'], // Color cálido amarillo/naranja
                        tooltip: {
                            fixed: { enabled: false },
                            x: { show: false },
                            y: { title: { formatter: function (seriesName) { return '°C' } } },
                            marker: { show: false }
                        }
                    };
                    var chartTemp = new ApexCharts(document.querySelector("#mini-chart-temperatura"), opcionesTemp);
                    chartTemp.render();
                }
            });
        });
    </script>
</body>

</html>