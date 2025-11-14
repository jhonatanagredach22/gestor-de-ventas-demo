<?php

namespace App\Domain\Core\Repositories;

use App\Domain\Core\Entities\Usuario;

/**
 * Interface UsuarioRepositoryInterface
 * 
 * Define el contrato para los repositorios encargados de manejar
 * las operaciones relacionadas con los usuarios dentro del sistema.
 * 
 * Esta interfaz establece los métodos esenciales para crear, actualizar
 * y obtener información del usuario, dejando la implementación concreta
 * a las clases de infraestructura (por ejemplo, repositorios basados en bases de datos).
 *
 * @package App\Domain\Core\Repositories
 * @author Jhonatan J. A. C.
 * @version 1.0.0
 */
interface UsuarioRepositoryInterface
{
    /**
     * Crea un nuevo usuario en el repositorio.
     *
     * @param Usuario $usuario Entidad Usuario a registrar.
     * @return void
     */
    public function crearUsuario(Usuario $usuario): void;

    /**
     * Actualiza los datos de un usuario existente.
     *
     * @param Usuario $usuario Entidad Usuario con la información actualizada.
     * @return void
     */
    public function actualizar(Usuario $usuario): void;

    /**
     * Retorna el usuario registrado en el sistema.
     *
     * Dado que esta demo maneja un único usuario, este método
     * devuelve la instancia de dicho usuario si existe, o null
     * si aún no ha sido creado.
     *
     * @return Usuario|null Usuario registrado o null si no existe.
     */
    public function mostrarUsuario(): ?Usuario;

    /**
     * Busca un usuario específico por su nombre.
     *
     * Permite obtener un usuario concreto para verificación de autenticación.
     *
     * @param string $nombre Nombre del usuario.
     * @return Usuario|null Usuario encontrado o null si no existe.
     */
    public function buscarPorNombre(string $nombre): ?Usuario;

    /**
     * Verifica si existe un usuario registrado.
     *
     * Este método permite validar si existe un usuario registrado
     * en la base de datos, para mostrar el apartado de registro si
     * no se encuentra.
     *
     * @return bool TRUE si hay un usuario registrado, FALSE en caso contrario.
     */
    public function existeUsuario(): bool;
}
