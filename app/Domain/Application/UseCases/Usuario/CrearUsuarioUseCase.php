<?php

namespace App\Application\UseCases\Usuario;

use App\Domain\Core\Repositories\UsuarioRepositoryInterface;
use App\Domain\Core\Entities\Usuario;
use InvalidArgumentException;

/**
 * Caso de uso: CrearUsuarioUseCase
 *
 * Se encarga de registrar el único usuario permitido en el sistema.
 * 
 * Flujo:
 *  1. Verificar que no exista ya un usuario registrado.
 *  2. Validar el nombre de usuario usando las reglas de la entidad.
 *  3. Validar y hashear la contraseña mediante la entidad.
 *  4. Crear la entidad Usuario.
 *  5. Delegar al repositorio la persistencia del nuevo usuario.
 *
 * En este proyecto solo debe existir **un usuario**
 * por lo que intentar registrar un segundo usuario genera un error.
 *
 * @package App\Application\UseCases\Usuario
 * @author Jhonatan J. A. C.
 * @version 1.0.0
 */
class CrearUsuarioUseCase
{
    /**
     * @param UsuarioRepositoryInterface $usuarioRepository
     *        Repositorio encargado de manejar la persistencia del usuario.
     */
    public function __construct(
        private UsuarioRepositoryInterface $usuarioRepository
    ) {}

    /**
     * Ejecuta el caso de uso de creación de usuario.
     *
     * @param string $username Nombre de usuario ingresado.
     * @param string $pass     Contraseña en texto plano.
     *
     * @throws InvalidArgumentException Si ya existe un usuario registrado.
     *
     * @return void
     */
    public function execute(string $username, string $pass): void
    {
        // Verificar que no exista ya un usuario registrado
        $usuarioExistente = $this->usuarioRepository->existeUsuario();

        if ($usuarioExistente !== null) {
            throw new InvalidArgumentException('Ya existe un usuario registrado.');
        }

        // Validar el nombre de usuario según las reglas del dominio
        $validarUsername = Usuario::createUsername($username);

        // Validar y hashear la contraseña según las reglas del dominio
        $validarClave = Usuario::createPassword($pass);

        // Crear entidad Usuario ya validada
        $nuevoUsuario = new Usuario($validarUsername, $validarClave);

        // Persistir el usuario
        $this->usuarioRepository->crearUsuario($nuevoUsuario);
    }
}