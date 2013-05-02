<?php

namespace KevinGH\Bcrypt\Tests\SaltGenerator;

use KevinGH\Bcrypt\SaltGenerator\MtRandSaltGenerator;
use PHPUnit_Framework_TestCase;

class MtRandSaltGeneratorTest extends PHPUnit_Framework_TestCase
{
    public function testGenerateSalt()
    {
        $generator = new MtRandSaltGenerator();

        $this->assertRegExp(
            '/^[a-zA-Z0-9\.\/]{22}$/',
            $generator->generateSalt()
        );
    }

    public function testIsSupported()
    {
        $generator = new MtRandSaltGenerator();

        $this->assertTrue($generator->isSupported());
    }
}