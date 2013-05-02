<?php

namespace KevinGH\Bcrypt\Exception;

use InvalidArgumentException;

/**
 * This exception is thrown if the salt was not exactly 22 characters long,
 * or did not only contain a-z, A-Z, 0-9, . (period), or / (forward slash).
 * If using base64_encode() to encode a generated salt, make sure you replace
 * all instance of "+" with ".".
 *
 * @author Kevin Herrera <kevin@herrera.io>
 */
class InvalidSaltException extends InvalidArgumentException
{
    /**
     * The invalid salt.
     *
     * @var string
     */
    private $salt;

    /**
     * Sets the invalid salt.
     *
     * @param string $salt The invalid salt.
     */
    public function __construct($salt)
    {
        $this->salt = $salt;
    }

    /**
     * Returns the invalid salt.
     *
     * @return string The invalid salt.
     */
    public function getSalt()
    {
        return $this->salt;
    }
}
