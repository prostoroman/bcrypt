<?php

namespace KevinGH\Bcrypt\Tests\Exception;

use KevinGH\Bcrypt\Exception\InvalidImplementationException;
use PHPUnit_Framework_TestCase;

class InvalidImplementationExceptionTest extends PHPUnit_Framework_TestCase
{
    public function testConstructor()
    {
        $exception = new InvalidImplementationException('1b');

        $this->assertEquals('1b', $exception->getImplementation());
        $this->assertInstanceOf('InvalidArgumentException', $exception);
    }
}