<?php


namespace App\Security;


use phpseclib\Net\SSH2;
use Symfony\Component\Security\Core\User\UserInterface;

interface UserSshInterface extends UserInterface
{
    public function getSsh ():?SSH2;
}