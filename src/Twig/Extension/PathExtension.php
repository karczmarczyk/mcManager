<?php


namespace App\Twig\Extension;


use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class PathExtension extends AbstractExtension
{
    public function getFunctions()
    {
        return [
            new TwigFunction('pathToArray', [$this, 'pathToArray'])
        ];
    }

    public function pathToArray (String $path): array
    {
        $list [] = [
            'name' => DIRECTORY_SEPARATOR,
            'url' => DIRECTORY_SEPARATOR
        ];

        $path = str_replace(DIRECTORY_SEPARATOR.DIRECTORY_SEPARATOR,
            DIRECTORY_SEPARATOR, $path);

        if ($path==DIRECTORY_SEPARATOR) {
            return $list;
        }

        $array = explode(DIRECTORY_SEPARATOR, $path);

        unset($array[0]);
        //ini

        if (count($array)==0) {
            return $list;
        }
        foreach ($array as $key=>$item) {
            $list [] = [
                'name' => $item.DIRECTORY_SEPARATOR,
                'url' => DIRECTORY_SEPARATOR.implode(DIRECTORY_SEPARATOR, array_slice($array, 0, $key))
            ];
        }
        return $list;
    }
}