<?php

namespace App\Application\UseCases\Producto;

use App\Domain\Core\Entities\Producto;
use App\Domain\Core\Repositories\ProductoRepositoryInterface;
use InvalidArgumentException;

/**
 * Caso de uso encargado de actualizar los datos de un producto existente.
 *
 * Verifica la existencia del producto, evita duplicados y actualiza
 * los valores en el repositorio correspondiente.
 *
 * @package App\Application\UseCases\Producto
 * @author Jhonatan J. A. C.
 * @version 1.0.0
 */
class ActualizarProductoUseCase
{
    public function __construct(
        private ProductoRepositoryInterface $productoRepository
    ) {}

    /**
     * Actualiza la información de un producto existente.
     *
     * @param int $id ID único del producto.
     * @param string $nombre Nuevo nombre del producto.
     * @param int $precioCompraCentavos Nuevo precio de compra en centavos.
     * @param int $precioVentaCentavos Nuevo precio de venta en centavos.
     * @param int $igvCentavos Nuevo valor del IGV en centavos.
     * @param int $stock Nuevo stock del producto.
     *
     * @throws InvalidArgumentException Si el producto no existe o hay duplicidad de nombre.
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
        // Buscar el producto en el repositorio por su ID.
        $producto = $this->productoRepository->buscarPorId($id);

        // Validar que el producto exista.
        if ($producto === NULL) {
            throw new InvalidArgumentException('El producto no existe.');
        }

        // Verificar que no esté eliminado lógicamente.
        if (!$producto->estaEliminado()) {
            throw new InvalidArgumentException('El producto ha sido eliminado y no puede modificarse.');
        }

        // Validar duplicidad de nombre.
        $productoDuplicado = $this->productoRepository->buscarPorNombre($nombre);

        if ($productoDuplicado !== NULL && $productoDuplicado->getId() !== $id) {
            throw new InvalidArgumentException('Ya existe otro producto con este nombre.');
        }

        // Actualizar los datos del producto.
        $producto->setNombre($nombre);
        $producto->setPrecioCompra($precioCompraCentavos);
        $producto->setPrecioVenta($precioVentaCentavos);
        $producto->setIGV($igvCentavos);
        $producto->setStock($stock);

        // Persistir los cambios en el repositorio.
        $this->productoRepository->actualizar($producto);
    }
}