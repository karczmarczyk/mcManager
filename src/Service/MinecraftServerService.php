<?php

namespace App\Service;



class MinecraftServerService
{
    /**
     * @var CommandService
     */
    private $commandService;
    /**
     * @var SshService
     */
    private $conn;

    /**
     * Konfiguracja serwera
     * @var
     */
    private $host;
    private $port;

    /**
     * MinecraftServerService constructor.
     * @param CommandService $commandService
     * @param SshService $sshService
     * @param $host
     * @param $port
     */
    public function __construct(CommandService $commandService, SshService $sshService, $host, $port)
    {
        $this->commandService = $commandService;
        $this->conn = $sshService;
        $this->host = $host;
        $this->port = $port;
    }

    /**
     * @return bool
     */
    public function isRunning () : bool
    {
        return $this->isRunningCheckPortListening();
    }

    /**
     * Ustala czy serwer jset włączony na podstawie tego czy proces istnieje
     * @return bool
     * @throws \Exception
     */
    private function isRunningCheckProcessExist (): bool
    {
        $result = $this->conn->getSsh()->exec($this->commandService->getMcServerStatus());
        if (trim($result)==='Server is running') {
            return true;
        } else {
            return false;
        }
    }

    /**
     * UStala czy serwer jest włączony na podstawie tego czy port nasłuchuje
     * @return bool
     */
    private function  isRunningCheckPortListening(): bool
    {
        $connection = @fsockopen($this->host, $this->port);

        if (is_resource($connection)) {
            fclose($connection);
            return true;
        } else {
            return false;
        }
    }

    /**
     * Start server
     */
    public function start ()
    {
        $this->conn->getSsh()->exec($this->commandService->getMcServerStart());
    }

    /**
     * Stop server
     */
    public function stop ()
    {
        $this->conn->getSsh()->exec($this->commandService->getMcServerStop());
    }

    /**
     * Restart server
     */
    public function restart ()
    {
        $this->conn->getSsh()->exec($this->commandService->getMcServerRestart());
    }

    /**
     * Backup server
     */
    public function createBackup ()
    {
        $this->conn->getSsh()->exec($this->commandService->getMcServerBackup());
    }

    public function getPlayersOnline ()
    {
        $listLoggedInCmd = $this->commandService->getConsoleCommand($this->commandService->getMcPlayers());
        $this->conn->getSsh()->exec($listLoggedInCmd);
        $result = $this->conn->getSsh()->exec($this->commandService->getMcPlayersResult());
        $r = preg_replace('/\[.*\]\:\s/', '', $result);
        return $r;
    }

    public function getPlayersOnlineList ()
    {
        $str = $this->getPlayersOnline();
        $r = preg_match('/: (.*)/', $str, $matches);
        if (!isset($matches[1])) return [];
        $players = explode(", ",$matches[1]);
        return $players;
    }
}