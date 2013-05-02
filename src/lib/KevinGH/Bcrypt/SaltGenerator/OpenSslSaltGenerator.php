<?php

namespace KevinGH\Bcrypt\SaltGenerator;

/**
 * A salt generator using openssl_random_pseudo_bytes().
 *
 * @author Kevin Herrera <kevin@herrera.io>
 */
class OpenSslSaltGenerator extends AbstractSaltGenerator
{
    /** {@inheritDoc} */
    public function generateSalt()
    {
        return $this->processSalt(
            base64_encode(openssl_random_pseudo_bytes(22))
        );
    }

    /** {@inheritDoc} */
    public function isSupported()
    {
        $supported = false;

        if (function_exists('openssl_random_pseudo_bytes')) {
            openssl_random_pseudo_bytes(10, $supported);
        }

        return $supported;
    }
}
