<?php

namespace KevinGH\Bcrypt\Tests\Exception;

use KevinGH\Bcrypt\Exception\InvalidEncodedStringException;
use PHPUnit_Framework_TestCase;

class InvalidEncodedStringExceptionTest extends PHPUnit_Framework_TestCase
{
    public function testConstructor()
    {
        $exception = new InvalidEncodedStringException('$1$2$3');

        $this->assertEquals('$1$2$3', $exception->getEncodedString());
        $this->assertInstanceOf('InvalidArgumentException', $exception);
    }
}