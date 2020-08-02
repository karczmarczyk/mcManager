<?php


namespace App\Service;


class PlayerService
{
    /**
     * @var SshService
     */
    private $conn;
    /**
     * @var FileManagerService
     */
    private $fileManager;
    /**
     * @var CommandService
     */
    private $command;

    /**
     * PlayerService constructor.
     * @param SshService $conn
     * @param FileManagerService $fileManagerService
     * @param CommandService $commandService
     */
    public function __construct(SshService $conn, FileManagerService $fileManagerService, CommandService $commandService)
    {
        $this->conn = $conn;
        $this->fileManager = $fileManagerService;
        $this->command = $commandService;
    }

    /**
     * Return players list
     * @return array
     */
    public function getPlayers ()
    {
        $userPath = $this->command->getServerPath()
            .DIRECTORY_SEPARATOR."world".DIRECTORY_SEPARATOR."playerdata".DIRECTORY_SEPARATOR;
        $files = $this->fileManager->getFileList($userPath, true);
        $players = [];
        foreach ($files as $file) {
            $players [$this->_fetchPlayerUuidFromFileName($file->getFileName())]
                = $this->_fetchPlayerNameFromContent($this->fileManager->getFileContent($file->getFileAbsoluteName()));
        }
        return $players;
    }

    /**
     *
     */
    public function getStats ($uuid)
    {
        $userStatsPath = $this->command->getServerPath()
            .DIRECTORY_SEPARATOR."world".DIRECTORY_SEPARATOR."stats".DIRECTORY_SEPARATOR.$uuid.'.json';
        $fileJsonContent = $this->fileManager->getFileContent($userStatsPath);
        $playerStats = json_decode( $fileJsonContent , true );
//        print_r($playerStats); exit;
        return $playerStats;
    }

    /**
     * @param $fileName
     * @return mixed
     */
    private function _fetchPlayerUuidFromFileName ($fileName)
    {
        return str_replace(".dat","", $fileName);
    }

    /**
     * @param $content
     * @return mixed
     */
    private function _fetchPlayerNameFromContent ($content)
    {
        $content = gzdecode($content);
        preg_match('/lastKnownName\X\X([a-zA-Z0-9\@\!\#\$\%\^\&\*\(\)]*)\X\X/', $content, $matches);
        return $matches[1] ?? null;
    }
}