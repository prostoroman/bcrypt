<?php

namespace KevinGH\Bcrypt\Exception;

use RuntimeException;

/**
 * This exception is thrown if the implementation used is not supported by
 * this version of PHP. The "2y" and "2x" implementations are only supported
 * in PHP 5.3.7 and greater. The "2a" implementation is supported in all.
 *
 * @author Kevin Herrera <kevin@herrera.io>
 */
class ImplementationNotSupportedException extends RuntimeException
{
    /**
     * The unsupported implementation.
     *
     * @var string
     */
    private $implementation;

    /**
     * Sets the unsupported implementation.
     *
     * @param string $implementation The unsupported implementation.
     */
    public function __construct($implementation)
    {
        $this->implementation = $implementation;
    }

    /**
     * Returns the unsupported implementation.
     *
     * @return string The unsupported implementation.
     */
    public function getImplementation()
    {
        return $this->implementation;
    }
}
