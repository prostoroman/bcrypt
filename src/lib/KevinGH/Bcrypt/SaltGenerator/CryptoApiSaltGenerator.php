<?php

namespace KevinGH\Bcrypt\SaltGenerator;

use Exception;

/**
 * A salt generator using Microsoft's CryptoAPI.
 *
 * @author Kevin Herrera <kevin@herrera.io>
 */
class CryptoApiSaltGenerator extends AbstractSaltGenerator
{
    /** {@inheritDoc} */
    public function generateSalt()
    {
        $api = new COM('CAPICOM.Utilities.1');

        return $this->processSalt($api->GetRandom(22, 0));
    }

    /** {@inheritDoc} */
    public function isSupported()
    {
        $supported = false;

        if (class_exists('COM')) {
            try {
                $api = new COM('CAPICOM.Utilities.1');

                $supported = true;
            } catch (Exception $exception) {
            }
        }

        return $supported;
    }
}
