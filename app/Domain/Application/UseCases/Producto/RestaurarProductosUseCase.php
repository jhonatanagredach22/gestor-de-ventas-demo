<?php

namespace App\Application\UseCases\Producto;

use App\Domain\Core\Repositories\ProductoRepositoryInterface;
use InvalidArgumentException;

/**
 * Caso de uso: Restaurar un producto eliminado lógicamente.
 *
 * Permite volver a habilitar un producto previamente eliminado
 * sin necesidad de crear uno nuevo. Este proceso garantiza que
 * la integridad de los datos (como informes o relaciones con ventas)
 * no se pierda, ya que el registro original se conserva.
 *
 * @package App\Application\UseCases\Producto
 * @author Jhonatan J. A. C.
 * @version 1.0.0
 */
class RestaurarProductoUseCase
{
    /**     
     * @param ProductoRepositoryInterface $productoRepository
     * Repositorio encargado de gestionar las operaciones de persistencia de productos.
     */
    public function __construct(
        private ProductoRepositoryInterface $productoRepository
    ) {}

    /**
     * Ejecuta el proceso de restauración de un producto.
     *
     * @param int $id Identificador único del producto a restaurar.
     *
     * @throws InvalidArgumentException Si el producto no existe o ya está activo.
     * @return void
     */
    public function execute(int $id): void
    {
        // Buscar el producto por su ID.
        $producto = $this->productoRepository->buscarPorId($id);

        // Validar existencia.
        if ($producto === NULL) {
            throw new InvalidArgumentException('El producto no existe.');
        }

        // Validar que el producto esté realmente eliminado.
        if (!$producto->estaEliminado()) {
            throw new InvalidArgumentException('El producto ya está activo, no es necesario restaurarlo.');
        }

        // Restaurar el estado lógico del producto.
        $producto->restaurar();

        // Persistir los cambios en el repositorio.
        $this->productoRepository->actualizar($producto);
    }
}
