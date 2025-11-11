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

use InvalidArgumentException;

/**
 * Entidad Producto
 *
 * Representa un producto dentro del dominio con sus atributos,
 * comportamiento de negocio y control de eliminación lógica.
 *
 * La eliminación lógica (soft delete) permite mantener los registros
 * en la base de datos sin mostrarlos como activos, evitando pérdida
 * de información en reportes o relaciones con otras entidades.
 *
 * @package App\Domain\Core\Entities
 * @author Jhonatan J. A. C.
 * @version 1.1.0
 */
class Producto
{
    private int $id;
    private string $nombre;
    private int $precioCompraCentavos;
    private int $precioVentaCentavos;
    private int $igvCentavos;
    private int $stock;
    private bool $isDeleted = false; // Indicador de eliminación lógica

    /**
     * Constructor de la entidad Producto.
     *
     * @param int $id Identificador único del producto.
     * @param string $nombre Nombre del producto.
     * @param int $precioCompraCentavos Precio de compra en centavos.
     * @param int $precioVentaCentavos Precio de venta en centavos.
     * @param int $igvCentavos Valor del IGV en centavos.
     * @param int $stock Cantidad disponible.
     * @param bool $isDeleted Indica si el producto fue eliminado lógicamente.
     *
     * @throws InvalidArgumentException Si se ingresan valores inválidos.
     */
    public function __construct(
        int $id,
        string $nombre,
        int $precioCompraCentavos,
        int $precioVentaCentavos,
        int $igvCentavos,
        int $stock,
        bool $isDeleted = false
    ) {
        if (empty($nombre)) {
            throw new InvalidArgumentException('El nombre del producto no puede estar vacío.');
        }

        if ($precioCompraCentavos < 0 || $precioVentaCentavos < 0 || $igvCentavos < 0) {
            throw new InvalidArgumentException('Los precios no pueden ser negativos.');
        }

        if ($stock < 0) {
            throw new InvalidArgumentException('El stock no puede ser negativo.');
        }

        $this->id = $id;
        $this->nombre = $nombre;
        $this->precioCompraCentavos = $precioCompraCentavos;
        $this->precioVentaCentavos = $precioVentaCentavos;
        $this->igvCentavos = $igvCentavos;
        $this->stock = $stock;
        $this->isDeleted = $isDeleted;
    }

    // --- Getters ---

    public function getId(): int
    {
        return $this->id;
    }
    public function getNombre(): string
    {
        return $this->nombre;
    }
    public function getPrecioCompra(): int
    {
        return $this->precioCompraCentavos;
    }
    public function getPrecioVenta(): int
    {
        return $this->precioVentaCentavos;
    }
    public function getIGV(): int
    {
        return $this->igvCentavos;
    }
    public function getStock(): int
    {
        return $this->stock;
    }
    public function estaEliminado(): bool
    {
        return $this->isDeleted;
    }

    // --- Setters ---

    public function setNombre(string $nombre): void
    {
        if (empty($nombre)) {
            throw new InvalidArgumentException('El nombre del producto no puede estar vacío.');
        }
        $this->nombre = $nombre;
    }

    public function setPrecioCompra(int $precio): void
    {
        if ($precio < 0) {
            throw new InvalidArgumentException('El precio de compra no puede ser negativo.');
        }
        $this->precioCompraCentavos = $precio;
    }

    public function setPrecioVenta(int $precio): void
    {
        if ($precio < 0) {
            throw new InvalidArgumentException('El precio de venta no puede ser negativo.');
        }
        $this->precioVentaCentavos = $precio;
    }

    public function setIGV(int $igv): void
    {
        if ($igv < 0) {
            throw new InvalidArgumentException('El IGV no puede ser negativo.');
        }
        $this->igvCentavos = $igv;
    }

    public function setStock(int $stock): void
    {
        if ($stock < 0) {
            throw new InvalidArgumentException('El stock no puede ser negativo.');
        }
        $this->stock = $stock;
    }

    // --- Métodos de negocio ---

    /**
     * Marca el producto como eliminado (soft delete).
     *
     * Esta acción no borra el registro físicamente, solo cambia su estado.
     * Se utiliza para mantener integridad con informes o relaciones.
     *
     * @return void
     */
    public function eliminar(): void
    {
        $this->isDeleted = true;
    }

    /**
     * Restaura el producto eliminado lógicamente.
     *
     * Permite recuperar un producto previamente marcado como eliminado.
     * Útil cuando se desea reactivar un registro sin crear uno nuevo.
     *
     * @return void
     */
    public function restaurar(): void
    {
        $this->isDeleted = false;
    }
}
