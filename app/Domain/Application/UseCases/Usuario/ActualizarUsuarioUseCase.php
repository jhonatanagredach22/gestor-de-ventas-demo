<?php

namespace App\Application\UseCases\Usuario;

use App\Domain\Core\Repositories\UsuarioRepositoryInterface;
use InvalidArgumentException;

/**
 * Caso de uso: Actualizar Usuario
 *
 * Permite modificar el nombre de usuario y/o la contraseña,
 * verificando la contraseña actual antes de autorizar cambios sensibles.
 * 
 * @package App\Application\UseCases\Usuario
 * @author Jhonatan J. A. C.
 * @version 1.0.0
 */
class ActualizarUsuarioUseCase
{
    public function __construct(
        private UsuarioRepositoryInterface $usuarioRepository
    ) {}

    /**
     * Ejecuta la actualización del usuario.
     *
     * @param string      $nuevoUsername        Nombre nuevo.
     * @param string|null $claveActual          Contraseña actual (obligatoria si se desea cambiar la contraseña).
     * @param string|null $nuevaClave           Nueva contraseña.
     *
     * @throws InvalidArgumentException Si no existe usuario o si la contraseña actual no coincide.
     */
    public function execute(
        string $nuevoUsername,
        ?string $claveActual = null,
        ?string $nuevaClave = null
    ): void {

        // obtener usuario existente
        $usuario = $this->usuarioRepository->mostrarUsuario();

        if ($usuario === null) {
            throw new InvalidArgumentException('No existe un usuario registrado para actualizar.');
        }

        // actualizar nombre de usuario
        $usuario->setUsername($nuevoUsername);

        // si se quiere cambiar la contraseña, validar
        if ($nuevaClave !== null && trim($nuevaClave) !== '') {

            if ($claveActual === null || trim($claveActual) === '') {
                throw new InvalidArgumentException('Debe ingresar la contraseña actual para cambiarla.');
            }

            // verificar contraseña actual
            if (!password_verify($claveActual, $usuario->getPassword())) {
                throw new InvalidArgumentException('La contraseña actual no es correcta.');
            }

            // asignar nueva contraseña validada
            $usuario->setPassword($nuevaClave);
        }

        // persistir cambios
        $this->usuarioRepository->actualizar($usuario);
    }
}
