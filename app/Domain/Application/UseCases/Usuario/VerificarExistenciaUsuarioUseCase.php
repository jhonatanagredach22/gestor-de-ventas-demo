<?php

namespace App\Application\UseCases\Usuario;

use App\Domain\Core\Repositories\UsuarioRepositoryInterface;

/**
 * Caso de Uso: VerificarExistenciaUsuarioUseCase
 *
 * Determina si ya existe al menos un usuario registrado.
 * Este caso de uso es útil durante el arranque del sistema,
 * para decidir si se debe mostrar el registro inicial o el login.
 *
 * No se aplican reglas de negocio adicionales porque solo se
 * consulta la existencia de registros.
 *
 * @package App\Application\UseCases\Usuario
 * @author Jhonatan J. A. C.
 * @version 1.0.0
 */
class VerificarExistenciaUsuarioUseCase
{
    /**
     * @param UsuarioRepositoryInterface $usuarioRepository
     * Repositorio encargado del acceso a los datos de usuario.
     */
    public function __construct(
        private UsuarioRepositoryInterface $usuarioRepository
    ) {}

    /**
     * Ejecuta el caso de uso.
     *
     * @return bool
     * Devuelve TRUE si existe al menos un usuario registrado.
     * Devuelve FALSE si no hay usuarios en la base de datos.
     */
    public function execute(): bool
    {
        return $this->usuarioRepository->existeUsuario();
    }
}
