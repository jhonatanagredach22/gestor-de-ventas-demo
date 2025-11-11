<?php

namespace App\Domain\Core\Repositories;

use App\Domain\Core\Entities\Caja;
use DateTime;

/**
 * Interface CajaRepositoryInterface
 *
 * Define el contrato para la persistencia y gestión de entidades Caja.
 * 
 * Esta interfaz especifica las operaciones que cualquier implementación de repositorio
 * debe proporcionar para manejar el ciclo de vida de una caja: su cierre, 
 * listado histórico y búsqueda por fecha. Su objetivo es abstraer la capa de 
 * infraestructura (por ejemplo, base de datos o almacenamiento).
 *
 * @package App\Domain\Core\Repositories
 * @author Jhonatan J. A. C.
 * @version 1.0.0
 */
interface CajaRepositoryInterface
{
    /**
     * Guarda una nueva caja abierta en el repositorio.
     *
     * @param Caja $caja
     * @return void
     */
    public function guardarCaja(Caja $caja): void;

    /**
     * Retorna la caja actualmente activa (abierta), si existe.
     *
     * @return Caja|null Caja abierta o null si no hay ninguna activa.
     */
    public function obtenerCajaActiva(): ?Caja;

    /**
     * Registra o actualiza la información de una caja cerrada.
     *
     * Este método se ejecuta cuando una caja se cierra, permitiendo
     * almacenar su información final (ventas, totales, fecha de cierre, etc.)
     * en el repositorio correspondiente.
     *
     * @param Caja $caja Instancia de la caja a persistir.
     * @return void
     */
    public function cerrarCaja(Caja $caja): void;

    /**
     * Obtiene el historial completo de cajas cerradas.
     *
     * Retorna un arreglo con todas las cajas previamente cerradas, lo cual
     * permite consultar registros históricos, generar informes o estadísticas.
     * Si no existen cajas registradas, retorna null.
     *
     * @return array<Caja>|null Lista de cajas cerradas o null si no hay registros.
     */
    public function listarCajasCerradas(): ?array;

    /**
     * Busca una caja por su identificador único.
     *
     * @param int $id Identificador de la caja.
     * @return Caja|null Caja encontrada o null si no existe.
     */
    public function buscarPorId(int $id): ?Caja;

    /**
     * Busca una caja en función de su fecha de apertura.
     *
     * Si existe una caja abierta o cerrada con la fecha especificada,
     * se devuelve la instancia correspondiente; de lo contrario, retorna null.
     *
     * @param DateTime $fecha Fecha de apertura de la caja a buscar.
     * @return Caja|null Caja encontrada o null si no existe coincidencia.
     */
    public function buscarPorFecha(DateTime $fecha): ?Caja;
}
