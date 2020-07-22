<?php


namespace App\Service;


use phpseclib\Net\SSH2;
use phpseclib\Net\SFTP;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class SshService
{
    /**
     * @var SSH2
     */
    private $ssh = null;

    /**
     * @var SFTP
     */
    private $sftp = null;

    private $sshHost;
    private $sshPort;
    private $login;
    private $password;

    public function __construct(TokenStorageInterface $tokenStorage, $sshHost, $sshPort)
    {
        $user=$tokenStorage->getToken()->getUser();

        $this->login = $user->getUsername();
        $this->password = $user->getPassword();
        $this->sshHost = $sshHost;
        $this->sshPort = $sshPort;
    }

    public function getSsh(): SSH2
    {
        if (is_null($this->ssh)) {
            $this->ssh =  new SSH2($this->sshHost, $this->sshPort);
            if(!$this->ssh->login($this->login, $this->password)) {
                throw new \Exception("Błąd logowania SSH");
            }
        }
        return $this->ssh;
    }

    public function getSftp(): SFTP
    {
        if (is_null($this->sftp)) {
            $this->sftp = new SFTP($this->sshHost);
            if(!$this->sftp->login($this->login, $this->password)) {
                throw new \Exception("Błąd logowania SFTP");
            }
        }
        return $this->sftp;
    }
}