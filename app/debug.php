<?php

include 'autoload.php';

use App\Domain\Core\Entities\Informe;
use App\Domain\Core\Entities\Producto;
use App\Domain\Core\Entities\Proveedor;
use App\Domain\Core\Entities\Venta;
use App\Domain\Core\Entities\Usuario;

// Prueba de la clase Producto

try {
    $gaseosa = new Producto(
        id: 2,
        nombre: 'Gaseosa    ',
        precioVentaCentavos: 325,
        igvCentavos: 115,
        precioCompraCentavos: 210,
        stock: 2
    );

    echo 'Producto creado correctamente';
    echo "\n";
    echo number_format($gaseosa->getIGV() / 100, 2, '.', '');
    echo "\n";
    echo $gaseosa->getNombre();
} catch (\InvalidArgumentException $e) {
    echo 'Validación: ' . $e->getMessage();
} catch (\TypeError $e) {
    echo 'Un valor no cumple con el tipo de dato esperado';
} catch (\Throwable $th) {
    echo 'Error inesperado: ' . $th->getMessage();
}

echo "\n";

// Prueba de la clase Proveedor

try {
    $proveedorNuevo = new Proveedor(1, 'Mark Howard', 12345678910);

    echo 'Proveedor creado correctamente';
    echo "\n";
    echo $proveedorNuevo->getNombre();
} catch (\InvalidArgumentException $e) {
    echo 'Validación: ' . $e->getMessage();
} catch (\TypeError $e) {
    echo 'Un valor no cumple con el tipo de dato esperado';
} catch (\Throwable $th) {
    echo 'Error inesperado: ' . $th->getMessage();
}

echo "\n";

// Prueba de la clase Venta

try {
    $nuevaVenta = new Venta(
        fecha: new DateTime(datetime: 'now'),
        id: 1,
        detalles: [
            ['cantidad' => 2, 'precio_unitario' => 1050],
            ['cantidad' => 1, 'precio_unitario' => 500],
        ]
    );

    $nuevaVenta->aplicarDescuento(300);

    echo "Subtotal: " . $nuevaVenta->getSubtotal() . PHP_EOL;
    echo "Impuesto: " . $nuevaVenta->getImpuesto() . PHP_EOL;
    echo "Total: " . $nuevaVenta->getTotal() . PHP_EOL;
    echo "Fecha: " . $nuevaVenta->getFecha()->format('Y-m-d');
} catch (\InvalidArgumentException $e) {
    echo 'Validación: ' . $e->getMessage();
} catch (\TypeError $e) {
    echo 'Un valor no cumple con el tipo de dato esperado';
} catch (\Throwable $th) {
    echo 'Error inesperado: ' . $th->getMessage();
}

echo "\n";

// Prueba de la clase Informe

try {
    $nuevoInforme = new Informe(1, new DateTime('2025-01-10'), new DateTime('2025-05-10'));
    echo 'Informe creado correctamente';
    echo "\n";
} catch (\InvalidArgumentException $e) {
    echo 'Validación: ' . $e->getMessage();
} catch (\TypeError $e) {
    echo 'Un valor no cumple con el tipo de dato esperado';
} catch (\Throwable $th) {
    echo 'Error inesperado: ' . $th->getMessage();
}

echo "\n";

// Prueba de la clase Usuario

try {
    $nuevoUsuario = new Usuario('jhonatan', '12345678');
    echo 'Usuario creado correctamente';
    echo "\n";
    echo Usuario::createUsername('user2003');
    echo "\n";
    echo Usuario::createPassword('nI/0"v<&Y46R');
    echo "\n";
} catch (\InvalidArgumentException $e) {
    echo 'Validación: ' . $e->getMessage();
} catch (\TypeError $e) {
    echo 'Un valor no cumple con el tipo de dato esperado';
} catch (\Throwable $th) {
    echo 'Error inesperado: ' . $th->getMessage();
}
