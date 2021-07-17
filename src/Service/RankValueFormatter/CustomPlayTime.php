<?php


namespace App\Service\RankValueFormatter;


use App\Utils\AppTool;

class CustomPlayTime implements ValueFormatterInterface
{

    public function format(String $value)
    {
        return AppTool::secondsToHumanTime($value/20);
    }
}