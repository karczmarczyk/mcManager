<?php


namespace App\Utils;


class FileTool
{
    /**
     * Sprawdza czy plik ma wskazane rozszerzenie
     * @param $fileName
     * @param $ext
     * @return bool
     */
    public static function hasExtension ($fileName, $ext)
    {
        $filePart = explode('.', $fileName);
        if (is_array($filePart)) {
            $extOfFile = $filePart[array_key_last($filePart)];
            if ($extOfFile === $ext) {
                return true;
            }
        }
        return false;
    }
}