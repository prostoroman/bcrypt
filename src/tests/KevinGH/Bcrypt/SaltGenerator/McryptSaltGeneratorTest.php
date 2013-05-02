<?php

namespace KevinGH\Bcrypt\Tests\SaltGenerator;

use KevinGH\Bcrypt\SaltGenerator\McryptSaltGenerator;
use PHPUnit_Framework_TestCase;

class McryptSaltGeneratorTest extends PHPUnit_Framework_TestCase
{
    /**
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage The source "invalid" is invalid.
     */
    public function testConstructorInvalidSource()
    {
        new McryptSaltGenerator('invalid');
    }

    public function testIsSupported()
    {
        $generator = new McryptSaltGenerator();

        $this->assertSame(
            function_exists('mcrypt_create_iv'),
            $generator->isSupported()
        );
    }

    /**
     * @depends testIsSupported
     */
    public function testGenerateSalt()
    {
        $generator = new McryptSaltGenerator();

        if (false === $generator->isSupported()) {
            $this->markTestSkipped('The McryptSaltGenerator is not supported.');
        }

        $this->assertRegExp(
            '/^[a-zA-Z0-9\.\/]{22}$/',
            $generator->generateSalt()
        );
    }
}
