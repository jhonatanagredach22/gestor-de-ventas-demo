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

use App\Domain\Core\Entities\ProductoBase;
use DateTime;
use InvalidArgumentException;

/**
 * Clase Venta
 * 
 * Representa una entidad de venta dentro del dominio, encargada de manejar
 * los cálculos de subtotales, impuestos, descuentos y totales basados en los
 * detalles de los productos vendidos.
 * 
 * Cada detalle del arreglo `$detalles` debe incluir las claves:
 *  - `cantidad` (int): cantidad del producto.
 *  - `precio_unitario` (int): precio del producto en centavos.
 *
 * @package App\Domain\Core\Entities
 * @author Jhonatan J. A. C.
 * @version 1.0.0
 */
class Venta
{
    /** @var int Subtotal de la venta en centavos */
    private int $subtotal = 0;

    /** @var int Descuento aplicado en centavos */
    private int $descuento = 0;

    /** @var int Monto de impuesto (IGV) en centavos */
    private int $impuesto = 0;

    /** @var int Total final de la venta en centavos */
    private int $total = 0;

    /**
     * Constructor de la clase Venta.
     * 
     * @param int $id Identificador único de la venta.
     * @param DateTime $fecha Fecha en que se realizó la venta.
     * @param int|null $clienteId Identificador del cliente asociado (opcional).
     * @param array $detalles Lista de productos vendidos con cantidad y precio.
     */
    public function __construct(
        private int $id,
        private DateTime $fecha,
        public ?int $clienteId = null,
        private array $detalles = []
    ) {
        $this->calcularTotales();
    }

    /**
     * Calcula el subtotal sumando la cantidad * precio_unitario de cada producto.
     * 
     * @return void
     * @throws InvalidArgumentException Si algún detalle no contiene los campos requeridos.
     */
    private function calcularSubtotal(): void
    {
        $this->subtotal = array_reduce($this->detalles, function ($carry, $item) {
            if (!isset($item['cantidad'], $item['precio_unitario'])) {
                throw new InvalidArgumentException('Cada detalle debe tener cantidad y precio unitario.');
            }

            return $carry + ($item['cantidad'] * $item['precio_unitario']);
        }, 0);
    }

    /**
     * Calcula los valores de subtotal, impuesto y total final.
     * 
     * @return void
     */
    private function calcularTotales(): void
    {
        $this->calcularSubtotal();

        // El IGV se toma del valor definido en ProductoBase::IGV
        $this->impuesto = (int) round($this->subtotal * ProductoBase::IGV / 100);

        // Total = Subtotal + Impuesto - Descuento
        $this->total = $this->subtotal + $this->impuesto - $this->descuento;
    }

    /**
     * Aplica un descuento a la venta y recalcula los totales.
     * 
     * @param int $monto Monto del descuento en centavos.
     * @return void
     * @throws InvalidArgumentException Si el descuento es negativo.
     */
    public function aplicarDescuento(int $monto): void
    {
        if ($monto < 0) {
            throw new InvalidArgumentException('El descuento no puede ser negativo.');
        }

        $this->descuento = $monto;
        $this->calcularTotales();
    }

    /**
     * Retorna el subtotal en soles.
     * 
     * @return float Subtotal convertido a soles.
     */
    public function getSubtotal(): float
    {
        return $this->subtotal / 100;
    }

    /**
     * Retorna el impuesto (IGV) en soles.
     * 
     * @return float Impuesto convertido a soles.
     */
    public function getImpuesto(): float
    {
        return $this->impuesto / 100;
    }

    /**
     * Retorna el total final de la venta en soles.
     * 
     * @return float Total convertido a soles.
     */
    public function getTotal(): float
    {
        return $this->total / 100;
    }

    /**
     * Retorna el subtotal de la venta en centavos.
     * 
     * Este valor representa el monto total antes de aplicar impuestos
     * o descuentos. Por ejemplo, 1250 equivale a S/ 12.50.
     * 
     * @return int Subtotal en centavos.
     */
    public function getSubtotalCentavos(): int
    {
        return $this->subtotal;
    }

    /**
     * Retorna el impuesto aplicado a la venta en centavos.
     * 
     * Por ejemplo, 380 equivale a S/ 3.80.
     * 
     * @return int Impuesto en centavos.
     */
    public function getImpuestoCentavos(): int
    {
        return $this->impuesto;
    }

    /**
     * Retorna el total final de la venta en centavos.
     * 
     * Incluye subtotal, impuestos y descuentos aplicados.
     * Por ejemplo, 1630 equivale a S/ 16.30.
     * 
     * @return int Total en centavos.
     */
    public function getTotalCentavos(): int
    {
        return $this->total;
    }

    /**
     * Retorna la lista de productos vendidos.
     * 
     * @return array Detalles de la venta (cantidad y precio unitario).
     */
    public function getDetalles(): array
    {
        return $this->detalles;
    }

    /**
     * Retorna la fecha de la venta.
     * 
     * @return DateTime
     */
    public function getFecha(): DateTime
    {
        return $this->fecha;
    }

    /**
     * Retorna el identificador de la venta.
     *
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }
}
