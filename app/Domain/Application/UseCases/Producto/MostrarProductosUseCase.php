<?php

namespace App\Application\UseCases\Producto;

use App\Domain\Core\Repositories\ProductoRepositoryInterface;

/**
 * Caso de uso: Mostrar Productos
 *
 * Permite obtener la lista completa de productos almacenados en el sistema.
 * Este caso de uso actúa como intermediario entre la capa de aplicación y la 
 * capa de dominio, delegando la obtención de datos al repositorio correspondiente.
 *
 * Si no existen productos registrados, el método retornará `null`.
 *
 * @package App\Application\UseCases\Producto
 * @author Jhonatan J. A. C.
 * @version 1.0.0
 */
class MostrarProductosUseCase
{
    /**
     * @var ProductoRepositoryInterface Repositorio de productos utilizado para acceder a los datos.
     */
    public function __construct(
        private ProductoRepositoryInterface $productoRepository
    ) {}

    /**
     * Ejecuta el caso de uso de obtención de productos.
     *
     * Retorna un arreglo con todos los productos disponibles en el sistema.
     * Si no se encuentran registros, retorna `null`.
     *
     * @return array|null Lista de productos o null si no existen registros.
     */
    public function execute(): ?array
    {
        return $this->productoRepository->mostrarProductos();
    }
}