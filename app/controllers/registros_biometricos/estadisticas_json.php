<?php
// =========================================================================
// ARCHIVO: estadisticas_json.php
// PROPÓSITO: Sirve como una "API" interna que devuelve los datos biométricos
// del usuario logueado en formato JSON. Estos datos serán consumidos por 
// el código JavaScript de ApexCharts para dibujar las gráficas.
// =========================================================================

session_start();
include("../../config/conexion.php");

// Le decimos al navegador que le vamos a enviar datos JSON puros, no HTML
header('Content-Type: application/json');

// Por seguridad, verificamos que el usuario esté logueado
if (!isset($_SESSION['id_usuario'])) {
    echo json_encode(['error' => 'No autorizado']);
    exit();
}

// Obtenemos el ID del usuario directamente de la sesión para aislar sus datos
$id_usuario = $_SESSION['id_usuario'];

// Construimos los filtros de la consulta SQL dinámicamente
// Siempre filtramos por el id_usuario
$where_clauses = ["id_usuario = $id_usuario"];

// Si nos envían una fecha de inicio, agregamos el filtro
if (isset($_GET['fecha_inicio']) && !empty($_GET['fecha_inicio'])) {
    $fecha_inicio = $conn->real_escape_string($_GET['fecha_inicio']);
    // DATE() extrae la parte de fecha ignorando horas y minutos
    $where_clauses[] = "DATE(fecha_registro) >= '$fecha_inicio'";
}

// Si nos envían una fecha de fin, agregamos el filtro
if (isset($_GET['fecha_fin']) && !empty($_GET['fecha_fin'])) {
    $fecha_fin = $conn->real_escape_string($_GET['fecha_fin']);
    $where_clauses[] = "DATE(fecha_registro) <= '$fecha_fin'";
}

// Si nos piden específicamente la última semana (para el dashboard)
if (isset($_GET['last_week']) && $_GET['last_week'] == 'true') {
    // DATE_SUB(CURDATE(), INTERVAL 7 DAY) le resta 7 días a la fecha actual en MySQL
    $where_clauses[] = "fecha_registro >= DATE_SUB(CURDATE(), INTERVAL 7 DAY)";
}

// Unimos todas las condiciones con " AND "
$where_sql = implode(" AND ", $where_clauses);

// Hacemos la consulta obteniendo los datos relevantes y ordenados por fecha ascendente
// (las gráficas siempre deben ir de lo más viejo a lo más nuevo de izquierda a derecha)
$sql = "SELECT id_registro, id_dispositivos, ritmo_cardiaco, oxigeno, temperatura, presion_sistolica, presion_diastolica, fecha_registro 
        FROM registros_biometricos 
        WHERE $where_sql 
        ORDER BY fecha_registro ASC";

$result = $conn->query($sql);

$data = [];
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $data[] = $row; // Guardamos cada fila en nuestro arreglo
    }
}

// Convertimos el arreglo de PHP a una cadena de texto en formato JSON y lo imprimimos
echo json_encode($data);

// Cerramos conexión
$conn->close();
?>
