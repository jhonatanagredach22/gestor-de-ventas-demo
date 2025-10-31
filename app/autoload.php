<?php

/**
 * Autoloader básico mejorado para el proyecto.
 *
 * Carga automáticamente todas las clases bajo el namespace App\
 * sin necesidad de usar require o include manualmente.
 *
 * @author  Jhonatan J. A. C.
 * @version 1.1.1
 */

spl_autoload_register(function (string $clase): void {
    // Asegurar que la clase pertenezca al namespace App\
    if (!str_starts_with($clase, 'App\\')) {
        return;
    }

    // Convertir el namespace a una ruta de archivo
    $archivo = str_replace('\\', '/', $clase) . '.php';

    // Construir la ruta absoluta (segura en Windows/Linux)
    $ruta = __DIR__ . str_replace('App', '', $archivo);
    $ruta = str_replace(['\\', '/'], DIRECTORY_SEPARATOR, $ruta);

    // Verificar si el archivo es accesible y cargarlo
    if (is_readable($ruta)) {
        require_once $ruta;
    } else {
        // Registrar en log si no se puede cargar
        error_log("[Autoload] No se pudo cargar la clase {$clase} desde {$ruta}");
    }
});
