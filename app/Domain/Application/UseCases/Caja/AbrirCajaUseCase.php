<?php

namespace App\Application\UseCases\Caja;

use App\Domain\Core\Repositories\CajaRepositoryInterface;
use App\Domain\Core\Entities\Caja;
use InvalidArgumentException;

/**
 * Caso de uso: Abrir Caja
 *
 * Permite crear una nueva caja siempre que no exista otra activa.
 * 
 * Reglas:
 * - Solo puede existir una caja abierta a la vez.
 * - Si ya hay una caja activa, se lanza una excepción.
 * 
 * @package App\Application\UseCases\Producto
 * @author Jhonatan J. A. C.
 * @version 1.0.0
 */
class AbrirCajaUseCase
{
    public function __construct(
        private CajaRepositoryInterface $cajaRepository
    ) {}

    /**
     * Ejecuta el caso de uso.
     *
     * @return void
     * @throws InvalidArgumentException Si ya existe una caja abierta.
     */
    public function execute(): void
    {
        $cajaActiva = $this->cajaRepository->obtenerCajaActiva();

        if ($cajaActiva !== null) {
            throw new InvalidArgumentException('Ya existe una caja activa.');
        }

        $nuevaCaja = new Caja();

        $this->cajaRepository->guardarCaja($nuevaCaja);
    }
}
