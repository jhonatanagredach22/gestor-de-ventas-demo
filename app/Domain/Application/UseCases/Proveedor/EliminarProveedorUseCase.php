<?php

namespace App\Application\UseCases\Proveedor;

use App\Domain\Core\Entities\Proveedor;
use App\Domain\Core\Repositories\ProveedorRepositoryInterface;
use InvalidArgumentException;

/**
 * Caso de uso: Eliminar un proveedor del sistema.
 *
 * Esta clase encapsula la lógica de negocio necesaria para eliminar un proveedor
 * de forma segura. Antes de proceder con la eliminación, verifica:
 *   - Que el proveedor realmente exista.
 *   - Que no tenga productos asociados (ya que su eliminación podría afectar la integridad de datos).
 *
 * Si cualquiera de estas condiciones no se cumple, lanza una excepción con un mensaje descriptivo.
 *
 * @package App\Application\UseCases\Proveedor
 * @author Jhonatan J. A. C.
 * @version 1.0.0
 */
class EliminarProveedorUseCase
{
    /**
     * Inyección del repositorio de proveedores.
     *
     * @param ProveedorRepositoryInterface $proveedorRepository Repositorio que gestiona la persistencia de proveedores.
     */
    public function __construct(
        private ProveedorRepositoryInterface $proveedorRepository
    ) {}

    /**
     * Ejecuta el proceso de eliminación de un proveedor.
     *
     * @param int $id Identificador único del proveedor a eliminar.
     * @return void
     * 
     * @throws InvalidArgumentException Si el proveedor no existe o si tiene productos asociados.
     */
    public function execute(int $id): void
    {
        // Verifica si el proveedor existe en el repositorio.
        $proveedorExistente = $this->proveedorRepository->mostrarPorId($id);

        if ($proveedorExistente === NULL) {
            throw new InvalidArgumentException('El proveedor no existe.');
        }

        // Comprueba si el proveedor tiene productos registrados.
        $existenciaProductos = $this->proveedorRepository->verificarExistenciaProductos($id);

        if ($existenciaProductos === TRUE) {
            throw new InvalidArgumentException('El proveedor tiene productos registrados.');
        }

        // Si pasa las validaciones, procede a eliminarlo.
        $this->proveedorRepository->eliminar($id);
    }
}
