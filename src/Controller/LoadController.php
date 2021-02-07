<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class LoadController
 * @package App\Controller
 */
class LoadController extends AbstractController
{

    /**
     * @Route("/load", name="load-view")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function loadAction ()
    {
        return $this->render('load/index.html.twig', [
        ]);
    }

    /**
     * @Route("/load/check", name="load-check", methods={"GET"})
     */
    public function checkAction ()
    {
        return $this->json(['status'=>'OK'], 200);
    }
}