<?php


namespace App\Controller;


use App\Security\UserSshInterface;
use App\Service\SshService;
use phpseclib\Net\SSH2;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;

class TestController extends AbstractController
{
    /**
     * @Route("/", name="app_main")
     */
    public function indexAction(Request $request, SshService $sshService)
    {

//        echo '<pre>';
//        print_r($user->getSsh());
//        echo '</pre>';

//        $ssh = new SSH2('192.168.10.102');
//        if (!$ssh->login('minecraft', 'mc1234')) {
//            exit('Login Failed');
//        }
//
//        //echo $ssh->exec('screen -S minecraft/test -X stuff "'.time().'\r"');
//
//        $log = $ssh->exec('cat /home/minecraft/server/logs/latest.log');

//        echo (int) $user->getSsh()->isConnected();
//        echo (int) $user->getSsh()->isAuthenticated();
//
//        echo '<br>';

//        $log = $user->getSsh()->exec('cat /home/minecraft/server/logs/latest.log');

        $log = $sshService->getSsh()->exec('cat /home/minecraft/server/logs/latest.log');

        return $this->render('time/index.html.twig', [
            'log' => $log
        ]);
    }

    /**
     * @Route("/test2")
     */
    public function testAction (SshService $sshService) {

//        echo $user->getUsername();
//        print_r($user->getPassword());
//        echo '<br>';
////        exit;
//        //$user->getSsh()->login($user->getUsername(),$user->getPassword());
//        echo (int) $user->getSsh()->isConnected();
//        echo (int) $user->getSsh()->isAuthenticated();
//
//        echo '<br>';
//
//        echo $user->getSsh()->exec('cat /home/minecraft/server/logs/latest.log');

        echo $sshService->getSsh()->exec('cat /home/minecraft/server/logs/latest.log');

//        $ssh = new SSH2('192.168.10.102');
//        if (!$ssh->login($user->getUsername(), $user->getPassword())) {
//            exit('Login Failed');
//        }
//        echo $ssh->exec('cat /home/minecraft/server/logs/latest.log');

        exit;
    }
}