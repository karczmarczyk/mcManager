<?php


namespace App\Controller;

use App\Service\CommandService;
use App\Service\SshService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class ConsoleController extends AbstractController
{
    /**
     * @Route("/", name="app_main")
     * @Route("/console", name="console")
     * @param Request $request
     * @param SshService $sshService
     * @param CommandService $commandService
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction(Request $request, SshService $sshService, CommandService $commandService)
    {

        $commandService;
        $log = $sshService->getSsh()->exec($commandService->getCurrentLog());

        return $this->render('console/console.html.twig', [
            'log' => $log
        ]);
    }
}