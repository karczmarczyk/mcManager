<?php


namespace App\Service;


use App\Entity\User;
use phpseclib\Net\SSH2;
use phpseclib\Net\SFTP;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
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

    private $params;
    private $tokenStorage;


    public function __construct(TokenStorageInterface $tokenStorage, ParameterBagInterface $params, $sshHost, $sshPort)
    {
        $this->params = $params;
        $this->tokenStorage = $tokenStorage;

        if (!is_null($tokenStorage) && !is_null($tokenStorage->getToken())) {
            $user = $tokenStorage->getToken()->getUser();
            if ($user instanceof User) {
                setUserFromToken ();
            } else {
                //$this->setTechnicalUser();
            }
        } else {
            $this->setTechnicalUser();
        }

        $this->sshHost = $sshHost;
        $this->sshPort = $sshPort;
    }

    private function setUserFromToken ()
    {
        $user = $this->tokenStorage->getToken()->getUser();
        $this->login = $user->getUsername();
        $this->password = $user->getPassword();
    }

    private function setTechnicalUser ()
    {
        $this->login = $this->params->get('technicalUser');
        $this->password = $this->params->get('technicalPass');
    }

    public function setCredentials ($login, $password)
    {
        $this->login = $login;
        $this->password = $password;
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