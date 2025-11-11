<?php

namespace App\Domain\Core\Repositories;

use App\Domain\Core\Entities\Informe;
use DateTime;

/**
 * Interface InformeRepositoryInterface
 *
 * Define el contrato para la persistencia y manejo de informes dentro del dominio.
 * 
 * Esta interfaz abstrae las operaciones relacionadas con la generación, eliminación,
 * búsqueda y listado de informes. Su objetivo es desacoplar la lógica de dominio
 * de la capa de infraestructura (por ejemplo, base de datos o archivos).
 *
 * @package App\Domain\Core\Repositories
 * @author Jhonatan J. A. C.
 * @version 1.0.0
 */
interface InformeRepositoryInterface
{
    /**
     * Genera un informe basado en una caja cerrada específica.
     *
     * Este método permite construir un informe a partir de las ventas y datos
     * registrados en una caja determinada por su identificador único.
     *
     * @param int $id Identificador de la caja sobre la que se generará el informe.
     * @return void
     */
    public function generarInformePorCaja(int $id): void;

    /**
     * Genera un informe a partir de un rango de fechas.
     *
     * Usa la entidad Informe para establecer el rango (fecha inicial y final),
     * validando y procesando la información de ventas u operaciones ocurridas
     * en ese intervalo.
     *
     * @param Informe $informe Entidad que define el rango de fechas del informe.
     * @return void
     */
    public function generarInformePorFechas(Informe $informe): void;

    /**
     * Elimina un informe previamente generado.
     *
     * @param int $id Identificador único del informe a eliminar.
     * @return void
     */
    public function eliminarInforme(int $id): void;

    /**
     * Retorna todos los informes generados en el sistema.
     *
     * @return Informe[]|null Lista de informes disponibles o null si no existen.
     */
    public function mostrarInformes(): ?array;

    /**
     * Busca un informe específico por su identificador.
     *
     * @param int $id Identificador del informe.
     * @return Informe|null Informe encontrado o null si no existe.
     */
    public function buscarPorId(int $id): ?Informe;

    /**
     * Busca informes generados en una fecha específica.
     *
     * @param DateTime $fecha Fecha en la que se desea buscar informes.
     * @return Informe[]|null Informes encontrados o null si no hay coincidencias.
     */
    public function buscarPorFecha(DateTime $fecha): ?array;
}
