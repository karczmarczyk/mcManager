<?php


namespace App\Controller;


use phpseclib\Net\SSH2;
use Spatie\Ssh\Ssh;
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


        $ssh = new SSH2('192.168.10.102');
        if (!$ssh->login('minecraft', 'mc1234')) {
            exit('Login Failed');
        }

        //echo $ssh->exec('screen -S minecraft/test -X stuff "'.time().'\r"');

        $log = $ssh->exec('cat /home/minecraft/server/logs/latest.log');

        return $this->render('time/index.html.twig', [
            'log' => $log
        ]);
    }
}