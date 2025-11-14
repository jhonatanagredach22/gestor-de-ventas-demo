<?php

namespace App\Application\UseCases\Usuario;

use App\Domain\Core\Repositories\UsuarioRepositoryInterface;
use App\Domain\Core\Entities\Usuario;

/**
 * Caso de uso: MostrarUsuarioUseCase
 *
 * Se encarga de obtener el único usuario registrado en el sistema.
 * 
 * - En este proyecto se maneja solo **un usuario**, por lo que el repositorio
 *   expone el método `mostrarUsuario()` en lugar de una colección.
 * - El caso de uso simplemente delega la acción al repositorio.
 *
 * @package App\Application\UseCases\Usuario
 * @author Jhonatan J. A. C.
 * @version 1.0.0
 */
class MostrarUsuarioUseCase
{
    /**
     * Constructor del caso de uso.
     *
     * @param UsuarioRepositoryInterface $usuarioRepository
     *        Repositorio encargado de acceder a los datos del usuario.
     */
    public function __construct(
        private UsuarioRepositoryInterface $usuarioRepository
    ) {}

    /**
     * Ejecuta el caso de uso.
     *
     * Obtiene la entidad Usuario desde el repositorio.
     * Puede retornar null si no existe ningún usuario registrado.
     *
     * @return Usuario|null
     */
    public function execute(): ?Usuario
    {
        return $this->usuarioRepository->mostrarUsuario();
    }
}
