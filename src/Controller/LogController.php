<?php


namespace App\Controller;

use App\Service\CommandService;
use App\Service\FileManagerService;
use App\Service\SshService;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class LogController extends AbstractController
{
    /**
     * @Route("/logs/index", name="logs_index")
     * @param FileManagerService $fileManagerService
     * @param CommandService $commandService
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction (Request $request, FileManagerService $fileManagerService,CommandService $commandService)
    {
        $path = $request->query->get('fileManagerPath');
        if (is_null($path)) {
            $path = $commandService->getLogsPath();
        }

        $files = $fileManagerService->getFileList($path);

//        print_r($files); exit;

        return $this->render('backup/index.html.twig', [
            'path' => $path,
            'files' => $files
        ]);
    }
}