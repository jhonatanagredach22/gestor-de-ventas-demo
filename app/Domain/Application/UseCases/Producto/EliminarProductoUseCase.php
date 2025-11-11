<?php

namespace App\Application\UseCases\Producto;

use App\Domain\Core\Repositories\ProductoRepositoryInterface;
use App\Domain\Core\Repositories\VentaRepositoryInterface;
use InvalidArgumentException;

/**
 * Caso de uso: Eliminar producto (soft delete)
 *
 * Esta clase encapsula la lógica de negocio para la eliminación lógica de un producto.
 * Antes de eliminar, valida:
 * - Que el producto exista.
 * - Que no esté vinculado a ventas activas.
 *
 * En lugar de eliminar el registro físicamente, marca el producto como eliminado
 * (soft delete) para preservar su integridad en informes y relaciones históricas.
 *
 * @package App\Application\UseCases\Producto
 * @author Jhonatan J. A. C.
 * @version 1.0.0
 */
class EliminarProductoUseCase
{
    /**
     * @param ProductoRepositoryInterface $productoRepository Repositorio de productos.
     * @param VentaRepositoryInterface $ventaRepository Repositorio de ventas (para verificar dependencias).
     */
    public function __construct(
        private ProductoRepositoryInterface $productoRepository,
        private VentaRepositoryInterface $ventaRepository
    ) {}

    /**
     * Ejecuta la eliminación lógica de un producto.
     *
     * @param int $id Identificador del producto a eliminar.
     * @return void
     *
     * @throws InvalidArgumentException Si el producto no existe o está vinculado a ventas activas.
     */
    public function execute(int $id): void
    {
        // Verificar existencia del producto
        $producto = $this->productoRepository->buscarPorId($id);

        if ($producto === null) {
            throw new InvalidArgumentException('El producto no existe.');
        }

        // Evitar eliminar si está vinculado a ventas activas
        $tieneVentas = $this->ventaRepository->verificarExistenciaProductoEnVentas($id);

        if ($tieneVentas === true) {
            throw new InvalidArgumentException('No se puede eliminar el producto, está vinculado a ventas activas.');
        }

        // Aplicar eliminación lógica (soft delete)
        $producto->eliminar();

        // Persistir cambios en el repositorio
        $this->productoRepository->actualizar($producto);
    }
}