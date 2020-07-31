<?php


namespace App\Controller;

use App\Form\Model\CommandForm;
use App\Form\Type\CommandType;
use App\Service\AvailableCommandService;
use App\Service\CommandService;
use App\Service\SshService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ConsoleController extends AbstractController
{
    /**
     * @Route("/console", name="console")
     */
    public function indexAction(AvailableCommandService $availableCommandService)
    {
        return $this->render('console/console.html.twig', [
            'availableCommands' => $availableCommandService->getAllWithDescAsJson()
        ]);
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
        $model = new CommandForm();

        $form = $this->createForm(CommandType::class, $model);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $model = $form->getData();

            $command = $model->getCommand();//$request->get('command');
            $sshService->getSsh()->exec($commandService->getConsoleCommand($command));
        } else {
            return $this->json(['errorMsg'=>$form->getErrors()], 400);
        }

        return new Response("ok");
    }
}