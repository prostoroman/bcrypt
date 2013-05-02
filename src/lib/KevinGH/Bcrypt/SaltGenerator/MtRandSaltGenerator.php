<?php

namespace KevinGH\Bcrypt\SaltGenerator;

/**
 * Generates a new salt using mt_rand().
 *
 * @author Kevin Herrera <kevin@herrera.io>
 */
class MtRandSaltGenerator implements SaltGeneratorInterface
{
    /**
     * The allowed characters.
     *
     * @var string
     */
    private $characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ01234567890./';

    /**
     * Sets the random number generator.
     */
    public function __construct()
    {
        mt_srand();
    }

    /** {@inheritDoc} */
    public function generateSalt()
    {
        $salt = '';

        for ($i = 0; $i < 22; $i++) {
            $salt .= $this->characters[mt_rand(0, 63)];
        }

        return $salt;
    }

    /** {@inheritDoc} */
    public function isSupported()
    {
        return true;
    }
}
