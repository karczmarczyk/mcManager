<?php


namespace App\Controller;

use App\Form\Model\CommandFilterForm;
use App\Form\Model\CommandForm;
use App\Form\Type\CommandFilterType;
use App\Form\Type\CommandType;
use App\Service\AvailableCommandService;
use App\Service\CommandService;
use App\Service\SshService;
use App\Utils\CommandFilterTool;
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
        $model = new CommandFilterForm();
        $form = $this->createForm(CommandFilterType::class, $model);

        return $this->render('console/console.html.twig', [
            'availableCommands' => $availableCommandService->getAllWithDescAsJson(),
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/console/current-log", name="current_log")
     * @param SshService $sshService
     * @param CommandService $commandService
     * @param Request $request
     * @return Response
     * @throws \Exception
     */
    public function getCurrentLogAction (SshService $sshService, CommandService $commandService, Request $request)
    {
        $model = new CommandFilterForm();
        $form = $this->createForm(CommandFilterType::class, $model);
        $form->handleRequest($request);

        $log = $sshService->getSsh()->exec($commandService->getCurrentLog());

        //highlights
        $log = CommandFilterTool::highlightPlayerInChat($log);
        $log = CommandFilterTool::highlightTime($log);
        $log = CommandFilterTool::highlightSecondParam($log);
        $log = CommandFilterTool::highlightAuthMe($log);
        $log = CommandFilterTool::highlightLostConnection($log);
        $log = CommandFilterTool::highlightListOfPlayers($log);
        $log = CommandFilterTool::higlightServerCommand($log);

        //filters
        if ($form->isSubmitted() && $form->isValid()) {
            $model = $form->getData();
            if ($model->getAll()==0) {
                if ($model->getAsyncChatThread()) {

                }
                if ($model->getServerThread()) {

                }
            }
        }


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