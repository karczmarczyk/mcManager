<?php


namespace App\Controller;


use App\Form\Model\McServerForm;
use App\Form\Type\McServerType;
use App\Service\MinecraftServerService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ControlPanelController extends AbstractController
{
    /**
     * @Route("/controlPanel", name="control_panel")
     * @param MinecraftServerService $minecraftServerService
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function panelAction (MinecraftServerService $minecraftServerService)
    {
        return $this->render('controlPanel/index.html.twig', [
            'isRunning' => $minecraftServerService->isRunning()
        ]);
    }

    /**
     * @Route("/mcSetStatus", name="mc_set_status")
     * @param Request $request
     * @return Response|\Symfony\Component\HttpFoundation\JsonResponse
     */
    public function mcStatusAction (Request $request, MinecraftServerService $minecraftServerService)
    {
        $model = new McServerForm();

        $form = $this->createForm(McServerType::class, $model);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $model = $form->getData();
            if ($model->getServerStatus()) {
                $minecraftServerService->start();
            } else {
                $minecraftServerService->stop();
            }
        } else {
            return $this->json(['errorMsg'=>$form->getErrors()], 400);
        }

        return new Response("ok");
    }

    /**
     * @Route("/createBackup", name="mc_create_backup")
     */
    public function mcCreateBackup (Request $request, MinecraftServerService $minecraftServerService)
    {
        $token = $request->get('_token');
        if ($this->isCsrfTokenValid('mc_create_backup', $token)) {
            $minecraftServerService->createBackup();
            return new Response("ok");
        }
        return new Response("error", 400);
    }
}