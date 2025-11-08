<?php
/**
 * Copyright 2025 Jhonatan J. A. C.
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *     http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

namespace App\Domain\Core\Entities;

use DateTime;
use InvalidArgumentException;
use App\Domain\Core\Entities\Venta;

/**
 * Clase Caja
 *
 * Representa la caja/registro de ventas del día. Permite registrar ventas,
 * calcular totales (en centavos) y cerrar la caja.
 *
 * NOTA: Los importes se manejan en centavos (int) dentro del dominio para
 * evitar errores de punto flotante.
 *
 * @package App\Domain\Core\Entities
 * @author Jhonatan J. A. C.
 * @version 1.0.0
 */
class Caja
{
    /** @var Venta[] Ventas registradas en la caja */
    private array $ventas = [];

    /** @var DateTime Fecha y hora de apertura */
    private DateTime $fechaApertura;

    /** @var DateTime|null Fecha y hora de cierre (null si no está cerrada) */
    private ?DateTime $fechaCierre = null;

    /** @var bool Indicador si la caja está cerrada */
    private bool $cerrada = false;

    public function __construct()
    {
        $this->fechaApertura = new DateTime();
    }

    /**
     * Registra una venta en la caja (solo si la caja está abierta).
     *
     * @param Venta $venta
     * @return void
     * @throws InvalidArgumentException Si la caja está cerrada.
     */
    public function registrarVenta(Venta $venta): void
    {
        if ($this->cerrada) {
            throw new InvalidArgumentException('No se pueden registrar ventas: la caja está cerrada.');
        }

        $this->ventas[] = $venta;
    }

    /**
     * Calcula el subtotal total del día en centavos.
     *
     * @return int Subtotal (centavos).
     */
    public function calcularSubtotalCentavos(): int
    {
        return array_reduce($this->ventas, function (int $carry, Venta $v): int {
            // getSubtotal() en Venta devuelve float en soles; asumimos en tu modelo que
            // internamente subtotal está en centavos. Si getSubtotal() devuelve float en soles,
            // es mejor exponer un método en Venta que retorne el subtotal en centavos.
            // Aquí asumimos que existe getSubtotalCentavos() o que podemos multiplicar.
            // Ajusta según tu implementación de Venta.
            if (method_exists($v, 'getSubtotalCentavos')) {
                return $carry + $v->getSubtotalCentavos();
            }

            // Fallback: convertir getSubtotal() (soles) a centavos
            return $carry + (int) round($v->getSubtotal() * 100);
        }, 0);
    }

    /**
     * Calcula el impuesto total (IGV) del día en centavos.
     *
     * @return int Impuesto total (centavos).
     */
    public function calcularImpuestoCentavos(): int
    {
        return array_reduce($this->ventas, function (int $carry, Venta $v): int {
            if (method_exists($v, 'getImpuestoCentavos')) {
                return $carry + $v->getImpuestoCentavos();
            }
            return $carry + (int) round($v->getImpuesto() * 100);
        }, 0);
    }

    /**
     * Calcula el total final (subtotal + impuesto - descuentos) en centavos.
     *
     * @return int Total en centavos.
     */
    public function calcularTotalCentavos(): int
    {
        return array_reduce($this->ventas, function (int $carry, Venta $v): int {
            if (method_exists($v, 'getTotalCentavos')) {
                return $carry + $v->getTotalCentavos();
            }
            return $carry + (int) round($v->getTotal() * 100);
        }, 0);
    }

    /**
     * Cierra la caja: no se permiten más registros y se establece la fecha de cierre.
     *
     * @return void
     */
    public function cerrarCaja(): void
    {
        $this->cerrada = true;
        $this->fechaCierre = new DateTime();
    }

    public function estaCerrada(): bool
    {
        return $this->cerrada;
    }

    public function getFechaApertura(): DateTime
    {
        return $this->fechaApertura;
    }

    public function getFechaCierre(): ?DateTime
    {
        return $this->fechaCierre;
    }

    /**
     * Retorna las ventas registradas (array de Venta).
     *
     * @return Venta[]
     */
    public function getVentas(): array
    {
        return $this->ventas;
    }
}
