<?php

namespace App\Domain\Core\Entities;

/**
 * Clase abstracta base para entidades de tipo Producto.
 *
 * Define los atributos comunes y la interfaz básica para productos,
 * permitiendo que las subclases concreten la implementación de sus
 * validaciones y comportamientos específicos.
 *
 * @package App\Domain\Core\Entities
 * @author Jhonatan J. A. C.
 * @version 1.0.0
 */

abstract class ProductoBase
{
    /** @var float IGV estándar aplicado en Perú (18%) */
    const IGV = 0.18;

    /**
     * Constructor base del producto.
     *
     * @param int $id Identificador del producto.
     * @param string $nombre Nombre del producto.
     * @param int $precioCompraCentavos Precio de compra en centavos.
     * @param int $precioVentaCentavos Precio de venta en centavos.
     * @param int $igvCentavos Monto de IGV.
     * @param int $stock Cantidad disponible.
     */

    public function __construct(

        protected int $id = 0,

        protected string $nombre = "",

        protected int $precioCompraCentavos = 0,

        protected int $precioVentaCentavos = 0,

        protected int $igvCentavos = 0,

        protected int $stock = 0
    ) {
        $this->setNombre($nombre);
        $this->setPrecioCompra($precioCompraCentavos);
        $this->setPrecioVenta($precioVentaCentavos);
        $this->setIGV($igvCentavos);
    }

    // -----------------------------------------------------------------
    // MÉTODOS ABSTRACTOS
    // -----------------------------------------------------------------

    /**
     * Establece el nombre del producto aplicando validaciones específicas.
     *
     * @param string $nombre
     * @return void
     * @throws \InvalidArgumentException Si el nombre no cumple las reglas.
     */
    abstract public function setNombre(string $nombre): void;

    /**
     * Establece el precio de compra aplicando validaciones específicas.
     *
     * @param int $valor Precio en centavos.
     * @return void
     * @throws \InvalidArgumentException Si el valor es inválido.
     */
    abstract public function setPrecioCompra(int $valor): void;

    /**
     * Establece el precio de venta aplicando validaciones específicas.
     *
     * @param int $valor Precio en centavos.
     * @return void
     * @throws \InvalidArgumentException Si el valor es inválido.
     */
    abstract public function setPrecioVenta(int $valor): void;

    /**
     * Establece el IGV aplicando validaciones específicas.
     *
     * @param int $igv Monto de IGV en centavos.
     * @return void
     * @throws \InvalidArgumentException Si el valor no está en rango válido.
     */
    abstract public function setIGV(int $igv): void;
}
