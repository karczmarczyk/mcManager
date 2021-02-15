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
            ['label'=>'Server', 'href'=>$this->router->generate('server'), 'isActive'=>$current=='server' || $current=='app_main'],
            ['label'=>'Console', 'href'=>$this->router->generate('console'), 'isActive'=>$current=='console'],
            ['label'=>'Control Panel', 'href'=>$this->router->generate('control_panel'), 'isActive'=>$current=='control_panel'],
            ['label'=>'Players', 'href'=>$this->router->generate('players'), 'isActive'=>$current=='players'],
            ['label'=>'Logs', 'href'=>$this->router->generate('logs_index'), 'isActive'=>$current=='logs_index'],
            ['label'=>'Backups', 'href'=>$this->router->generate('backup_index'), 'isActive'=>$current=='backup_index'],
            ['label'=>'Rank', 'href'=>$this->router->generate('rank'), 'isActive'=>$current=='rank'],
        ];

        return $this->render('layout/main_menu.html.twig', [
            'menu' => $menu
        ]);
    }

    /**
     * @Route("/app_frontend_menu", name="app_frontend_menu")
     */
    public function frontendMenu (Request $request) {
        $current = $request->get('current');
        $menu = [
            ['label'=>'Rank', 'href'=>$this->router->generate('rank'), 'isActive'=>$current=='rank'],
            ['label'=>'Administration', 'href'=>$this->router->generate('app_main'), 'isActive'=>$current=='app_main']
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