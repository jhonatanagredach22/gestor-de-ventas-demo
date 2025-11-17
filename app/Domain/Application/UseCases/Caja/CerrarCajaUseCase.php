<?php

namespace App\Application\UseCases\Caja;

use App\Domain\Core\Repositories\CajaRepositoryInterface;
use InvalidArgumentException;

/**
 * Caso de uso: Cerrar Caja
 *
 * Marca la caja activa como cerrada y la persiste.
 *
 * Reglas:
 * - Debe existir una caja abierta.
 * - Si ya está cerrada, no debe cerrarse de nuevo.
 * 
 * @package App\Application\UseCases\Producto
 * @author Jhonatan J. A. C.
 * @version 1.0.0
 */
class CerrarCajaUseCase
{
    public function __construct(
        private CajaRepositoryInterface $cajaRepository
    ) {}

    /**
     * @return void
     * @throws InvalidArgumentException Si no existe caja activa o ya está cerrada.
     */
    public function execute(): void
    {
        $caja = $this->cajaRepository->obtenerCajaActiva();

        if ($caja === null) {
            throw new InvalidArgumentException('No existe una caja activa para cerrar.');
        }

        if ($caja->estaCerrada()) {
            throw new InvalidArgumentException('La caja ya está cerrada.');
        }

        $caja->cerrarCaja();

        $this->cajaRepository->cerrarCaja($caja);
    }
}
