<?php

namespace App\Domain\Core\Traits;

use InvalidArgumentException;

/**
 * Trait Validaciones
 *
 * Proporciona métodos reutilizables para realizar validaciones
 * comunes en distintas entidades del dominio, como la validación
 * de nombres u otros textos con longitud máxima.
 *
 * Este trait permite mantener una única fuente de validaciones
 * compartidas, reduciendo duplicación y mejorando la coherencia
 * entre entidades.
 *
 * @package App\Domain\Core\Traits
 * @author Jhonatan J. A. C.
 * @version 1.0.0
 */
trait Validaciones
{
    /**
     * Valida que un texto (por ejemplo, nombre o descripción) no esté vacío
     * ni exceda la longitud máxima permitida.
     *
     * @param string $nombre  Texto a validar.
     * @param int    $longitud Longitud máxima permitida.
     * @param string $campo   Nombre del campo, usado para los mensajes de error.
     * 
     * @return string Texto validado.
     * @throws InvalidArgumentException Si el texto está vacío o excede la longitud permitida.
     */
    protected function validarNombre(string $nombre, int $longitud, string $campo): string
    {
        $nombre = trim($nombre);

        if ($nombre === '') {
            $campo = str_replace(['El', 'La'], '', $campo);
            $campo = trim($campo);

            throw new InvalidArgumentException("El campo {$campo} no puede estar vacío.");
        }

        if (strlen($nombre) > $longitud) {
            throw new InvalidArgumentException("{$campo} supera los {$longitud} caracteres.");
        }

        return $nombre;
    }
}
