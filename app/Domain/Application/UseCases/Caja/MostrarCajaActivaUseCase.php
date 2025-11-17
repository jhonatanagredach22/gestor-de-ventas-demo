<?php

namespace App\Application\UseCases\Caja;

use App\Domain\Core\Repositories\CajaRepositoryInterface;
use App\Domain\Core\Entities\Caja;

/**
 * Caso de uso: Mostrar Caja Activa
 *
 * Retorna la caja actualmente abierta, si existe.
 * 
 * @package App\Application\UseCases\Producto
 * @author Jhonatan J. A. C.
 * @version 1.0.0
 */
class MostrarCajaActivaUseCase
{
    public function __construct(
        private CajaRepositoryInterface $cajaRepository
    ) {}

    /**
     * @return Caja|null Caja activa o null si no existe.
     */
    public function execute(): ?Caja
    {
        return $this->cajaRepository->obtenerCajaActiva();
    }
}
