<?php


namespace App\Utils;


class AppTool
{
    /**
     * pre debug
     * @param $value
     * @param bool $exit
     */
    public static function d ($value, $exit = true)
    {
        echo '<pre>';
        print_r($value);
        echo '</pre>';
        if ($exit) {
            exit;
        }
    }

    public static function StringToNumeric ($string)
    {
        $number = str_replace(',','.', $string);
        return $number;
    }
}