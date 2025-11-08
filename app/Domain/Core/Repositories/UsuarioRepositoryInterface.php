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
}