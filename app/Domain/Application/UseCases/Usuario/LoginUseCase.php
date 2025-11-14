<?php

namespace App\Application\UseCases\Usuario;

use App\Domain\Core\Repositories\UsuarioRepositoryInterface;
use App\Domain\Core\Entities\Usuario;
use InvalidArgumentException;

/**
 * Caso de uso: Autenticar usuario en el sistema.
 *
 * Este caso de uso valida que exista un usuario registrado,
 * busca al usuario por su nombre y verifica la contraseña
 * utilizando password_verify, asegurando un proceso seguro de login.
 *
 * @package App\Application\UseCases\Usuario
 * @author Jhonatan J. A. C.
 * @version 1.0.0
 */
class LoginUseCase
{
    public function __construct(
        private UsuarioRepositoryInterface $usuarioRepository
    ) {}

    /**
     * Ejecuta el proceso de autenticación.
     *
     * @param string $nombreUsuario Nombre de usuario ingresado.
     * @param string $password Contraseña ingresada.
     *
     * @return \App\Domain\Core\Entities\Usuario Usuario autenticado.
     *
     * @throws InvalidArgumentException Si no existe un usuario registrado,
     *                                  si el usuario no coincide o si la contraseña es incorrecta.
     */
    public function execute(string $nombreUsuario, string $password)
    {
        // Verificar que exista un usuario registrado en el sistema
        $usuarioRegistrado = $this->usuarioRepository->mostrarUsuario();

        if ($usuarioRegistrado === null) {
            throw new InvalidArgumentException(
                'No existe ningún usuario registrado. Debe crear uno antes de iniciar sesión.'
            );
        }

        // Buscar el usuario por su nombre
        $usuario = $this->usuarioRepository->buscarPorNombre($nombreUsuario);

        if ($usuario === null) {
            throw new InvalidArgumentException('El usuario ingresado no existe.');
        }

        // Verificar contraseña segura
        if (!password_verify($password, $usuario->getPassword())) {
            throw new InvalidArgumentException('La contraseña ingresada es incorrecta.');
        }

        // Login exitoso
        return $usuario;
    }
}
