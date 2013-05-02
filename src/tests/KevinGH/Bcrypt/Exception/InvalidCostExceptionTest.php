<?php

namespace KevinGH\Bcrypt\Tests\Exception;

use KevinGH\Bcrypt\Exception\InvalidCostException;
use PHPUnit_Framework_TestCase;

class InvalidCostExceptionTest extends PHPUnit_Framework_TestCase
{
    public function testConstructor()
    {
        $exception = new InvalidCostException(123);

        $this->assertSame(123, $exception->getCost());
        $this->assertInstanceOf('InvalidArgumentException', $exception);
    }
}