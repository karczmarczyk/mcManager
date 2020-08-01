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

        $file = $fileManagerService->getFile($filePath);
        if ($file->getSize()>$this->getParameter('fileMaxSizeForPreview')) {
            return new Response("Rozmiar pliku jest za duży. \nPodgląd jest niedostępny.");
        }

        $content = $fileManagerService->getFileContent($filePath);

        if ($file->isArchive()) {
            $content = gzdecode($content);
        }

        return new Response($content);
    }
}