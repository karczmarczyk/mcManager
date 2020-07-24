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

        sort ($filesTmp);

        $files = [];
        foreach ($filesTmp as $fileName) {
            if ($fileName=='.' || $fileName=='..') continue;

            $file = new File(
                $fileName,
                $path.DIRECTORY_SEPARATOR.$fileName,
                $this->sftp->lstat($path.DIRECTORY_SEPARATOR.$fileName)
            );

            $files [] = $file;
        }

        return $files;
    }
}