<?php


namespace App\Controller;


use App\Service\FileManagerService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FileManagerController extends AbstractController
{
    /**
     * @Route("/file-manager/preview", name="file-manager-preview")
     * @param Request $request
     * @param FileManagerService $fileManagerService
     * @return Response|null
     */
    public function previewFileContentAction (Request $request, FileManagerService $fileManagerService)
    {
        $filePath = $request->query->get('fileManagerFilePath');
        if (is_null($filePath)) {
            return null;
        }

        return new Response('<pre>'.$fileManagerService->getFileContent($filePath).'</pre>');
    }
}