<?php

namespace App\Domain\Core\Repositories;

use App\Domain\Core\Entities\Venta;
use DateTime;

/**
 * Interface VentaRepositoryInterface
 * 
 * Define el contrato para la gestión de ventas dentro del sistema.
 * 
 * Esta interfaz establece las operaciones principales que deben implementarse
 * en cualquier repositorio que maneje entidades de tipo Venta, incluyendo
 * la inserción, eliminación, listado general y búsqueda por fecha.
 *
 * @package App\Domain\Core\Repositories
 * @author Jhonatan J. A. C.
 * @version 1.0.0
 */
interface VentaRepositoryInterface
{
    /**
     * Registra una nueva venta en el repositorio.
     *
     * @param Venta $venta Entidad de venta a registrar.
     * @return void
     */
    public function agregarVenta(Venta $venta): void;

    /**
     * Elimina una venta existente según su identificador.
     *
     * @param int $id Identificador único de la venta a eliminar.
     * @return void
     */
    public function eliminarVenta(int $id): void;

    /**
     * Retorna todas las ventas registradas.
     *
     * Devuelve un arreglo con todas las ventas almacenadas en el sistema.
     * Si aún no existen ventas registradas, retorna null.
     *
     * @return array<Venta>|null Lista de ventas o null si no hay registros.
     */
    public function mostrarVentas(): ?array;

    /**
     * Busca las ventas realizadas en una fecha específica.
     *
     * @param DateTime $fecha Fecha de búsqueda.
     * @return Venta[]|null Lista de ventas encontradas o null si no existen registros.
     */
    public function buscarPorFecha(DateTime $fecha): ?array;
}
