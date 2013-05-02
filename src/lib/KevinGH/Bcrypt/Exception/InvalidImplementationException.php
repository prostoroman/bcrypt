<?php

namespace KevinGH\Bcrypt\Exception;

use InvalidArgumentException;

/**
 * This exception is thrown if the implementation was not a valid Blowfish
 * implementation. The only recognized implementations are the broken "2a",
 * and fixed "2x" and "2y".
 *
 * @author Kevin Herrera <kevin@herrera.io>
 */
class InvalidImplementationException extends InvalidArgumentException
{
    /**
     * The invalid implementation.
     *
     * @var string
     */
    private $implementation;

    /**
     * Sets the invalid implementation.
     *
     * @param string $implementation The invalid implementation.
     */
    public function __construct($implementation)
    {
        $this->implementation = $implementation;
    }

    /**
     * Returns the invalid implementation.
     *
     * @return string The invalid implementation.
     */
    public function getImplementation()
    {
        return $this->implementation;
    }
}
