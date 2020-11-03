<?php

namespace App\Tests\Utils;

use App\Utils\FileTool;
use PHPUnit\Framework\TestCase;

class FileToolTest extends TestCase
{

    public function testHasExtension()
    {
        $toTest = [
            'a'=>'test.a',
            'b'=>'test.test.b',
            'c'=>'/test/test.c',
            'd'=>'\test\test.d',
        ];
        foreach ($toTest as $ext=>$filename) {
            $this->assertTrue(FileTool::hasExtension($filename, $ext), $ext."=>".$filename);
        }
    }
}
