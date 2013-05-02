<?php

class bcryptTest extends PHPUnit_Framework_TestCase
{
    public function testBcrypt()
    {
        $this->assertRegExp(
            '/^\$2[axy]\$10\$[a-zA-Z0-9\.\/]{22}[a-zA-Z0-9\.\/]+$/',
            bcrypt('test')
        );
    }

    public function testBcryptBroken()
    {
        $this->assertRegExp(
            '/^\$2a\$10\$[a-zA-Z0-9\.\/]{22}[a-zA-Z0-9\.\/]+$/',
            bcrypt('test', null, null, true)
        );
    }

    public function testBcryptCost()
    {
        $this->assertRegExp(
            '/^\$2[axy]\$05\$[a-zA-Z0-9\.\/]{22}[a-zA-Z0-9\.\/]+$/',
            bcrypt('test', null, 5)
        );
    }

    public function testBcryptEncoded()
    {
        $test = bcrypt('test');

        $this->assertEquals($test, bcrypt('test', $test));
    }

    public function testBcryptSalted()
    {
        $this->assertEquals(
            '$2a$10$UFemvSjF0xBnJTMNbNfog.DG2n9G7ldWISASSyDtg3SZH555QDAhm',
            bcrypt('test', 'UFemvSjF0xBnJTMNbNfog.D', 10, true)
        );
    }

    /**
     * @depends testBcrypt
     */
    public function testBcryptVerify()
    {
        $encoded = bcrypt('test');

        $this->assertTrue(bcrypt_verify('test', $encoded));
        $this->assertFalse(bcrypt_verify('nope', $encoded));
    }
}
