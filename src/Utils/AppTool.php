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

    public static function secundToHumanTime ($value)
    {
        $left = $value;

        $d = (int) ($left / (3600*24));
        $left = $left - $d*(3600*24);
        $h = (int) ($left / 3600);
        $left = $left - $h*3600;
        $i = (int) ($left / 60);
        $left = $left - $i*60;
        $s = $left;

        $hP = str_pad($h, 2, "0", STR_PAD_LEFT);
        $iP = str_pad($i, 2, "0", STR_PAD_LEFT);
        $sP = str_pad($s, 2, "0", STR_PAD_LEFT);

        return "$d dni, $hP:$iP:$sP";
    }
}