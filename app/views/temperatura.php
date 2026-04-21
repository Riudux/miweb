<?php
session_start();
if (!isset($_SESSION['email']) || !isset($_SESSION['username'])) {
    header("Location: login.html");
    exit();
}
$username = $_SESSION['username'];
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Temperatura Detallada</title>

    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/styles/cruds.css">
    <link rel="stylesheet" href="../assets/styles/navbar.css">
    <link rel="stylesheet" href="../assets/styles/body.css">
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

        <div class="botones">
            <a href="dashboard.php" class="botones_nav"><span class="glyphicon glyphicon-home"></span> Panel</a>
            <a href="perfil.php" class="botones_nav"><span class="glyphicon glyphicon-user"></span> Mi Perfil</a>
            <a href="../controllers/usuarios/logout.php" class="boton_register"><span class="glyphicon glyphicon-log-out"></span> Cerrar Sesión</a>
        </div>
    </nav>

    <section>
        <h1 class="text-center">Detalle de Temperatura Corporal</h1>
        
        <!-- Contenedor para los filtros de fecha -->
        <div class="row" style="margin-bottom: 20px;">
            <div class="col-md-4">
                <label>Fecha Inicio:</label>
                <input type="date" id="fechaInicio" class="form-control">
            </div>
            <div class="col-md-4">
                <label>Fecha Fin:</label>
                <input type="date" id="fechaFin" class="form-control">
            </div>
            <div class="col-md-4">
                <label>&nbsp;</label><br>
                <button id="btnFiltrar" class="btn btn-primary" style="width: 100%;" onclick="cargarDatos()">Filtrar Fechas</button>
            </div>
        </div>

        <!-- Contenedor donde se dibujará la gráfica gigante de ApexCharts -->
        <div id="chart-temperatura-detallado" style="background: white; border-radius: 8px; padding: 15px; box-shadow: 0 2px 5px rgba(0,0,0,0.1); margin-bottom: 30px;"></div>

        <!-- Tabla para ver los registros exactos de esas fechas -->
        <div class="table-responsive">
            <table class="table table-striped table-bordered" id="tablaRegistros">
                <thead>
                    <tr>
                        <th>Fecha de Registro</th>
                        <th>Temperatura (°C)</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- El contenido se llenará dinámicamente con JavaScript -->
                </tbody>
            </table>
        </div>
    </section>

    <!-- Librerías JS -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <!-- Incluimos ApexCharts -->
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

    <script>
        // Variable global para guardar la instancia de la gráfica y poder destruirla/actualizarla
        var chart;

        // Función principal que trae los datos de PHP y dibuja tanto gráfica como tabla
        function cargarDatos() {
            var fInicio = document.getElementById('fechaInicio').value;
            var fFin = document.getElementById('fechaFin').value;

            // Construimos la URL agregando los parámetros de fecha si es que el usuario seleccionó alguna
            var urlAjax = '../controllers/registros_biometricos/estadisticas_json.php?';
            if (fInicio) urlAjax += 'fecha_inicio=' + fInicio + '&';
            if (fFin) urlAjax += 'fecha_fin=' + fFin;

            $.ajax({
                url: urlAjax,
                type: 'GET',
                dataType: 'json',
                success: function(data) {
                    if (data.error) {
                        alert("Error: " + data.error);
                        return;
                    }

                    // Limpiamos la tabla
                    var tbody = $('#tablaRegistros tbody');
                    tbody.empty();

                    let fechas = [];
                    let valores = [];

                    // Llenamos los arrays para la gráfica y las filas para la tabla
                    data.forEach(function(registro) {
                        // El formato de fecha suele traer hora (ej. 2026-04-20 18:30:00)
                        let fechaSola = registro.fecha_registro.substring(0, 10);
                        let valor = parseFloat(registro.temperatura);

                        fechas.push(fechaSola);
                        valores.push(valor);

                        // Agregamos la fila a la tabla (<tr> = table row, <td> = table data/cell)
                        tbody.append(`
                            <tr>
                                <td>${registro.fecha_registro}</td>
                                <td>${valor} °C</td>
                            </tr>
                        `);
                    });

                    // Si no hay datos, mostramos un mensaje
                    if (data.length === 0) {
                        tbody.append(`<tr><td colspan="2" class="text-center">No se encontraron registros en estas fechas</td></tr>`);
                    }

                    // ==========================================
                    // CONFIGURACIÓN DE APEXCHARTS DETALLADO
                    // ==========================================
                    var opciones = {
                        series: [{
                            name: 'Temperatura (°C)',
                            data: valores // Insertamos los valores numéricos extraídos
                        }],
                        chart: {
                            type: 'line', // Usamos línea para ver claramente la evolución
                            height: 350, // Altura grande para verlo a detalle
                            zoom: {
                                enabled: true // Permite al usuario hacer zoom con el mouse
                            }
                        },
                        dataLabels: {
                            enabled: false // Ocultamos los numeritos flotando para no ensuciar la vista
                        },
                        stroke: {
                            curve: 'smooth' // Línea curva suave
                        },
                        title: {
                            text: 'Evolución de Temperatura Corporal',
                            align: 'left'
                        },
                        grid: {
                            row: {
                                colors: ['#f3f3f3', 'transparent'], // Rayado de fondo tipo cebra
                                opacity: 0.5
                            },
                        },
                        xaxis: {
                            categories: fechas, // El eje horizontal (X) será el arreglo de fechas
                            title: {
                                text: 'Fecha'
                            }
                        },
                        yaxis: {
                            title: {
                                text: 'Temperatura (°C)'
                            }
                        },
                        colors: ['#FEB019'] // Naranja/Amarillo para temperatura
                    };

                    // Si la gráfica ya existía de un filtro anterior, la destruimos para crear una nueva limpia
                    if (chart) {
                        chart.destroy();
                    }

                    // Renderizamos la gráfica en el contenedor designado
                    chart = new ApexCharts(document.querySelector("#chart-temperatura-detallado"), opciones);
                    chart.render();
                }
            });
        }

        // Cuando la página carga por primera vez, ejecutamos la función para que no salga en blanco
        $(document).ready(function() {
            cargarDatos();
        });
    </script>
</body>
</html>
