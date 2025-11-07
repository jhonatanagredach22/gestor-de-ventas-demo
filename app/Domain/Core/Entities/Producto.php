<?php

namespace App\Domain\Core\Entities;

use App\Domain\Core\Traits\Validaciones;
use InvalidArgumentException;

/**
 * Clase Producto que representa una entidad dentro del dominio.
 * 
 * Hereda de {@see ProductoBase} e implementa las validaciones y reglas
 * de negocio específicas para la gestión de productos (nombre, precios, stock, IGV).
 *
 * @package App\Domain\Core\Entities
 * @author Jhonatan J. A. C.
 * @version 1.0.0
 */

class Producto extends ProductoBase
{
    use Validaciones;

    /** @var int Logitud máxima permitida para el nombre del producto */
    const MAX_LONG = 50;

    /** @var int Precio máximo en centavos permitido para los precios */
    const MAX_PRECIO = 9999999;

    public function __construct(
        int $id = 0,
        string $nombre = "",
        int $precioCompraCentavos = 0,
        int $precioVentaCentavos = 0,
        int $igvCentavos = 0,
        int $stock = 0
    ) {
        // Llamada al constructor de la clase padre (equivalente a super())
        parent::__construct(
            id: $id,
            nombre: $nombre,
            precioCompraCentavos: $precioCompraCentavos,
            precioVentaCentavos: $precioVentaCentavos,
            igvCentavos: $igvCentavos,
        );

        // Agregar validación del stock
        $this->setStock($stock);
    }

    // -----------------------------------------------------------------
    // MÉTODOS COMUNES
    // -----------------------------------------------------------------

    /**
     * Establece un límite máximo para el precio del producto.
     * 
     * Este método aplica una validación general que se utiliza en los precios
     * de compra, venta e IGV, en correspondencia con los campos de la base de datos.
     * 
     * @param int $precio Precio en centavos.
     * @param string $campo Nombre del campo evaluado (compra, venta o IGV).
     * @return void
     * @throws InvalidArgumentException Si el valor proporcionado no cumple las reglas de validación.
     */
    private function setPrecioLimite(int $precio, string $campo): void
    {
        if ($precio > self::MAX_PRECIO) { // 99999.99
            $mensaje = 'El precio de ' . $campo . ' no puede superar los 99999.99';

            if ($campo == 'IGV') {
                $mensaje = 'El precio del ' . $campo . ' no puede superar los 99999.99';
            }

            throw new InvalidArgumentException($mensaje);
        }
    }

    /**
     * Establece el nombre del producto aplicando validaciones específicas.
     *
     * @param string $nombre
     * @return void
     * @throws InvalidArgumentException Si el valor proporcionado no cumple las reglas de validación.
     */
    public function setNombre(string $nombre): void
    {
        $this->nombre = $this->validarNombre($nombre, self::MAX_LONG, 'El nombre del producto');
    }

    /**
     * Establece el precio de compra aplicando validaciones específicas.
     *
     * @param int $valor Precio en centavos.
     * @return void
     * @throws InvalidArgumentException Si el valor del precio es inválido o excede los límites permitidos.
     */
    public function setPrecioCompra(int $valor): void
    {
        if ($valor <= 0) {
            throw new InvalidArgumentException('El precio debe ser mayor a 0');
        }

        if ($valor > $this->precioVentaCentavos) {
            throw new InvalidArgumentException('El precio de compra debe ser menor al precio de venta');
        }

        $this->setPrecioLimite($valor, 'compra');

        $this->precioCompraCentavos = $valor;
    }

    /**
     * Establece el precio de venta aplicando validaciones específicas.
     *
     * @param int $valor Precio en centavos.
     * @return void
     * @throws InvalidArgumentException Si el valor del precio es inválido o excede los límites permitidos.
     */
    public function setPrecioVenta(int $valor): void
    {
        if ($valor <= 0) {
            throw new InvalidArgumentException('El precio debe ser mayor a 0');
        }

        if ($valor < $this->precioCompraCentavos) {
            throw new InvalidArgumentException('El precio de venta debe ser mayor al precio de compra');
        }

        $this->setPrecioLimite($valor, 'venta');

        $this->precioVentaCentavos = $valor;
    }

    /**
     * Establece el IGV aplicando validaciones específicas.
     *
     * @param int $valor Monto total en centavos del IGV aplicado.
     * @return void
     * @throws InvalidArgumentException Si el valor del precio es inválido o excede los límites permitidos.
     */
    public function setIGV(int $valor): void
    {
        if ($valor <= 0) {
            throw new InvalidArgumentException('El precio debe ser mayor a 0');
        }

        $this->setPrecioLimite($valor, 'IGV');

        $this->igvCentavos = $valor;
    }

    /**
     * Establece la cantidad en stock del producto.
     * 
     * @param int $cantidad Stock del producto.
     * @return void
     * @throws InvalidArgumentException Si el valor proporcionado no cumple las reglas de validación.
     */
    public function setStock(int $cantidad): void
    {
        if ($cantidad < 0) {
            throw new InvalidArgumentException('La cantidad en stock no puede ser menor a 0');
        }

        $this->stock = $cantidad;
    }


    /**
     * Retorna el valor del nombre asignado.
     * 
     * @return string
     */
    public function getNombre(): string
    {
        return $this->nombre;
    }

    /**
     * Retorna el precio de compra en centavos (por ejemplo, 1250 representa S/ 12.50).
     * 
     * @return int
     */
    public function getPrecioDeCompra(): int
    {
        return $this->precioCompraCentavos;
    }

    /**
     * Retorna el precio de venta en centavos (por ejemplo, 2050 representa S/ 20.50).
     * 
     * @return int
     */
    public function getPrecioDeVenta(): int
    {
        return $this->precioVentaCentavos;
    }

    /**
     * Retorna el valor del igv en centavos (por ejemplo, 380 representa S/ 3.80).
     * 
     * @return int
     */
    public function getIGV(): int
    {
        return $this->igvCentavos;
    }

    /**
     * Retorna el identificador del producto.
     *
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * Retorna la cantidad en stock del producto
     * 
     * @return int
     */
    public function getStock(): int
    {
        return $this->stock;
    }
}
