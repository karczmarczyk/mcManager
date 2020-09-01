<?php


namespace App\Service;


use App\Service\Dto\Player;
use App\Utils\FileTool;

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
     * @var MinecraftServerService
     */
    private $minecraftServerService;

    /**
     * PlayerService constructor.
     * @param SshService $conn
     * @param FileManagerService $fileManagerService
     * @param CommandService $commandService
     * @param MinecraftServerService $minecraftServerService
     */
    public function __construct(SshService $conn, FileManagerService $fileManagerService,
                                CommandService $commandService, MinecraftServerService $minecraftServerService)
    {
        $this->conn = $conn;
        $this->fileManager = $fileManagerService;
        $this->command = $commandService;
        $this->minecraftServerService = $minecraftServerService;
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
        $activePlayers = $this->minecraftServerService->getPlayersOnlineList();
        foreach ($files as $file) {
            // only dat file
            if (!FileTool::hasExtension($file->getFileName(), 'dat')) {
                continue;
            }
            $player = new Player();
            $player->setUuid($this->_fetchPlayerUuidFromFileName($file->getFileName()));
            $player->setName($this->_fetchPlayerNameFromContent($this->fileManager->getFileContent($file->getFileAbsoluteName())));
            $player->setLastActivityH($file->getModifyTimeH());
            $player->setLastActivity($file->getModifyTime());
            $player->setPlayNow(in_array($player->getName(), $activePlayers));
            $players [] = $player;
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