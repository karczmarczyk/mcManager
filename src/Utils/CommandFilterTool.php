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
            '<span class="player-content"> <i class="fa fa-comments" aria-hidden="true"></i> &lt;<span class="player">${1}</span>&gt;</span>',
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

    public static function highlightAuthMe ($string)
    {
        $string = preg_replace('/(\[AuthMe\] .* logged in .*)/',
            '<span class="authme-login"><i class="fa fa-sign-in" aria-hidden="true"></i> ${1}</span>',
            $string);
        $string = preg_replace('/\[AuthMe\]\s(.*)\slogged in /',
            '[AuthMe] <b>${1}</b> logged in ',
            $string);

        return $string;
    }

    public static function highlightLostConnection ($string)
    {
        $string = preg_replace('/: (.* lost connection: Disconnected)/',
            ': <span class="authme-logout"><i class="fa fa-sign-out" aria-hidden="true"></i> ${1}</span>',
            $string);
        $string = preg_replace('/: (.* left the game)/',
            ': <span class="authme-logout"><i class="fa fa-sign-out" aria-hidden="true"></i> ${1}</span>',
            $string);

        return $string;
    }

    public static function highlightListOfPlayers ($string)
    {
        $string = preg_replace('/(There are \d{1,4} of a max of \d{1,4} players online: .*)/',
            '<span class="list">${1}</span>',
            $string);

        return $string;
    }
}