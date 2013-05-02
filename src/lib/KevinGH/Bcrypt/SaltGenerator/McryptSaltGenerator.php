<?php

namespace KevinGH\Bcrypt\SaltGenerator;

use InvalidArgumentException;

/**
 * A salt generator using mcrypt_create_iv().
 *
 * @author Kevin Herrera <kevin@herrera.io>
 */
class McryptSaltGenerator extends AbstractSaltGenerator
{
    /**
     * The source for mcrypt.
     *
     * @var string
     */
    private $source;

    /**
     * Sets the source for mcrypt.
     *
     * @param integer $source The source.
     *
     * @throws InvalidArgumentException If the source is invalid.
     */
    public function __construct($source = MCRYPT_DEV_URANDOM)
    {
        if (false === in_array(
            $source,
            array(MCRYPT_DEV_RANDOM, MCRYPT_DEV_URANDOM),
            true
        )){
            throw new InvalidArgumentException(sprintf(
                'The source "%s" is invalid.',
                $source
            ));
        }

        $this->source = $source;
    }

    /** {@inheritDoc} */
    public function generateSalt()
    {
        return $this->processSalt(
            base64_encode(mcrypt_create_iv(22, $this->source))
        );
    }

    /** {@inheritDoc} */
    public function isSupported()
    {
        return function_exists('mcrypt_create_iv');
    }
}
