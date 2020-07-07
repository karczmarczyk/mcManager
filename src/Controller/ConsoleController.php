<?php


namespace App\Controller;

use App\Service\CommandService;
use App\Service\SshService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ConsoleController extends AbstractController
{
    /**
     * @Route("/", name="app_main")
     * @Route("/console", name="console")
     */
    public function indexAction()
    {
        return $this->render('console/console.html.twig');
    }

    /**
     * @Route("/console/current-log", name="current_log")
     * @param SshService $sshService
     * @param CommandService $commandService
     * @return Response
     */
    public function getCurrentLogAction (SshService $sshService, CommandService $commandService)
    {
        $log = $sshService->getSsh()->exec($commandService->getCurrentLog());
        return $this->json(['data' => $log]);
    }

    /**
     * @Route("/console/send-command", name="send_command", methods={"POST"})
     * @param Request $request
     */
    public function sendCommandAction (Request $request, SshService $sshService, CommandService $commandService)
    {
        $command = $request->get('command');
        $sshService->getSsh()->exec($commandService->getConsoleCommand($command));
        return new Response();
    }
}