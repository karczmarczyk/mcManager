<?php


namespace App\Service\RankValueFormatter;


use App\Utils\AppTool;

class CustomPlayOneMinute implements ValueFormatterInterface
{

    public function format(String $value)
    {
        return AppTool::secondsToHumanTime($value/20);
    }
}