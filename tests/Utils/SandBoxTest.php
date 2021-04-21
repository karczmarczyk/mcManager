<?php

namespace App\Tests\Utils;

use PHPUnit\Framework\TestCase;
use ZipArchive;
use Selective\Rar\RarFileReader;
use SplFileObject;

class SandBoxTest extends TestCase
{
    public function testCraftNbt ()
    {
        $files = scandir("/home/mateusz/playerdata");

//        foreach ($files as $file) {

        try {
            echo "\n";
            echo "\n";
//                echo $filename = "/home/mateusz/playerdata/" . $file;
            echo $filename = "/home/mateusz/playerdata/" . 'fcc15583-f734-36db-9712-e7da1de46509.dat';
            echo "\n";

            $handle = gzopen($filename, "r");

            $nbtService = new \Nbt\Service(new \Nbt\DataHandler());
            $tree = $nbtService->readFilePointer($handle);

//            echo $tree->getName();
//            var_dump($tree);

            $Inventory = $tree->findChildByName('Inventory');
            foreach ($Inventory->getChildren() as $child) {
//                var_dump($child);
                foreach($child->getChildren() as $item) {
                    var_dump($item->getName());
                    var_dump($item->getValue());
                    if ($item->getName()=='tag') {
                        foreach($item->getChildren() as $tag) {
                            var_dump($tag->getName());
                            var_dump($tag->getValue());
                        }
                    }
                }
                echo "\n\n";
            }

//            $XpLevel = $tree->findChildByName('XpLevel');
//            echo $XpLevel->getValue();

//                $con = new \Phpcraft\Connection(-1, $handle);
//                if ($con->readRawPacket()) {
//
//                    $nbt = $con->readNBT();
//                    //$this->assertTrue(!$con->hasRemainingData());
//
//                    echo $nbt->toSNBT();
//                }
        } catch (\Exception $exception) {
            echo "\n".$exception->getMessage()."\n";
//                continue;
        }
//        }

        $this->assertTrue(true,"OK");
    }

}