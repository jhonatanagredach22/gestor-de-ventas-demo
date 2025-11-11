<?php

namespace App\Application\UseCases\Proveedor;

use App\Domain\Core\Repositories\ProveedorRepositoryInterface;

/**
 * Caso de uso: Mostrar todos los proveedores registrados.
 *
 * Esta clase encapsula la lógica para obtener la lista completa
 * de proveedores desde el repositorio. Es un caso de uso de solo lectura,
 * por lo que no realiza validaciones ni modificaciones de estado.
 *
 * @package App\Application\UseCases\Proveedor
 * @author Jhonatan J. A. C.
 * @version 1.0.0
 */
class MostrarProveedoresUseCase
{
    /**
     * @var ProveedorRepositoryInterface Repositorio de proveedores.
     */
    private ProveedorRepositoryInterface $proveedorRepository;

    /**
     * Constructor que recibe la dependencia del repositorio.
     *
     * @param ProveedorRepositoryInterface $proveedorRepository
     */
    public function __construct(ProveedorRepositoryInterface $proveedorRepository)
    {
        $this->proveedorRepository = $proveedorRepository;
    }

    /**
     * Ejecuta el caso de uso.
     *
     * Recupera todos los proveedores almacenados. Si no existen proveedores
     * registrados, puede retornar un arreglo vacío o NULL según la implementación
     * del repositorio.
     *
     * @return array|null Lista de proveedores o NULL si no hay registros.
     */
    public function execute(): ?array
    {
        return $this->proveedorRepository->mostrarProveedores();
    }
}
    