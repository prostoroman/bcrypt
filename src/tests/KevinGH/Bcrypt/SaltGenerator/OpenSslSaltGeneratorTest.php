<?php

namespace KevinGH\Bcrypt\Tests\SaltGenerator;

use KevinGH\Bcrypt\SaltGenerator\OpenSslSaltGenerator;
use KevinGH\Runkit\RunkitTestCase;

class OpenSslSaltGeneratorTest extends RunkitTestCase
{
    public function testIsSupported()
    {
        $generator = new OpenSslSaltGenerator();
        $supported = false;

        if (function_exists('openssl_random_pseudo_bytes')) {
            openssl_random_pseudo_bytes(10, $supported);
        }

        $this->assertSame(
            $supported,
            $generator->isSupported()
        );
    }

    /**
     * @depends testIsSupported
     */
    public function testGenerateSalt()
    {
        $generator = new OpenSslSaltGenerator();

        if (false === $generator->isSupported()) {
            $this->markTestSkipped('The OpenSslSaltGenerator is not supported.');
        }

        $this->assertRegExp(
            '/^[a-zA-Z0-9\.\/]{22}$/',
            $generator->generateSalt()
        );
    }
}
