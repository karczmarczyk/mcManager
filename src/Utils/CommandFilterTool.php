<?php


namespace App\Utils;


class CommandFilterTool
{
    /**
     * Oznacza klasą player nazwę playera
     *
     * @param $string
     * @return string|string[]|null
     */
    public static function highlightPlayerInChat ($string)
    {
        $string = htmlentities($string);
        $string = preg_replace('/&lt\;(.*)&gt\;/',
            '<span class="player-content">&lt;<span class="player">${1}</span>&gt;</span>',
            $string);

        return $string;
    }

    /**
     * Podświetla czas
     *
     * @param $string
     * @return string|string[]|null
     */
    public static function highlightTime ($string)
    {
        $string = preg_replace('[\[(\d\d:\d\d:\d\d)\]]',
            '<span class="time-content">[<span class="time" title="${1}">${1}</span>]</span>',
            $string);

        return $string;
    }

    /**
     * Podświetla drugi nawias kwadratowy
     * @param $string
     * @return mixed
     */
    public static function highlightSecondParam ($string)
    {
        $string = preg_replace('/\s\[(.*)\]:/',
            ' <span class="second-content mobile-hide">[<span class="second" title="${1}">${1}</span>]</span>:',
            $string);
        return $string;
    }

}