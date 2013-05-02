<?php

namespace KevinGH\Bcrypt\Tests\SaltGenerator;

use KevinGH\Bcrypt\SaltGenerator\DevRandomSaltGenerator;
use PHPUnit_Framework_TestCase;

class DevRandomSaltGeneratorTest extends PHPUnit_Framework_TestCase
{
    public function testIsSupported()
    {
        $generator = new DevRandomSaltGenerator();

        $this->assertSame(
            file_exists('/dev/random'),
            $generator->isSupported()
        );
    }

    /**
     * @depends testIsSupported
     */
    public function testGenerateSalt()
    {
        $generator = new DevRandomSaltGenerator('/dev/urandom');

        if (false === $generator->isSupported()) {
            $this->markTestSkipped('The DevRandomSaltGenerator is not supported.');
        }

        $this->assertRegExp(
            '/^[a-zA-Z0-9\.\/]{22}$/',
            $generator->generateSalt()
        );
    }
}
