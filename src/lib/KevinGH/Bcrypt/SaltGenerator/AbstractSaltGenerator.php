<?php

namespace KevinGH\Bcrypt\SaltGenerator;

/**
 * Provides common functionality to most salt generators.
 *
 * @author Kevin Herrera <kevin@herrera.io>
 */
abstract class AbstractSaltGenerator implements SaltGeneratorInterface
{
    /**
     * Processes the salt into the proper characters and length.
     *
     * @param string $original The original salt.
     *
     * @return string The processed salt.
     */
    protected function processSalt($salt)
    {
        return substr(str_replace('+', '.', $salt), 0, 22);
    }
}
