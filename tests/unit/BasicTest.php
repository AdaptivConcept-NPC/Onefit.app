<?php

use \PHPUnit\Framework\TestCase;

class BasicTest extends TestCase
{
    public function testBasicTest()
    {
        $expected = true;
        $actual = true;

        $this->assertEquals($expected, $actual);
    }
}
