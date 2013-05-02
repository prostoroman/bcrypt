<?php

namespace KevinGH\Bcrypt\Tests\Exception;

use KevinGH\Bcrypt\Exception\ImplementationNotSupportedException;
use PHPUnit_Framework_TestCase;

class ImplementationNotSupportedExceptionTest extends PHPUnit_Framework_TestCase
{
    public function testConstructor()
    {
        $exception = new ImplementationNotSupportedException('2y');

        $this->assertEquals('2y', $exception->getImplementation());
        $this->assertInstanceOf('RuntimeException', $exception);
    }
}