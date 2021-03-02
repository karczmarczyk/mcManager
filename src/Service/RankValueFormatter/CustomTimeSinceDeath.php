<?php


namespace App\Service\RankValueFormatter;


use App\Utils\AppTool;

class CustomTimeSinceDeath implements ValueFormatterInterface
{
    public function format(String $value)
    {
        return AppTool::secundToHumanTime($value);
    }
}