<?php

namespace App\Domain\Core\Repositories;

use App\Domain\Core\Entities\Proveedor;

/**
 * Interface ProveedorRepositoryInterface
 * 
 * Define el contrato que deben implementar todos los repositorios
 * encargados de gestionar los datos de los proveedores en el sistema.
 * 
 * Esta interfaz establece las operaciones CRUD básicas y sirve como
 * capa intermedia entre el dominio y la infraestructura de persistencia
 * (por ejemplo, una base de datos o una API externa).
 *
 * @package App\Domain\Core\Repositories
 * @author Jhonatan J. A. C.
 * @version 1.0.0
 */
interface ProveedorRepositoryInterface
{
    /**
     * Guarda un nuevo proveedor en el repositorio.
     *
     * @param Proveedor $proveedor Entidad Proveedor a registrar.
     * @return void
     */
    public function guardar(Proveedor $proveedor): void;

    /**
     * Actualiza los datos de un proveedor existente.
     *
     * @param Proveedor $proveedor Entidad Proveedor con los datos actualizados.
     * @return void
     */
    public function actualizar(Proveedor $proveedor): void;

    /**
     * Elimina un proveedor por su identificador.
     *
     * @param int $id Identificador único del proveedor a eliminar.
     * @return void
     */
    public function eliminar(int $id): void;

    /**
     * Retorna una lista de todos los proveedores registrados.
     *
     * Si aún no existen proveedores en el sistema, retorna null.
     *
     * @return array<Proveedor>|null Lista de proveedores o null si no hay registros.
     */
    public function mostrarProveedores(): ?array;

    /**
     * Busca un proveedor por su identificador único.
     *
     * @param int $id Identificador del proveedor a buscar.
     * @return Proveedor|null Devuelve la entidad Proveedor si existe, o null si no se encuentra.
     */
    public function mostrarPorId(int $id): ?Proveedor;
}
