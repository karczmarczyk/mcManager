<?php


namespace App\Controller;

use App\Service\CommandService;
use App\Service\SshService;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class BackupController extends AbstractController
{
    /**
     * @Route("/backup/index", name="backup_index")
     * @param SshService $sshService
     */
    public function indexAction (SshService $sshService, CommandService $commandService)
    {
        $sftp = $sshService->getSftp();
        $filesTmp = $sftp->nlist($commandService->getBackupPath());

        sort ($filesTmp);

        $files = [];
        foreach ($filesTmp as $fileName) {
            if ($fileName=='.' || $fileName=='..') continue;

            $stat = $sftp->lstat($commandService->getBackupPath().DIRECTORY_SEPARATOR.$fileName);
            $files[] = [
                'name' => $fileName,
                'stat' => $stat,
            ];
        }

        //print_r($files); exit;

        return $this->render('backup/index.html.twig', [
            'files' => $files
        ]);
    }
}