<?php

namespace KevinGH\Bcrypt\Tests;

use KevinGH\Bcrypt\Bcrypt;
use KevinGH\Bcrypt\SaltGenerator\MtRandSaltGenerator;
use KevinGH\Runkit\RunkitTestCase;
use ReflectionClass;

class BcryptTest extends RunkitTestCase
{
    public function testConstructor()
    {
        $bcrypt = new Bcrypt();

        $this->assertEquals(
            BLOWFISH_IMPLEMENTATION,
            $bcrypt->getImplementation()
        );
    }

    public function testConstructorForceBroken()
    {
        $bcrypt = new Bcrypt(true);

        $this->assertEquals('2a', $bcrypt->getImplementation());
    }

    public function testAddSaltGenerator()
    {
        $bcrypt = new Bcrypt();
        $mt = new MtRandSaltGenerator();

        $bcrypt->addSaltGenerator($mt);

        $reflection = new ReflectionClass($bcrypt);
        $reflection = $reflection->getProperty('saltGenerators');
                      $reflection->setAccessible(true);
        $reflection = $reflection->getValue($bcrypt);

        $this->assertSame($mt, $reflection[0]);
    }

    public function testSetCost()
    {
        $bcrypt = new Bcrypt();
        $bcrypt->setCost(12);

        $this->assertSame(12, $bcrypt->getCost());
    }

    /**
     * @expectedException KevinGH\Bcrypt\Exception\InvalidCostException
     */
    public function testSetCostInvalid()
    {
        $bcrypt = new Bcrypt();
        $bcrypt->setCost(123);
    }

    /**
     * @depends testAddSaltGenerator
     */
    public function testGenerateSalt()
    {
        $bcrypt = new Bcrypt();
        $bcrypt->addSaltGenerator(new MtRandSaltGenerator());

        $this->assertRegExp(
            '/^[a-zA-Z0-9\.\/]{22}$/',
            $bcrypt->generateSalt()
        );
    }

    public function testGenerateSaltFallback()
    {
        $bcrypt = new Bcrypt();

        $this->assertRegExp(
            '/^[a-zA-Z0-9\.\/]{22}$/',
            $bcrypt->generateSalt()
        );
    }

    public function testSetImplementation()
    {
        $bcrypt = new Bcrypt();
        $bcrypt->setImplementation('2a');

        $this->assertEquals('2a', $bcrypt->getImplementation());
    }

    /**
     * @expectedException KevinGH\Bcrypt\Exception\ImplementationNotSupportedException
     */
    public function testSetImplementationNotSupported()
    {
        if ('2y' === BLOWFISH_IMPLEMENTATION) {
            $this->requireRunkit();
            $this->redefineConstant('BLOWFISH_IMPLEMENTATION', '2a');
        }

        $bcrypt = new Bcrypt();
        $bcrypt->setImplementation('2y');
    }

    /**
     * @expectedException KevinGH\Bcrypt\Exception\InvalidImplementationException
     */
    public function testSetImplementationInvalid()
    {
        $bcrypt = new Bcrypt();
        $bcrypt->setImplementation('1a');
    }

    public function testSetSalt()
    {
        $bcrypt = new Bcrypt();
        $bcrypt->setSalt('abcdefghijklmnopqrstuv');

        $this->assertEquals('abcdefghijklmnopqrstuv', $bcrypt->getSalt());
    }

    /**
     * @expectedException KevinGH\Bcrypt\Exception\InvalidSaltException
     */
    public function testSetSaltInvalid()
    {
        $bcrypt = new Bcrypt();
        $bcrypt->setSalt('test');
    }

    public function testSetEncoded()
    {
        $bcrypt = new Bcrypt();
        $bcrypt->setEncoded('$2a$10$abcdefghijklmnopqrstuuNYVhuCzN8W/N3q6oBTpBoHaLLh6DgBG');

        $this->assertSame(10, $bcrypt->getCost());
        $this->assertEquals('2a', $bcrypt->getImplementation());
        $this->assertEquals('abcdefghijklmnopqrstuu', $bcrypt->getSalt());
    }

    /**
     * @expectedException KevinGH\Bcrypt\Exception\InvalidEncodedStringException
     */
    public function testSetEncodedInvalid()
    {
        $bcrypt = new Bcrypt();
        $bcrypt->setEncoded('123');
    }

    /**
     * @depends testGenerateSalt
     * @depends testSetSalt
     */
    public function testGetCryptSalt()
    {
        $bcrypt = new Bcrypt();
        $bcrypt->setSalt($bcrypt->generateSalt());

        $this->assertRegExp(
            '/^\$2[axy]\$\d{1,2}\$[a-zA-Z0-9\.\/]{22}$/',
            $bcrypt->getCryptSalt()
        );
    }

    /**
     * @depends testSetSalt
     */
    public function testInvoke()
    {
        $bcrypt = new Bcrypt();
        $bcrypt->setSalt('abcdefghijklmnopqrstuv');

        $encoded = $bcrypt('test');

        $bcrypt->setEncoded($encoded);

        $this->assertEquals($encoded, $bcrypt('test'));
        $this->assertRegExp(
            '/^\$2[axy]\$\d{1,2}\$[a-zA-Z0-9\.\/]{22}[a-zA-Z0-9\.\/]+$/',
            $encoded
        );
    }

    /**
     * @expectedException KevinGH\Bcrypt\Exception\MissingSaltException
     */
    public function testInvokeMissingSalt()
    {
        $bcrypt = new Bcrypt();
        $bcrypt('test');
    }
}
