<?php

namespace KevinGH\Bcrypt\Tests\Exception;

use KevinGH\Bcrypt\Exception\InvalidSaltException;
use PHPUnit_Framework_TestCase;

class InvalidSaltExceptionTest extends PHPUnit_Framework_TestCase
{
    public function testConstructor()
    {
        $exception = new InvalidSaltException('test');

        $this->assertEquals('test', $exception->getSalt());
        $this->assertInstanceOf('InvalidArgumentException', $exception);
    }
}