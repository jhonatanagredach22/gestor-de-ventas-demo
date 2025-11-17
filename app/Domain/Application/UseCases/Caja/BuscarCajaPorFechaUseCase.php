<?php

namespace App\Application\UseCases\Caja;

use App\Domain\Core\Repositories\CajaRepositoryInterface;
use DateTime;

/**
 * Caso de uso: Buscar Caja por Fecha
 *
 * Retorna la caja (abierta o cerrada) cuya fecha de apertura coincida
 * con la fecha solicitada.
 * 
 * @package App\Application\UseCases\Producto
 * @author Jhonatan J. A. C.
 * @version 1.0.0
 */
class BuscarCajaPorFechaUseCase
{
    public function __construct(
        private CajaRepositoryInterface $cajaRepository
    ) {}

    /**
     * @param DateTime $fecha Fecha a buscar.
     * @return mixed Caja encontrada o null si no existe.
     */
    public function execute(DateTime $fecha)
    {
        return $this->cajaRepository->buscarPorFecha($fecha);
    }
}