<?php


namespace App\Service;


use phpseclib\Net\SSH2;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class SshService
{
    private $ssh;

    public function __construct(TokenStorageInterface $tokenStorage, $sshHost, $sshPort)
    {
        $user=$tokenStorage->getToken()->getUser();
        $this->ssh =  new SSH2($sshHost, $sshPort);
        if(!$this->ssh->login($user->getUsername(), $user->getPassword())) {
            throw new \Exception("Błąd logowania SSH");
        }
    }

    public function getSsh(): SSH2
    {
        return $this->ssh;
    }
}