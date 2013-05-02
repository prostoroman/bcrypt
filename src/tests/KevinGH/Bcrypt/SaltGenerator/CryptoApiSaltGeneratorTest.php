<?php

namespace KevinGH\Bcrypt\Tests\SaltGenerator;

use Exception;
use KevinGH\Bcrypt\SaltGenerator\CryptoApiSaltGenerator;
use PHPUnit_Framework_TestCase;

class CryptoApiSaltGeneratorTest extends PHPUnit_Framework_TestCase
{
    public function testIsSupported()
    {
        $generator = new CryptoApiSaltGenerator();
        $supported = false;

        if (class_exists('COM')) {
            try {
                $api = new COM('CAPICOM.Utilities.1');

                $supported = true;
            } catch (Exception $exception) {
            }
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
        $generator = new CryptoApiSaltGenerator();

        if (false === $generator->isSupported()) {
            $this->markTestSkipped('The CryptoApialtGenerator is not supported.');
        }

        $this->assertRegExp(
            '/^[a-zA-Z0-9\.\/]{22}$/',
            $generator->generateSalt()
        );
    }
}
