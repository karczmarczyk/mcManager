<?php

namespace App\Tests\Utils;

use App\Utils\AppTool;
use PHPUnit\Framework\TestCase;

class AppToolTest extends TestCase
{

    public function testStringToNumeric()
    {
        $toTest = [
            '1',
            1,
            1.2,
            '1,2',
            '1.2',
            '10000.50',
            '10 000.50',
            '10 000,50'
        ];

        foreach ($toTest as $n) {
            $this->assertIsNumeric(AppTool::StringToNumeric($n));
        }
    }
}
