<?php

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

    /** @var DateTime Fecha de la venta */
    private DateTime $fecha;

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
        DateTime $fecha,
        public ?int $clienteId = null,
        private array $detalles = []
    ) {
        $this->fecha = $fecha;
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
