<?php

namespace App\Domain\Core\Repositories;

use App\Domain\Core\Entities\Producto;

/**
 * Interface ProductoRepositoryInterface
 *
 * Define el contrato que deben cumplir los repositorios encargados de
 * gestionar la persistencia de objetos Producto, sin importar la fuente
 * de datos (por ejemplo, base de datos, archivo JSON, API externa, etc.).
 *
 * Esta interfaz forma parte de la capa de dominio y desacopla la lógica
 * del negocio de los detalles de infraestructura.
 *
 * @package App\Domain\Core\Repositories
 * @author Jhonatan J. A. C.
 * @version 1.0.0
 */
interface ProductoRepositoryInterface
{
    /**
     * Guarda un nuevo producto en el repositorio.
     *
     * @param Producto $producto Instancia del producto a guardar.
     * @return void
     */
    public function guardar(Producto $producto): void;

    /**
     * Actualiza los datos de un producto existente.
     *
     * @param Producto $producto Instancia del producto con los datos actualizados.
     * @return void
     */
    public function actualizar(Producto $producto): void;

    /**
     * Busca un producto por su identificador.
     *
     * @param int $id Identificador del producto.
     * @return Producto|null Retorna la instancia del producto si existe, o null si no se encuentra.
     */
    public function buscarPorId(int $id): ?Producto;

    /**
     * Obtiene la lista de todos los productos almacenados.
     *
     * Si no existen productos registrados, retorna null.
     *
     * @return array<Producto>|null Lista de productos o null si no hay registros.
     */
    public function mostrarProductos(): ?array;

    /**
     * Busca un producto por su nombre.
     *
     * @param string $nombre Nombre del producto a buscar.
     * @return Producto|null Devuelve la entidad Producto si existe, o null si no se encuentra.
     */
    public function buscarPorNombre(string $nombre): ?Producto;

    /**
     * Elimina lógicamente un producto del repositorio (soft delete).
     *
     * @param int $id Identificador del producto a eliminar.
     * @return void
     */
    public function eliminar(int $id): void;

    /**
     * Restaura un producto previamente eliminado lógicamente.
     *
     * @param int $id Identificador del producto a restaurar.
     * @return void
     */
    public function restaurar(int $id): void;
}
