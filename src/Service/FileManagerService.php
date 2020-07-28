<?php


namespace App\Service;


use App\Service\Dto\File;

class FileManagerService
{
    private $sftp;

    public function __construct(SshService $sshService)
    {
        $this->sftp = $sshService->getSftp();
    }

    /**
     * Zwraca listę plików w katalogu (path)
     *
     * @param String $path
     * @return array <App\Service\Dto\File>
     */
    public function getFileList (String $path): array
    {
        $filesTmp = $this->sftp->nlist($path);

        if (!is_array($filesTmp)) {
            return [];
        }

        $files = [];
        foreach ($filesTmp as $fileName) {
            if ($fileName=='.') continue;

            $file = new File(
                $fileName,
                $path.DIRECTORY_SEPARATOR.$fileName,
                $this->sftp->lstat($path.DIRECTORY_SEPARATOR.$fileName)
            );

            $files [] = $file;
        }

        usort($files, function ($a, $b) {
            if ($a->isDir()==$b->isDir()) {
                return ($a->getFileName() > $b->getFileName()) ? +1 : -1;
            } else {
                return ($a->isDir()) ? -1 : +1;
            }
        });

        return $files;
    }

    /**
     * @param String $filePath
     * @return String|null
     */
    public function getFileContent (String $filePath): ?String
    {
        return $this->sftp->exec ("cat ".$filePath);
    }

    /**
     * @param String $path
     * @return File
     */
    public function getFile (String $path) {
        $pathT = explode(DIRECTORY_SEPARATOR, $path);
        $fileName = $pathT[array_key_last($pathT)];
        $file = new File(
            $fileName,
            $path,
            $this->sftp->lstat($path)
        );
        return $file;
    }

}