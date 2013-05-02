<?php

namespace KevinGH\Bcrypt\SaltGenerator;

/**
 * An interface for salt generators.
 *
 * @author Kevin Herrera <kevin@herrera.io>
 */
interface SaltGeneratorInterface
{
    /**
     * Returns a new salt.
     *
     * @return string The salt.
     */
    public function generateSalt();

    /**
     * Checks if the salt generator is supported.
     *
     * @return boolean TRUE if supported, FALSE if not.
     */
    public function isSupported();
}