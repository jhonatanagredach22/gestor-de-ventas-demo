<?php

namespace App\Domain\Core\Entities;

use App\Domain\Core\Traits\Validaciones;
use InvalidArgumentException;

/**
 * Clase Proveedor que representa una entidad de proveedor dentro del dominio.
 * 
 * Define los atributos principales de un proveedor (ID, nombre y RUC) e incluye
 * las validaciones necesarias para asegurar la integridad de los datos.
 *
 * @package App\Domain\Core\Entities
 * @author Jhonatan J. A. C.
 * @version 1.0.0
 */

class Proveedor
{
    use Validaciones;

    /** @var int Longitud máxima permitida para el nombre del proveedor */
    const MAX_LONG = 45;

    /** @var int Longitud exacta requerida para el número de RUC */
    const MAX_LONG_RUC = 11;

    /**
     * Constructor de la clase Proveedor.
     * 
     * @param int $id Identificador único del proveedor.
     * @param string $nombre Nombre del proveedor.
     * @param int $ruc Número de RUC del proveedor (11 dígitos).
     * 
     * @throws InvalidArgumentException Si el nombre o el RUC no cumplen las validaciones.
     */
    public function __construct(
        private int $id,
        private string $nombre,
        private int $ruc,
    ) {
        $this->setNombre($nombre);
        $this->setRUC($ruc);
    }

    /**
     * Establece el nombre del proveedor aplicando validaciones específicas.
     * 
     * @param string $nombre Nombre del proveedor.
     * @return void
     * @throws InvalidArgumentException Si el nombre está vacío o excede la longitud máxima permitida.
     */
    public function setNombre(string $nombre): void
    {
        $this->nombre = $this->validarNombre($nombre, self::MAX_LONG, 'nombre del proveedor');
    }

    /**
     * Establece el número de RUC aplicando validaciones específicas.
     * 
     * @param int $ruc Número de RUC del proveedor (debe tener 11 dígitos).
     * @return void
     * @throws InvalidArgumentException Si el RUC no tiene exactamente 11 dígitos.
     */
    public function setRUC(int $ruc): void
    {
        if (strlen((string) $ruc) != self::MAX_LONG_RUC) {
            throw new InvalidArgumentException('El RUC debe ser de 11 dígitos.');
        }

        $this->ruc = $ruc;
    }

    /**
     * Retorna el nombre del proveedor.
     * 
     * @return string
     */
    public function getNombre(): string
    {
        return $this->nombre;
    }

    /**
     * Retorna el número de RUC del proveedor.
     * 
     * @return int
     */
    public function getRUC(): int
    {
        return $this->ruc;
    }

    /**
     * Retorna el identificador único del proveedor.
     * 
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }
}
