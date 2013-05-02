<?php

namespace KevinGH\Bcrypt\Tests\Exception;

use KevinGH\Bcrypt\Exception\MissingSaltException;
use PHPUnit_Framework_TestCase;

class MissingSaltExceptionTest extends PHPUnit_Framework_TestCase
{
    public function testParent()
    {
        $this->assertInstanceOf(
            'LogicException',
            new MissingSaltException()
        );
    }
}