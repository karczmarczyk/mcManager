<?php


namespace App\Controller;


use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class TimeController  extends AbstractController
{
    /**
     * Lista paragonów
     *
     * @Route("/", name="app_main")
     */
    public function index(Request $request)
    {
        return $this->render('time/index.html.twig');
    }
}