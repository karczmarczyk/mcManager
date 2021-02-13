<?php

namespace App\Helper;

/**
 * Description of GeneralUtils
 *
 * @author mateusz
 */
class GeneralUtils {

    /**
     * @param type $format
     * @param type $utimestamp
     * @return type
     */
    public static function udate($format, $utimestamp = null)
    {
        if (is_null($utimestamp)) {
            $utimestamp = microtime(true);
        }

        $timestamp = floor($utimestamp);
        $milliseconds = round(($utimestamp - $timestamp) * 1000000);

        return date(preg_replace('`(?<!\\\\)u`', sprintf("%06u", $milliseconds), $format), $timestamp);
    }
}