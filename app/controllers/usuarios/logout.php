<?php
    // =========================================================================
    // ARCHIVO: logout.php (CIERRE DE SESIÓN)
    // PROPÓSITO: Cuando en la barra de navegación cliqueas "Cerrar Sesión", 
    // entras un microsegundo a este puente, se evaporan tus variables Mágicas
    // y te devuelven sin pase de acceso al inicio.
    // =========================================================================
    session_start(); // Inicias/reconoces la bolsa con los datos existentes en memoria...
    session_unset(); // ...Vacias el contenido de las variables (Nombre, id, nivel)...
    session_destroy(); // ... Y finalmente aniquilas el pase temporal por completo de este navegador.
    
    // Expulsado de vuelta a pantalla gráfica pública.
    header("Location: ../../views/login.html");
    exit(); // Exit previene que se lance por error un bucle infinito o se lean líneas por debajo en caso extremo.
?>