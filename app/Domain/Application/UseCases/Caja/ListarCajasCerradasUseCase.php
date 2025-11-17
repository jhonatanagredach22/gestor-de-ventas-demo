<?php

namespace App\Application\UseCases\Caja;

use App\Domain\Core\Repositories\CajaRepositoryInterface;

/**
 * Caso de uso: Listar Cajas Cerradas
 *
 * Retorna todo el historial de cajas que han sido cerradas.
 * 
 * @package App\Application\UseCases\Producto
 * @author Jhonatan J. A. C.
 * @version 1.0.0
 */
class ListarCajasCerradasUseCase
{
    public function __construct(
        private CajaRepositoryInterface $cajaRepository
    ) {}

    /**
     * @return array|null Lista de cajas cerradas o null si no hay registros.
     */
    public function execute(): ?array
    {
        return $this->cajaRepository->listarCajasCerradas();
    }
}
