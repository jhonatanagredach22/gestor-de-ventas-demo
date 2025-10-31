<?php

include 'autoload.php';

use App\Domain\Core\Entities\Producto;
use App\Domain\Core\Entities\Proveedor;

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
} 

catch (\InvalidArgumentException $e) {
    echo 'Validación: ' . $e->getMessage();
}
catch (\TypeError $e) {
    echo 'Un valor no cumple con el tipo de dato esperado';
}
catch (\Throwable $th) {
    echo 'Error inesperado: ' . $th->getMessage();
}

echo "\n";

try {
    $proveedorNuevo = new Proveedor(1, 'Mark Howard', 12345678910);

    echo 'Proveedor creado correctamente';
    echo "\n";
    echo $proveedorNuevo->getNombre();
} 

catch (\InvalidArgumentException $e) {
    echo 'Validación: ' . $e->getMessage();
}
catch (\TypeError $e) {
    echo 'Un valor no cumple con el tipo de dato esperado';
}
catch (\Throwable $th) {
    echo 'Error inesperado: ' . $th->getMessage();
}