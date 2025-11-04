<?php

namespace App\Domain\Core\Entities;

use InvalidArgumentException;
use DateTime;

/**
 * Clase Informe que representa un informe generado en el sistema.
 * 
 * Esta entidad define el rango de fechas asociado al informe y valida que 
 * la fecha final no sea anterior a la inicial. No gestiona consultas ni 
 * listados de informes, su propósito es representar los datos base de uno.
 *
 * @package App\Domain\Core\Entities
 * @author Jhonatan J. A. C.
 * @version 1.0.0
 */
class Informe
{
    /**
     * Crea una nueva instancia del informe con las fechas validadas.
     *
     * @param int $id Identificador único del informe.
     * @param DateTime $fechaInicial Fecha de inicio del rango del informe.
     * @param DateTime $fechaFinal Fecha de fin del rango del informe.
     * 
     * @throws InvalidArgumentException Si la fecha final es anterior a la inicial.
     */
    public function __construct(
        private int $id,
        public readonly DateTime $fechaInicial,
        public readonly DateTime $fechaFinal
    ) {
        if ($fechaFinal < $fechaInicial) {
            throw new InvalidArgumentException('La fecha final no puede ser anterior a la fecha inicial.');
        }
    }

    /**
     * Retorna el identificador único del informe.
     *
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }
}
