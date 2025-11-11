<?php

namespace App\Application\UseCases\Producto;

use App\Domain\Core\Entities\Producto;
use App\Domain\Core\Repositories\ProductoRepositoryInterface;
use InvalidArgumentException;

/**
 * Caso de uso: RegistrarProductoUseCase
 * 
 * Se encarga de gestionar el proceso de registro de un nuevo producto en el sistema.
 * Este caso de uso valida que no exista otro producto con el mismo nombre antes
 * de persistir la nueva instancia en el repositorio.
 * 
 * La validación evita duplicidades y mantiene la integridad del inventario.
 *
 * @package App\Application\UseCases\Producto
 * @author Jhonatan J. A. C.
 * @version 1.0.0
 */
class RegistrarProductoUseCase
{
    /**
     * Constructor de la clase.
     *
     * @param ProductoRepositoryInterface $productoRepository Repositorio encargado de la persistencia de productos.
     */
    public function __construct(
        private ProductoRepositoryInterface $productoRepository
    ) {}

    /**
     * Ejecuta el flujo de registro de un nuevo producto.
     *
     * - Verifica si ya existe un producto con el mismo nombre en el repositorio.
     * - Si existe, lanza una excepción para evitar duplicados.
     * - Si no existe, crea una nueva instancia de Producto y la guarda.
     *
     * @param int $id Identificador del producto.
     * @param string $nombre Nombre del producto.
     * @param int $precioCompraCentavos Precio de compra expresado en centavos.
     * @param int $precioVentaCentavos Precio de venta expresado en centavos.
     * @param int $igvCentavos Valor del IGV expresado en centavos.
     * @param int $stock Cantidad disponible en inventario.
     * 
     * @throws InvalidArgumentException Si ya existe un producto con el mismo nombre.
     * @return void
     */
    public function execute(
        int $id,
        string $nombre,
        int $precioCompraCentavos,
        int $precioVentaCentavos,
        int $igvCentavos,
        int $stock
    ): void {
        // Verifica si el nombre del producto ya está registrado
        $validarProductoDuplicado = $this->productoRepository->buscarPorNombre($nombre);

        if ($validarProductoDuplicado !== NULL) {
            throw new InvalidArgumentException('Ya existe un producto con el nombre ingresado.');
        }

        // Crea una nueva instancia de producto con los datos proporcionados
        $nuevoProducto = new Producto(
            $id,
            $nombre,
            $precioCompraCentavos,
            $precioVentaCentavos,
            $igvCentavos,
            $stock
        );

        // Persiste el nuevo producto en el repositorio
        $this->productoRepository->guardar($nuevoProducto);
    }
}
