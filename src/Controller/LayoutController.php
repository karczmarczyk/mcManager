<?php


namespace App\Controller;


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
            ['label'=>'Serwer', 'href'=>$this->router->generate('server'), 'isActive'=>$current=='server'],
            ['label'=>'Konsola', 'href'=>$this->router->generate('console'), 'isActive'=>$current=='console' || $current=='app_main'],
            ['label'=>'Panel sterowania', 'href'=>$this->router->generate('control_panel'), 'isActive'=>$current=='control_panel'],
//            ['label'=>'System', 'href'=>$this->router->generate('console'), 'isActive'=>$current=='console' || $current=='app_main'],
        ];

        return $this->render('layout/main_menu.html.twig', [
            'menu' => $menu
        ]);
    }
}