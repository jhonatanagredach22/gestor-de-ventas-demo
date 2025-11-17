<?php

namespace App\Application\UseCases\Caja;

use App\Domain\Core\Repositories\CajaRepositoryInterface;
use App\Domain\Core\Entities\Venta;
use InvalidArgumentException;

/**
 * Caso de uso: Registrar Venta en Caja
 *
 * Agrega una venta a la caja activa.
 *
 * Reglas:
 * - Debe existir una caja abierta.
 * - La caja no puede estar cerrada.
 * 
 * @package App\Application\UseCases\Producto
 * @author Jhonatan J. A. C.
 * @version 1.0.0
 */
class RegistrarVentaUseCase
{
    public function __construct(
        private CajaRepositoryInterface $cajaRepository
    ) {}

    /**
     * @param Venta $venta Venta a registrar.
     * @return void
     * @throws InvalidArgumentException Si no existe caja activa o está cerrada.
     */
    public function execute(Venta $venta): void
    {
        $caja = $this->cajaRepository->obtenerCajaActiva();

        if ($caja === null) {
            throw new InvalidArgumentException('No existe una caja activa.');
        }

        if ($caja->estaCerrada()) {
            throw new InvalidArgumentException('La caja está cerrada.');
        }

        $caja->registrarVenta($venta);

        // Persistimos el estado actualizado
        $this->cajaRepository->guardarCaja($caja);
    }
}
