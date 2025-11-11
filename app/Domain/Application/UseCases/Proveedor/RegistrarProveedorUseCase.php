<?php

namespace App\Application\UseCases\Proveedor;

use App\Domain\Core\Entities\Proveedor;
use App\Domain\Core\Repositories\ProveedorRepositoryInterface;
use InvalidArgumentException;

/**
 * Caso de uso: RegistrarProveedorUseCase
 * 
 * Este caso de uso se encarga de orquestar la lógica necesaria para registrar
 * un nuevo proveedor en el sistema. Antes de realizar el registro, se valida 
 * que no existan proveedores con el mismo nombre o RUC, garantizando la 
 * unicidad de estos campos dentro del repositorio.
 *
 * Forma parte de la capa de aplicación, sirviendo como intermediario entre
 * el dominio y la infraestructura (por ejemplo, controladores o servicios externos).
 * 
 * @package App\Application\UseCases\Proveedor
 * @author Jhonatan J. A. C.
 * @version 1.0.0
 */
class RegistrarProveedorUseCase
{
    /**
     * Constructor del caso de uso.
     *
     * @param ProveedorRepositoryInterface $proveedorRepository
     *        Repositorio encargado de la persistencia de proveedores.
     */
    public function __construct(
        private ProveedorRepositoryInterface $proveedorRepository
    ) {}

    /**
     * Ejecuta el proceso de registro de un nuevo proveedor.
     *
     * Verifica previamente que no existan proveedores con el mismo nombre o RUC.
     * Si alguna de estas condiciones se cumple, lanza una excepción para evitar duplicados.
     *
     * @param int $id Identificador único del proveedor.
     * @param string $nombre Nombre del proveedor.
     * @param int $ruc Número de RUC del proveedor.
     * 
     * @throws InvalidArgumentException Si el nombre o RUC ya existen en el repositorio.
     * @return void
     */
    public function execute(int $id, string $nombre, int $ruc): void
    {
        // Verifica si ya existe un proveedor con el mismo nombre
        $proveedorExistente = $this->proveedorRepository->buscarPorNombre($nombre);
        if ($proveedorExistente !== null) {
            throw new InvalidArgumentException('Ya existe un proveedor con el nombre ingresado.');
        }

        // Verifica si ya existe un proveedor con el mismo RUC
        $proveedorExistente = $this->proveedorRepository->buscarPorRuc($ruc);
        if ($proveedorExistente !== null) {
            throw new InvalidArgumentException('Ya existe un proveedor con el RUC ingresado.');
        }

        // Crea la nueva entidad Proveedor y la guarda en el repositorio
        $proveedor = new Proveedor($id, $nombre, $ruc);
        $this->proveedorRepository->guardar($proveedor);
    }
}
