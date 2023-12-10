<?php

use PHPUnit\Framework\TestCase;

// Assuming the functions are in the global namespace
// scripts/php/functions.php
require_once './scripts/php/functions.php';

class FunctionsTest extends TestCase
{
    public function testSanitizeString()
    {
        $input = "<h1>Hello, World!'\"</h1>";
        $expectedOutput = "Hello, World!`&quot;";

        $this->assertEquals($expectedOutput, sanitizeString($input));
    }

    public function testSanitizeMySQL()
    {
        $mysqli = new mysqli('localhost', 'phpunit_test', 'L8Pgk79v(3]iA9Q', 'adaptivc_onefit_db');

        $input = "' OR '1'='1";
        $expectedOutput = "` OR `1`=`1";

        $this->assertEquals($expectedOutput, sanitizeMySQL($mysqli, $input));
    }
}
