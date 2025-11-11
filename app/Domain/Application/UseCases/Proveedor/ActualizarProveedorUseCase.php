<?php

namespace App\Application\UseCases\Proveedor;

use App\Domain\Core\Entities\Proveedor;
use App\Domain\Core\Repositories\ProveedorRepositoryInterface;
use InvalidArgumentException;

/**
 * Caso de uso: ActualizarProveedorUseCase
 * 
 * Permite modificar los datos de un proveedor existente.
 * Antes de actualizar, valida que el proveedor exista y que
 * el nuevo nombre o RUC no estén siendo utilizados por otro registro.
 * 
 * @package App\Application\UseCases\Proveedor
 * @author Jhonatan J. A. C.
 * @version 1.0.0
 */
class ActualizarProveedorUseCase
{
    public function __construct(
        private ProveedorRepositoryInterface $proveedorRepository
    ) {}

    /**
     * Ejecuta el proceso de actualización de un proveedor.
     *
     * @param int $id Identificador del proveedor.
     * @param string $nombre Nuevo nombre del proveedor.
     * @param int $ruc Nuevo RUC del proveedor.
     * 
     * @throws InvalidArgumentException Si el proveedor no existe o los datos están duplicados.
     * @return void
     */
    public function execute(int $id, string $nombre, int $ruc): void
    {
        // Verificar que el proveedor exista
        $proveedor = $this->proveedorRepository->mostrarPorId($id);
        if ($proveedor === null) {
            throw new InvalidArgumentException('El proveedor no existe.');
        }

        // Validar duplicado de nombre (en otro proveedor)
        $proveedorDuplicado = $this->proveedorRepository->buscarPorNombre($nombre);
        if ($proveedorDuplicado !== null && $proveedorDuplicado->getId() !== $id) {
            throw new InvalidArgumentException('Ya existe otro proveedor con el nombre ingresado.');
        }

        // Validar duplicado de RUC (en otro proveedor)
        $proveedorDuplicado = $this->proveedorRepository->buscarPorRuc($ruc);
        if ($proveedorDuplicado !== null && $proveedorDuplicado->getId() !== $id) {
            throw new InvalidArgumentException('Ya existe otro proveedor con el RUC ingresado.');
        }

        // Actualizar datos en la entidad
        $proveedor->setNombre($nombre);
        $proveedor->setRuc($ruc);

        // Persistir cambios
        $this->proveedorRepository->actualizar($proveedor);
    }
}
