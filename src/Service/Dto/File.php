<?php


namespace App\Service\Dto;


class File
{
    private $fileName;
    private $fileAbsoluteName;
    private $fileStat;

    public static $TB = 1024*1024*1024*1024;
    public static $GB = 1024*1024*1024;
    public static $MB = 1024*1024;
    public static $KB = 1024;

    public function __construct(String $fileName, String $fileAbsoluteName, Array $fileStat)
    {
        $this->fileName = $fileName;
        if ($fileName=='..') {
            $fileAbsoluteNameT = explode(DIRECTORY_SEPARATOR, $fileAbsoluteName);
            // wyznaczam cofnięcie o 1
            if (is_array($fileAbsoluteNameT)) {
            }
            unset($fileAbsoluteNameT[count($fileAbsoluteNameT) - 1]);
            unset($fileAbsoluteNameT[count($fileAbsoluteNameT) - 1]);
            $fileAbsoluteName = implode(DIRECTORY_SEPARATOR, $fileAbsoluteNameT);
            if ($fileAbsoluteName == '') {
                $fileAbsoluteName = DIRECTORY_SEPARATOR;
            }
        }
        $this->fileAbsoluteName = $fileAbsoluteName;
        $this->fileStat = $fileStat;
    }

    /**
     * @return String
     */
    public function getFileName(): String
    {
        return $this->fileName;
    }

    /**
     * @param String $fileName
     */
    public function setFileName(String $fileName): void
    {
        $this->fileName = $fileName;
    }

    /**
     * @return String
     */
    public function getFileAbsoluteName(): String
    {
        return $this->fileAbsoluteName;
    }

    /**
     * @param String $fileAbsoluteName
     */
    public function setFileAbsoluteName(String $fileAbsoluteName): void
    {
            $this->fileAbsoluteName = $fileAbsoluteName;
    }

    /**
     * @return array
     */
    public function getFileStat(): array
    {
        return $this->fileStat;
    }

    /**
     * @param array $fileStat
     */
    public function setFileStat(array $fileStat): void
    {
        $this->fileStat = $fileStat;
    }

    /**
     * Rozmiar pliku w B
     * @return int|mixed
     */
    public function getSize ()
    {
        return $this->fileStat['size'] ?? 0;
    }

    /**
     * Rozmiar pliku "ładny"
     *
     * @return string
     */
    public function getSizeH ()
    {
        $size = $this->getSize();
        if ($size > self::$TB) {
            return round($size/self::$TB, 3) . " TB";
        } else if ($size > self::$GB) {
            return round($size/self::$GB, 2) . " GB";
        } else if ($size > self::$MB) {
            return round($size/self::$MB, 1) . " MB";
        } else if ($size > self::$KB) {
            return round($size/self::$KB, 0) . " KB";
        }

        return $size . " B";
    }

    /**
     * @return int|mixed
     */
    public function getAccessTime ()
    {
        return $this->fileStat['atime'] ?? 0;
    }

    /**
     * @param string $format
     * @return false|string
     */
    public function getAccessTimeH ($format = "Y-m-d H:i:s")
    {
        return date($format, $this->getAccessTime());
    }

    /**
     * @return int|mixed
     */
    public function getModifyTime ()
    {
        return $this->fileStat['mtime'] ?? 0;
    }

    /**
     * @param string $format
     * @return false|string
     */
    public function getModifyTimeH ($format = "Y-m-d H:i:s")
    {
        return date($format, $this->getModifyTime());
    }

    /**
     * Zwraca rozszerzenie
     */
    public function getExt ()
    {
        $fileName = $this->getFileName();
        $fileNameT = explode(".", $fileName);
        if (is_array($fileNameT)) {
            return $fileNameT[count($fileNameT)-1];
        }
        return null;
    }

    /**
     * Czy katalog
     * @return bool
     */
    public function isDir ()
    {
        return $this->fileStat['type']==2;
    }

    /**
     * Czy plik
     * @return bool
     */
    public function isFile ()
    {
        return $this->fileStat['type']==1;
    }

    public function isArchive ()
    {
        return in_array($this->getExt(), [
            'gz'
        ]);
    }

}