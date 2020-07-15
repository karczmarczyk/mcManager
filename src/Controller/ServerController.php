<?php

namespace App\Controller;

use App\Service\SystemStatService;
use App\Utils\AppTool;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class ServerController extends AbstractController
{

    /**
     * @Route("/server", name="server")
     * @param SystemStatService $systemStatService
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function serverAction (SystemStatService $systemStatService)
    {
//        $stats = $systemStatService->getAll();
//        AppTool::d($stats, true);
        return $this->render('server/server.html.twig', [
//            'stats' => $stats
        ]);
    }

    /**
     * @Route("/getStat", name="getStat")
     * @param SystemStatService $systemStatService
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function getStatAction (SystemStatService $systemStatService)
    {
        $stats = $systemStatService->getAll();
        return $this->render('server/_stat.html.twig', [
            'stats' => $stats
        ]);
    }
}