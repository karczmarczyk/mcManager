<?php

namespace App\Service;


class MinecraftServerService
{
    private $commandService;
    private $conn;

    public function __construct(CommandService $commandService, SshService $sshService)
    {
        $this->commandService = $commandService;
        $this->conn = $sshService;
    }

    /**
     * @return bool
     */
    public function isRunning ()
    {
        $result = $this->conn->getSsh()->exec($this->commandService->getMcServerStatus());
        if (trim($result)==='Server is running') {
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
}