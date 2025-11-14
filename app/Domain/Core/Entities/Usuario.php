<?php

/**
 * Copyright 2025 Jhonatan J. A. C.
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *     http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

namespace App\Domain\Core\Entities;

use App\Domain\Core\Traits\Validaciones;
use InvalidArgumentException;

/**
 * Clase Usuario que representa un usuario dentro del sistema.
 *
 * Contiene las validaciones necesarias para garantizar que tanto el nombre
 * de usuario como la contraseña cumplan con las reglas de formato establecidas.
 * 
 * - Los métodos estáticos `createUsername()` y `createPassword()` se utilizan
 *   al momento de **registrar un nuevo usuario**, aplicando validaciones más
 *   estrictas.
 * - Los métodos `setUsername()` y `setPassword()` se utilizan durante el
 *   **inicio de sesión** o actualización de credenciales, donde la validación
 *   puede ser más simple.
 *
 * @package App\Domain\Core\Entities
 * @author Jhonatan J. A.
 * @version 1.0.0
 */
class Usuario
{
    use Validaciones;

    /** @var int Longitud mínima y máxima para el nombre de usuario */
    const MIN_LONG_NAME = 4, MAX_LONG_NAME = 20;

    /** @var int Longitud mínima y máxima para la contraseña */
    const MIN_LONG_PASS = 8, MAX_LONG_PASS = 12;

    /**
     * Constructor del usuario.
     *
     * @param string $username Nombre de usuario.
     * @param string $password Contraseña del usuario.
     */
    public function __construct(
        private string $username,
        private string $password
    ) {}

    // -----------------------------------------------------------------
    // VALIDACIONES PARA CREACIÓN DE NUEVOS USUARIOS
    // -----------------------------------------------------------------

    /**
     * Valida el nombre de usuario al momento de registrar un nuevo usuario.
     *
     * @param string $username
     * @return string Nombre validado.
     * @throws InvalidArgumentException Si el nombre no cumple las reglas.
     */
    public static function createUsername(string $username): string
    {
        $username = trim($username);

        $username = preg_replace('/[^A-Za-z0-9_-]/', '', $username);

        if ($username === '') {
            throw new InvalidArgumentException('El nombre de usuario no puede estar vacío.');
        }

        if (strlen($username) < self::MIN_LONG_NAME || strlen($username) > self::MAX_LONG_NAME) {
            throw new InvalidArgumentException('El nombre de usuario debe tener entre 4 y 20 caracteres.');
        }

        return $username;
    }

    /**
     * Valida la contraseña al momento de registrar un nuevo usuario.
     *
     * @param string $password
     * @return string Contraseña validada.
     * @throws InvalidArgumentException Si la contraseña no cumple las reglas.
     */
    public static function createPassword(string $password): string
    {
        $password = trim($password);

        if ($password === '') {
            throw new InvalidArgumentException('La contraseña no puede estar vacía.');
        }

        if (strlen($password) < self::MIN_LONG_PASS || strlen($password) > self::MAX_LONG_PASS) {
            throw new InvalidArgumentException('La contraseña debe tener entre 8 y 12 caracteres.');
        }

        if (!preg_match('/[A-Z]/', $password)) {
            throw new InvalidArgumentException('La contraseña debe incluir al menos una letra mayúscula.');
        }

        if (!preg_match('/[a-z]/', $password)) {
            throw new InvalidArgumentException('La contraseña debe incluir al menos una letra minúscula.');
        }

        if (!preg_match('/[0-9]/', $password)) {
            throw new InvalidArgumentException('La contraseña debe incluir al menos un número.');
        }

        if (!preg_match('/[\W_]/', $password)) { // \W = no alfanumérico
            throw new InvalidArgumentException('La contraseña debe incluir al menos un carácter especial.');
        }

        $password = password_hash($password, PASSWORD_DEFAULT);

        return $password;
    }

    // -----------------------------------------------------------------
    // GETTERS
    // -----------------------------------------------------------------

    /**
     * Retorna el nombre de usuario.
     *
     * @return string
     */
    public function getUsername(): string
    {
        return $this->username;
    }

    /**
     * Retorna la contraseña.
     *
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }
}
