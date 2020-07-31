<?php


namespace App\Controller;


use App\Service\CommandService;
use App\Service\MinecraftServerService;
use App\Service\SshService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class LayoutController extends AbstractController
{
    /**
     * @var UrlGeneratorInterface
     */
    private $router;

    public function __construct(UrlGeneratorInterface $router)
    {
        $this->router = $router;
    }

    /**
     * @Route("/app_main_menu", name="app_main_menu")
     */
    public function mainMenu (Request $request) {
        $current = $request->get('current');
        $menu = [
            ['label'=>'Serwer', 'href'=>$this->router->generate('server'), 'isActive'=>$current=='server' || $current=='app_main'],
            ['label'=>'Konsola', 'href'=>$this->router->generate('console'), 'isActive'=>$current=='console'],
            ['label'=>'Panel sterowania', 'href'=>$this->router->generate('control_panel'), 'isActive'=>$current=='control_panel'],
            ['label'=>'Backup', 'href'=>$this->router->generate('backup_index'), 'isActive'=>$current=='backup_index'],
        ];

        return $this->render('layout/main_menu.html.twig', [
            'menu' => $menu
        ]);
    }

    /**
     * @Route("/app_main_server_info", name="app_main_server_info")
     * @param MinecraftServerService $minecraftServerService
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function mainServerInfo (MinecraftServerService $minecraftServerService)
    {
        $isRunning = $minecraftServerService->isRunning();
        $listLoggedIn = "";
        if ($isRunning) {
            $listLoggedIn = $minecraftServerService->getPlayersOnline();
        }

        return $this->render('layout/main_server_info.html.twig', [
            'isRunning' => $isRunning,
            'listLoggedIn' => $listLoggedIn
        ]);
    }
}