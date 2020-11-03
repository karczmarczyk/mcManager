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

    public static function StringToNumeric ($number)
    {
        $number = str_replace(',','.', $number);
        $number = str_replace(' ','', $number);
        return $number;
    }
}