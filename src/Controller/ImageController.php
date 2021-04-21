<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\HttpFoundation\BinaryFileResponse;;
use Symfony\Component\Routing\Annotation\Route;

class ImageController extends AbstractController
{
    /**
     * @Route("/images/icon/{name}_{size}.png", name="images_icon")
     */
    public function minecraftIconAction ($name, $size, ParameterBagInterface $parameterBag)
    {
        $publicResourcesFolderPath = $parameterBag->get('kernel.project_dir') . '/public/images/mc_small_icons/';
        $filename = strtolower(str_replace(['minecraft:','_','-'],['','',''],$name))
            ."_icon".$size.".png";

        if(!file_exists($publicResourcesFolderPath.$filename)) {
            $publicResourcesFolderPath = $parameterBag->get('kernel.project_dir') . '/public/images/';
            $filename = "no_img.png";
        }

        return new BinaryFileResponse($publicResourcesFolderPath.$filename);
    }
}